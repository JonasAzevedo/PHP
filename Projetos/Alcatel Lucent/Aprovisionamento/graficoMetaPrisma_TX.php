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
  
  function formataDataPesquisa($dataFormatar){
    $dataExp = explode("/", $dataFormatar);
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
  
  if(isset($_GET['dtIni'])){ $dtIni = $_GET['dtIni'];} else {$dtIni = 0;}
  if(isset($_GET['dtFin'])){ $dtFin = $_GET['dtFin'];} else {$dtFin = 0;}
  
//  echo "dt Ini: " . $dtIni;
//  echo "<br>";
//  echo "dt Fim: " . $dtFin;
  
  //selecionando dados
  $bd = new conexao("localhost","root","","aprovisionamento");
  $sql = "SELECT dia,segNovo,NoPrazo,Vencido,100*(Noprazo/(noPrazo+Vencido)) AS Perc FROM( ";
  $sql = $sql . "SELECT diaEncerramento AS dia,segNovo,SUM(IF(aprovNoPrazo='NoPrazo',1,0)) AS NoPrazo, ";
  $sql = $sql . "SUM(IF(aprovNoPrazo='Vencidas',1,0)) AS Vencido FROM os_encerrada ";
  $sql = $sql . "WHERE (computar = 'Sim' OR computar='sim') AND gerencia='TX' ";
  if(($dtIni!=0)and($dtFin!=0)){
    $dt1 = formataDataPesquisa($dtIni);
    $dt2 = formataDataPesquisa($dtFin);
    $sql = $sql . "AND CAST(diaEncerramento AS DATE) BETWEEN '" . $dt1 . "' AND '" . $dt2 . "'";
    //$sql = $sql . "AND CAST(diaEncerramento AS DATE) BETWEEN '2010/2/1' AND '2010/2/20'";
  }
  $sql = $sql . " GROUP BY diaEncerramento,segNovo ORDER BY diaEncerramento,segNovo) AS a";
  $dados = $bd->selecionaDados($sql);

  $tot = count($dados);

  if($tot!=0){
    //definindo variáveis
    $dia = array();
    //$segNovo = array();
    $noPrazo_Proprio = array(); $noPrazo_B2B = array();
    $vencidas_Proprio = array(); $vencidas_B2B = array();
    $perc_Proprio = array(); $perc_B2B = array();
    $metaPrisma = array();
    $cores_Pro = array(); $cores_B2B = array();
    $i = 0;
    $totOS_Proprio = 0; $totOS_B2B = 0;
    $totNoPrazo_Proprio = 0; $totNoPrazo_B2B = 0;
    $prisma = pegaProjetado();
    foreach($dados as $percorre){
      //arrumar algorítimo para pegar dia
      $dt = formataData($percorre->dia);
      if($dt <> $dia[$i-1]){
        $dia[$i] = formataData($percorre->dia);
        $metaPrisma[$i] = $prisma;
        $i++;
      }
    }//foreach dia

    //pegando dados da OS
    $b = 0; $p = 0;
   //variáveis para verificar se achou as 2 ocorrências para a data atual
   $dtAtual = 0;
   $qtdeDtAtual=0;
   foreach($dados as $percorre){
     if(($qtdeDtAtual==0)or($qtdeDtAtual==2)){
       $dtAtual=$percorre->dia;
       $qtdeDtAtual = 0;
     }
     elseif($qtdeDtAtual==1){
       if($dtAtual<>$percorre->dia){
         $noPrazo_Proprio[$p] = "";//0;
         $vencidas_Proprio[$p] = "";//0;
         $perc_Proprio[$p] = 100;//0;
         $cores_Pro[$p] = "#81D2FE";
         $p++;
         $dtAtual=$percorre->dia;
         $qtdeDtAtual=0;
       }
     }
     if($qtdeDtAtual==0){
       //$ver = $vezSeg % 2;
       if($percorre->segNovo == "B2B"){ //se o registro é mesmo de B2B
         //salvando segmento B2B
         $noPrazo_B2B[$b] = $percorre->NoPrazo;
         $vencidas_B2B[$b] = $percorre->Vencido;
         if($percorre->Perc <> 0){$perc_B2B[$b] = $percorre->Perc;}else {$perc_B2B[$b] = 0;}
         $totOS_B2B = $totOS_B2B + $percorre->NoPrazo + $percorre->Vencido;
         $totNoPrazo_B2B = $totNoPrazo_B2B + $percorre->NoPrazo;
         $cores_B2B[$b] = "#82A7FD";
         $b++;
         $qtdeDtAtual ++;
       }
       elseif($percorre->segNovo == "Próprio"){ //se o registro não é o corrente (Próprio)
         //salvando segmento Próprio
         $noPrazo_Proprio[$p] = $percorre->NoPrazo;
         $vencidas_Proprio[$p] = $percorre->Vencido;
         if($percorre->Perc <> 0){$perc_Proprio[$p] = $percorre->Perc;}else {$perc_Proprio[$p] = 0;}
         $totOS_Proprio = $totOS_Proprio + $percorre->NoPrazo + $percorre->Vencido;
         $totNoPrazo_Proprio = $totNoPrazo_Proprio + $percorre->NoPrazo;
         $cores_Pro[$p] = "#81D2FE";
         //salvando segmento B2B
         $noPrazo_B2B[$b] = "";//0;
         $vencidas_B2B[$b] = "";//0;
         $perc_B2B[$b] = 100;//0;
         $cores_B2B[$b] = "#82A7FD";
         $b++;
         $p++;
         $qtdeDtAtual==2;
       }
     }//if($qtdeDtAtual==0)
     elseif($qtdeDtAtual==1){
       if($percorre->segNovo == "Próprio"){ //se o registro é mesmo de Próprio
         //salvando segmento Próprio
         $noPrazo_Proprio[$p] = $percorre->NoPrazo;
         $vencidas_Proprio[$p] = $percorre->Vencido;
         if($percorre->Perc <> 0){$perc_Proprio[$p] = $percorre->Perc;}else {$perc_Proprio[$p] = 0;}
         $totOS_Proprio = $totOS_Proprio + $percorre->NoPrazo + $percorre->Vencido;
         $totNoPrazo_Proprio = $totNoPrazo_Proprio + $percorre->NoPrazo;
         $cores_Pro[$p] = "#81D2FE";
         $p++;
         $qtdeDtAtual ++;
       }
     }//elseif($qtdeDtAtual==1)
   } //foreach

   //valor de realizado
   $dia[$i] = "Realizado";
   $metaPrisma[$i] = $prisma;
   //próprio
   $cores_Pro[$p] = "#92C6ED";
   $totRealizado = (100/$totOS_Proprio) * $totNoPrazo_Proprio;
   $perc_Proprio[$p] = $totRealizado;
   $p++;
   //b2b
   $cores_B2B[$b] = "#947EEB";
   $totRealizado = (100/$totOS_B2B) * $totNoPrazo_B2B;
   $perc_B2B[$b] = $totRealizado;
   $b++;
   $i++;
   //valor de projetado
   $dia[$i] = "Projetado";
   $metaPrisma[$i] = $prisma;
   //próprio
   $cores_Pro[$p] = "#8FAAEF";
   $perc_Proprio[$p] = pegaProjetado();
   $p++;
   //b2b
   $cores_B2B[$b] = "#A665E0";
   $perc_B2B[$b] = pegaProjetado();
   $b++;
   $i++;

   //cria gráfico
   //$grafico = new Graph($pieGra1,$pieGra2); //,'auto');
   $grafico = new Graph(910,410); //,'auto');
   $grafico->SetColor("#D0ECF0");//("#C0FFFF");
   $grafico->SetScale("textlin");
   $grafico->img->SetMargin(40,130,20,40);
   //$grafico->SetShadow(); //seta sombra
   //cria a linha - meta prisma
   $l1plot=new LinePlot($metaPrisma);
   $l1plot->SetColor("#004000");
   $l1plot->SetWeight(2);
   $l1plot->SetLegend("M.P. - " . $prisma . "%");
   //cria as barras do gráfico
   //próprio
   $b1plot = new BarPlot($perc_Proprio);
   //$b1plot->SetFillColor("#FFC0C0","#FFFF80");
   $b1plot->SetFillColor($cores_Pro);
   $b1plot->SetLegend("SWAP 3G");
   $b1plot->value->SetAngle(90);//inclinação da legenda dos valores
   $b1plot->value->Show(); //mostra valores
   $b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8); //fonte
   $b1plot->value->SetColor("#008000");
   //$b1plot->value->SetAlign('left','center');
   $b1plot->value->SetFormat('%.2f'); //exibir 2 casas depois da vírgula
   $b1plot->SetValuePos('center'); //posição da legenda - no centro
   //b2b
   $b2plot = new BarPlot($perc_B2B);
   //$b2plot->SetFillColor("#FFC0C0","#FFFF80");
   $b2plot->SetFillColor($cores_B2B);
   $b2plot->SetLegend("Clientes");
   $b2plot->value->SetAngle(90);//inclinação da legenda dos valores
   $b2plot->value->Show(); //mostra valores
   $b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8); //fonte
   $b2plot->value->SetColor("#008000");
   //$b2plot->value->SetAlign('left','center');
   $b2plot->value->SetFormat('%.2f'); //exibir 2 casas depois da vírgula
   $b2plot->SetValuePos('center'); //posição da legenda - no centro
   //cria grupo de barras
   $gbplot = new GroupBarPlot(array($b1plot,$b2plot));
   //adicionando as barras e linha ao gráfico
   $grafico->Add($gbplot);
   $grafico->Add($l1plot);
   //legendas
   //$grafico->title->Set("Meta Prisma - TX ");
   $grafico->title->Set("TX");
   $grafico->title->SetMargin(15);
   $grafico->title->SetFont(FF_ARIAL,FS_BOLD,16);
   //formatação da legenda no rodapé
   $grafico->legend->SetLayout(LEGEND_HOR);
   $grafico->legend->Pos(0.80,0.08,"center","bottom");
   //eixo Y
   $grafico->yaxis->title->Set("%");
   $grafico->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
   //$grafico->yaxis->Hide(); //esconde o eixo Y
   $grafico->ygrid->Show(false); //esconde o gride do eixo Y
   //$grafico->yaxis->scale->SetGrace(20); //escala do eixo Y + 20 % (sempre dá 20%)
   //eixo X
   //$grafico->xaxis->title->Set("Dias");
   //$grafico->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
   $grafico->xaxis->SetTickLabels($dia); //legenda do eixo X
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
?>
