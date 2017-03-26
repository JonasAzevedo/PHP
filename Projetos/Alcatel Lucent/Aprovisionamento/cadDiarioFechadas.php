<?php
  /* cadastro de diário de fechadas
  Jonas da Silva Azevedo
  Criado: 03/01/2010 - 15:21
*/
  function formataData($dataFormatar){
    $dataExp = explode("/", $dataFormatar);
    $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
    return $data;
  }
    
  require("sessao.php");
  require_once("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  if(isset($_GET['opcao'])){
    $tela=$_GET['opcao'];
  }
  if($_GET['acao']=='cadastrar') {
    //editar
    if($_POST['edCodigo']!=''){
      $sql = "UPDATE diario_fechadas SET cod_grupo_diario_fechadas='" . $_POST['edGrupoDiarioFec'] . "',data='" . formataData($_POST['edData']) . "',";
      $sql = $sql . "porc_eficiencia='" . $_POST['edPorcEficiencia'] . "',no_prazo='" . $_POST['edNoPrazo'] . "',vencidas='" . $_POST['edVencidas'] . "' WHERE codigo=" . $_POST['edCodigo'];
    }
    //cadastrar
    else {
      $sql = "INSERT INTO diario_fechadas (cod_grupo_diario_fechadas,data,porc_eficiencia,no_prazo,vencidas) ";
      $sql = $sql . "VALUES ('". $_POST['cbBxGrupo'] . "','" . formataData($_POST['edData']) ."','" . $_POST['edPorcEficiencia'] . "'";
      $sql = $sql . ",'" . $_POST['edNoPrazo'] . "','" . $_POST['edVencidas'] . "')";
    }
    $selDiarioFechada = "SELECT * FROM diario_fechadas WHERE cod_grupo_diario_fechadas=" . $_POST['cbBxGrupo'] ;
    $selDiarioFechada = $selDiarioFechada . " AND data='" . formataData($_POST['edData']) . "'";
    if($_POST['edCodigo']!=''){
      $selMotivo = $selMotivo . " AND codigo <> " . $_POST['edCodigo'];
    }
    $achouDiarioFechada = $bd->selecionaDados($selDiarioFechada);
    $total = count($achouDiarioFechada);
    if($total==0){
      $insere = $bd->executaSQL($sql);
      if($insere){
        if($tela=="consulta"){
/////////          echo "<meta http-equiv='refresh' content='0;url=./principalMotivoVencimentoOS.php'>";
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
          alert("Diário de Fechadas já cadastrado para esse grupo e data!")
        -->
      </script>
      <?php
    }
  }
  if(isset($_GET['codigo'])) {
    $sqlCod = "SELECT * FROM diario_fechadas WHERE m.codigo=" . $_GET['codigo'];
    $dadosRes = $bd->selecionaDados($sqlCod);
    $total = count($dadosRes);
    $achouCodigo=false;
    if($total=1){
      $achouCodigo=true;
    }
  }
?>

    <script language="JavaScript">
      <!--
        function validaDados(form) {
          campos = ""
          tot = 0
          if (form.cbBxGrupo.value == "") {
            tot ++
            campos = "Grupo"
          }
          if (form.edData.value == "") {
            tot ++
            if(campos == "") {
              campos = "Data"
            }
            else {
              campos = campos + ", Data"
            }
          }
          if (form.edPorcEficiencia.value == "") {
            tot ++
            if(campos == "") {
              campos = "% Eficiência"
            }
            else {
              campos = campos + ", % Eficiência"
            }
          }
          if (form.edNoPrazo.value == "") {
            tot ++
            if(campos == "") {
              campos = "No Prazo"
            }
            else {
              campos = campos + ", No Prazo"
            }
          }
          if (form.edVencidas.value == "") {
            tot ++
            if(campos == "") {
              campos = "Vencidas"
            }
            else {
              campos = campos + ", Vencidas"
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
    
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>


    <link rel="stylesheet" type="text/css" href="estilos.css" />


    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cadastro de Diário de OS's Fechadas</title>
  </head>

  <body>
    <center>
      <p>
        <a href="logoff.php">Sair</a>
      </p>
      <p>
        <a href="index.php">Principal</a>
      </p>
      <h2>Cadastro de OS's Diárias Fechadas</h2>
    </center>
    <form name="cadastroDiarioFechadas" method="POST" onSubmit="return validaDados(this)" action="<?php echo $PHP_SELF;?> ?acao=cadastrar<?php if(isset($tela)){echo '&opcao=' . $tela;} ?>">
      <table id="tblDadosDiarioFechadas" border="0" align="center" cellpadding="10" cellpacing="1">
        <tr>
          <td>
          <?php
          $resGrupo = $bd->selecionaDados("SELECT * FROM grupo_diario_fechadas ORDER BY codigo");
          $totGrupo = count($resGrupo);
          ?>
         <b>Grupo:</b> <select name="cbBxGrupo" size="1" style="width: 200px;">
          <?php
          if($totGrupo>0){
            foreach($resGrupo as $mostraGrupos){
              echo "<option value='" . $mostraGrupos->codigo . "'>" . $mostraGrupos->grupo . "</option>";
            }
          }
          ?>
          </select>
          </td>
          <td>
            <b>Data:</b> <input type="text" name="edData" value="<?php if($achouCodigo==true){echo $dadosRes[0]->data;}?>" />
          </td>
          <td>
            <b>Código:</b> <input type="text" name="edCodigo" value="<?php if($achouCodigo==true){echo $dadosRes[0]->codigo;}?>" />
          </td>
        </tr>
         <tr>
          <td>
            <b>% Eficiência:</b> <input type="text" name="edPorcEficiencia" class="text2" value="<?php if($achouCodigo==true){echo $dadosRes[0]->porc_eficiencia;}?>" />
          </td>
          <td>
            <b>No Prazo:</b> <input type="text" name="edNoPrazo" class="text2" value="<?php if($achouCodigo==true){echo $dadosRes[0]->no_prazo;}?>" />
          </td>
          <td>
            <b>Vencidas:</b> <input type="text" name="edVencidas" class="text2" value="<?php if($achouCodigo==true){echo $dadosRes[0]->vencidas;}?>" />
          </td>
        </tr>
        <tr>
          <td colspan=3>
            <hr size="1" width="80%" align="center" noshade>
          </tr>
        <tr align="center">
          <td colspan=2>
            <input type="submit" name="btnSalvar" value="Salvar"  class="buttons1" />
          </td>
          <td>
            <input type="reset" name="btnLimpar" value="Limpar"  class="buttons2" />
          </td>
        </tr>

      </table>
    </form>
  </body>
</html>
