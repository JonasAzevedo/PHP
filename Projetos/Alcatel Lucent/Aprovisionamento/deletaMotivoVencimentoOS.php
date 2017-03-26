<?php
  /* deleta de motivo de vencimento das OS's
  Jonas da Silva Azevedo
  Criado: 25/01/2010 - 11:17
  */
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  $codigo = $_GET['codigo'];
  $opcao = $_GET['opcao'];

  $sql = "DELETE FROM motivos_vencimento_os WHERE codigo=" . $codigo;
  //echo $sql;
  $delete = $bd->executaSQL($sql);

  if($delete){
  ?>
    <script type="text/javascript">
      <!--
        alert("Motivo de Vencimento da OS deletada com sucesso!")
      // -->
    </script>
    <?php
    if($opcao=="consulta"){
      echo "<meta http-equiv='refresh' content='0;url=./principalMotivoVencimentoOS.php'>";
    }
    else {
      echo "Erro no servidor";
      echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
    }
  }
  else {
  ?>
    <script type="text/javascript">
      <!--
        alert("Motivo de Vencimento da OS não pode ser deletado!")
      // -->
    </script>
    <?php
    echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
  }
  echo "<center>";
  echo "<b>";
  echo "<h2>";
  echo "<br><br><br><br><br><br>";
  echo "Você será redirecionado em instantes!";
  echo "</h2>";
  echo "</b>";
  echo "</center>";
?>
