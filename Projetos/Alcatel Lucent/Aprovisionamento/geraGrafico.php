<?php
  require("conexaoBD.php");
  require("graficos.php");
  $grafico = new graficos();
  
  function pegaCodigoImagem(){
    $bd = new conexao("localhost","root","","aprovisionamento");
    $sql = "SELECT codigo FROM imagem ORDER BY codigo DESC LIMIT 1";
    $ultRegistro = $bd->selecionaDados($sql);
    if(isset($ultRegistro)){
      return $ultRegistro[0]->codigo + 1;
    }
    else {
      return 1;
    }
  }
  
  if(isset($_GET['opcao'])){ $opc = $_GET['opcao'];} else {$opc = 0;}
  if(isset($_GET['dtIni'])){ $dtIni = $_GET['dtIni'];} else {$dtIni = 0;}
  if(isset($_GET['dtFin'])){ $dtFin = $_GET['dtFin'];} else {$dtFin = 0;}
  
  if($opc=='Geral de OS'){
    $cod = pegaCodigoImagem();
    $grafico->graficoGeral(900,450,$dtIni,$dtFin,$cod);
  }
  else if($opc=='Ofensores por Segmento'){
    $cod = pegaCodigoImagem();
    $grafico->graficoOfensoresSegmento(900,450,$dtIni,$dtFin,$cod);
  }
  else if($opc=='Ofensores por Responsável'){
    $cod = pegaCodigoImagem();
    $grafico->graficoOfensoresResponsavel(900,450,$dtIni,$dtFin,$cod);
  }
  else if($opc=='Causa Ofensores'){
    $cod = pegaCodigoImagem();
    $grafico->graficoCausasOfensores(900,450,$dtIni,$dtFin,$cod);
  }
  else if($opc=='Meta Prisma - VOZ_AV'){
    $cod = pegaCodigoImagem();
    $grafico->graficoAcompanhamentoMetaPrisma(900,450,$dtIni,$dtFin,$cod,'VOZ_AV');
  }
  else if($opc=='Meta Prisma - CD'){
    $cod = pegaCodigoImagem();
    $grafico->graficoAcompanhamentoMetaPrisma(900,450,$dtIni,$dtFin,$cod,'CD');
  }
  else if($opc=='Meta Prisma - TX'){
    $cod = pegaCodigoImagem();
    $grafico->graficoAcompanhamentoMetaPrismaTX(900,450,$dtIni,$dtFin,$cod);
  }
   else if($opc=='Meta Prisma - Eficiência'){
    $cod = pegaCodigoImagem();
    $grafico->graficoAcompanhamentoMetaPrisma(900,450,$dtIni,$dtFin,$cod,'Todos');
  }
   else if($opc=='Mensal - Meta Prisma - Eficiência'){
    $cod = pegaCodigoImagem();
    $grafico->graficoAcompanhamentoMensal(900,450,$dtIni,$dtFin,$cod,'Todos');
  }
  else if($opc=='Acompanhamento'){
//    $dtIni = '2010/01/01';
//    $dtFin = '2010/01/31';
    $grafico->graficoAcompanhamentoEvolucaoOSsPrazo(900,450,$dtIni,$dtFin);
  }
?>
