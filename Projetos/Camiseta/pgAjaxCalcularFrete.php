<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxCalcularFrete.php
  Função: página para calcular o frete do produto
  Data de Criação: 29/03/2011 - 09:47
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  DefinirConstantes()
  InicializarVariaveis()
  GetCEP_Destino() //retorna o CEP de destino com base no CEP gravado para o pedido de compra atual - ($this->nCdPedidoCompra)
  GetPeso() //retorna o peso dos produtos do pedido de compra
  GetQuantidadeItensPedidoCompra() //calcula a quantidade de itens do pedido de compra
  ValidarDadosAntesCalcularFrete() //valida os dados antes de calcular o frete
  AjustarPeso() //ajusta o peso
  CalcularFreteServicoPAC_SEDEX_10_HOJE($sServico) //calcula o valor do frete para os serviços PAC, SEDEX, SEDEX_10 e SEDEX_HOJE
  CalcularFreteServicoSedex_a_Cobrar() //calcula o valor do frete utilizando o serviço Sedex a Cobrar
  GetFormatarSaidaCEP($psCEP) //formata a saída do CEP, inserindo o caracter '-'
  RetornoProcessamentoAJAX() //retorna o processamento da página AJAX
*/

    $calcularFrete = new CalcularFrete();

    class CalcularFrete{
      //bd
      private $oBd;
      private $sSql;
      
      //métodos gerais
      private $oMetGer;

      //dados recebidos via $_POST
      private $nCdPedidoCompra;

      private $nTotalItensPedidoCompra;
      
      //valores do serviço que a página irá calcular
      private $dValorPAC;
      private $dValorSEDEX;
      private $dValorSEDEX_10;
      private $dValorSEDEX_A_COBRAR;
      private $dValorSEDEX_HOJE;
      
      private $sCEP_Origem;
      private $sCEP_Destino;
      
      private $dPeso;
      private $dValorDeclarado;
      
      private $sRetornoErro;


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->DefinirConstantes();
        $this->InicializarVariaveis();
        if($this->ValidarDadosAntesCalcularFrete()){
          $this->AjustarPeso();
          $this->dValorPAC = $this->CalcularFreteServicoPAC_SEDEX_10_HOJE(SERVICO_PAC);
          $this->dValorSEDEX = $this->CalcularFreteServicoPAC_SEDEX_10_HOJE(SERVICO_SEDEX);
          $this->dValorSEDEX_10 = $this->CalcularFreteServicoPAC_SEDEX_10_HOJE(SERVICO_SEDEX_10);
          $this->dValorSEDEX_HOJE = $this->CalcularFreteServicoPAC_SEDEX_10_HOJE(SERVICO_SEDEX_HOJE);
          //$this->dValorSEDEX_A_COBRAR = $this->CalcularFreteServicoSedex_a_Cobrar();
        }
        else{
          echo $this->sRetornoErro;
        }
        $this->RetornoProcessamentoAJAX();
      }


      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
        setlocale(LC_CTYPE,"pt_BR");
        //data no passado
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        //sempre modificado
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        // HTTP/1.1
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        // HTTP/1.0
        header("Pragma: no-cache");
      }


      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
        require_once("./classes/metodosGerais.php");
	  }
	  
	  
	  private function DefinirConstantes(){
        define("SERVICO_PAC", "41106");
        define("SERVICO_SEDEX", "40010");
        define("SERVICO_SEDEX_10", "40215");
        define("SERVICO_SEDEX_A_COBRAR", "40045");
        define("SERVICO_SEDEX_HOJE", "40290");
      } //fim - DefinirConstantes()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //métodos gerais
        $this->oMetGer = MetodosGerais::GetInstanciaMetodosGerais();
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
          $this->nCdPedidoCompra = trim($this->oMetGer->GetPost('nCdPedidoCompra'));
        }
        $this->nCdPedidoCompra = 16; //xxxxxxxxxxxxx
        
        $this->nTotalItensPedidoCompra = $this->GetQuantidadeItensPedidoCompra();
        
        //valores do serviço que a página irá calcular
        $this->dValorPAC = 0;
        $this->dValorSEDEX = 0;
        $this->dValorSEDEX_10 = 0;
        $this->dValorSEDEX_A_COBRAR = 0;
        $this->dValorSEDEX_HOJE = 0;
        
        $this->sCEP_Origem = $this->oMetGer->GetCEP_Origem();
        $this->sCEP_Destino = $this->GetCEP_Destino();
        $this->dPeso = $this->GetPeso();
        $this->dValorDeclarado = 0;
        
        $this->sRetornoErro = "";
      } //fim - InicializarVariaveis()
      
      
      //retorna o CEP de destino com base no CEP gravado para o pedido de compra atual - ($this->nCdPedidoCompra)
      private function GetCEP_Destino(){
        $sCEP_Destino = "";
        $sSql = "SELECT endereco_entrega_cep FROM pedido_compra WHERE cdPedidoCompra = '" .$this->nCdPedidoCompra. "'";
        $oDados = $this->oBd->PesquisarSQL($sSql);
        if($oDados){
          $sCEP_Destino = $oDados[0]->endereco_entrega_cep;
          $sCEP_Destino = str_replace("-","",$sCEP_Destino);
        }
        return $sCEP_Destino;
      } //fim - GetCEP_Destino()
      
      
      //retorna o peso dos produtos do pedido de compra
      private function GetPeso(){
        $dPeso = "0";

        $sSql = "SELECT SUM(c.peso) AS soma ";
        $sSql .= "FROM camiseta c ";
        $sSql .= "JOIN item_pedido_compra i ON c.cdCamiseta = i.cdFkProduto ";
        $sSql .= "JOIN pedido_compra p ON p.cdPedidoCompra = i.cdFkPedidoCompra ";
        $sSql .= "WHERE p.cdPedidoCompra = '" .$this->nCdPedidoCompra."'";
        $oDados = $this->oBd->PesquisarSQL($sSql);
        if($oDados){
          $dPeso = $oDados[0]->soma;
        }
        return $dPeso;
      } //fim - GetPeso()


      //valida os dados antes de calcular o frete
      private function ValidarDadosAntesCalcularFrete(){
        $bRetorno = true;
        
        if(($this->nCdPedidoCompra == 0)or($this->nCdPedidoCompra == null)){
          $this->sRetornoErro = "Não foi possível encontrar o pedido de compra";
          $bRetorno = false;
        }
        
        if(($this->nTotalItensPedidoCompra == 0)or($this->nTotalItensPedidoCompra == null)){
          $this->sRetornoErro = "Pedido de compra não possui produtos";
          $bRetorno = false;
        }
        
        if(($this->sCEP_Origem == "")or($this->sCEP_Origem == null)or(strlen($this->sCEP_Origem) < 8)){
          $this->sRetornoErro = "CEP de origem deve conter 8 caracteres";
          $bRetorno = false;
        }
        
        if(($this->sCEP_Destino == "")or($this->sCEP_Destino == null)or(strlen($this->sCEP_Destino) < 8)){
          $this->sRetornoErro = "Erro com o CEP de destino. Contacte o administrador";
          $bRetorno = false;
        }

        return $bRetorno;
      } //fim - ValidarDadosAntesCalcularFrete()
      
      
      //ajusta o peso
      private function AjustarPeso(){
        if($this->dPeso <= 300){
          $this->dPeso = 500;
        }
        $this->dPeso = $this->dPeso / 1000;
      } //fim - AjustarPeso()
      

      //calcula o valor do frete para os serviços PAC, SEDEX, SEDEX_10 e SEDEX_HOJE
      private function CalcularFreteServicoPAC_SEDEX_10_HOJE($sServico){
        $sUrl = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
        $sUrl .= "nCdEmpresa=&sDsSenha=&sCepOrigem=".$this->sCEP_Origem."&sCepDestino=".$this->sCEP_Destino;
        $sUrl .= "&nVlPeso=".$this->dPeso."&nCdFormato=1&nVlComprimento=25&nVlAltura=5&nVlLargura=15";
        $sUrl .= "&sCdMaoPropria=n&nVlValorDeclarado=1&sCdAvisoRecebimento=n&nCdServico=".$sServico;
        $sUrl .= "&nVlDiametro=20&StrRetorno=xml";

        //captura as linhas da URL retornada
        $fonte = file($sUrl);
        //varre as linhas e procura o valor do frete, no caso está na linha 660
        //caso não retorne descomente a linha dentro do foreach e veja qual a linha que retorna o valor
        
        foreach ($fonte as $www) {
          $bsc = "/\<Valor>(.*)\<\/Valor>/";
          $bsc2 = "/\<MsgErro>(.*)\<\/MsgErro>/";
          if(preg_match($bsc,$www,$retorno)){
            //$preco = number_format($retorno[1],2,',','.');
            $preco = str_replace(',','.',$retorno[0]);
            $preco = strip_tags($preco);
          }
          if(preg_match($bsc2,$www,$retorno)){
            $descricao = $retorno[1];
          }
        }
        
        //se os correios estiver fora do ar aparece uma mensagem
        if($preco == ''){
          $this->sRetornoErro = "Erro, correios não respondeu!";
        }
        
        if(empty($descricao)){
          return $preco;
        }
        else{
          return $descricao;
        }
      } // fim - CalcularFreteServicoPAC_SEDEX_10_HOJE($sServico)


      //calcula o valor do frete utilizando o serviço Sedex a Cobrar
      private function CalcularFreteServicoSedex_a_Cobrar(){
        $sUrl = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
        $sUrl .= "nCdEmpresa=&sDsSenha=&sCepOrigem=".$this->sCEP_Origem."&sCepDestino=".$this->sCEP_Destino;
        $sUrl .= "&nVlPeso=".$this->dPeso."&nCdFormato=1&nVlComprimento=25&nVlAltura=5&nVlLargura=15";
        $sUrl .= "&sCdMaoPropria=n&nVlValorDeclarado=1&sCdAvisoRecebimento=n&nCdServico=".SERVICO_SEDEX_A_COBRAR;
        $sUrl .= "&nVlDiametro=20&StrRetorno=xml";

        //captura as linhas da URL retornada
        $fonte = file($sUrl);
        //varre as linhas e procura o valor do frete, no caso está na linha 660
        //caso não retorne descomente a linha dentro do foreach e veja qual a linha que retorna o valor

        foreach ($fonte as $www) {
          $bsc = "/\<Valor>(.*)\<\/Valor>/";
          $bsc2 = "/\<MsgErro>(.*)\<\/MsgErro>/";
          if(preg_match($bsc,$www,$retorno)){
            //$preco = number_format($retorno[1],2,',','.');
            $preco = str_replace(',','.',$retorno[0]);
            $preco = strip_tags($preco);
          }
          if(preg_match($bsc2,$www,$retorno)){
            $descricao = $retorno[1];
          }
        }

        //se os correios estiver fora do ar aparece uma mensagem
        if($preco == ''){
          $this->sRetornoErro = "Erro, correios não respondeu!";
        }

        if(empty($descricao)) { echo $preco; } else { echo $descricao; }
      } // fim - CalcularFreteServicoSedex_a_Cobrar()


      //calcula a quantidade de itens do pedido de compra
      private function GetQuantidadeItensPedidoCompra(){
        if($this->nCdPedidoCompra != 0){
          $nTotalItens = 0;
          $sSql = "SELECT COUNT(cdItemPedidoCompra) AS 'total'";
          $sSql .= " FROM item_pedido_compra";
          $sSql .= " WHERE cdFkPedidoCompra = '".$this->nCdPedidoCompra."'";
          $sSql .= " AND status = 'aberto'";

          $oDados = $this->oBd->PesquisarSQL($sSql);
          if($oDados){
            $nTotalItens = $oDados[0]->total;
          }
          return $nTotalItens;
        }
      } //fim - GetQuantidadeItensPedidoCompra()
      

      //formata a saída do CEP, inserindo o caracter '-'
      private function GetFormatarSaidaCEP($psCEP){
        $sCEP = substr($psCEP,0,5) . "-" . substr($psCEP,5,3);
        return $sCEP;
      } //fim - GetFormatarSaidaCEP($psCEP)

      
      //retorna o processamento da página AJAX
      private function RetornoProcessamentoAJAX(){
        $this->sCEP_Origem = $this->GetFormatarSaidaCEP($this->sCEP_Origem);
        $this->sCEP_Destino = $this->GetFormatarSaidaCEP($this->sCEP_Destino);
        
        $sResposta = "[{";
        $sResposta .= "'CEP_Origem': '".$this->sCEP_Origem."',";
        $sResposta .= "'CEP_Destino': '".$this->sCEP_Destino."',";
        $sResposta .= "'peso': '".$this->dPeso."',";
        $sResposta .= "'valorPAC': '".$this->dValorPAC."',";
        $sResposta .= "'valorSEDEX': '".$this->dValorSEDEX."',";
        $sResposta .= "'valorSEDEX_10': '".$this->dValorSEDEX_10."',";
        //$sResposta .= "'valorSEDEX_A_COBRAR': '".$this->dValorSEDEX_A_COBRAR."',";
        $sResposta .= "'valorSEDEX_HOJE': '".$this->dValorSEDEX_HOJE."'";
        $sResposta .= "}]";
  //      $sResposta = json_encode($sResposta); //problema com charset
        echo $sResposta;
      } //fim - RetornoProcessamentoAJAX()
      
      private function temp(){
        echo "nCdPedidoCompra = " . $this->nCdPedidoCompra;
        echo "<br />";
        echo "dValorPAC = " . $this->dValorPAC;
        echo "<br />";

        echo "dValorSEDEX = " . $this->dValorSEDEX;
        echo "<br />";
        echo "dValorSEDEX_10 = " . $this->dValorSEDEX_10;
        echo "<br />";
        echo "dValorSEDEX_A_COBRAR = " . $this->dValorSEDEX_A_COBRAR;
        echo "<br />";
        echo "dValorSEDEX_HOJE = " . $this->dValorSEDEX_HOJE;
        echo "<br />";

        echo "sCEP_Origem = " . $this->sCEP_Origem;
        echo "<br />";
        echo "sCEP_Destino = " . $this->sCEP_Destino;
        echo "<br />";

        echo "dPeso = " . $this->dPeso;
        echo "<br />";
        echo "dValorDeclarado = " . $this->dValorDeclarado;
        echo "<br />";
      } //fim - temp()

    } //fim - class CalcularFrete()
?>
