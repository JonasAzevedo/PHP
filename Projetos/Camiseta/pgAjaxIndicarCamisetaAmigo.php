<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxIndicarCamisetaAmigo.php
  Fun��o: p�gina para indicar produto para amigo - usa Ajax
  Data de Cria��o: 24/03/2011 - 09:08
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  InicializarVariaveis()
  EnviarEmailIndicarProduto() //envia email para o amigo de indica��o de produto
  RetornoProcessamentoAJAX() //retorna o processamento da p�gina AJAX
xxxx

  BuscarUsuarioRecuperarSenha() //busca o usu�rio o qual ser� enviado o email de recupera��o de senha
  EnviarEmailRecuperarSenha() //envia o email de recupera��o da senha

*/

    $indicarCamiseta = new IndicarCamiseta();

    class IndicarCamiseta{
      //bd
      private $oBd;
      private $sSql;

      //m�todos gerais
      private $FMetGer;

      private $oEnvioEmail;

      //par�metros recebidos
      private $sDe; //quem est� enviando email
      private $sEmailPara; //quem vai receber o email
      private $nCdUsuarioDe; //c�digo do usu�rio que est� enviando o email (se usu�rio estiver logado)
      private $nCdProduto; //c�digo do produto que est� sendo indicado
      private $sTipoProduto; //tipo do produto que est� sendo indicado

      private $sRetorno; //retorno AJAX


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->EnviarEmailIndicarProduto();

//        if($this->sTipoValidar != ""){
//          $this->BuscarUsuarioRecuperarSenha();
  //        if($this->nUsuarioCodigo != 0){
    //        $this->EnviarEmailRecuperarSenha();
      //    }
//        }
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
        $this->FMetGer = MetodosGerais::GetInstanciaMetodosGerais();

        $this->oEnvioEmail = null;
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
          $this->sDe = trim($this->FMetGer->GetPost('txtValorOpcIndicarParaAmigoDe'));
          $this->sEmailPara = trim($this->FMetGer->GetPost('txtValorOpcIndicarParaAmigoPara'));
          $this->nCdUsuarioDe = trim($this->FMetGer->GetPost('edCdUsuarioDe'));
          $this->nCdProduto = trim($this->FMetGer->GetPost('edCdProduto'));
          $this->sTipoProduto = trim($this->FMetGer->GetPost('edTipoProduto'));
        }

        $this->sRetorno = "";
      } //fim - InicializarVariaveis()
      

      //envia email para o amigo de indica��o de produto
      private function EnviarEmailIndicarProduto(){
        $this->oEnvioEmail = new EnviarEmail("indicar_produto");
        $this->oEnvioEmail->SetProduto($this->sTipoProduto, $this->nCdProduto);
        $this->oEnvioEmail->DefinirDadosEnvioEmail(0, $this->sEmailPara, "");
        $this->oEnvioEmail->ChamarFuncoesEnviarEmail();
        if($this->oEnvioEmail->EnviouEmail()){
          $this->sRetorno = "Email enviado com sucesso.";
        }
        else{
          $this->sRetorno = "Email n�o pode ser enviado.";
        }
      } //fim - EnviarEmailIndicarProduto()
      
      
      

      //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
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
      //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
      
      




      //retorna o processamento da p�gina AJAX
      private function RetornoProcessamentoAJAX(){
        if($this->oEnvioEmail->EnviouEmail()){
          $oRetorno = "Email enviado";
        }
        else{
          $oRetorno .= "Email n�o pode ser enviado";
        }
        
        echo $oRetorno;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class IndicarCamiseta()
?>
