<?php
  /* cadastro dos setores responsáveis pelas OS's
  Jonas da Silva Azevedo
  Criado: 21/01/2010 - 16:43
*/
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  if(isset($_GET['opcao'])){
    $tela=$_GET['opcao'];
  }
  if($_GET['acao']=='cadastrar') {
    //editar
    if($_POST['edCodigo']!=''){
      $sql = "UPDATE setores_responsabilidade SET nome='" . $_POST['edNome'] . "',descricao='" . $_POST['mmDescricao'] . "',";
      $sql = $sql . "ativo=" . $_POST['cbBxStatus'] . " WHERE codigo=" . $_POST['edCodigo'];
    }
    //cadastrar
    else {
      $sql = "INSERT INTO setores_responsabilidade (nome,descricao,ativo)";
      $sql = $sql . "VALUES ('". $_POST['edNome'] . "','" . $_POST['mmDescricao'] ."'," . $_POST['cbBxStatus'] . ")";
    }
    $selMotivo = "SELECT * FROM setores_responsabilidade WHERE nome='" . $_POST['edNome'] . "'";
    if($_POST['edCodigo']!=''){
      $selMotivo = $selMotivo . " AND codigo<>" . $_POST['edCodigo'];
    }
    $achouMotivo = $bd->selecionaDados($selMotivo);
    $total = count($achouMotivo);
    if($total==0){
      $insere = $bd->executaSQL($sql);
      if($insere){
        if($tela=="consulta"){
          echo "<meta http-equiv='refresh' content='0;url=./principalSetoresResponsabilidade.php'>";
        }
        else if($tela=="principal"){
          echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
        }
      }
    }
    else {//total<>0
      ?>
      <script language="JavaScript">
        <!--
          alert("Setor com este nome já cadastrado!")
        -->
      </script>
      <?php
    }
  }
  if(isset($_GET['codigo'])) {
    $sqlCod = "SELECT * FROM setores_responsabilidade m WHERE m.codigo=" . $_GET['codigo'];
    $dadosRes = $bd->selecionaDados($sqlCod);
    $total = count($dadosRes);
    $achouCodigo=false;
    if($total=1){
      $achouCodigo=true;
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <script language="JavaScript">
      <!--
        function validaDados(form) {
          campos = ""
          tot = 0
          if (form.cbBxStatus.value == " ") {
            tot ++
            campos = "Status"
          }
          if (form.edNome.value == "") {
            tot ++
            if(campos == "") {
              campos = "Nome"
            }
            else {
              campos = campos + ", Nome"
            }
          }
          if(tot==1){
            alert("Preencha o campo: " + campos)
            return false
          }
          else if(tot>1){
            alert("Preencha os campos: " + campos)
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
    <title>Cadastro dos Setores Responsáveis</title>
  </head>

  <body>
    <center>
      <p>
        <a href='logoff.php'>Sair</a>
      </p>
      <p>
        <a href="index.php">Principal</a> &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="principalSetoresResponsabilidade.php">Pesquisa</a>
      </p>
      <h2>CADASTRO DOS SETORES RESPONSÁVEIS</h2>
    </center>
    <form name="cadastroSetoresResponsaveis" method="POST" onSubmit="return validaDados(this)" action="<?php echo $PHP_SELF;?> ?acao=cadastrar<?php if(isset($tela)){echo '&opcao=' . $tela;} ?>">
      <table id="tblDadosSetoresResponsaveis" border="0" align="center" cellpadding="10" cellpacing="1">
        <tr>
          <td>
            <b>Status:</b> <select name="cbBxStatus" size="1" style="width: 200px;">
                             <option value="1"<?php if($achouCodigo==true){if($dadosRes[0]->ativo==1){echo "selected";}}?>>Ativo</option>
                             <option value="2"<?php if($achouCodigo==true){if($dadosRes[0]->ativo==2){echo "selected";}}?>>Inativo</option>
                           </select>
          </td>
          <td>
            <input type="hidden" name="edCodigo" value="<?php if($achouCodigo==true){echo $dadosRes[0]->codigo;}?>" />
          </td>

        </tr>
        <tr>
          <td colspan="2">
            <b>Nome:</b> <br> <input type="text" name="edNome" maxlength="50" size="122" value="<?php if($achouCodigo==true){echo $dadosRes[0]->nome;}?>" />
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <b>Descrição:</b> <br> <textarea name="mmDescricao" rows="3" cols="92"><?php if($achouCodigo==true){echo $dadosRes[0]->descricao;}?></textarea>
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
