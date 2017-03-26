<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxRealizarLogoffUsuario.php
  Fun��o: realiza logoff do usu�rio no site
  Data de Cria��o: 14/02/2011 - 15:41
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
  ApagarSession()
  InicializarVariaveis()
  RealizarLogoff() //realiza logoff do usu�rio
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
      

      //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }
      
      
      //solicita arquivos necess�rios desta p�gina
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
	  }


      //inicia a sess�o que armazenar� os dados do usu�rio logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()
      
      
      //apaga a sess�o atual
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


      //realiza logoff do usu�rio
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
