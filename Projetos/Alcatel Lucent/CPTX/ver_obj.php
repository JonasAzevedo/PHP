<?php include("funcoes.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<?php

 $con = conectar();

$query = mysql_query("SELECT* FROM `objectel` WHERE `n_circ` = '$_GET[ccto]' and `filial` = '$_GET[filial]' and `status` = 0");
ver_mysql($query);

if(mysql_num_rows($query) > 0) {

while ($row = mysql_fetch_array($query)) {
echo "Este circuito se encontra possui um erro de Objectel:<br><br>\t$row[relatorio]";
echo "<br>";
}
echo "<script>\n";
echo "window.parent.lin_obj_frm.style.display = 'block';";
echo "</script>\n";
}
else {
echo "<script>\n";
echo "window.parent.lin_obj_frm.style.display = 'none';";
echo "</script>\n";
}

mysql_close($con);
?>
</body>

</html>
