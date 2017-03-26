<?php
/*******************************************************************
********************************************************************
  Nome: conexaoBD.php
  Função: realiza conexão e executa operações com o banco de dados
  Data de Criação: 10/02/2011 - 17:26
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  GetInstanciaConexao() //recuperar instância
  PesquisarSQL($sSql) //realiza SELECT
*/

  class Conexao {
    public $oCon;
    
    //propriedade estática referenciando um tipo da mesma classe
    private static $bd = false;

    //construtor private - não é possível utilizar new em outras classes
    private function __construct() {
      //var's para se conectar com o BD
      // lendo arquivo .INI
      if (file_exists("./config.ini")){
        $oIni = parse_ini_file('./config.ini', true);
      }
      else{
        $oIni = parse_ini_file('../config.ini', true);
      }
      $sServidorBd = $oIni['BD']['servidorBd'];
      $sUsuarioBd = $oIni['BD']['usuarioBd'];
      $sSenhaBd = $oIni['BD']['senhaBd'];
      $sNomeBd = $oIni['BD']['nomeBd'];

      $this->oCon = mysql_connect("$sServidorBd", "$sUsuarioBd", "$sSenhaBd")
        or die ("Problemas ao conectar com o banco de dados!");
      mysql_select_db("$sNomeBd")
        or die ("Problemas ao selecionar o banco de dados!");
      return $this->oCon;
    } //fim - __construct();


    //método para recuperar instância
    public static function GetInstanciaConexao() {
      if (Conexao::$bd === false){
        Conexao::$bd = new Conexao();//chamando construtor
      }
      return Conexao::$bd;
    }
    
    
    //realiza SELECT
    function PesquisarSQL($sSql){
      $oResultado = mysql_query($sSql,$this->oCon);
      if($oResultado){
        while($oLinha = mysql_fetch_object($oResultado)){
          $oDados[]=$oLinha;
        }
        return $oDados;
      }
      else{ //não pode realizar SELECT
        return false;
      }
    } //fim - PesquisarSQL();
    
  } //fim - class Conexao
  ?>
