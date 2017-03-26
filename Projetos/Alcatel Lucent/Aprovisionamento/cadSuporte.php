<?php
  /* cadastro dos suportes
  Jonas da Silva Azevedo
  Criado: 10/02/2010 - 11:35
*/
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");
  $codUsuario = $_SESSION["codigoUsuario"];

  if($_GET['acao']=='cadastrar') {
    //cadastrar
      $sql = "INSERT INTO suporte (cod_usuario,descricao,status)";
      $sql = $sql . "VALUES ('". $codUsuario . "','" . $_POST['mmDescricao'] ."','1')";
      $insere = $bd->executaSQL($sql);
      if($insere){
        ?>
        <script language="JavaScript">
          <!--
            alert("Cadastro realizado com sucesso. Obrigado por contribuir pela melhoria do sistema!")
          -->
        </script>
        <?php
          echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
      }
      else { //($insere){
        ?>
        <script language="JavaScript">
          <!--
            alert("Suporte não pode ser cadastrado. Contacte o administrador do sistema!")
          -->
        </script>
        <?php
      }
  } //($_GET['acao']=='cadastrar') {

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <script language="JavaScript">
      <!--
        function validaDados(form) {
          campos = ""
          if (form.mmDescricao.value == " ") {
            campos = "Descricao"
          if(campo<>""){
            alert("Preencha o campo: " + campos)
            return false
          }
          else {
            return true
          }
        }
      // -->
    </script>

    <link rel="stylesheet" type="text/css" href="estilos.css" />


    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Tela de Suporte ao Usuário</title>
  </head>

  <body>
    <center>
      <p>
        <a href='logoff.php'>Sair</a>
      </p>
      <p>
        <a href="index.php">Principal</a>
      </p>
      <h2>CADASTRO DE SUPORTE AO USUÁRIO</h2>
    </center>
    <form name="cadastroSuporte" method="POST" onSubmit="return validaDados(this)" action="<?php echo $PHP_SELF;?> ?acao=cadastrar">
      <table id="tblDadosSuporte" border="0
      " align="center" cellpadding="10" cellpacing="1">
        <tr>
          <td colspan="2">
            <b>Descrição:</b> <br> <textarea name="mmDescricao" rows="3" cols="92"></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <hr size="1" width="80%" align="center" noshade>
          </tr>
        <tr align="center">
          <td>
            <input type="submit" name="btnSalvar" value="Salvar"  class="buttons1" />
          </td>
          <td>
            <input type="reset" name="btnLimpar" value="Limpar"  class="buttons2" />
          </td>
        </tr>
      </table>
  </body>
</html>
