<?php
  /* Conexao com o banco de dados
  Jonas da Silva Azevedo
  Criado: 25/02/2010 - 21:52
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

    private function formataData($dataFormatar){
      $dataExp = explode("/", $dataFormatar);
      $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
      return $data;
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

    function pegaRegistros($sql){
      $resultado = mysql_query($sql,$this->id);
      while($linha = mysql_fetch_object($resultado)){
        $dados=$linha;
      }
      $total = count($dados);
      return $total;
    }
  }
?>
