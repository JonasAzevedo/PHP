<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxRecuperarSenha.php
  Função: página que recupera a senha do usuário - usa Ajax
  Data de Criação: 09/03/2011 - 13:52
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: pgAjaxRecuperarSenha.php?login=login&email=email
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  InicializarVariaveis()
  VerificarTipoValidarParametros() //verifica o tipo que irá ser validado os parâmetros - //valores possíveis para: $this->sTipoValidar = login, email, login_email
  BuscarUsuarioRecuperarSenha() //busca o usuário o qual será enviado o email de recuperação de senha
  EnviarEmailRecuperarSenha() //envia o email de recuperação da senha
  RetornoProcessamentoAJAX() //retorna o processamento da página AJAX
*/

    $recuperarSenha = new RecuperarSenha();

    class RecuperarSenha{
      //bd
      private $oBd;
      private $sSql;

      //métodos gerais
      private $oMetGer;

      private $oEnvioEmail;

      //parâmetros recebidos
      private $sLogin;
      private $sEmail;
      
      private $sTipoValidar; //valores possíveis = login, email, login_email
      
      //dados do usuário, com base nos parâmetros $sLogin e $sEmail
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


      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }
      
      
      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
        require_once("./classes/metodosGerais.php");
        require_once("./classes/enviarEmail.php");
	  }
      

      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //métodos gerais
        $this->oMetGer = MetodosGerais::GetInstanciaMetodosGerais();
        
        $this->oEnvioEmail = null;

        //parâmetros recebidos via _POST
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
      
      
      //verifica o tipo que irá ser validado os parâmetros
      //valores possíveis para: $this->sTipoValidar = login, email, login_email
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
      
      
      //busca o usuário o qual será enviado o email de recuperação de senha
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
        else{ //select não pode ser realizado
          $this->sRetorno = "Usuário não pode ser localizado.";
        }
        
        if(count($oDadosPesquisaUsuario) == 0){ //não encontrou usuário
          if($this->sTipoValidar == "login_email"){
            $this->sRetorno = "Usuário não encontrado com o login e email informados.";
          }
          else if($this->sTipoValidar == "login"){
            $this->sRetorno = "Usuário não encontrado com o login informado.";
          }
          else if($this->sTipoValidar == "email"){
            $this->sRetorno = "Usuário não encontrado com o email informado.";
          }
        }
        else{ //encontrou usuário
          $this->nUsuarioCodigo = $oDadosPesquisaUsuario[0]->cdUsuario;
          $this->sUsuarioNomeChamado = $oDadosPesquisaUsuario[0]->nome_chamado;
          $this->sUsuarioEmail = $oDadosPesquisaUsuario[0]->email;
          $this->sUsuarioLogin = $oDadosPesquisaUsuario[0]->login;
          $this->sUsuarioSenha = $oDadosPesquisaUsuario[0]->senha;
        }
      } //fim - BuscarUsuarioRecuperarSenha()
      
      
      //envia o email de recuperação da senha
      private function EnviarEmailRecuperarSenha(){
        $this->oEnvioEmail = new EnviarEmail("recuperar_senha");
        $this->oEnvioEmail->DefinirDadosEnvioEmail($this->nUsuarioCodigo, $this->sUsuarioEmail, $this->sUsuarioNomeChamado);
        $this->oEnvioEmail->ChamarFuncoesEnviarEmail();
        if($this->oEnvioEmail->EnviouEmail()){
          $this->sRetorno = "Email enviado com sucesso.";
        }
        else{
          $this->sRetorno = "Email não pode ser enviado.";
        }
      } //fim - EnviarEmailRecuperarSenha()
      
      
      //retorna o processamento da página AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->sRetorno;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class RecuperarSenha()
?>
