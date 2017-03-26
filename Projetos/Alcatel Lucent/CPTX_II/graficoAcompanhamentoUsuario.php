<?php
    session_start();
    require_once ("./jpgraph-3.0.7/src/jpgraph.php");
    require_once ("./jpgraph-3.0.7/src/jpgraph_line.php");
    
    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");
    
    //subtrai da data atual, para gerar gráfico por período - semanal
    function subtraiData($data,$dias) {
      $thisyear = substr ($data, 0, 4);
      $thismonth = substr ($data, 4, 2);
      $thisday =  substr ($data, 6, 2);
      $nextdate = mktime (0, 0, 0, $thismonth, $thisday - $dias, $thisyear );
      return strftime("%Y%m%d", $nextdate);
    }
    
    //adiciona a data atual, para gerar eixo datas do gráfico
    function adicionaData($data,$dias) {
      $thisyear = substr ($data, 0, 4);
      $thismonth = substr ($data, 4, 2);
      $thisday =  substr ($data, 6, 2);
      $nextdate = mktime (0, 0, 0, $thismonth, $thisday + $dias, $thisyear );
      return strftime("%Y%m%d", $nextdate);
    }

    //formata data para legenda do gráfico
    function formataData($dataFormatar){
      $dataExp = explode("-", $dataFormatar);
      $data = $dataExp[2] . "/" . $dataExp[1];
      return $data;
    }
    
    //formata data para ser exibida corretamente = Date("Ymd");
    function formataDataYmd($dataFormatar){
      $data = substr($dataFormatar,0,4) . "-" . substr($dataFormatar,4,2) . "-" . substr($dataFormatar,6,2);
      return $data;
    }
    
    //formata data para ser exibida corretamente no gráfico - dia/mês
    function formataDataYmd_DiaMes($dataFormatar){
      $data = substr($dataFormatar,6,2) . "-" . substr($dataFormatar,4,2);
      return $data;
    }
    
    //formata data para fazer teste de comparação se data existe
    //formatar para aparecer data mesmo se total de circuitos nesse dia não existe
    function formataCompararData($dataFormatar){
      $dataExp = explode("-", $dataFormatar);
      $data = $dataExp[0] . $dataExp[1] . $dataExp[2];
      return $data;
    }

    $dataAtual = date("Ymd");
    $dataFinal = subtraiData($dataAtual,6); // Subtrair 06 dias - gráfico dos últimos 7 dias - semana

    $dataB = formataDataYmd($dataAtual);
    $dataA = formataDataYmd($dataFinal);

    $sql = "SELECT COUNT(codigo) AS total,CAST(data_executou AS DATE) AS data FROM os ";
    $sql = $sql . "WHERE CAST(data_executou AS DATE) BETWEEN '" . $dataA . "' AND '" . $dataB . " ' ";
    $sql = $sql . "GROUP BY CAST(data_executou AS DATE)";
    $pesquisa = $bd->selecionaDados($sql);
    $total = count($pesquisa);
    
    //pegar eixo x e y
    $i = 0;
    $data = array();
    $total = array();
    $dataX = $dataFinal;
    foreach($pesquisa as $mostra){
/*        $total[$i] = $mostra->total;
          $data[$i] = formataData($mostra->data);
          $i++;
}*/
      for ($x=1;$x<=7;$x++){
        if($dataX == formataCompararData($mostra->data)){
          $total[$i] = $mostra->total;
          $data[$i] = formataData($mostra->data);
          $i++;
          $dataX = adicionaData($dataX,1);
          break;
        }
        else{
          $total[$i] = 0;
          $data[$i] = formataDataYmd_DiaMes($dataX);
          $i++;
          $dataX = adicionaData($dataX,1);
        }
      }
    }

    while($i<7){ //garantir que aparecera os sete dias
      $total[$i] = 0;
      $data[$i] = formataDataYmd_DiaMes($dataX);
      $dataX = adicionaData($dataX,1);
      $i++;
    }

    // Setup the graph
    $graph = new Graph(350,300);
    $graph->SetMarginColor('white');
    $graph->img->SetAntiAliasing();
    $graph->SetScale("textlin");
    $graph->SetFrame(false);
    $graph->SetMargin(30,50,30,100);
    $graph->SetMarginColor('white');
    $graph->title->SetFont(FF_ARIAL,FS_BOLD,13);
    $graph->title->Set('Gráfico de Acompanhamento');

    $graph->ygrid->SetFill(true,'white@0.9','green@0.9');
    // Add 10% grace to top and bottom of plot
    $graph->yscale->SetGrace(10,0);

    $graph->xaxis->SetTickLabels($data);
    $graph->xaxis->SetFont(FF_ARIAL);

    // Create the first line
    $p1 = new LinePlot($total);
    $p1->SetWeight(2);
    $p1->SetCenter();
    $p1->SetColor("black");
    $p1->SetLegend('Circuitos');
    $graph->Add($p1);

    $graph->legend->SetShadow('gray@0.4',5);
    $graph->legend->SetPos(0.35,0.80,'right','top');
    // Output line
    $graph->Stroke();

    ?>

