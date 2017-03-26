<?php include("../funcoes.php");

$con = conectar();

$query = "SELECT* FROM `tabelacptx`";

mysql_query($query,$con);

while ($row = mysql_fetch_array($query)) {


$number = $row['n'];



$ccto[$n] = $row['circuito'];
}

$query = "SELECT* FROM `comentarios`";

mysql_query($query,$con);

while ($row = mysql_fetch_array($query)) {
$x = $row['n_circ'];
mysql_query("UPDATE `comentarios` set `n_circ` = '$ccto[$x]' where 'n_circ' = `$row[n_circ]`",$con);
}

mysql_close();


?>
