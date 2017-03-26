<?php
/*******************************************************************
********************************************************************
  Nome: pgDeletarItemPedidoCompra.php
  Fun��o: p�gina que deleta um item do pedido de compra
  Data de Cria��o: 28/02/2011 - 14:53
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
********************************************************************
*******************************************************************/

/*
//function's:
  SolicitarArquivos()
  InicializarVariaveis()
  ExecutarDeleteItemPedido() //executa delete do item do pedido
  VerificarDeleteVoltarPaginaChamou() //verifica se o delete foi executado, e retorna para a p�gina que realizou a chamada do delete
*/

    $pgDeletarItemPedidoCompra = new PgDeletarItemPedidoCompra();

    class PgDeletarItemPedidoCompra{
      //bd
      private $Fbd;
      private $sSql;
      
      private $bDeletou;
      
      //vari�veis recebidas via par�metro
      private $sChamou; //pgFinalizarCompra
      private $nCdItemPedidoCompra;

      function __construct(){
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        if($this->sChamou == "pgFinalizarCompra"){
          $this->ExecutarDeleteItemPedido();
        }
        $this->VerificarDeleteVoltarPaginaChamou();
      }


	  //solicita arquivos necess�rios desta p�gina
	  private function SolicitarArquivos(){
        require_once("../classes/ConexaoBD.php");
	  }
	  
	  private function InicializarVariaveis(){
        //p�gina que chamou esta - para depois redirecionar
        if(isset($_GET["chamou"])){
          $this->sChamou = $_GET["chamou"];
        }
        else{
          $this->sChamou = "";
        }
        
        //c�digo do item pedido de compra a ser excluido
        if(isset($_GET["cdItemPedidoCompra"])){
          $this->nCdItemPedidoCompra = $_GET["cdItemPedidoCompra"];
        }
        else{
          $this->nCdItemPedidoCompra = "";
        }
        
        //bd
        $this->Fbd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        
        $this->bDeletou = False;
      } //fim - InicializarVariaveis()
      
      
      //executa delete do item do pedido
      private function ExecutarDeleteItemPedido(){
        $this->sSql =  "UPDATE item_pedido_compra SET status='usuario_excluiu' WHERE cdItemPedidoCompra = '" .$this->nCdItemPedidoCompra. "'";
        $this->bDeletou = mysql_query($this->sSql, $this->Fbd->oCon);
      } //fim - ExecutarDeleteItemPedido()
      
      
      //verifica se o delete foi executado, e retorna para a p�gina que realizou a chamada do delete
      private function VerificarDeleteVoltarPaginaChamou(){
        //if($this->bDeletou){
        if($this->sChamou == "pgFinalizarCompra"){
          echo "<meta http-equiv='refresh' content='0;url=./pgFinalizarCompra.php'>";
        }
        else {
          echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
        }
        
        echo "<center>";
        echo "<b>";
        echo "<h2>";
        echo "<br><br><br><br><br><br>";
        echo "Voc� ser� redirecionado em instantes!";
        echo "</h2>";
        echo "</b>";
        echo "</center>";
      } //fim - VerificarDeleteVoltarPaginaChamou()
    
    } //fim - class PgDeletarItemPedidoCompra
?>
