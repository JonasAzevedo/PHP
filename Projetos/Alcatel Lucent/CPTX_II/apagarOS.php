<?php
 require("conexao.php");
 $bd = new conexao("localhost","root","","os_sac");
 
 $codigo = $_GET['codigo'];
 $data = $_GET['data'];
 $mes = $_GET['mes'];
 $ano = $_GET['ano'];

 $sql = "DELETE FROM os WHERE codigo=" . $codigo;
 
 if($bd->executaSQL($sql)){
   ?>
    <script language="JavaScript">
      window.alert("Circuito deletado com sucesso!");
    </script>
   <?php
   echo "<meta http-equiv='refresh' content='0;url=./minhasOSs.php?data=" . $data . "&mes=" . $mes . "&ano=" . $ano . "'>";
 }
 else {
   ?>
    <script language="JavaScript">
      window.alert("Circuito nao pode ser deletado!");
    </script>
   <?php
   echo "<meta http-equiv='refresh' content='0;url=./minhasOSs.php?data=" . $data . "&mes=" . $mes . "&ano=" . $ano . "'>";
 }
?>
