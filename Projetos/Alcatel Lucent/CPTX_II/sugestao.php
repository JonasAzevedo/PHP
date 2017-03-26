<?php
    session_start();
    require("sessao.php");
    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");

    include("menuPrincipal.html");

    function formataData($dataFormatar){
      $dataExp = explode(" ", $dataFormatar);
      $dataData = explode("-", $dataExp[0]);
      $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0] . " " . $dataExp[1];
      return $data;
    }
    //cadastrar circuito
    if($_GET['acao']=="cadastrar"){
      $sql = "INSERT INTO ajuda(cod_usuario,descricao,tipo,status,data_cadastro) ";
      $sql = $sql . "VALUES('" . $_SESSION["codigoUsuario"] . "','" . $_POST['txtAreaDescricao'] . "','";
      $sql = $sql . $_POST['cbSelTipo'] . "','1',CURRENT_TIMESTAMP)";
      if($bd->executaSQL($sql)){
        ?>
        <script language="JavaScript">
          window.alert("Obrigado por realizar o contato");
        </script>
        <?php
          echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
      }
      else{
        ?>
        <script language="JavaScript">
          window.alert("Seu contato não pode ser cadastrado");
        </script>
        <?php
      }
    } //cadastrar circuito
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <script language="JavaScript" src="./js/pgSugestao.js">
    </script>

    <link rel="stylesheet" href="./estilos/pgSugestao.css" type="text/css" />

    <title>Ajuda On-Line</title>
  </head>

  <body onLoad='inicio();'>
  
    <form name="frmAjuda" method="POST" action="<?php echo $PHP_SELF; ?>?acao=cadastrar">
      <div class='grupoOpc'>
        <p class="titulo"> Formulário para Contato </p>
        <!-- dados do formulário para contato -->
        <div class="grupoDados" id="cxDadosFormulario">
          <!-- tipo -->
          <span class="tituloCampo"> Tipo: </span>
          <select class="slctTipo" name="cbSelTipo" id="cbSelTipo" onChange="verificaSugestao(this.id);">
            <?php
              $tipos = array('Dúvida','Sugestão','Outro');
              $totTipos = count($tipos);
              echo "<option value=\"#\""; if($_GET['acao']=="pesquisar"){if($_POST['cbSelTipo']=="#"){
                                            echo "select=\"selected\"";}} echo "></option>";
              for($x=0; $x<$totTipos; $x++) {
                echo "<option value=\"$tipos[$x]\"";
                if($_GET['acao']=="pesquisar"){if( $_POST['cbSelTipo']==$tipos[$x]){
                  echo " selected=\"selected\"";}}
                echo ">$tipos[$x]</option>";
              }
            ?>
          </select>
          <br />
          <span class="tituloCampo"> Descrição: </span>
          <textarea class="txtAreDescricao" name="txtAreaDescricao" id="txtAreaDescricao" rows="3" cols="50"></textarea>
          <br /><br />
        </div>
        <div class="grupoOpcBotoes" id="cxBotoes">
          <a href="#" name="lkInserir" id="lkInserir" class="lnkInserir" onClick="validaInserir();">INSERIR</a>
          <a href="#"  name="lkLimpar" id="lkLimpar" class="lnkLimpar" onClick="limpar();">LIMPAR</a>
        </div>
      </div>
    </form>
  </body>

</html>

<!-- Cadastro de Circuitos
       autor: Jonas da Silva Azevedo
       criado em: 05/03/2010 - 08:00
       última modificação: 10/03/2010 - 16:41
-->
