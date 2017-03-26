<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxVerificaExisteCadastroUsuario.php
  Função: página que retorna se o cadastro do usuário desejado já existe - usa Ajax
  Data de Criação: 13/02/2011 - 08:49
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: pgAjaxVerificaExisteCadastroUsuario.php?chamou=cadNovoUsuario&nome=nome&email=email&login=login
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  InicializarVariaveis()
  MontarSQLPesquisarVerificarCadastroUsuario()  //monta o SQL e executa o SELECT de verificação do cadastro de usuário
  RetornarRegistroJSON()  //retorno AJAX em formato JSON
*/

    $verificaCadastroUsuario = new VerificarCadastroUsuario();

    class VerificarCadastroUsuario{
      //bd
      private $oBd;
      private $sSql;

      //parâmetros recebidos
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
      
      
      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }


      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
	  }


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";

        //armazena parâmetros recebidos via GET
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
      

      //monta o SQL e executa o SELECT de verificação do cadastro de usuário
      private function MontarSQLPesquisarVerificarCadastroUsuario(){
        //verifica se nome já está cadastrado
        $this->sSql = "SELECT cdUsuario FROM usuario WHERE nome = '" .$this->sNome. "'";
        $oDadosPesquisaNome = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosPesquisaNome){
          $this->nTotalNome = count($oDadosPesquisaNome);
        }
        
        //verifica se email já está cadastrado
        $this->sSql = "SELECT cdUsuario FROM usuario WHERE email = '" .$this->sEmail. "'";
        $oDadosPesquisaEmail = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosPesquisaEmail){
          $this->nTotalEmail = count($oDadosPesquisaEmail);
        }

        //verifica se login já está cadastrado
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
