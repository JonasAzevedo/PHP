<?php
  /* sessão
  Jonas da Silva Azevedo
*/
        include("conecta.php");
        
        //buscando por usuário
        if($_GET['login']==true){
          if(($_POST['edUsuario']!="")and($_POST['edSenha']!="")){
            $sql = "SELECT * FROM usuario u WHERE u.login='" . $_POST['edUsuario'] . "' AND u.senha='" . $_POST['edSenha'] . "'";
            $resultado = mysql_query($sql);
            $linha = mysql_num_rows($resultado);
            if($linha==0){
              echo "<br><br>";
              echo "<center><font face='Arial' size='2' color='red'><b>Usuário não encontrado!</b></font></center>";
            }
            else {
              $dados = mysql_fetch_array($resultado);
              //inserindo log de acesso
              $sql = "INSERT INTO log (cod_usuario) VALUES (" . $dados['codigo'] . ")";
              $insere = mysql_query($sql);
              //total de acessos do usuário
              $totAcessos = "SELECT * FROM log WHERE cod_usuario=" . $dados["codigo"];
              $resTotAcessos = mysql_query($totAcessos);
              $linhaTotAcessos = mysql_num_rows($resTotAcessos);
              //pegando código do log
              $sqlLast = "SELECT * FROM log ORDER BY codigo DESC LIMIT 1";
              $selectLast = mysql_query($sqlLast);
              $codLog = mysql_fetch_array($selectLast);
              
              //inicializa uma sessão
              ini_set("session.save_path","C:\wamp\www\Rota SDH\Sessions"); //muda diretório que será salva a sessãos
              session_start();
              $_SESSION["codigoUsuario"] = $dados["codigo"];
              $_SESSION["nomeUsuario"] = $dados["nome"];
              $_SESSION["totAcessos"] = $linhaTotAcessos;
              $_SESSION["codigoLog"] = $codLog["codigo"];
              header("Location: http://localhost/Rota%20SDH/index.php");
            }
          }
          else{
            ?>
            <script language="JavaScript">
              <!--
                alert("Digite o seu usuário e senha!");
              // -->
            </script>
            <?php
            //echo "<br><br>";
            //echo "<center><font face='Arial' size='2' color='red'><b>Digite o seu Usuário e Senha</b></font></center>";
          }
        }
?>

<html>
      <head>
        <link rel="StyleSheet" href="estilos.css" type="text/css"/>
        <title>Login ROUTE</title>
      </head>
      
      <body>
        <center>
        <h4><a href="cadastroUsuario.php">Cadastrar Usuário</a></h4>
        </center>
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
