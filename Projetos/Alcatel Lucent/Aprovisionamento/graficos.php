<?php
  /* Conexao com o banco de dados
  Jonas da Silva Azevedo
  Criado: 26/01/2010 - 14:37
*/
 // require("sessao.php");
  require_once("conexaoBD.php");
  require("./jpgraph-3.0.7/src/jpgraph.php");
  require("./jpgraph-3.0.7/src/jpgraph_pie.php");
  require("./jpgraph-3.0.7/src/jpgraph_pie3d.php");
  require("./jpgraph-3.0.7/src/jpgraph_line.php");
  require("./jpgraph-3.0.7/src/jpgraph_bar.php");

  class graficos {
    private $bd;
    
    private function formataData($dataFormatar){
      $dataExp = explode("/", $dataFormatar);
      $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
      return $data;
    }
    
    private function formataData_MesAno($dataFormatar){
      $dataExp = explode("-", $dataFormatar);
      $data = $dataExp[2] . "/" . $dataExp[1];
      return $data;
    }
    
    private function salvaImagem($img){
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
    
    private function pegaProjetado(){
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

    function graficoGeral($pieGra1,$pieGra2,$dtIni,$dtFin,$cod){
      //selecionando dados
      $bd = new conexao("localhost","root","","aprovisionamento");
      $sql = "SELECT COUNT(o.codigo) AS Total,o.aprovNoPrazo FROM os_encerrada o ";
      $sql = $sql . "WHERE o.aprovNoPrazo IS NOT NULL AND o.aprovNoPrazo <> ''";
      if(($dtIni!=0)and($dtFin!=0)){
        $dt1 = $this->formataData($dtIni);
        $dt2 = $this->formataData($dtFin);
        $sql = $sql . "AND CAST(o.diaEncerramento AS DATE) BETWEEN '" . $dt1 . "' AND '" . $dt2 . "' ";
      }
      $sql = $sql . "GROUP BY o.aprovNoPrazo";

      $dados = $bd->selecionaDados($sql);
      $tot = count($dados);
      if($tot!=0){
        $total = array();
        $tipo = array();
        $i = 0;
        foreach($dados as $percorre){
          $total[$i] = $percorre->Total; // definir um array com os valores de cada fatia
          $tipo[$i] = $percorre->aprovNoPrazo; // definir um array que será usado como legenda
          $i++;
        }
        // criar novo gráfico de 350x200 pixels com tipo de imagem automático
        $grafico = new PieGraph($pieGra1,$pieGra2,"auto");
        // adicionar sombra
        $grafico->SetColor("#C0FFFF");
        $grafico->SetShadow();
        // título do gráfico
        $grafico->title->Set("Geral de OS's Encerradas");
        $grafico->title->SetFont(FF_ARIAL,FS_BOLD,16);
        $grafico->title->SetMargin(25);
        // definir valores ao gráfico
        $p1 = new PiePlot3D($total);
        // destacar o valor correspondente ao elemento (1), sendo que o primeiro elemento do array corresponde a (0)
        $p1->ExplodeSlice(1);
        // centralizar a 45% da largura
        $p1->SetCenter(0.45);
        // definir legendas
        $p1->SetLegends($tipo);
        $p1->value->SetFont(FF_ARIAL,FS_NORMAL,10); //fonte
        //legenda embaixo do gráfico
        $grafico->legend->SetLayout(LEGEND_HOR);
        $grafico->legend->Pos(0.50,0.96,"center","bottom");
        // adicionar valores ao gráfico
        $grafico->Add($p1);
        // gerar o gráfico
        $grafico->Stroke();
        //salvando imagem em disco
        $img = "./img/imagem_" . $cod . ".png";
        $this->salvaImagem($img);
        $grafico->Stroke($img);
      }
      else {
        echo "Nenhum resultado encontrado para a pesquisa.";
      }
    } //graficoGeral()
    
    function graficoOfensoresSegmento($pieGra1,$pieGra2,$dtIni,$dtFin,$cod){
      //selecionando dados
      $bd = new conexao("localhost","root","","aprovisionamento");
      $sql = "SELECT COUNT(o.codigo) AS Total,o.gerencia FROM os_encerrada o ".
      $sql = $sql . "WHERE o.gerencia IS NOT NULL AND o.gerencia <> ''";
      if(($dtIni!=0)and($dtFin!=0)){
        $dt1 = $this->formataData($dtIni);
        $dt2 = $this->formataData($dtFin);
        $sql = $sql . "AND CAST(o.diaEncerramento AS DATE) BETWEEN '" . $dt1 . "' AND '" . $dt2 . "'";
      }
      $sql = $sql . "GROUP BY o.gerencia";
      
      $dados = $bd->selecionaDados($sql);
      $tot = count($dados);
      if($tot!=0){
        $total = array();
        $tipo = array();
        $i = 0;
        foreach($dados as $percorre){
          $total[$i] = $percorre->Total; // definir um array com os valores de cada fatia
          $tipo[$i] = $percorre->gerencia; // definir um array que será usado como legenda
          $i++;
        }
        // criar novo gráfico de 350x200 pixels com tipo de imagem automático
        $grafico = new PieGraph($pieGra1,$pieGra2,"auto");
        $grafico->SetColor("#C0FFFF");
        // adicionar sombra
        $grafico->SetShadow();
        // título do gráfico
        $grafico->title->Set("Ofensores por Segmento");
        $grafico->title->SetFont(FF_ARIAL,FS_BOLD,16);
        $grafico->title->SetMargin(25);
        // definir valores ao gráfico
        $p1 = new PiePlot3D($total);
        // destacar o valor correspondente ao elemento (1), sendo que o primeiro elemento do array corresponde a (0)
        $p1->ExplodeSlice(1);
        // centralizar a 45% da largura
        $p1->SetCenter(0.45);
        // definir legendas
        $p1->SetLegends($tipo);
        $p1->value->SetFont(FF_ARIAL,FS_NORMAL,10); //fonte
        //legenda embaixo do gráfico
        $grafico->legend->SetLayout(LEGEND_HOR);
        $grafico->legend->Pos(0.50,0.95,"center","bottom");
        // adicionar valores ao gráfico
        $grafico->Add($p1);
        // gerar o gráfico
        $grafico->Stroke();
        //salvando imagem em disco
        $img = "./img/imagem_" . $cod . ".png";
        $this->salvaImagem($img);
        $grafico->Stroke($img);
      }
      else {
        echo "Nenhum resultado encontrado para a pesquisa.";
      }
    } //graficoOfensoresSegmento()

    function graficoOfensoresResponsavel($pieGra1,$pieGra2,$dtIni,$dtFin,$cod){
      //selecionando dados
      $bd = new conexao("localhost","root","","aprovisionamento");
      $sql = "SELECT COUNT(o.codigo) AS Total,o.setor_responsavel FROM os_encerrada o ";
      $sql = $sql . "WHERE o.setor_responsavel IS NOT NULL AND o.setor_responsavel <> '' ";
      if(($dtIni!=0)and($dtFin!=0)){
        $dt1 = $this->formataData($dtIni);
        $dt2 = $this->formataData($dtFin);
        $sql = $sql . "AND CAST(o.diaEncerramento AS DATE) BETWEEN '" . $dt1 . "' AND '" . $dt2 . "'";
      }
      $sql = $sql . "GROUP BY o.setor_responsavel";
      $dados = $bd->selecionaDados($sql);
      $tot = count($dados);
      if($tot!=0){
        $total = array();
        $tipo = array();
        $i = 0;
        foreach($dados as $percorre){
          $total[$i] = $percorre->Total; // definir um array com os valores de cada fatia
          $tipo[$i] = $percorre->setor_responsavel; // definir um array que será usado como legenda
          $i++;
        }
        // criar novo gráfico de 350x200 pixels com tipo de imagem automático
        $grafico = new PieGraph($pieGra1,$pieGra2,"auto");
        $grafico->SetColor("#C0FFFF");
        // adicionar sombra
        $grafico->SetShadow();
        // título do gráfico
        $grafico->title->Set("Ofensores por Responsável");
        $grafico->title->SetFont(FF_ARIAL,FS_BOLD,16);
        $grafico->title->SetMargin(25);
        // definir valores ao gráfico
        $p1 = new PiePlot3D($total);
        // destacar o valor correspondente ao elemento (1), sendo que o primeiro elemento do array corresponde a (0)
        $p1->ExplodeSlice(1);
        // centralizar a 45% da largura
        $p1->SetCenter(0.45);
        // definir legendas
        $p1->SetLegends($tipo);
        $p1->SetColor(array(255,255,255));
        $p1->value->SetFont(FF_ARIAL,FS_NORMAL,10); //fonte
        //legenda embaixo do gráfico
        $grafico->legend->SetLayout(LEGEND_HOR);
        $grafico->legend->Pos(0.50,0.95,"center","bottom");
        // adicionar valores ao gráfico
        $grafico->Add($p1);
        // gerar o gráfico
        $grafico->Stroke();
        //salvando imagem em disco
        $img = "./img/imagem_" . $cod . ".png";
        $this->salvaImagem($img);
        $grafico->Stroke($img);
      }
      else {
        echo "Nenhum resultado encontrado para a pesquisa.";
      }
    } //graficoOfensoresResponsavel()

    function graficoCausasOfensores($pieGra1,$pieGra2,$dtIni,$dtFin,$cod){
      //selecionando dados
      $bd = new conexao("localhost","root","","aprovisionamento");
      $sql = "SELECT COUNT(o.codigo) AS Total,o.motivo_vencimento FROM os_encerrada o ";
      $sql = $sql . "WHERE o.motivo_vencimento IS NOT NULL AND o.motivo_vencimento <> '' ";
      if(($dtIni!=0)and($dtFin!=0)){
        $dt1 = $this->formataData($dtIni);
        $dt2 = $this->formataData($dtFin);
        $sql = $sql . "AND CAST(o.diaEncerramento AS DATE) BETWEEN '" . $dt1 . "' AND '" . $dt2 . "'";
      }
      $sql = $sql . "GROUP BY o.motivo_vencimento";
      $dados = $bd->selecionaDados($sql);
      $tot = count($dados);
      if($tot!=0){
        $total = array();
        $motivo = array();
        $legenda = array();
        $i = 0;
        foreach($dados as $percorre){
          $total[$i] = $percorre->Total; // definir um array com os valores de cada fatia
          $motivo[$i] = $percorre->motivo_vencimento; // definir um array que será usado como legenda
          $legenda[$i] = substr($percorre->motivo_vencimento,0,30); //copia 15 caracteres para legenda
          $i++;
        }
        // criar novo gráfico de 350x200 pixels com tipo de imagem automático
        $grafico = new PieGraph($pieGra1,$pieGra2,"auto");
        $grafico->SetColor("#C0FFFF");
        // adicionar sombra
        $grafico->SetShadow();
        // título do gráfico
        $grafico->title->Set("Causas dos Ofensores");
        $grafico->title->SetFont(FF_ARIAL,FS_BOLD,16);
        $grafico->title->SetMargin(25);
        // definir valores ao gráfico
        $p1 = new PiePlot3D($total);
        // destacar o valor correspondente ao elemento (1), sendo que o primeiro elemento do array corresponde a (0)
        $p1->ExplodeSlice(1);
        // centralizar a 45% da largura
        $p1->SetCenter(0.45);
        // definir legendas
        //$p1->SetLegends($motivo);
        $p1->SetLegends($legenda);
        $p1->SetColor(array(255,255,255));
        $p1->value->SetFont(FF_ARIAL,FS_NORMAL,10); //fonte
        //legenda embaixo do gráfico
        $grafico->legend->SetLayout(LEGEND_HOR);
        $grafico->legend->SetFont(FF_ARIAL,FS_NORMAL,5); //fonte
        $grafico->legend->Pos(0.50,0.95,"center","bottom");
        // adicionar valores ao gráfico
        $grafico->Add($p1);
        // gerar o gráfico
        $grafico->Stroke();
        //salvando imagem em disco
        $img = "./img/imagem_" . $cod . ".png";
        $this->salvaImagem($img);
        $grafico->Stroke($img);
      }
      else {
        echo "Nenhum resultado encontrado para a pesquisa.";
      }
    } //graficoCausasOfensores()

    function graficoAcompanhamentoMetaPrisma($pieGra1,$pieGra2,$dtIni,$dtFin,$cod,$gerencia){
      //selecionando dados
      $prisma = $this->pegaProjetado();
      $bd = new conexao("localhost","root","","aprovisionamento");
      $sql = "SELECT dia,NoPrazo,Vencido,100*(Noprazo/(noPrazo+Vencido)) AS Perc FROM( ";
      $sql = $sql . "SELECT diaEncerramento AS dia,SUM(IF(aprovNoPrazo='NoPrazo',1,0)) AS NoPrazo, ";
      $sql = $sql . "SUM(IF(aprovNoPrazo='Vencidas',1,0)) AS Vencido FROM os_encerrada ";
      $sql = $sql . "WHERE (computar = 'Sim' OR computar='sim') ";
      if($gerencia!="Todos"){
        $sql = $sql . "AND gerencia='" . $gerencia . "' ";
      }
      //else{
      //  $sql = $sql . "AND (gerencia='CD' OR gerencia='TX' OR gerencia='VOZ_AV') ";
      //}
      if(($dtIni!=0)and($dtFin!=0)){
        $dt1 = $this->formataData($dtIni);
        $dt2 = $this->formataData($dtFin);
        $sql = $sql . "AND diaEncerramento BETWEEN '" . $dt1 . "' AND '" . $dt2 . "'";
      }
      $sql = $sql . "GROUP BY (diaEncerramento)) AS a";
      $dados = $bd->selecionaDados($sql);
      $tot = count($dados);
      if($tot!=0){
        $dia = array();
        $noPrazo = array();
        $vencidas = array();
        $perc = array();
        $metaPrisma = array();
        $cores = array();
        $i = 0;
        $totOS = 0;
        $totNoPrazo = 0;
        foreach($dados as $percorre){
          $dia[$i] = $this->formataData_MesAno($percorre->dia);
          $noPrazo[$i] = $percorre->NoPrazo;
          $vencidas[$i] = $percorre->Vencido;
          if($percorre->Perc <> 0){$perc[$i] = $percorre->Perc;}else {$perc[$i] = 0;}
          $totOS = $totOS + $percorre->NoPrazo + $percorre->Vencido;
          $totNoPrazo = $totNoPrazo + $percorre->NoPrazo;
          $metaPrisma[$i] = $prisma;
          $cores[$i] = "#74C9FC";
          $i++;
        }
        //valor de realizado
        $totRealizado = (100/$totOS) * $totNoPrazo;
        $dia[$i] = "Realizado";
        $perc[$i] = $totRealizado;
        $metaPrisma[$i] = $prisma;
        $cores[$i] = "#8F77F2";
        $i++;
        //valor de projetado
        $dia[$i] = "Projetado";
        $perc[$i] = $this->pegaProjetado();
        $metaPrisma[$i] = $prisma;
        $cores[$i] = "#2180DE";

        //cria gráfico
        $grafico = new Graph($pieGra1,$pieGra2); //,'auto');
        $grafico->SetColor("#C0FFFF");
        $grafico->SetScale("textlin");
        $grafico->img->SetMargin(40,130,20,40);
        //$grafico->SetShadow(); //seta sombra
        //cria a linha - meta prisma
        $l1plot=new LinePlot($metaPrisma);
        $l1plot->SetColor("#004000");
        $l1plot->SetWeight(2);
        $l1plot->SetLegend("Meta Prisma - " . $prisma . "%");
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
        $grafico->Add($l1plot);
        //legendas
        if($gerencia=="VOZ_AV"){
          $grafico->title->Set("VOZ AVANÇADA");
        }
        if($gerencia=="CD"){
          $grafico->title->Set("CD");
        }
        if($gerencia=="TX"){
          $grafico->title->Set("TX");
        }
        if($gerencia=="Todos"){
          $grafico->title->Set("EFICIÊNCIA");
        }
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
        $grafico->xaxis->SetTickLabels($dia); //legenda do eixo X
        $grafico->xaxis->SetLabelAngle(90); //inclinação da legenda do eixo X
        //$grafico->xaxis->SetTitleMargin(50);//posição referente a margem da legenda do eixo X (Dias)
        //$grafico->xaxis->SetTextTickInterval(2); //intervalo da legenda do eixo X
        $grafico->img->SetMargin(50,65,50,85); //setando margens do gráfico

        //exibir gráfico
        $grafico->Stroke();
        //salvando imagem em disco
        $img = "./img/imagem_" . $cod . ".png";
        $this->salvaImagem($img);
        $grafico->Stroke($img);
      }
      else {
        echo "Nenhum resultado encontrado para a pesquisa.";
      }
    } //graficoAcompanhamentoMetaPrisma()
    
 //   function graficoAcompanhamentoMetaPrismaTX($pieGra1,$pieGra2,$dtIni,$dtFin,$cod){
//   }
  }//class
?>
