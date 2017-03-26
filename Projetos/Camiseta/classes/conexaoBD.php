<?php
/*******************************************************************
********************************************************************
  Nome: conexaoBD.php
  Fun��o: realiza conex�o e executa opera��es com o banco de dados
  Data de Cria��o: 10/02/2011 - 17:26
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
********************************************************************
*******************************************************************/

/*
//function's:
  GetInstanciaConexao() //recuperar inst�ncia
  PesquisarSQL($sSql) //realiza SELECT
*/

  class Conexao {
    public $oCon;
    
    //propriedade est�tica referenciando um tipo da mesma classe
    private static $bd = false;

    //construtor private - n�o � poss�vel utilizar new em outras classes
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


    //m�todo para recuperar inst�ncia
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
      else{ //n�o pode realizar SELECT
        return false;
      }
    } //fim - PesquisarSQL();
    
  } //fim - class Conexao
  ?>
