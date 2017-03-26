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
  if(isset($_GET['codigo'])){
    $temCod = true;
    if(!isset($_GET['acao'])){
      $sql = "SELECT * FROM usuario WHERE codigo=" . $_GET['codigo'];
      $consulta = mysql_query($sql);
      $res = mysql_fetch_array($consulta);
      $_POST['edCodigo'] = $res['codigo'];
      $_POST['edNome'] = $res['nome'];
      $_POST['edLogin'] = $res['login'];
      $_POST['edSenha'] = $res['senha'];
    }
  }
  else {
    $temCod = false;
  }
  
?>

<html>
      <head>
        <link rel="StyleSheet" href="estilos.css" type="text/css"/>
        <title>Cadastro de Usuário - ROUTE</title>
        
        <script language="JavaScript">
          <!--
          function validaDados(form) {
            campos = ""
            tot = 0
            if (form.edNome.value == "") {
              tot ++
              campos = "Nome"
            }
            if (form.edLogin.value == "") {
              tot ++
              if(campos == "") {
                campos = "Login"
              }
              else {
                campos = campos + ", Login"
              }
            }
            if (form.edSenha.value == "") {
              tot ++
              if(campos == "") {
                campos = "Senha"
              }
              else {
                campos = campos + ", Senha"
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

      </head>

      <body>
        <center>
        <h4>
        <?php
          if(isset($_GET['codigo'])){
            echo "<a href='index.php'>Principal</a>";
          }
          else {
            echo "<a href='login.php'>Login</a>";
          }
        ?>
        </h4>
        <h2>Cadastro de Usuário</h2>
        </center>
        <form name="cadastroUsuario" method="POST" onSubmit="return validaDados(this)" action="<?php echo $PHP_SELF;?>?acao=cadastrar<?php if(isset($_GET['codigo'])){echo "&codigo=" . $_GET['codigo'];}?>">
          <table id="tblCadastroUsuario" border="0" align="center" cellpadding="10" cellpacing="1">
            <tr>
              <td colspan="2">
                <input type="hidden" name="edCodigo" size="40" maxlength="20" value="<?php if($temCod == true){echo $_POST['edCodigo'];} ?>"/>
              </td>
            </tr>
            <tr>
            <tr>
              <td>
                <b>Nome:</b>
              </td>
              <td>
                <input type="text" name="edNome" size="40" maxlength="20" value="<?php if($temCod == true){echo $_POST['edNome'];} ?>"/>
              </td>
            </tr>
            <tr>
              <td>
                <b>Login:</b>
              </td>
              <td>
                <input type="text" name="edLogin" size="40" maxlength="10" value="<?php if($temCod == true){echo $_POST['edLogin'];} ?>"/>
              </td>
            </tr>
            <tr>
              <td>
                <b>Senha:</b>
              </td>
              <td>
                <input type="text" name="edSenha" size="40" maxlength="10" value="<?php if($temCod == true){echo $_POST['edSenha'];} ?>"/>
              </td>
            </tr>
            <tr>
              <td align="center" colspan="2">
                <input type="submit" name="btnSalvar" value="Salvar" style="width: 340px; height: 35px; font-weight: bold;"/>
              </td>
            </tr>
          </table>
        </form>
        <br>
        <center>
        <font face=Arial' size='3' color='green'><b>OBS: Preencha os campos corretamente. Sujeito análise do cadastro!</b></font>
        </center>
        
        <center>
        <b>
        <font face="Arial" size="5">
        <?php
        if($_GET['acao']=="cadastrar"){
          //insere novo
          if($_POST['edCodigo']==""){
            $sqlCons = "SELECT * FROM usuario WHERE nome= '" . $_POST['edNome'] . "'";
            $consulta = mysql_query($sqlCons);
            $total = mysql_num_rows($consulta);
            if($total>0){
              ?>
              <script language="JavaScript">
                <!--
                  alert("Usuário com este nome já cadastrado!")
                // -->
              </script>
              <?php
            }
            else {
              $sqlLogSen = "SELECT * FROM usuario WHERE login='" . $_POST['edLogin'] . "' AND senha='" . $_POST['edSenha'] . "'";
              $consulta2 =  mysql_query($sqlLogSen);
              $total2 = mysql_num_rows($consulta2);
              if($total2>0){
                ?>
                <script language="JavaScript">
                  <!--
                    alert("Usuário com este Login e Senha já cadastrado!")
                  // -->
                </script>
                <?php
              }
              else {
                $sql = "INSERT INTO usuario (nome,login,senha) VALUES ('" . $_POST['edNome'] . "','" . $_POST['edLogin'] . "','" . $_POST['edSenha'] . "')";
                $insere = mysql_query($sql);
                if($insere){
                  echo "<br><br>";
                  echo $_POST['edNome'] . ", obrigado por realizar o cadastro.";
                  ?>
                  <script language="JavaScript">
                    <!--
                      alert("Usuário cadastrado com sucesso!");
                    // -->
                  </script>
                  <?php
                  echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
                }
              }
            }
          }
          //editar
          else {
            $sqlCons = "SELECT * FROM usuario WHERE nome= '" . $_POST['edNome'] . "' AND codigo <>" . $_POST['edCodigo'];
            $consulta = mysql_query($sqlCons);
            $total = mysql_num_rows($consulta);
            if($total>0){
              ?>
              <script language="JavaScript">
                <!--
                  alert("Usuário com este nome já cadastrado!")
                // -->
              </script>
              <?php
            }
            else {
              $sqlLogSen = "SELECT * FROM usuario WHERE login='" . $_POST['edLogin'] . "' AND senha='" . $_POST['edSenha'] . "' AND codigo <>" . $_POST['edCodigo'];
              $consulta2 =  mysql_query($sqlLogSen);
              $total2 = mysql_num_rows($consulta2);
              if($total2>0){
                ?>
                <script language="JavaScript">
                  <!--
                    alert("Usuário com este Login e Senha já cadastrado!")
                  // -->
                </script>
                <?php
              }
              else {
                $sql = "UPDATE usuario SET nome='" . $_POST['edNome'] . "',login='" . $_POST['edLogin'] . "',senha='";
                $sql = $sql . $_POST['edSenha'] . "' WHERE codigo=" . $_POST['edCodigo'];
                $edita = mysql_query($sql);
                if($edita){
                  echo "<br><br>";
                  echo $_POST['edNome'] . ", seu cadastro foi editado com sucesso.";
                  ?>
                  <script language="JavaScript">
                    <!--
                      alert("Usuário editado com sucesso!");
                    // -->
                  </script>
                  <?php
                  echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
                }
              }
            }
          }
        }
        ?>
        </center>
        </b>
        </font>
</html>
