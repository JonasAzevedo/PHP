<?php
  require("./jpgraph-3.0.7/src/jpgraph.php");
  require("./jpgraph-3.0.7/src/jpgraph_pie.php");
  require("./jpgraph-3.0.7/src/jpgraph_pie3d.php");
  require("./jpgraph-3.0.7/src/jpgraph_line.php");
  require("./jpgraph-3.0.7/src/jpgraph_bar.php");



$data1y=array(12,8,19,3,10,5);
$data2y=array(8,2,11,7,14,4);
$meta=array(8,8,8,8,8,8);

// Create the graph. These two calls are always required
$graph = new Graph(310,200);
$graph->SetScale("textlin");

$graph->SetShadow();
$graph->img->SetMargin(40,30,20,40);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b1plot->SetFillColor("orange");
$b2plot = new BarPlot($data2y);
$b2plot->SetFillColor("blue");

$lin=new LinePlot($meta);
        $lin->SetColor("#004000");
        $lin->SetWeight(2);
        $lin->SetLegend("Meta Prisma - " . $prisma . "%");

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));

// ...and add it to the graPH
$graph->Add($gbplot);
$graph->Add($lin);

$graph->title->Set("Example 21");
$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("Y-title");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke();


?>

