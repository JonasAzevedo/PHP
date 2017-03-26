<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxRealizarLoginUsuario.php
  Função: realiza login do usuário no site
  Data de Criação: 14/02/2011 - 13:49
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: pgAjaxRealizarLoginUsuario.php?login=login&senha=senha
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  IniciarSession()
  GravarSession()
  InicializarVariaveis()
  ValidarLoginUsuario() //valida se login do usuário é válido (sUsuarioLogin + sSenhaLogin)
  GravarLogLoginUsuario() //grava log do login do usuário
  AtualizarUsuarioDoPedidoCompra() //atualizar usuário para pedido de compra atual
  CalcularQuantidadeItensPedidoCompra() //calcula a quantidade de itens do pedido de compra - caso o usuário realizou compra antes de efetuar o login
  RetornarRegistroJSON() //retorno AJAX em formato JSON
*/

    $loginUsuario = new LoginUsuario();

    class LoginUsuario{
      //bd
      private $oBd;
      private $sSql;

      //dados recebidos via $_GET - para realizar login
      private $sUsuarioLogin;
      private $sSenhaLogin;

      //dados do usuário logado
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
        //login válido ?
        if($this->ValidarLoginUsuario()){
          $this->GravarLogLoginUsuario();
          $this->AtualizarUsuarioDoPedidoCompra();
          $this->CalcularQuantidadeItensPedidoCompra();
          $this->GravarSession();
        }
        $this->RetornarRegistroJSON();
      }
      
      
      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }
      
      
      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
	  }


      //inicia a sessão que armazenará os dados do usuário logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()


      //grava a sessão
      private function GravarSession(){
        $_SESSION["nCodigo"] = $this->nCodigo;
        $_SESSION["sUsuario"] = $this->sUsuario;
        $_SESSION["sSenha"] = $this->sSenha;
        $_SESSION["sNome"] = $this->sNome;
        $_SESSION["nIdLog"] = $this->nIdLog;
        if(!(isset($_SESSION["nIdCompra"]))){ //pode ter realizado uma compra sem estar logado
          $_SESSION["nIdCompra"] = 0; //preenchido quando usuário realizar uma compra
        }
      } //fim - GravarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        
        //armazena parâmetros recebidos via GET
        if(isset($_GET['login'])){
          $this->sUsuarioLogin = $_GET['login'];
        }
        else{
          $this->sUsuarioLogin = "";
        }
        if(isset($_GET['senha'])){
          $this->sSenhaLogin = $_GET['senha'];
        }
        else{
          $this->sSenhaLogin = "";
        }

        $this->nCodigo = 0;
        $this->sUsuario = "";
        $this->sSenha = "";
        $this->sNome = "";
        $this->nIdLog = 0;
        
        if(isset($_SESSION["nIdCompra"])){
          $this->nCdPedidoCompra = $_SESSION["nIdCompra"];
        }
        else{
          $this->nCdPedidoCompra = 0;
        }

        $this->nTotalItensPedidoCompra = 0;
      } //fim - InicializarVariaveis()


      //valida se login do usuário é válido (sUsuarioLogin + sSenhaLogin)
      private function ValidarLoginUsuario(){
        $oDadosLoginUsuario = null;
        $oLinha = null;
        $oDadosRegistro = null;
        $nTotalRegistros = 0;
        
        $this->sSql = "SELECT * FROM usuario u ";
        $this->sSql .= "WHERE u.login='".$this->sUsuarioLogin."' AND u.senha='".$this->sSenhaLogin."'";
        $oDadosLoginUsuario = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosLoginUsuario){
          $nTotalRegistros = count($oDadosLoginUsuario);
        }

        if($nTotalRegistros == 1){
          $this->nCodigo = $oDadosLoginUsuario[0]->cdUsuario;
          $this->sUsuario = $oDadosLoginUsuario[0]->login;
          $this->sSenha = $oDadosLoginUsuario[0]->senha;
          //$this->sNome = $oDadosLoginUsuario[0]->nome;
          $this->sNome = $oDadosLoginUsuario[0]->nome_chamado;
          $this->nIdLog = 0;
          return true;
        }
        else{
          return false;
        }
      } //fim -  ValidarLoginUsuario()
      

      //grava log do login do usuário
      private function GravarLogLoginUsuario(){
        $bInsert;
        $this->sSql = "INSERT INTO log_login_usuario(cdFkUsuario,data_entrada) ";
        $this->sSql .= "VALUES ('".$this->nCodigo."', CURRENT_TIMESTAMP)";
        $bInsert = mysql_query($this->sSql, $this->oBd->oCon);
        if($bInsert){
          $this->sSql = "SELECT last_insert_id() AS id";
          $oDadosIdLog = $this->oBd->PesquisarSQL($this->sSql);
          if($oDadosIdLog){
            $this->nIdLog = $oDadosIdLog[0]->id;
          }
        }
      } //fim - GravarLogLoginUsuario()
      
      
      //atualizar usuário para pedido de compra atual
      private function AtualizarUsuarioDoPedidoCompra(){
        //se existe usuário logado e pedido de compra aberto,
        //verifica se o pedido de compra ainda não tem usuário setado
        if(($this->nCodigo != 0)and($this->nCdPedidoCompra != 0)){
          $sSql = "SELECT cdFkUsuario FROM pedido_compra WHERE cdPedidoCompra='" .$this->nCdPedidoCompra. "'";
          $oDados = $this->oBd->PesquisarSQL($sSql);
          if($oDados){
            //ainda não tem usuário para o pedido de compra
            if($oDados[0]->cdFkUsuario == 0){
              $sSql = "UPDATE pedido_compra SET cdFkUsuario='" .$this->nCodigo. "' ";
              $sSql .= "WHERE cdPedidoCompra='".$this->nCdPedidoCompra."'";
              $bUpdate = mysql_query($sSql, $this->oBd->oCon);
            }
          }
        }
      } //fim - AtualizarUsuarioDoPedidoCompra()
      
      
      //calcula a quantidade de itens do pedido de compra
      //caso o usuário realizou compra antes de efetuar o login
      private function CalcularQuantidadeItensPedidoCompra(){
        if($this->nCdPedidoCompra != 0){
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
        }
      } //fim - QuantidadeItensPedidoCompra()
      
      
      //retorno AJAX em formato JSON
      private function RetornarRegistroJSON(){
        if($this->nCodigo != 0){
          $sValidou = "sim";
        }
        else{
          $sValidou = "nao";
        }
        //monta registro em formato JSON
        $registro = "{'registro':[";
          $registro .= "{'validou':'" .$sValidou. "'";
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
      
    } //fim - class LoginUsuario()
?>
