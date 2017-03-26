<?php
  /* Importa arquivo .CSV das OS's para BD
  Jonas da Silva Azevedo
  Criado: 20/01/2010
*/
  require("sessao.php");
  $codUsu = $_SESSION["codigoUsuario"];
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  if(isset($_FILES['edArquivo'])){
    $arquivo = $_FILES['edArquivo'];
    $abreArq = fopen($arquivo['tmp_name'],"r");//r = apenas leitura

    $i = 0;
    $bd->setInsercoes();
    ini_set('max_execution_time', 1000); //para servidor não abortar processo
    while($valores = fgetcsv($abreArq,0,";")){
      $bd->insereBD($valores);
      $i++;
    }

    if(!($bd->getExectou())){
      ?>
      <script language="JavaScript">
        alert("Ocorreu um erro na importação!");
      </script>
      <?php
    }
    echo "<center>";
    echo "<br><br>";
    echo "Total de Registros Percorridos: " . $i;
    echo "<br>";
    echo "Total de Registros Importados: " . $bd->getInsercoes();
    echo "<meta http-equiv='refresh' content='3;url=./index.php'>";
    echo "</center>";
  }
?>
