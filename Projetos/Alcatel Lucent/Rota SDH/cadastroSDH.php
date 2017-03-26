<?php
/*
************************************************************************************************************
*
* 	CREATED ON 11/01/2010  by Jonas da Silva Azevedo
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

  if(isset($_GET['opcao'])){
    $tela=$_GET['opcao'];
  }

  if($_GET['acao']=='cadastrar') {
    //editar
    if($_POST['edCodigo']!=''){
      $sql = "UPDATE rotasdh SET rota='" . $_POST['edRota'] . "',anel='" . $_POST['edAnel'] . "',plataforma='";
      $sql = $sql . $_POST['rdBtnPlataforma'] . "',filial='" . $_POST['cbBxFilial'] . "',indisponibilidade='";
      $sql = $sql . $_POST['mmIndisponibilidade'] . "',rota_alternativa='" . $_POST['mmRotaAlternativa'] . "'";
      $sql = $sql . ",cod_usuario_editou='" . $_SESSION['codigoUsuario'] . "',ultima_edicao=current_timestamp,status=1 ";
      $sql = $sql . "WHERE codigo=" . $_POST['edCodigo'];
    }
    //cadastrar
    else {
      $sql = "INSERT INTO rotasdh (cod_usuario_cadastrou,rota,anel,plataforma,filial,indisponibilidade,rota_alternativa,status)";
      $sql = $sql . "VALUES (" . $_SESSION['codigoUsuario'] . ",'". $_POST['edRota'] . "','" . $_POST['edAnel'] ."','" . $_POST['rdBtnPlataforma'] . "','" . $_POST['cbBxFilial'] . "','";
      $sql = $sql . $_POST['mmIndisponibilidade'] . "','" . $_POST['mmRotaAlternativa'] . "',0)";
    }
    $insere = mysql_query($sql);
//    if(($insere)and($_POST['edCodigo']!='')){
      //header("Location: http://localhost/Rota%20SDH/index.php?edicao=true");
//      echo "<meta http-equiv='refresh' content='0';url=./index.php?edicao=true'>";
//    }
//    else {
//      echo "<center><font face=Arial' size='4' color='red'><b>Preencha os seguintes campos: $erros</b></font></center>";
//    }
    if($insere){
      if($tela=="consulta"){
        echo "<meta http-equiv='refresh' content='0;url=./consultaSDH.php'>";
      }
      else if($tela=="principal"){
        echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
      }
    }
  }
  
  if(isset($_GET['codigo'])) {
    $sqlCod = "SELECT * FROM rotasdh r WHERE r.codigo=" . $_GET['codigo'];
    $consultaCod = mysql_query($sqlCod);
    $linhaCod = mysql_fetch_array($consultaCod);
    $_POST['edCodigo'] = $linhaCod['codigo'];
    $_POST['edRota'] = $linhaCod['rota'];
    $_POST['edAnel'] = $linhaCod['anel'];
    $_POST['rdBtnPlataforma'] = $linhaCod['plataforma'];
    $_POST['cbBxFilial'] = $linhaCod['filial'];
    $_POST['mmIndisponibilidade'] = $linhaCod['indisponibilidade'];
    $_POST['mmRotaAlternativa'] = $linhaCod['rota_alternativa'];
  }
?>

<html>
      <head>
        <script language="JavaScript">
          <!--
          function validaDados(form) {
            campos = ""
            tot = 0
            if (form.edRota.value == "") {
              tot ++
              campos = "Rota"
            }
            if (form.edAnel.value == "") {
              tot ++
              if(campos == "") {
                campos = "Anel"
              }
              else {
                campos = campos + ", Anel"
              }
            }
            if (form.rdBtnPlataforma.value == "") {
              tot ++
              if(campos == "") {
                campos = "Plataforma"
              }
              else {
                campos = campos + ", Plataforma"
              }
            }
            if (form.cbBxFilial.value == "") {
              tot ++
              if(campos == "") {
                campos = "Filial"
              }
              else {
                campos = campos + ", Filial"
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
        
        <style type="text/css">
          <!--
          body {
            font-family:verdana;
            font-size:15px;
          }
          
          a { text-decoration:none}
          a:hover { text-decoration:none}
          // -->
        </style>
        <link rel="StyleSheet" href="estilos.css" type="text/css"/>
        <title>Cadastro de SDH Inviáveis</title>
      </head>
      <body>
        <center>
        <p>
        <h6>
          <a href='logoff.php'>Sair</a>
        </h6>
        </p>
        <p>
        <h4>
          <a href="index.php">Principal</a> &nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="consultaSDH.php">Pesquisa</a>
        </h4>
        </p>
        <h2>CADASTRO DE ROTAS SDH INVIÁVEIS</h2>
        </center>
        <form name="cadastroSDH" method="POST" onSubmit="return validaDados(this)" action="<?php echo $PHP_SELF;?> ?acao=cadastrar<?php if(isset($tela)){echo '&opcao=' . $tela;} ?>">
          <table id="tblDadosSDH" border="0" align="center" cellpadding="10" cellpacing="1">
            <tr>
              <td>
                <b>Rota:</b> <input type="text" name="edRota" size="50" maxlength="200" value="<?php if(isset($_POST['edRota'])){echo $_POST['edRota'];} ?>" />
              </td>
              <td colspan="2">
                <b>Anel:</b> <input type="text" name="edAnel" size="50" maxlength="200" value="<?php if(isset($_POST['edAnel'])){echo $_POST['edAnel'];} ?>" />
              </td>
            </tr>
            <tr>
              <td>
                <b>Plataforma:</b> <input type="radio" name="rdBtnPlataforma" value="Marconi" <?php if(isset($_POST['rdBtnPlataforma'])){if($_POST['rdBtnPlataforma']=="Marconi"){echo "checked";}}else{echo "checked";} ?> />Marconi
                                   <input type="radio" name="rdBtnPlataforma" value="Alcatel" <?php if(isset($_POST['rdBtnPlataforma'])){if($_POST['rdBtnPlataforma']=="Alcatel"){echo "checked";}} ?>  />Alcatel
                                   <input type="radio" name="rdBtnPlataforma" value="Siemens" <?php if(isset($_POST['rdBtnPlataforma'])){if($_POST['rdBtnPlataforma']=="Siemens"){echo "checked";}} ?> />Siemens
              </td>
              <td>
                <b>Filial:</b> <select name="cbBxFilial" size="1" style="width: 100px;">
                                     <option value="AC"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="AC"){echo "selected";}}?>>AC</option>
                                     <option value="MS"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="MS"){echo "selected";}}?>>MS</option>
                                     <option value="MT"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="MT"){echo "selected";}}?>>MT</option>
                                     <option value="RO"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="RO"){echo "selected";}}?>>RO</option>
                                     <option value="GO"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="GO"){echo "selected";}}?>>GO</option>
                                     <option value="TO"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="TO"){echo "selected";}}?>>TO</option>
                                     <option value="RS"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="RS"){echo "selected";}}?>>RS</option>
                                     <option value="PR"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="PR"){echo "selected";}}?>>PR</option>
                                     <option value="SC"<?php if(isset($_POST['cbBxFilial'])){if($_POST['cbBxFilial']=="SC"){echo "selected";}}?>>SC</option>
                                   </select>
              </td>
              <td>
                <input type="hidden" name="edCodigo" value="<?php if(isset($_POST['edCodigo'])){echo $_POST['edCodigo'];} ?>" />
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <b>Indisponibilidade:</b> <br> <textarea name="mmIndisponibilidade" rows="3" cols="92"><?php if(isset($_POST['mmIndisponibilidade'])){echo $_POST['mmIndisponibilidade'];}?></textarea>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <b>Rota Alternativa:</b> <br> <textarea name="mmRotaAlternativa" rows="3" cols="92"><?php if(isset($_POST['mmRotaAlternativa'])){echo $_POST['mmRotaAlternativa'];}?></textarea>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <hr size="1" width="80%" align="center" noshade>
            </tr>
            <tr align="center">
              <td> <input type="submit" name="btnSalvar" value="Salvar" style="width: 200px; height: 35px; font-weight: bold;"/>
              </td>
              <td  colspan="2"> <input type="reset" name="btnLimpar" value="Limpar" style="width: 200px; height: 35px; font-weight: bold;"/>
              </td>
            </tr>
          </table>
      </body>
</html>
