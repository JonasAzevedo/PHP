<?php
  /* deleta de setor responsável pela OS
  Jonas da Silva Azevedo
  Criado: 25/01/2010 - 10:10
  */
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  $codigo = $_GET['codigo'];
  $opcao = $_GET['opcao'];

  $sql = "DELETE FROM setores_responsabilidade WHERE codigo=" . $codigo;
  //echo $sql;
  $delete = $bd->executaSQL($sql);

  if($delete){
  ?>
    <script type="text/javascript">
      <!--
        alert("Setor Responsável deletado com sucesso!")
      // -->
    </script>
    <?php
    if($opcao=="consulta"){
      echo "<meta http-equiv='refresh' content='0;url=./principalSetoresResponsabilidade.php'>";
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
        alert("Setor Responsável não pode ser deletado!")
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
