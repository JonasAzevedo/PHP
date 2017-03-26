<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxFinalizarEnderecoEntrega.php
  Fun��o: p�gina que cadastra o endere�o de entrega - ao estar finalizando o pedido
  Data de Cria��o: 28/02/2011 - 21:57
  Data de Atualiza��o: 28/03/2011 - 10:33
  Desenvolvido por: Jonas
  Acessando p�gina: -
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  IniciarSession()
  InicializarVariaveis()
  AtualizarEnderecoEntrega() //atualiza o endere�o de entrega do pedido da compra
  AtualizarEnderecoPadrao() //atualiza o endere�o padr�o do usu�rio para o endere�o deste pedido de compra
  RetornoProcessamentoAJAX() //retorna o processamento da p�gina AJAX
*/
    $finalizarEnderecoEntrega = new FinalizarEnderecoEntrega();

    class FinalizarEnderecoEntrega{
      //bd
      private $oBd;
      private $sSql;
      
      //m�todos gerais
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

      private $nCdPedidoCompra; //c�digo do pedido da compra
      private $nCdUsuario; //c�digo do usu�rio

      //retorno
      private $sRetorno;

      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();
        //sem usu�rio logado
        if(($this->nCdUsuario == 0)or($this->nCdUsuario == null)){
          $this->sRetorno = "Sem usu�rio logado";
        }
        //sem pedido de compra
        else if(($this->nCdPedidoCompra == 0)or($this->nCdPedidoCompra == null)){
          $this->sRetorno = "sem pedido compra";
        }
        else{ //atualiza endere�o
          $this->AtualizarEnderecoEntrega();
          if(($this->sSalvarEnderecoPadrao == "salvarEnderecoPadrao")and
            ($this->sRetorno == "Endere�o de entrega salvo.")){
            $this->AtualizarEnderecoPadrao();
          }
        }
        $this->RetornoProcessamentoAJAX();
      }


      //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }
      
      
      //solicita arquivos necess�rios desta p�gina
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
        require_once("./classes/metodosGerais.php");
	  }
      
      
      //inicia a sess�o que armazenar� os dados do usu�rio logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //m�todos gerais
        $this->oMetGer = MetodosGerais::GetInstanciaMetodosGerais();
        
        //pedido_compra
        $this->nCdPedidoCompra = trim($this->oMetGer->GetSession('nIdCompra'));
        //c�digo do usu�rio
        $this->nCdUsuario = trim($this->oMetGer->GetSession('nCodigo'));
        //par�metros recebidos via _POST
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
      
      
      //atualiza o endere�o de entrega do pedido da compra
      private function AtualizarEnderecoEntrega(){
        $this->sSql = "UPDATE pedido_compra SET endereco_entrega_uf='" .$this->sUF. "',endereco_entrega_cidade='";
        $this->sSql .= $this->sCidade. "',endereco_entrega_cep='" .$this->sCEP. "',endereco_entrega_bairro='";
        $this->sSql .= $this->sBairro. "',endereco_entrega_rua='" .$this->sRua. "',endereco_entrega_numero='";
        $this->sSql .= $this->sNumero. "',endereco_entrega_complemento='" .$this->sComplemento. "'";
        $this->sSql .= " WHERE cdPedidoCompra='" .$this->nCdPedidoCompra. "'";
        
        $bSalvouEnderecoEntrega = mysql_query($this->sSql, $this->oBd->oCon);
        if($bSalvouEnderecoEntrega){
          $this->sRetorno = "Endere�o de entrega salvo.";
        }
      } //fim - AtualizarEnderecoEntrega()
      

      //atualiza o endere�o padr�o do usu�rio para o endere�o deste pedido de compra
      private function AtualizarEnderecoPadrao(){
        $this->sSql = "UPDATE usuario SET endereco_uf='" .$this->sUF. "',endereco_cidade='";
        $this->sSql .= $this->sCidade. "',endereco_cep='" .$this->sCEP. "',endereco_bairro='";
        $this->sSql .= $this->sBairro. "',endereco_rua='" .$this->sRua. "',endereco_numero='";
        $this->sSql .= $this->sNumero. "',endereco_complemento='" .$this->sComplemento. "'";
        $this->sSql .= " WHERE cdUsuario='" .$this->nCdUsuario. "'";
        
        $bSalvouEnderecoUsuario = mysql_query($this->sSql, $this->oBd->oCon);
      } //fim - AtualizarEnderecoPadrao()


      //retorna o processamento da p�gina AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->sRetorno;
      } //fim - RetornoProcessamentoAJAX()


    } //fim - class ComprarItemProduto();
?>

