<?php
  /* Conexao com o banco de dados
  autor: Jonas da Silva Azevedo
  criado em: 03/03/2010 - 17:30
  última modificação: 05/03/2010 -
*/
  class conexao {
    private $ins;
    private $executou = true;
    private $insercoes;
    public $id;

    function conexao($servidor="", $usuario="", $senha="", $nomebd=""){
      $this->id = mysql_connect("$servidor", "$usuario", "$senha")
        or die ("Problemas ao conectar com o banco de dados!");
      mysql_select_db("$nomebd")
        or die ("Problemas ao selecionar o banco de dados!");
      return $this->id;
    }

    function getExectou(){
      return $this->executou;
    }

    function setInsercoes(){
      $this->insercoes = 0;
    }
    function getInsercoes(){
      return $this->insercoes;
    }
    
    function executaSQL($sql){
      $this->executou = true;
      $this->ins = mysql_query($sql,$this->id);
      if(! $this->ins) {
        $this->executou = false;
      }
      return $this->executou;
    }

    function selecionaDados($sql){
      $resultado = mysql_query($sql,$this->id);
      while($linha = mysql_fetch_object($resultado)){
        $dados[]=$linha;
      }
      return $dados;
    }

    function pegaTotalRegistros($sql){
      $resultado = mysql_query($sql,$this->id);
      $tot = 0;
      while($linha = mysql_fetch_object($resultado)){
         $tot++;
      }
      return $tot;
    }
    
    function pegaUltimoCodigo($tabela){
      $sql = "SELECT codigo FROM " . $tabela . " ORDER BY codigo DESC LIMIT 1";
      $resultado = mysql_query($sql,$this->id);
      $linha = mysql_fetch_object($resultado);
      return $linha->codigo;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    

    private function formataData($dataFormatar){
      $dataExp = explode("/", $dataFormatar);
      $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
      return $data;
    }


  }
?>
