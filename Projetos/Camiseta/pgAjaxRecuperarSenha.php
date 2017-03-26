<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxRecuperarSenha.php
  Fun��o: p�gina que recupera a senha do usu�rio - usa Ajax
  Data de Cria��o: 09/03/2011 - 13:52
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: pgAjaxRecuperarSenha.php?login=login&email=email
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  InicializarVariaveis()
  VerificarTipoValidarParametros() //verifica o tipo que ir� ser validado os par�metros - //valores poss�veis para: $this->sTipoValidar = login, email, login_email
  BuscarUsuarioRecuperarSenha() //busca o usu�rio o qual ser� enviado o email de recupera��o de senha
  EnviarEmailRecuperarSenha() //envia o email de recupera��o da senha
  RetornoProcessamentoAJAX() //retorna o processamento da p�gina AJAX
*/

    $recuperarSenha = new RecuperarSenha();

    class RecuperarSenha{
      //bd
      private $oBd;
      private $sSql;

      //m�todos gerais
      private $oMetGer;

      private $oEnvioEmail;

      //par�metros recebidos
      private $sLogin;
      private $sEmail;
      
      private $sTipoValidar; //valores poss�veis = login, email, login_email
      
      //dados do usu�rio, com base nos par�metros $sLogin e $sEmail
      private $nUsuarioCodigo;
      private $sUsuarioNomeChamado;
      private $sUsuarioEmail;
      private $sUsuarioLogin;
      private $sUsuarioSenha;

      private $sRetorno; //retorno AJAX


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->VerificarTipoValidarParametros();
        if($this->sTipoValidar != ""){
          $this->BuscarUsuarioRecuperarSenha();
          if($this->nUsuarioCodigo != 0){
            $this->EnviarEmailRecuperarSenha();
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
        require_once("./classes/enviarEmail.php");
	  }
      

      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //m�todos gerais
        $this->oMetGer = MetodosGerais::GetInstanciaMetodosGerais();
        
        $this->oEnvioEmail = null;

        //par�metros recebidos via _POST
        if($_SERVER['REQUEST_METHOD']=='POST'){
          $this->sLogin = trim($this->oMetGer->GetPost('login'));
          $this->sEmail = trim($this->oMetGer->GetPost('email'));
        }

        $this->sTipoValidar = "";
        
        $this->nUsuarioCodigo = 0;
        $this->sUsuarioNomeChamado = "";
        $this->sUsuarioEmail = "";
        $this->sUsuarioLogin = "";
        $this->sUsuarioSenha = "";

        $this->sRetorno = "";
      } //fim - InicializarVariaveis()
      
      
      //verifica o tipo que ir� ser validado os par�metros
      //valores poss�veis para: $this->sTipoValidar = login, email, login_email
      private function VerificarTipoValidarParametros(){
        if(($this->sLogin != "")and($this->sEmail != "")){
          $this->sTipoValidar = "login_email";
        }
        else if(($this->sLogin != "")and($this->sEmail == "")){
          $this->sTipoValidar = "login";
        }
        else if(($this->sLogin == "")and($this->sEmail != "")){
          $this->sTipoValidar = "email";
        }
        else if(($this->sLogin == "")and($this->sEmail == "")){
          $this->sTipoValidar = "";
          $this->sRetorno = "Informe o login ou email para recuperar a sua senha de acesso ao site.";
        }
      } //fim - VerificarTipoValidarParametros()
      
      
      //busca o usu�rio o qual ser� enviado o email de recupera��o de senha
      private function BuscarUsuarioRecuperarSenha(){
        $this->sSql = "SELECT * FROM usuario";
        if($this->sTipoValidar == "login_email"){
          $this->sSql .= " WHERE login = '" .$this->sLogin. "'";
          $this->sSql .= " AND email = '" .$this->sEmail. "'";
        }
        else if($this->sTipoValidar == "login"){
          $this->sSql .= " WHERE login = '" .$this->sLogin. "'";
        }
        else if($this->sTipoValidar == "email"){
          $this->sSql .= " WHERE email = '" .$this->sEmail. "'";
        }

        $oDadosPesquisaUsuario = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosPesquisaUsuario){
        }
        else{ //select n�o pode ser realizado
          $this->sRetorno = "Usu�rio n�o pode ser localizado.";
        }
        
        if(count($oDadosPesquisaUsuario) == 0){ //n�o encontrou usu�rio
          if($this->sTipoValidar == "login_email"){
            $this->sRetorno = "Usu�rio n�o encontrado com o login e email informados.";
          }
          else if($this->sTipoValidar == "login"){
            $this->sRetorno = "Usu�rio n�o encontrado com o login informado.";
          }
          else if($this->sTipoValidar == "email"){
            $this->sRetorno = "Usu�rio n�o encontrado com o email informado.";
          }
        }
        else{ //encontrou usu�rio
          $this->nUsuarioCodigo = $oDadosPesquisaUsuario[0]->cdUsuario;
          $this->sUsuarioNomeChamado = $oDadosPesquisaUsuario[0]->nome_chamado;
          $this->sUsuarioEmail = $oDadosPesquisaUsuario[0]->email;
          $this->sUsuarioLogin = $oDadosPesquisaUsuario[0]->login;
          $this->sUsuarioSenha = $oDadosPesquisaUsuario[0]->senha;
        }
      } //fim - BuscarUsuarioRecuperarSenha()
      
      
      //envia o email de recupera��o da senha
      private function EnviarEmailRecuperarSenha(){
        $this->oEnvioEmail = new EnviarEmail("recuperar_senha");
        $this->oEnvioEmail->DefinirDadosEnvioEmail($this->nUsuarioCodigo, $this->sUsuarioEmail, $this->sUsuarioNomeChamado);
        $this->oEnvioEmail->ChamarFuncoesEnviarEmail();
        if($this->oEnvioEmail->EnviouEmail()){
          $this->sRetorno = "Email enviado com sucesso.";
        }
        else{
          $this->sRetorno = "Email n�o pode ser enviado.";
        }
      } //fim - EnviarEmailRecuperarSenha()
      
      
      //retorna o processamento da p�gina AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->sRetorno;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class RecuperarSenha()
?>
