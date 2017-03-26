<?php

session_start('cptx');

require_once ('../jpgraph/jpgraph.php');
require_once ('../jpgraph/jpgraph_line.php');

mysql_connect("localhost","root","");
mysql_select_db("cptx");

$query = mysql_query("SELECT* FROM `cadastro` where `tr` = '$_SESSION[log_tx]'");
while($row = mysql_fetch_array($query)) {

$nome = $row['nome'];
}


$ano = date('Y');
if(isset($_GET['mes'])) {
$mes = $_GET['mes'];
}
else {
$mes = date('m');
}
//pegar eixo x
for($x = 0; $x < cal_days_in_month(CAL_GREGORIAN, $mes, $ano)+1; $x++) {
$dia[$x] = $x+1;
	if(strlen($dia[$x]) == 1) {
	$dia[$x] = "0" . $dia[$x];
	}

	$dia2[$x] = date("Y-m-d", mktime(0, 0, 0, $mes, $x, $ano));

}


// Setup the graph
$graph = new Graph(1000,500);
$graph->SetMarginColor('white');
$graph->img->SetAntiAliasing();
$graph->SetScale("textlin");
$graph->SetFrame(false);
$graph->SetMargin(50,50,30,70);
$graph->SetMarginColor('white');
$graph->title->SetFont(FF_ARIAL,FS_BOLD,13);
$graph->title->Set('Gráfico de Acompanhamento - ' . $nome);


$graph->ygrid->SetFill(true,'white@0.9','green@0.9');
// Add 10% grace to top and bottom of plot
$graph->yscale->SetGrace(10,0);
$graph->xaxis->HideZeroLabel();
$graph->xaxis->SetTickLabels($dia);
$graph->xaxis->SetFont(FF_ARIAL);


$cores = array('black','blue','orange','green','yellow','purple','#ffffff','#028456','#028456','#028456');

// Create the first lin
$out[0] = 0;
for($x=1;$x<cal_days_in_month(CAL_GREGORIAN, $mes, $ano)+1;$x++) {
	if(strlen($x) == 1) {
	$dia = "0" . $x;
	}
	else {
	$dia = $x;
	}
	$query2 = mysql_query("SELECT COUNT(`circuito`) FROM `tabelacptx` WHERE `data_e` = '$ano-$mes-$dia' and `tr` = '$_SESSION[log_tx]'");

		while ($row = mysql_fetch_array($query2)) {
			if ((date('w', mktime(0,0,0,$mes,$dia,$ano)) == 0 or date('w', mktime(0,0,0,$mes,$dia,$ano)) == 6) && $row['COUNT(`circuito`)'] == 0) {
			$out[$x-1] = "-";
			}
			else {
				if($row['COUNT(`circuito`)'] == 0 && $dia > date('d')) {
				$out[$x-1] = "";
				}
				else {
				$out[$x-1] = $row['COUNT(`circuito`)'];
				}
			}
		}

}
$p1 = new LinePlot($out);
$p1->SetWeight(2);
$p1->SetLegend("Circuitos");
$p1->SetColor('black');
$graph->Add($p1);

//meta
for($x=0;$x<cal_days_in_month(CAL_GREGORIAN, $mes, $ano);$x++) {
$out[$x] = 350/22;
}

$p1 = new LinePlot($out);
$p1->SetWeight(3);
$p1->SetColor('red');
$graph->Add($p1);




$graph->legend->SetShadow('gray@0.4',5);
$graph->legend->SetPos(0,0,'right','top');
// Output line
$graph->Stroke();

?>

