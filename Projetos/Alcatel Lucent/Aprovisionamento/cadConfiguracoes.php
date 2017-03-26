<?php
  /* cadastro de configurações
  Jonas da Silva Azevedo
  Criado: 02/02/2010 - 09:22
*/
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  if($_GET['acao']=='cadastrar') {
    $sql = "UPDATE configuracoes SET projetado='" . $_POST['edProjetado'] . "',descricao_graf_geral_de_os='" . $_POST['mmDescGrafGeralOS'] . "', ";
    $sql = $sql . "descricao_graf_ofensores_segmento='" . $_POST['mmDescGrafOfensoresSegmento'] . "',descricao_graf_ofensores_responsavel='" . $_POST['mmDescGrafOfensoresResponsavel'] . "', ";
    $sql = $sql . "descricao_graf_causa_ofensores='" . $_POST['mmDescGrafCausaOfensores'] . "',descricao_graf_meta_prisma_voz_av='" . $_POST['mmDescGrafMetaPrismaVozAV'] . "', ";
    $sql = $sql . "descricao_graf_meta_prisma_cd='" . $_POST['mmDescGrafMetaPrismaCD'] . "',descricao_graf_meta_prisma_tx='" . $_POST['mmDescGrafMetaPrismaTX'] . "', ";
    $sql = $sql . "descricao_graf_meta_prisma_eficiencia='" . $_POST['mmDescGrafMetaPrismaEficiencia'] . "', ";
    $sql = $sql . "descricao_graf_mensal_meta_prisma_voz_av='" . $_POST['mmDescGrafMetaPrismaMensalVozAV'] . "', ";
    $sql = $sql . "descricao_graf_mensal_meta_prisma_cd='" . $_POST['mmDescGrafMetaPrismaMensalCD'] . "', ";
    $sql = $sql . "descricao_graf_mensal_meta_prisma_tx='" . $_POST['mmDescGrafMetaPrismaMensalTX'] . "', ";
    $sql = $sql . "descricao_graf_mensal_meta_prisma_eficiencia='" . $_POST['mmDescGrafMetaPrismaMensalEficiencia'] . "' ";
    $sql = $sql . "WHERE codigo=1";
    $insere = $bd->executaSQL($sql);
    if($insere){
      echo "<meta http-equiv='refresh' content='0;url=./index.php'>";
    }
    else {
      ?>
      <script language="JavaScript">
        <!--
          alert("Configuração não pode ser editada!")
        -->
      </script>
      <?php
    }
  }
  
  $sqlCod = "SELECT * FROM configuracoes c WHERE c.codigo=1";
  $dadosRes = $bd->selecionaDados($sqlCod);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <script language="JavaScript">
      <!--
        function validaDados(form) {
          campos = ""
          tot = 0
          if (form.edProjetado.value == "") {
            tot ++
            campos = "Projetado"
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
    <title>Configurações</title>
  </head>

  <body>
    <center>
      <p>
        <a href='logoff.php'>Sair</a>
      </p>
      <p>
        <a href="index.php">Principal</a>
      </p>
      <h2>CADASTRO DAS CONFIGURACÕES</h2>
    </center>
    <form name="frmCadastroConfiguracoes" method="POST" onSubmit="return validaDados(this)" action="<?php echo $PHP_SELF;?> ?acao=cadastrar">
      <table id="tblDadosConfiguracoes" border="0" align="center" cellpadding="10" cellpacing="1">
        <tr>
          <td>
            <b>Projetado:</b> <input type="text" name="edProjetado" maxlength="20" size="10" value="<?php echo $dadosRes[0]->projetado;?>" />
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Geral de OS:</b> <br> <textarea name="mmDescGrafGeralOS" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_geral_de_os;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Ofensores Segmento:</b> <br> <textarea name="mmDescGrafOfensoresSegmento" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_ofensores_segmento;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Ofensores Responsável:</b> <br> <textarea name="mmDescGrafOfensoresResponsavel" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_ofensores_responsavel;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Causa Ofensores:</b> <br> <textarea name="mmDescGrafCausaOfensores" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_causa_ofensores;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma - VOZ AV:</b> <br> <textarea name="mmDescGrafMetaPrismaVozAV" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_meta_prisma_voz_av;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma - CD:</b> <br> <textarea name="mmDescGrafMetaPrismaCD" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_meta_prisma_cd;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma - TX:</b> <br> <textarea name="mmDescGrafMetaPrismaTX" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_meta_prisma_tx;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma - Eficiência:</b> <br> <textarea name="mmDescGrafMetaPrismaEficiencia" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_meta_prisma_eficiencia;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma Mensal - VOZ AV:</b> <br> <textarea name="mmDescGrafMetaPrismaMensalVozAV" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_mensal_meta_prisma_voz_av;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma Mensal - CD:</b> <br> <textarea name="mmDescGrafMetaPrismaMensalCD" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_mensal_meta_prisma_cd;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma Mensal - TX:</b> <br> <textarea name="mmDescGrafMetaPrismaMensalTX" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_mensal_meta_prisma_tx;?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <b>Descrição Gráfico Meta Prisma Mensal - Eficiência:</b> <br> <textarea name="mmDescGrafMetaPrismaMensalEficiencia" rows="3" cols="92"><?php echo $dadosRes[0]->descricao_graf_mensal_meta_prisma_eficiencia;?></textarea>
          </td>
        </tr>
        <tr align="center">
          <td>
            <hr size="1" width="80%" align="center" noshade>
          </td>
        </tr>
        <tr align="center">
          <td>
            <input type="submit" name="btnSalvar" value="Salvar"  class="buttons1" />
          </td>
        </tr>
      </table>
  </body>
</html>
