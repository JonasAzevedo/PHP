<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxRetornarTotalItensPedido.php
  Função: página AJAX para retornar o total de itens do pedido da compra
  Data de Criação: 27/03/2011 - 22:30
  Data de Atualização: -
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
  CalcularQuantidadeItensPedidoCompra()  //calcula a quantidade de itens do pedido de compra
  RetornoProcessamentoAJAX() //retorna o processamento da página AJAX
*/

    $totalItensPedido = new TotalItensPedido();

    class TotalItensPedido{
      //bd
      private $oBd;
      private $sSql;
      
      //métodos gerais
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


      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }


      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
        require_once("./classes/metodosGerais.php");
	  }


      //inicia a sessão que armazena os dados do usuário logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //métodos gerais
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


      //retorna o processamento da página AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->nTotalItensPedidoCompra;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class TotalItensPedido()
?>
