<?php
    session_start();
    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");

    //buscando por usuário
    if($_GET['login']==true){ //login
      if(($_POST['edTR']!="")and($_POST['edSenha']!="")){ //campos OK
        $sql = "SELECT * FROM usuario u WHERE u.tr='" . $_POST['edTR'] . "' AND u.senha='" . $_POST['edSenha'] . "'";
        $dadosRes = $bd->selecionaDados($sql);
        $achou = count($dadosRes);
        if($achou==0){ //nao achou
          ?>
          <script language="JavaScript">
            alert("Usuário não encontrado!");
          </script>
          <?php
        } //nao achou
        else { //achou
          //inserindo log de acesso
          $sql = "INSERT INTO log (cod_usuario,data_entrada) VALUES (" . $dadosRes[0]->codigo . ",CURRENT_TIMESTAMP)";
          $insere = $bd->executaSQL($sql);
          if($insere){ //inserindo log
            //pegando código do log
            $codLog = $bd->pegaUltimoCodigo("log");
            $_SESSION["codigoUsuario"] = $dadosRes[0]->codigo;
            $_SESSION["nomeUsuario"] = $dadosRes[0]->nome;
            $_SESSION["acesso"] = $dadosRes[0]->nivel;
            $_SESSION["codigoLog"] = $codLog;
            header("Location: ./index.php");
          } //inserindo log
          else{ //nao inseriu log
            ?>
            <script language="JavaScript">
              alert("Erro ao salvar log. Contate o administrador do sistema!");
            </script>
            <?php
          } //nao inseriu log
        } //achou
      } //campos OK
      else{ //campos nao OK
        ?>
        <script language="JavaScript">
          alert("Digite o seu usuário e senha!");
        </script>
        <?php
      } //campos nao OK
    } //login
?>

<?php
  include("menuPrincipal.html");
?>

<html>
  <head>
    <link rel="stylesheet" href="./estilos/pgLogin.css" type="text/css" />
    <title>Login CPTX</title>
  </head>

  <body>
      <br><br><br>
      
      <div class="grupoOpc">
        <form name="login" method="POST" action="<?php echo $PHP_SELF;?>?login=true" >
          <div class="titulo">Login CPTX</div>
            <span class="descTR"> TR: </span> <input type="text" class="campoTR" name="edTR" size="10" maxlength="8"/> <br>
            <span class="descSenha">Senha: </span> <input type="password" class="campoSenha" name="edSenha" size="10" maxlength="10"/>
            <input type="submit" name="btnLogin" class="pesquisar" value="Login" />
            <input type="reset" name="btnLimpar" class="limpar" value="Limpar" />
        </form>
      </div>
  </body>
</html>
<!-- Tela de Login
       autor: Jonas da Silva Azevedo
       criado em: 08/03/2010 - 15:09
       última modificação:
-->
