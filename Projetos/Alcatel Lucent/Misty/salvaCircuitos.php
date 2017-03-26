<?php
  /* Salvar Circuitos
     Jonas da Silva Azevedo
     Criado: 02/03/2010 - 13:12
  */
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","misty");


  echo "<html>";
    echo "<body background bgcolor='#E1E1C4'>";

  echo "<center>";
  echo "<b>";
  echo "<h2>";
  echo "<br><br><br><br><br><br>";

  $salva = $_POST['ckBxSalva'];
  $codigo = $_POST['edCodigo'];
  $processo = $_POST['edProcesso'];

  if($salva!=null){
    echo "Você será redirecionado em instantes!";
    echo "</h2>";
    echo "</b>";
    foreach($salva as $res){
      $idx = $res;
      $sql;
      if($processo[$idx]=='1'){
        $sql = "UPDATE circuitos SET processo='37' WHERE codigo=" . $codigo[$idx];
      }
      else if($processo[$idx]=='37'){
        $sql = "UPDATE circuitos SET processo='1' WHERE codigo=" . $codigo[$idx];
      }
      if(!($editou = $bd->executaSQL($sql))){
        echo "Erro para editar o ID de código " . $codigo[$idx];
      }
      else {
        echo "Gravação realizada com sucesso para o Circuito de código " . $codigo[$idx];
        echo "<br>";
      } //else {
    } //foreach($salva as $res){
  } //if($salva!=nul){
  else{
    echo "Nenhum registro selecionado para edição!";
    echo "</h2>";
    echo "</b>";
  }

  echo "</center>";
  echo "<meta http-equiv='refresh' content='0;url=./index.php?pesquisar=true'>";
?>
