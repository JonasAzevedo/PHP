<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxRetornarTotalItensPedido.php
  Fun��o: p�gina AJAX para retornar o total de itens do pedido da compra
  Data de Cria��o: 27/03/2011 - 22:30
  Data de Atualiza��o: -
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
  CalcularQuantidadeItensPedidoCompra()  //calcula a quantidade de itens do pedido de compra
  RetornoProcessamentoAJAX() //retorna o processamento da p�gina AJAX
*/

    $totalItensPedido = new TotalItensPedido();

    class TotalItensPedido{
      //bd
      private $oBd;
      private $sSql;
      
      //m�todos gerais
      private $FMetGer;

      private $nCdPedidoCompra;
      private $nTotalItensPedidoCompra;


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();
        $this->CalcularQuantidadeItensPedidoCompra();
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


      //inicia a sess�o que armazena os dados do usu�rio logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //m�todos gerais
        $this->FMetGer = MetodosGerais::GetInstanciaMetodosGerais();
        
        $this->nCdPedidoCompra = trim($this->FMetGer->GetSession('nIdCompra'));
        $this->nTotalItensPedidoCompra = 0;
      } //fim - InicializarVariaveis()


      //calcula a quantidade de itens do pedido de compra
      private function CalcularQuantidadeItensPedidoCompra(){
        $sSql = "SELECT COUNT(cdItemPedidoCompra) AS 'total'";
        $sSql .= " FROM item_pedido_compra";
        $sSql .= " WHERE cdFkPedidoCompra = '".$this->nCdPedidoCompra."'";
        $sSql .= " AND status = 'aberto'";

        $oDadosPesquisa = $this->oBd->PesquisarSQL($sSql);
        if($oDadosPesquisa){
          $this->nTotalItensPedidoCompra = $oDadosPesquisa[0]->total;
        }
        else{
          $this->nTotalItensPedidoCompra = 0;
        }
      } //fim - CalcularQuantidadeItensPedidoCompra()


      //retorna o processamento da p�gina AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->nTotalItensPedidoCompra;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class TotalItensPedido()
?>
