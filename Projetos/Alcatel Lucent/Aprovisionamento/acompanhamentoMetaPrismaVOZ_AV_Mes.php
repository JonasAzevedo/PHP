<?php
  require_once("conexaoBD.php");
  require("./jpgraph-3.0.7/src/jpgraph.php");
  require("./jpgraph-3.0.7/src/jpgraph_pie.php");
  require("./jpgraph-3.0.7/src/jpgraph_pie3d.php");
  require("./jpgraph-3.0.7/src/jpgraph_line.php");
  require("./jpgraph-3.0.7/src/jpgraph_bar.php");

  function formataData($dataFormatar){
    $dataExp = explode("-", $dataFormatar);
    $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
    return $data;
  }

  function pegaProjetado(){
    $bd = new conexao("localhost","root","","aprovisionamento");
    $sql = "SELECT * FROM configuracoes c WHERE c.codigo='1'";
    if(!$dados = $bd->selecionaDados($sql)){
      echo "Erro ao buscar valor projetado!";
    }
    else{
      $tot = count($dados);
      if($tot != 0){
        return $dados[0]->projetado;
      }
      else {
        return 0;
      }
    }
  }

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

  function salvaImagem($img){
    $bdImg = new conexao("localhost","root","","aprovisionamento");
    $sql = "INSERT INTO imagem(nome) VALUES ('" . $img . "')";
    //echo $sql;
    if(! $bdImg->executaSQL($sql)){
      echo "Erro ao salvar imagem!";
    }
    else{
      ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diretório que será salva a sessãos
      session_start();
      $_SESSION["imagemGrafico"] = $img;
    }
  }

  $cod = pegaCodigoImagem();
  //selecionando dados
  $bd = new conexao("localhost","root","","aprovisionamento");
  $sql = "SELECT mes,ano,NoPrazo,Vencido,100*(Noprazo/(noPrazo+Vencido)) AS Perc FROM( ";
  $sql = $sql . "SELECT  MONTH(diaEncerramento) AS mes,YEAR(diaEncerramento) AS ano,SUM(IF(aprovNoPrazo='NoPrazo',1,0)) AS NoPrazo, ";
  $sql = $sql . "SUM(IF(aprovNoPrazo='Vencidas',1,0)) AS Vencido FROM os_encerrada ";
  $sql = $sql . "WHERE (computar = 'Sim' OR computar='sim') AND YEAR(diaEncerramento)=YEAR(NOW()) ";
  $sql = $sql . "AND gerencia='VOZ_AV' ";
  $sql = $sql . "GROUP BY mes,ano ORDER BY mes,ano) AS a";

  $dados = $bd->selecionaDados($sql);

  $tot = count($dados);

  if($tot!=0){
    //definindo variáveis
    $mes = array();
    $ano = array();
    $mesAno = array();
    $noPrazo = array();
    $vencidas = array();
    $perc = array();
    $metaPrisma = array();
    $cores = array();
    $i = 0;
    $totNoPrazo = 0; $totVencidas = 0;
    $prisma = pegaProjetado();
    foreach($dados as $percorre){
      $mes[$i] = $percorre->mes;
      $ano[$i] = $percorre->ano;
      $mesAno[$i] = $percorre->mes . "/" . $percorre->ano;
      $noPrazo[$i] = $percorre->NoPrazo;
      $vencidas[$i] = $percorre->Vencido;
      $perc[$i] = $percorre->Perc;
      $totNoPrazo = $totNoPrazo + $percorre->NoPrazo;
      $totVencidas = $totVencidas + $percorre->Vencido;
      $metaPrisma[$i] = $prisma;
      $cores[$i] = "#81D2FE";
      $i++;
    }//foreach

    //valor de realizado
    $mesAno[$i] = "Média";
    $metaPrisma[$i] = $prisma;
    $cores[$i] = "#81D2FE";
    $totOSs = $totNoPrazo + $totVencidas;
    $totRealizado = (100/$totOSs) * $totNoPrazo;
    $perc[$i] = $totRealizado;
    $cores[$i] = "#8F77F2";
    $i++;

    //cria gráfico
    $grafico = new Graph(900,450); //,'auto');
    $grafico->SetColor("#C0FFFF");
    $grafico->SetScale("textlin");
    $grafico->img->SetMargin(40,130,20,40);
    //$grafico->SetShadow(); //seta sombra
    //cria as barras do gráfico
    $bplot = new BarPlot($perc);
    //$bplot->SetFillColor("#FFC0C0","#FFFF80");
    $bplot->SetFillColor($cores);
    $bplot->SetLegend("Resultado");
    $bplot->value->SetAngle(90);//inclinação da legenda dos valores
    $bplot->value->Show(); //mostra valores
    $bplot->value->SetFont(FF_ARIAL,FS_NORMAL,8); //fonte
    $bplot->value->SetColor("#000");//("#008000");
    //$bplot->value->SetAlign('left','center');
    $bplot->value->SetFormat('%.2f'); //exibir 2 casas depois da vírgula
    $bplot->SetValuePos('center'); //posição da legenda - no centro
    //adicionando as barras ao gráfico
    $grafico->Add($bplot);
    //legendas
    $grafico->title->Set("OS's APROVISIONADAS - VOZ AVANÇADA");
    $grafico->title->SetMargin(15);
    $grafico->title->SetFont(FF_ARIAL,FS_BOLD,16);
    //formatação da legenda no rodapé
    $grafico->legend->SetLayout(LEGEND_HOR);
    $grafico->legend->Pos(0.50,0.96,"center","bottom");
    //eixo Y
    $grafico->yaxis->title->Set("%");
    $grafico->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
    //$grafico->yaxis->Hide(); //esconde o eixo Y
    $grafico->ygrid->Show(false); //esconde o gride do eixo Y
    //$grafico->yaxis->scale->SetGrace(20); //escala do eixo Y + 20 % (sempre dá 20%)
    //eixo X
    //$grafico->xaxis->title->Set("Dias");
    //$grafico->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
    $grafico->xaxis->SetTickLabels($mesAno); //legenda do eixo X
    $grafico->xaxis->SetLabelAngle(90); //inclinação da legenda do eixo X
    //$grafico->xaxis->SetTitleMargin(50);//posição referente a margem da legenda do eixo X (Dias)
    //$grafico->xaxis->SetTextTickInterval(2); //intervalo da legenda do eixo X
    $grafico->img->SetMargin(50,65,50,85); //setando margens do gráfico
    //exibir gráfico
    $grafico->Stroke();
    //salvando imagem em disco
    $img = "./img/imagem_" . $cod . ".png";
    salvaImagem($img);
    $grafico->Stroke($img);
      }
  else {
    echo "Nenhum resultado encontrado para a pesquisa.";
  }
?>
