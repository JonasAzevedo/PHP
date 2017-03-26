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
      ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diret�rio que ser� salva a sess�os
      session_start();
      $_SESSION["imagemGrafico"] = $img;
    }
  }


  $cod = pegaCodigoImagem();
  //selecionando dados
  $bd = new conexao("localhost","root","","aprovisionamento");
  $sql = "SELECT mes,ano,segNovo,NoPrazo,Vencido,100*(Noprazo/(noPrazo+Vencido)) AS Perc FROM( ";
  $sql = $sql . "SELECT  MONTH(diaEncerramento) AS mes,YEAR(diaEncerramento) AS ano,segNovo,SUM(IF(aprovNoPrazo='NoPrazo',1,0)) AS NoPrazo, ";
  $sql = $sql . "SUM(IF(aprovNoPrazo='Vencidas',1,0)) AS Vencido FROM os_encerrada ";
  $sql = $sql . "WHERE (computar = 'Sim' OR computar='sim') AND YEAR(diaEncerramento)=YEAR(NOW()) ";
  $sql = $sql . "AND gerencia='TX' ";
  $sql = $sql . "GROUP BY mes,ano,segNovo ORDER BY mes,ano,segNovo) AS a";

  $dados = $bd->selecionaDados($sql);

  $tot = count($dados);

  if($tot!=0){
    //definindo vari�veis
    $mes = array();
    $ano = array();
    $mesAno = array();
    $noPrazo_Proprio = array(); $noPrazo_B2B = array();
    $vencidas_Proprio = array(); $vencidas_B2B = array();
    $perc_Proprio = array(); $perc_B2B = array();
    $metaPrisma = array();
    $cores_Pro = array(); $cores_B2B = array();
    $i = 0;
    $totOS_Proprio = 0; $totOS_B2B = 0;
    $totNoPrazo_Proprio = 0; $totNoPrazo_B2B = 0;
    $prisma = pegaProjetado();
    $aux;
    foreach($dados as $percorre){
      $mes[$i] = $percorre->mes;
      $ano[$i] = $percorre->ano;
      $aux = $percorre->mes . "/" . $percorre->ano;
      if($aux <> $mesAno[$i-1]){
        $mesAno[$i] = $percorre->mes . "/" . $percorre->ano;
        $i++;
      }
    }//foreach dia

    //pegando dados da OS
    $b = 0; $p = 0;
   //vari�veis para verificar se achou as 2 ocorr�ncias para a data atual
   $mesAtual = 0;
   $qtdeMesAtual=0;
   foreach($dados as $percorre){
     if(($qtdeMesAtual==0)or($qtdeMesAtual==2)){
       $mesAtual=$percorre->mes;
       $qtdeMesAtual = 0;
     }
     elseif($qtdeMesAtual==1){
       if($mesAtual<>$percorre->mes){
         $noPrazo_Proprio[$p] = "";//0;
         $vencidas_Proprio[$p] = "";//0;
         $perc_Proprio[$p] = 100;//0;
         $cores_Pro[$p] = "#81D2FE";
         $p++;
         $mesAtual=$percorre->mes;
         $qtdeMesAtual=0;
       }
     }
     if($qtdeMesAtual==0){
       //$ver = $vezSeg % 2;
       if($percorre->segNovo == "B2B"){ //se o registro � mesmo de B2B
         //salvando segmento B2B
         $noPrazo_B2B[$b] = $percorre->NoPrazo;
         $vencidas_B2B[$b] = $percorre->Vencido;
         if($percorre->Perc <> 0){$perc_B2B[$b] = $percorre->Perc;}else {$perc_B2B[$b] = 0;}
         $totOS_B2B = $totOS_B2B + $percorre->NoPrazo + $percorre->Vencido;
         $totNoPrazo_B2B = $totNoPrazo_B2B + $percorre->NoPrazo;
         $cores_B2B[$b] = "#82A7FD";
         $b++;
         $qtdeMesAtual ++;
       }
       elseif($percorre->segNovo == "Pr�prio"){ //se o registro n�o � o corrente (Pr�prio)
         //salvando segmento Pr�prio
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
         $qtdeMesAtual==2;
       }
     }//if($qtdeMesAtual==0)
     elseif($qtdeMesAtual==1){
       if($percorre->segNovo == "Pr�prio"){ //se o registro � mesmo de Pr�prio
         //salvando segmento Pr�prio
         $noPrazo_Proprio[$p] = $percorre->NoPrazo;
         $vencidas_Proprio[$p] = $percorre->Vencido;
         if($percorre->Perc <> 0){$perc_Proprio[$p] = $percorre->Perc;}else {$perc_Proprio[$p] = 0;}
         $totOS_Proprio = $totOS_Proprio + $percorre->NoPrazo + $percorre->Vencido;
         $totNoPrazo_Proprio = $totNoPrazo_Proprio + $percorre->NoPrazo;
         $cores_Pro[$p] = "#81D2FE";
         $p++;
         $qtdeMesAtual ++;
       }
     }//elseif($qtdeMesAtual==1)
   } //foreach

   //valor de realizado
   $mesAno[$i] = "M�dia";
   $metaPrisma[$i] = $prisma;
   //pr�prio
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

   //cria gr�fico
   //$grafico = new Graph($pieGra1,$pieGra2); //,'auto');
   $grafico = new Graph(910,410); //,'auto');
   $grafico->SetColor("#D0ECF0");//("#C0FFFF");
   $grafico->SetScale("textlin");
   $grafico->img->SetMargin(40,130,20,40);
   //$grafico->SetShadow(); //seta sombra
   //cria as barras do gr�fico
   //pr�prio
   $b1plot = new BarPlot($perc_Proprio);
   //$b1plot->SetFillColor("#FFC0C0","#FFFF80");
   $b1plot->SetFillColor($cores_Pro);
   $b1plot->SetLegend("SWAP 3G");
   $b1plot->value->SetAngle(90);//inclina��o da legenda dos valores
   $b1plot->value->Show(); //mostra valores
   $b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8); //fonte
   $b1plot->value->SetColor("#008000");
   //$b1plot->value->SetAlign('left','center');
   $b1plot->value->SetFormat('%.2f'); //exibir 2 casas depois da v�rgula
   $b1plot->SetValuePos('center'); //posi��o da legenda - no centro
   //b2b
   $b2plot = new BarPlot($perc_B2B);
   //$b2plot->SetFillColor("#FFC0C0","#FFFF80");
   $b2plot->SetFillColor($cores_B2B);
   $b2plot->SetLegend("Clientes");
   $b2plot->value->SetAngle(90);//inclina��o da legenda dos valores
   $b2plot->value->Show(); //mostra valores
   $b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8); //fonte
   $b2plot->value->SetColor("#008000");
   //$b2plot->value->SetAlign('left','center');
   $b2plot->value->SetFormat('%.2f'); //exibir 2 casas depois da v�rgula
   $b2plot->SetValuePos('center'); //posi��o da legenda - no centro
   //cria grupo de barras
   $gbplot = new GroupBarPlot(array($b1plot,$b2plot));
   //adicionando as barras e linha ao gr�fico
   $grafico->Add($gbplot);
   //legendas
   //$grafico->title->Set("Meta Prisma - TX ");
   $grafico->title->Set("OS's APROVISIONADAS - TX");
   $grafico->title->SetMargin(15);
   $grafico->title->SetFont(FF_ARIAL,FS_BOLD,16);
   //formata��o da legenda no rodap�
   $grafico->legend->SetLayout(LEGEND_HOR);
   $grafico->legend->Pos(0.80,0.08,"center","bottom");
   //eixo Y
   $grafico->yaxis->title->Set("%");
   $grafico->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
   //$grafico->yaxis->Hide(); //esconde o eixo Y
   $grafico->ygrid->Show(false); //esconde o gride do eixo Y
   //$grafico->yaxis->scale->SetGrace(20); //escala do eixo Y + 20 % (sempre d� 20%)
   //eixo X
   //$grafico->xaxis->title->Set("Dias");
   //$grafico->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
   $grafico->xaxis->SetTickLabels($mesAno); //legenda do eixo X
   $grafico->xaxis->SetLabelAngle(90); //inclina��o da legenda do eixo X
   //$grafico->xaxis->SetTitleMargin(50);//posi��o referente a margem da legenda do eixo X (Dias)
   //$grafico->xaxis->SetTextTickInterval(2); //intervalo da legenda do eixo X
   $grafico->img->SetMargin(50,65,50,85); //setando margens do gr�fico
   //exibir gr�fico
   $grafico->Stroke();
   //salvando imagem em disco
   $img = "./img/imagem_" . $cod . ".png";
   salvaImagem($img);
   $grafico->Stroke($img);
  }
?>
