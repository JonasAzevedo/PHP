<?php
/*
************************************************************************************************************
*
* 	CREATED ON 13/01/2010  by Jonas da Silva Azevedo
* 			CONTATO: jonassazevedo@hotmail.com
*
*  		ÚLTIMA MODIFICAÇÃO   13/01/2010 by Jonas da Silva Azevedo
*
************************************************************************************************************
* 			::::: Sistema de Gerenciamento de Rotas SDH Inviáveis :::: (Alcatel-Lucent)
************************************************************************************************************
*/
  include("conecta.php");
  include("sessao.php");

  $codigo = $_GET['codigo'];
  $opcao = $_GET['opcao'];

  $sql = "UPDATE rotasdh SET status=2, cod_usuario_deletou=" . $_SESSION['codigoUsuario'] . ", data_deletou =current_timestamp WHERE codigo=" . $codigo;
  //echo $sql;
  $delete = mysql_query($sql);
  if($delete){
  ?>
    <script type="text/javascript">
      <!--
        alert("Rota SDH deletada com sucesso!")
      // -->
    </script>
    <?php
    if($opcao=="consulta"){
      echo "<meta http-equiv='refresh' content='0;url=./consultaSDH.php'>";
    }
    else if($opcao=="principal"){
      echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
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
        alert("Rota SDH não pode ser deletada")
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
