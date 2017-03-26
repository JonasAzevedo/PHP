<?php
  require_once("conexaoBD.php");
  
  //buscando por configurações - campo descrição
  $bd = new conexao("localhost","root","","aprovisionamento");
  $sql = "SELECT * FROM configuracoes WHERE codigo=1";
  $dadosConf = $bd->selecionaDados($sql);
  $desc;
  
  if(isset($_POST['edDataInicio'])){ $dtIni = $_POST['edDataInicio'];} else {$dtIni = 0;}
  if(isset($_POST['edDataFinal'])){ $dtFin = $_POST['edDataFinal'];} else {$dtFin = 0;}
  if(isset($_POST['btnGrafico'])){
    $opc = $_POST['btnGrafico'];
    if($opc=='Geral de OS'){
      $desc = $dadosConf[0]->descricao_graf_geral_de_os;
    }
    else if($opc=='Ofensores por Segmento'){
      $desc = $dadosConf[0]->descricao_graf_ofensores_segmento;
    }
    else if($opc=='Ofensores por Responsável'){
      $desc = $dadosConf[0]->descricao_graf_ofensores_responsavel;
    }
    else if($opc=='Causa Ofensores'){
      $desc = $dadosConf[0]->descricao_graf_causa_ofensores;
    }
    else if($opc=='Meta Prisma - VOZ_AV'){
      $desc = $dadosConf[0]->descricao_graf_meta_prisma_voz_av;
    }
    else if($opc=='Meta Prisma - CD'){
      $desc = $dadosConf[0]->descricao_graf_meta_prisma_cd;
    }
    else if($opc=='Meta Prisma - TX'){
      $desc = $dadosConf[0]->descricao_graf_meta_prisma_tx;
    }
    else if($opc=='Meta Prisma - Eficiência'){
      $desc = $dadosConf[0]->descricao_graf_meta_prisma_eficiencia;
    }
    else if($opc=='Mensal - Meta Prisma - Eficiência'){
      $desc = $dadosConf[0]->descricao_graf_mensal_meta_prisma_eficiencia;
    }
    else if($opc=='Mensal - Meta Prisma - VOZ_AV'){
      $desc = $dadosConf[0]->descricao_graf_mensal_meta_prisma_voz_av;
    }
    else if($opc=='Mensal - Meta Prisma - CD'){
      $desc = $dadosConf[0]->descricao_graf_mensal_meta_prisma_cd;
    }
    else if($opc=='Mensal - Meta Prisma - TX'){
      $desc = $dadosConf[0]->descricao_graf_mensal_meta_prisma_tx;
    }
    else{
      $opc='Geral de OS';
      $desc = $dadosConf[0]->descricao_graf_geral_de_os;
    }
  }
  else{
    $opc='Geral de OS';
    $desc = $dadosConf[0]->descricao_graf_geral_de_os;
  }

?>

  <html>
    <head>
      <link rel="stylesheet" type="text/css" href="estilos.css" />
    </head>
    
    <body>
<?php
  //IMAGEM
  if($opc=='Meta Prisma - TX'){
    echo "<img src='graficoMetaPrisma_TX.php?dtIni=".$dtIni."&dtFin=".$dtFin . "' />";
  }
  elseif($opc=='Mensal - Meta Prisma - Eficiência'){
    echo "<img src='acompanhamentoMetaPrismaTodos_Mes.php' />";
  }
  elseif($opc=='Mensal - Meta Prisma - VOZ_AV'){
    echo "<img src='acompanhamentoMetaPrismaVOZ_AV_Mes.php' />";
  }
  elseif($opc=='Mensal - Meta Prisma - CD'){
    echo "<img src='acompanhamentoMetaPrismaCD_Mes.php' />";
  }
  elseif($opc=='Mensal - Meta Prisma - TX'){
    echo "<img src='acompanhamentoMetaPrismaTX.php' />";
  }
  else{
    echo "<img src='geraGrafico.php?opcao=".$opc."&dtIni=".$dtIni."&dtFin=".$dtFin . "' />";
  }

  echo "<form name='frmGeraPDF' method='POST' onSubmit action='geraArquivoPDF.php'>";
?>
    <align="center">
    <br>
    <b>Descrição:<b> <input type='checkbox' name='ckBxDescricao' checked/> <br>
    <textarea name="mmDescricao" rows="2" cols="108"><?php echo $desc; ?></textarea>
    <input type="hidden" name="edOpc" value="<?php echo $opc; ?>" />
    <center><input type="submit" name="btnGeraArquivoPDF" value="Gerar Arquivo PDF" class="buttonGeraPDF" /></center>
  </form>

  </body>
  </html>
  <!--
  <script language="JavaScript">
    alert(document.getElementById('textoLegenda').innerHTML);
  </script>
  !-->

