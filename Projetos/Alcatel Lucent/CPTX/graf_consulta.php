<?php // content="text/plain; charset=utf-8"

session_start('cptx');

require_once ('../jpgraph/jpgraph.php');
require_once ('../jpgraph/jpgraph_line.php');



mysql_connect("localhost","root","");
mysql_select_db("cptx");


//pegar eixo x
for($x = 0; $x < 5; $x++) {
$dia[$x] = date("d") - $x;
	if(strlen($dia[$x]) == 1) {
	$dia[$x] = "0".$dia[$x];
	}
	$dia[$x] = date("d/m", mktime(0, 0, 0, date("m"), date("d")-$x, date("Y")));
	$dia2[$x] = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-$x, date("Y")));

}
$dia = array_reverse($dia);


//pegar eixo y

for($x = 0; $x < 5; $x++) {
$res[$x] = mysql_query("SELECT COUNT(`circuito`) FROM `tabelacptx` WHERE `data_e` = '$dia2[$x]' and `tr` = '$_SESSION[log_tx]'");

if(!$res[$x]) {
echo mysql_error();
}

	while ($row = mysql_fetch_array($res[$x])) {
	$out[$x] = $row['COUNT(`circuito`)'];
	}
}

$out = array_reverse($out);

$datay1 = array(20,15,23,15,03);

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

$graph->xaxis->SetTickLabels($dia);
$graph->xaxis->SetFont(FF_ARIAL);

// Create the first line
$p1 = new LinePlot($out);
$p1->SetWeight(2);
$p1->SetCenter();
$p1->SetColor("black");
$p1->SetLegend('Circuitos');
$graph->Add($p1);

/*meta
for($x=0;$x<5;$x++) {
$out[$x] = 350/22;
}

$p1 = new LinePlot($out);
$p1->SetWeight(3);
$p1->SetColor('red');
$p1->SetLegend('Meta');
$graph->Add($p1);
*/


$graph->legend->SetShadow('gray@0.4',5);
$graph->legend->SetPos(0.35,0.80,'right','top');
// Output line
$graph->Stroke();

?>

