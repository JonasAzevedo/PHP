<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxSelecionarFrete.php
  Função: página que seleciona o frete que o usuário deseja para o seu pedido de compra
  Data de Criação: 01/04/2011 - 09:44
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
  GetTipoFrete() //formata o nome do tipo do frete
  ValidarDadosAntesSelecionarFrete() //valida os dados antes de selecionar o frete
  AtualizarTipoFrete() //atualiza o tipo de frete selecionado na tabela do pedido da compra
  RetornoProcessamentoAJAX() //retorna o processamento da página AJAX
*/

    $selecionarFrete = new SelecionarFrete();

    class SelecionarFrete{
      //bd
      private $oBd;
      private $sSql;
      
      //métodos gerais
      private $oMetGer;

      //dados recebidos via $_POST
      private $nCdPedidoCompra;
      private $sTipoFrete;
      private $dValorFrete;

      private $sRetornoOk;
      private $sRetornoErro;


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->DefinirConstantes();
        $this->InicializarVariaveis();
        if($this->ValidarDadosAntesSelecionarFrete()){
          $this->AtualizarTipoFrete();
        }
        //retorno
        if($this->sRetornoErro == ""){
          $this->RetornoProcessamentoAJAX();
        }
        else{
          echo $this->sRetornoErro;
        }
      }


      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }


      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
        require_once("./classes/metodosGerais.php");
	  }


	  private function DefinirConstantes(){
        define("SERVICO_PAC", "PAC");
        define("SERVICO_SEDEX", "SEDEX");
        define("SERVICO_SEDEX_10", "SEDEX 10");
        define("SERVICO_SEDEX_A_COBRAR", "SEDEX A COBRAR");
        define("SERVICO_SEDEX_HOJE", "SEDEX HOJE");
      } //fim - DefinirConstantes()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //métodos gerais
        $this->oMetGer = MetodosGerais::GetInstanciaMetodosGerais();

        if($_SERVER['REQUEST_METHOD']=='POST'){
          $this->nCdPedidoCompra = trim($this->oMetGer->GetPost('nCdPedidoCompra'));
          $this->sTipoFrete = trim($this->oMetGer->GetPost('sTipoFrete'));
          $this->dValorFrete = trim($this->oMetGer->GetPost('dValorFrete'));
        }
        $this->sTipoFrete = $this->GetTipoFrete();

        $this->sRetornoOk = "";
        $this->sRetornoErro = "";
      } //fim - InicializarVariaveis()
      
      
      //formata o nome do tipo do frete
      private function GetTipoFrete(){
        $sRetorno = "";
        switch($this->sTipoFrete){
          case "rdBtnServicoFretePAC":
            $sRetorno = SERVICO_PAC;
            break;
          case "rdBtnServicoFreteSedex":
            $sRetorno = SERVICO_SEDEX;
            break;
          case "rdBtnServicoFreteSedex10":
            $sRetorno = SERVICO_SEDEX_10;
            break;
          case "rdBtnServicoFreteSedexHoje":
            $sRetorno = SERVICO_SEDEX_HOJE;
            break;
          default:
            $sRetorno = "";
            break;
        } //fim - switch()

        return $sRetorno;
      } //fim - GetTipoFrete()


      //valida os dados antes de selecionar o frete
      private function ValidarDadosAntesSelecionarFrete(){
        $bRetorno = true;

        if(($this->nCdPedidoCompra == 0)or($this->nCdPedidoCompra == null)){
          $this->sRetornoErro = "Não foi possível encontrar o pedido de compra";
          $bRetorno = false;
        }

        if(($this->sTipoFrete == "")or($this->sTipoFrete == null)){
          $this->sRetornoErro = "Não há um tipo de frete selecionado";
          $bRetorno = false;
        }
        
        if(($this->dValorFrete == 0)or($this->dValorFrete == null)){
          $this->sRetornoErro = "Não há um valor de frete selecionado";
          $bRetorno = false;
        }

        return $bRetorno;
      } //fim - ValidarDadosAntesSelecionarFrete()
      
      
      //atualiza o tipo de frete selecionado na tabela do pedido da compra
      private function AtualizarTipoFrete(){
        $this->sSql = "UPDATE pedido_compra SET tipo_frete='" .$this->sTipoFrete. "', ";
        $this->sSql .= "valor_frete='" .$this->dValorFrete. "' ";
        $this->sSql .= "WHERE cdPedidoCompra='" .$this->nCdPedidoCompra. "'";
        $bAtualizouFrete = mysql_query($this->sSql, $this->oBd->oCon);
        if($bAtualizouFrete){
          $this->sRetornoOk = "Frete atualizado.";
        }
        else{
          $this->sRetornoErro =  "Frete não pode ser atualizado.";
        }
      } //fim - AtualizarTipoFrete()


      //retorna o processamento da página AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->sRetornoOk;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class SelecionarFrete()
?>
