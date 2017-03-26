<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxVerificarSessaoLoginUsuario.php
  Fun��o: verifica se existe sess�o atual do login do usu�rio - caso o usu�rio rearregue a p�gina
  Data de Cria��o: 14/02/2011 - 11:07
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
  RetornarRegistroJSON()  //retorno AJAX em formato JSON
*/

    $sessaoLoginUsuario = new SessaoLoginUsuario();

    class SessaoLoginUsuario{
      //bd
      private $oBd;
      private $sSql;
      
      private $nCodigo;
      private $sUsuario;
      private $sSenha;
      private $sNome;
      private $nIdLog;
      private $nCdPedidoCompra;
      private $nTotalItensPedidoCompra;


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();
        $this->CalcularQuantidadeItensPedidoCompra();
        $this->RetornarRegistroJSON();
      }


      //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }
      
      
      //solicita arquivos necess�rios desta p�gina
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
	  }


      //inicia a sess�o que armazena os dados do usu�rio logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        
        if(isset($_SESSION["nCodigo"])){
          $this->nCodigo = $_SESSION["nCodigo"];
        }
        else{
          $this->nCodigo = 0;
        }
      
        if(isset($_SESSION["sUsuario"])){
          $this->sUsuario = $_SESSION["sUsuario"];
        }
        else{
          $this->sUsuario = "";
        }

        if(isset($_SESSION["sSenha"])){
          $this->sSenha = $_SESSION["sSenha"];
        }
        else{
          $this->sSenha = "";
        }

        if(isset($_SESSION["sNome"])){
          $this->sNome = $_SESSION["sNome"];
        }
        else{
          $this->sNome = "";
        }

        if(isset($_SESSION["nIdLog"])){
          $this->nIdLog = $_SESSION["nIdLog"];
        }
        else{
          $this->nIdLog = 0;
        }

        if(isset($_SESSION["nIdCompra"])){
          $this->nCdPedidoCompra = $_SESSION["nIdCompra"];
        }
        else{
          $this->nCdPedidoCompra = 0;
        }
        
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
      

      //retorno AJAX em formato JSON
      private function RetornarRegistroJSON(){
        if($this->nCodigo != 0){
          $bExisteSessao = "sim";
        }
        else{
          $bExisteSessao = "nao";
        }
        
        //monta registro em formato JSON
        $registro = "{'registro':[";
          $registro .= "{'existe_sessao':'" .$bExisteSessao. "'";
          $registro .= ",'codigo':'" .$this->nCodigo. "'";
          $registro .= ",'usuario':'" .$this->sUsuario. "'";
          $registro .= ",'senha':'" .$this->sSenha. "'";
          $registro .= ",'nome':'" .$this->sNome. "'";
          $registro .= ",'id_log':'" .$this->nIdLog. "'";
          $registro .= ",'itens_pedido':'" .$this->nTotalItensPedidoCompra. "'";
          $registro .= "}";
        $registro .= "]}";

        echo $registro;
      } //fim - RetornarRegistroJSON()

    } //fim - class SessaoLoginUsuario()
?>
