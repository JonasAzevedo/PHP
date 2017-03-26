<?php
  /* sessão
  Jonas da Silva Azevedo
  Criado: 25/01/2010 - 14:05
*/
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  //buscando por usuário
  if($_GET['login']==true){ //if_1
    if(($_POST['edUsuario']!="")and($_POST['edSenha']!="")){ //if_2
      $sql = "SELECT * FROM usuario u WHERE u.login='" . $_POST['edUsuario'] . "' AND u.senha='" . $_POST['edSenha'] . "'";
      $dadosRes = $bd->selecionaDados($sql);
      $achou = count($dadosRes);
      if($achou==0){ //if_3
        echo "<br><br>";
        echo "<center><font face='Arial' size='2' color='red'><b>Usuário não encontrado!</b></font></center>";
          ?>
          <script language="JavaScript">
            alert("Usuário não encontrado!");
          </script>
          <?php
      } //if_3
      else { //else_3
        //inserindo log de acesso
        $sql = "INSERT INTO log (cod_usuario,data_entrada) VALUES (" . $dadosRes[0]->codigo . ",CURRENT_TIMESTAMP)";
        $insere = $bd->executaSQL($sql);
        if($insere){ //if_4
          //pegando código do log
          $sqlLast = "SELECT * FROM log ORDER BY codigo DESC LIMIT 1";
          $selectLast = $bd->selecionaDados($sqlLast);
          $codLog = $selectLast[0]->codigo;
          //inicializa uma sessão
          ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diretório que será salva a sessãos
          session_start();
          $_SESSION["codigoUsuario"] = $dadosRes[0]->codigo;
          $_SESSION["nomeUsuario"] = $dadosRes[0]->nome;
          $_SESSION["acesso"] = $dadosRes[0]->acesso;
          $_SESSION["codigoLog"] = $codLog;
          $_SESSION["imagemGrafico"] = "";
          header("Location: index.php");
        } //if_4
        else{ //if_5
          ?>
          <script language="JavaScript">
            alert("Erro ao salvar log. Contate o administrador do sistema!");
          </script>
          <?php
        } //if_5
      } //else_3
    } //if_2
    else{ //else_4
      ?>
      <script language="JavaScript">
        alert("Digite o seu usuário e senha!");
      </script>
      <?php
    } //else_4
  }//if_1
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="estilos.css" />
    <title>Login Aprovisionamento</title>
  </head>
      
  <body>
    <center>
      <br><br><br>
      <form name="login" method="POST" action="<?php echo $PHP_SELF;?>?login=true" >
        <h2> <b> <div align="center"> Entre com o seu Usuário e Senha para efetuar o Login:</div> </b> </h2>
        <br><br>
        <b> <div align="center">Usuário: </b> <input type="text" name="edUsuario" size="20" maxlength="10"/> </div>
        <br>
        <b> <div align="center">Senha: &nbsp;&nbsp;</b> <input type="password" name="edSenha" size="20" maxlength="10"/> </div>
        <br>
        <b> <div align="center"> <input type="submit" name="btnLogin" value="Login" style="width: 210px; height: 30px; font-weight: bold;"/> </div> </b>
      </form>
  </body>
</html>
