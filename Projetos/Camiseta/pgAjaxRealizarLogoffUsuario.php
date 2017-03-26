<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxRealizarLogoffUsuario.php
  Função: realiza logoff do usuário no site
  Data de Criação: 14/02/2011 - 15:41
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
  ApagarSession()
  InicializarVariaveis()
  RealizarLogoff() //realiza logoff do usuário
  RetornarRegistroJSON() //retorno AJAX em formato JSON
*/

    $logoffUsuario = new LogoffUsuario();

    class LogoffUsuario{
      //bd
      private $oBd;
      private $sSql;
      
      private $nIdLog;
      private $sStatusLogoff;

      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();
        if($this->nIdLog != 0){
          $this->RealizarLogoff();
          $this->ApagarSession();
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
      
      
      //apaga a sessão atual
      private function ApagarSession(){
        unset($_SESSION["nCodigo"]);
        unset($_SESSION["sUsuario"]);
        unset($_SESSION["sSenha"]);
        unset($_SESSION["sNome"]);
        unset($_SESSION["nIdLog"]);
        unset($_SESSION["nIdCompra"]);
      } //fim -  ApagarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";

        if (isset($_SESSION["nIdLog"])){
          $this->nIdLog = $_SESSION["nIdLog"];
        }
        else{
          $this->nIdLog = 0;
        }

        $this->sStatusLogoff = "nao";
      } //fim - InicializarVariaveis()


      //realiza logoff do usuário
      private function RealizarLogoff(){
        $bUpdate;
        $this->sSql = "UPDATE log_login_usuario l ";
        $this->sSql .= "SET l.data_saida = CURRENT_TIMESTAMP ";
        $this->sSql .= "WHERE l.cdLogLoginUsuario = '".$this->nIdLog."'";
        
        $bUpdate = mysql_query($this->sSql, $this->oBd->oCon);
        if($bUpdate){
          $this->sStatusLogoff = "sim";
        }
        else{
          $this->sStatusLogoff = "nao";
        }
      } //fim - RealizarLogoff()


      //retorno AJAX em formato JSON
      private function RetornarRegistroJSON(){
        //monta registro em formato JSON
        $registro = "{'registro':[";
          $registro .= "{'logoff':'" .$this->sStatusLogoff. "'";
          $registro .= "}";
        $registro .= "]}";

        echo $registro;
      } //fim - RetornarRegistroJSON()

    } //fim - class LogoffUsuario()
?>
