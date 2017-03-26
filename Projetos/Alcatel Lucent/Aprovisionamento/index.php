<?php
  require("sessao.php");
  $acesso = $_SESSION["acesso"];
  $nomeUsuario = $_SESSION["nomeUsuario"];
  
  require("funcoes.php");
  $funcoes = new funcoes();
  $mesAtual = $funcoes->getMesAtual();
  
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="estilos.css" />
    <title>IE²</title>

    <script language="JavaScript">
      var win = null;
      function NovaJanela(form,pagina,nome,w,h,scroll){
        LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
        TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
        settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
        pagina = pagina + '?codigo=' + form.pesquisaID.value;
        win = window.open(pagina,nome,settings);
      }
    </script>

  </head>
  <body>
    <center>
    <?php
      echo "<a href='osJustificar.php'>Justificar OS</a>&nbsp;&nbsp;|&nbsp;&nbsp";
      echo "<a href='mostraGraficos.php'>Gráficos</a>";
      if($acesso>=3){ // privilégios limitados
        echo "&nbsp;&nbsp;|&nbsp;&nbsp";
        echo "<a href='principalMotivoVencimentoOS.php'>Motivo de Vencimento das OS's</a>&nbsp;&nbsp;|&nbsp;&nbsp";
        echo "<a href='principalSetoresResponsabilidade.php'>Setores Responsáveis</a>&nbsp;&nbsp;|&nbsp;&nbsp";
        echo "<a href='cadConfiguracoes.php'>Configurações</a>&nbsp;&nbsp;|&nbsp;&nbsp";
        echo "<a href='importaArquivoCSV.html'>Importar Dados</a>";
      }
      echo "&nbsp;&nbsp;|&nbsp;&nbsp";
      echo "<a href='logoff.php'>Sair - " . $nomeUsuario . "</a>&nbsp;&nbsp;|&nbsp;&nbsp";
      echo "<a href='cadSuporte.php'>Suporte</a>";
    ?>
    </center><br><br>
    <center>
    <?php
    //total de OS's
    $sql = "SELECT COUNT(codigo) AS total FROM os_encerrada WHERE MONTH (diaEncerramento) = MONTH(NOW())";
    $totDados = $bd->selecionaDados($sql);
    
    //total de OS's no prazo
    $sql = "SELECT COUNT(o.codigo) AS total FROM os_encerrada o ";
    $sql = $sql . "WHERE o.aprovNoPrazo = 'NoPrazo' AND MONTH (diaEncerramento) = MONTH(NOW()) ";
    $totOSsPrazo = $bd->selecionaDados($sql);
    
    //total de OS's vencidas
    $sql = "SELECT COUNT(o.codigo) AS total FROM os_encerrada o ";
    $sql = $sql . "WHERE o.aprovNoPrazo = 'Vencidas' AND MONTH (diaEncerramento) = MONTH(NOW()) ";
    $totOSsVencidas = $bd->selecionaDados($sql);

    echo "<br><br><br>";
    echo "<table id='tblDadosOSsMes' border='0' align='center' cellpadding='10' cellpacing='1'>";
      echo "<tr align='center'>";
        echo "<th>";
          echo "Resumo das OS's Finalizadas no Mês de " . $mesAtual;
        echo "</th>";
      echo "</tr>";
      echo "<tr align='center'>";
        echo "<td>";
          echo "TOTAL DE OS's: " . $totDados[0]->total;
        echo "</td>";
      echo "</tr>";
      echo "<tr align='center'>";
        echo "<td>";
          echo "OS's no Prazo: " . $totOSsPrazo[0]->total;
        echo "</td>";
      echo "</tr>";
      echo "<tr align='center'>";
        echo "<td>";
          echo "OS's Vencidas: " . $totOSsVencidas[0]->total;
        echo "</td>";
      echo "</tr>";
      echo "</table>";
    ?>
    </center>
    
    <br><br><br><br><br><br><br><br><br>
    <b>Pesquisar por ID:</b>
    <form name="consultaOS" method="POST" onSubmit="NovaJanela(this,'detalheOS.php','Detalhe_da_OS','700','400','yes')">
      <input type="text" name="pesquisaID" value="<?php echo $_POST['pesquisaID'];?>" />
      <input type="submit" value="OK" name="modal" class="buttonOK" />
    </form>

  </body>
</html>
