<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxVerificaExisteCadastroUsuario.php
  Fun��o: p�gina que retorna se o cadastro do usu�rio desejado j� existe - usa Ajax
  Data de Cria��o: 13/02/2011 - 08:49
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: pgAjaxVerificaExisteCadastroUsuario.php?chamou=cadNovoUsuario&nome=nome&email=email&login=login
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  InicializarVariaveis()
  MontarSQLPesquisarVerificarCadastroUsuario()  //monta o SQL e executa o SELECT de verifica��o do cadastro de usu�rio
  RetornarRegistroJSON()  //retorno AJAX em formato JSON
*/

    $verificaCadastroUsuario = new VerificarCadastroUsuario();

    class VerificarCadastroUsuario{
      //bd
      private $oBd;
      private $sSql;

      //par�metros recebidos
      private $sChamou;
      private $sNome;
      private $sEmail;
      private $sLogin;

      private $nTotalNome;
      private $nTotalEmail;
      private $nTotalLogin;

      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        if($this->sChamou == "cadNovoUsuario"){
          $this->MontarSQLPesquisarVerificarCadastroUsuario();
          $this->RetornarRegistroJSON();
        }
        else{
          echo "";
        }
      }
      
      
      //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }


      //solicita arquivos necess�rios desta p�gina
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
	  }


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";

        //armazena par�metros recebidos via GET
        if(isset($_GET['chamou'])){
          $this->sChamou = $_GET['chamou'];
        }
        else{
          $this->sChamou = "";
        }

        if(isset($_GET['nome'])){
          $this->sNome = trim($_GET['nome']);
        }
        else{
          $this->sNome = "";
        }
        
        if(isset($_GET['email'])){
          $this->sEmail = trim($_GET['email']);
        }
        else{
          $this->sEmail = "";
        }
        
        if(isset($_GET['login'])){
          $this->sLogin = trim($_GET['login']);
        }
        else{
          $this->sLogin = "";
        }
        
        $this->nTotalNome = 0;
        $this->nTotalEmail = 0;
        $this->nTotalLogin = 0;
      } //fim - InicializarVariaveis()
      

      //monta o SQL e executa o SELECT de verifica��o do cadastro de usu�rio
      private function MontarSQLPesquisarVerificarCadastroUsuario(){
        //verifica se nome j� est� cadastrado
        $this->sSql = "SELECT cdUsuario FROM usuario WHERE nome = '" .$this->sNome. "'";
        $oDadosPesquisaNome = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosPesquisaNome){
          $this->nTotalNome = count($oDadosPesquisaNome);
        }
        
        //verifica se email j� est� cadastrado
        $this->sSql = "SELECT cdUsuario FROM usuario WHERE email = '" .$this->sEmail. "'";
        $oDadosPesquisaEmail = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosPesquisaEmail){
          $this->nTotalEmail = count($oDadosPesquisaEmail);
        }

        //verifica se login j� est� cadastrado
        $this->sSql = "SELECT cdUsuario FROM usuario WHERE login = '" .$this->sLogin. "'";
        $oDadosPesquisaLogin = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosPesquisaLogin){
          $this->nTotalLogin = count($oDadosPesquisaLogin);
        }
      } //fim -  MontarSQLPesquisarVerificarCadastroUsuario()
      
      
      //retorno AJAX em formato JSON
      private function RetornarRegistroJSON(){
        $oRegistro = "{'registro':[{";
        $oRegistro .= "'totalNome':'" .$this->nTotalNome. "'";
        $oRegistro .= ",'totalEmail':'" .$this->nTotalEmail. "'";
        $oRegistro .= ",'totalLogin':'" .$this->nTotalLogin. "'";
        $oRegistro .= "}]}";
        echo $oRegistro;
      } //fim - RetornarRegistroJSON()


    } //fim - class VerificarCadastroUsuario()
?>
