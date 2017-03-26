<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxFinalizarEnderecoEntrega.php
  Função: página que cadastra o endereço de entrega - ao estar finalizando o pedido
  Data de Criação: 28/02/2011 - 21:57
  Data de Atualização: 28/03/2011 - 10:33
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  IniciarSession()
  InicializarVariaveis()
  AtualizarEnderecoEntrega() //atualiza o endereço de entrega do pedido da compra
  AtualizarEnderecoPadrao() //atualiza o endereço padrão do usuário para o endereço deste pedido de compra
  RetornoProcessamentoAJAX() //retorna o processamento da página AJAX
*/
    $finalizarEnderecoEntrega = new FinalizarEnderecoEntrega();

    class FinalizarEnderecoEntrega{
      //bd
      private $oBd;
      private $sSql;
      
      //métodos gerais
      private $oMetGer;

      //recebidos via POST
      private $sUF;
      private $sCidade;
      private $sCEP;
      private $sBairro;
      private $sRua;
      private $sNumero;
      private $sComplemento;
      private $sSalvarEnderecoPadrao;

      private $nCdPedidoCompra; //código do pedido da compra
      private $nCdUsuario; //código do usuário

      //retorno
      private $sRetorno;

      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();
        //sem usuário logado
        if(($this->nCdUsuario == 0)or($this->nCdUsuario == null)){
          $this->sRetorno = "Sem usuário logado";
        }
        //sem pedido de compra
        else if(($this->nCdPedidoCompra == 0)or($this->nCdPedidoCompra == null)){
          $this->sRetorno = "sem pedido compra";
        }
        else{ //atualiza endereço
          $this->AtualizarEnderecoEntrega();
          if(($this->sSalvarEnderecoPadrao == "salvarEnderecoPadrao")and
            ($this->sRetorno == "Endereço de entrega salvo.")){
            $this->AtualizarEnderecoPadrao();
          }
        }
        $this->RetornoProcessamentoAJAX();
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
      
      
      //inicia a sessão que armazenará os dados do usuário logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //métodos gerais
        $this->oMetGer = MetodosGerais::GetInstanciaMetodosGerais();
        
        //pedido_compra
        $this->nCdPedidoCompra = trim($this->oMetGer->GetSession('nIdCompra'));
        //código do usuário
        $this->nCdUsuario = trim($this->oMetGer->GetSession('nCodigo'));
        //parâmetros recebidos via _POST
        if($_SERVER['REQUEST_METHOD']=='POST'){
          $this->sUF = trim($this->oMetGer->GetPost('txtValorEnderecoEntregaUF'));
          $this->sCidade = trim($this->oMetGer->GetPost('txtValorEnderecoEntregaCidade'));
          $this->sCEP = trim($this->oMetGer->GetPost('txtValorEnderecoEntregaCEP'));
          $this->sBairro = trim($this->oMetGer->GetPost('txtValorEnderecoEntregaBairro'));
          $this->sRua = trim($this->oMetGer->GetPost('txtValorEnderecoEntregaRua'));
          $this->sNumero = trim($this->oMetGer->GetPost('txtValorEnderecoEntregaNumero'));
          $this->sComplemento = trim($this->oMetGer->GetPost('txtAreaValorEnderecoEntregaComplemento'));
          $this->sSalvarEnderecoPadrao = trim($this->oMetGer->GetPost('ckBxEnderecoPadrao'));
        }

        //retorno
        $this->sRetorno = "";
      } //fim - InicializarVariaveis()
      
      
      //atualiza o endereço de entrega do pedido da compra
      private function AtualizarEnderecoEntrega(){
        $this->sSql = "UPDATE pedido_compra SET endereco_entrega_uf='" .$this->sUF. "',endereco_entrega_cidade='";
        $this->sSql .= $this->sCidade. "',endereco_entrega_cep='" .$this->sCEP. "',endereco_entrega_bairro='";
        $this->sSql .= $this->sBairro. "',endereco_entrega_rua='" .$this->sRua. "',endereco_entrega_numero='";
        $this->sSql .= $this->sNumero. "',endereco_entrega_complemento='" .$this->sComplemento. "'";
        $this->sSql .= " WHERE cdPedidoCompra='" .$this->nCdPedidoCompra. "'";
        
        $bSalvouEnderecoEntrega = mysql_query($this->sSql, $this->oBd->oCon);
        if($bSalvouEnderecoEntrega){
          $this->sRetorno = "Endereço de entrega salvo.";
        }
      } //fim - AtualizarEnderecoEntrega()
      

      //atualiza o endereço padrão do usuário para o endereço deste pedido de compra
      private function AtualizarEnderecoPadrao(){
        $this->sSql = "UPDATE usuario SET endereco_uf='" .$this->sUF. "',endereco_cidade='";
        $this->sSql .= $this->sCidade. "',endereco_cep='" .$this->sCEP. "',endereco_bairro='";
        $this->sSql .= $this->sBairro. "',endereco_rua='" .$this->sRua. "',endereco_numero='";
        $this->sSql .= $this->sNumero. "',endereco_complemento='" .$this->sComplemento. "'";
        $this->sSql .= " WHERE cdUsuario='" .$this->nCdUsuario. "'";
        
        $bSalvouEnderecoUsuario = mysql_query($this->sSql, $this->oBd->oCon);
      } //fim - AtualizarEnderecoPadrao()


      //retorna o processamento da página AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->sRetorno;
      } //fim - RetornoProcessamentoAJAX()


    } //fim - class ComprarItemProduto();
?>

