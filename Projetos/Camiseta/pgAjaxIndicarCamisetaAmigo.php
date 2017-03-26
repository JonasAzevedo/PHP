<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxIndicarCamisetaAmigo.php
  Função: página para indicar produto para amigo - usa Ajax
  Data de Criação: 24/03/2011 - 09:08
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  InicializarVariaveis()
  EnviarEmailIndicarProduto() //envia email para o amigo de indicação de produto
  RetornoProcessamentoAJAX() //retorna o processamento da página AJAX
xxxx

  BuscarUsuarioRecuperarSenha() //busca o usuário o qual será enviado o email de recuperação de senha
  EnviarEmailRecuperarSenha() //envia o email de recuperação da senha

*/

    $indicarCamiseta = new IndicarCamiseta();

    class IndicarCamiseta{
      //bd
      private $oBd;
      private $sSql;

      //métodos gerais
      private $FMetGer;

      private $oEnvioEmail;

      //parâmetros recebidos
      private $sDe; //quem está enviando email
      private $sEmailPara; //quem vai receber o email
      private $nCdUsuarioDe; //código do usuário que está enviando o email (se usuário estiver logado)
      private $nCdProduto; //código do produto que está sendo indicado
      private $sTipoProduto; //tipo do produto que está sendo indicado

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
      

      //envia email para o amigo de indicação de produto
      private function EnviarEmailIndicarProduto(){
        $this->oEnvioEmail = new EnviarEmail("indicar_produto");
        $this->oEnvioEmail->SetProduto($this->sTipoProduto, $this->nCdProduto);
        $this->oEnvioEmail->DefinirDadosEnvioEmail(0, $this->sEmailPara, "");
        $this->oEnvioEmail->ChamarFuncoesEnviarEmail();
        if($this->oEnvioEmail->EnviouEmail()){
          $this->sRetorno = "Email enviado com sucesso.";
        }
        else{
          $this->sRetorno = "Email não pode ser enviado.";
        }
      } //fim - EnviarEmailIndicarProduto()
      
      
      

      //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
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
      //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
      
      




      //retorna o processamento da página AJAX
      private function RetornoProcessamentoAJAX(){
        if($this->oEnvioEmail->EnviouEmail()){
          $oRetorno = "Email enviado";
        }
        else{
          $oRetorno .= "Email não pode ser enviado";
        }
        
        echo $oRetorno;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class IndicarCamiseta()
?>
