<?php
  $timestamp = time();
  echo $timestamp;
  echo "<br>";
  
  echo date('d/m/Y - h:i:s');
  echo "<br>";
  echo "<br>";
  echo "<br>";
  


/* data inicial */
$data1 = "08/11/2011 23:00:44";

/* data final */
//$data2 = "27/04/2011 22:15:33";
$data2 = date('d/m/Y H:i:s');
echo DiferencaEntreDatas($data1,$data2,"m");
?>



