<?php include("funcoes.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<?php

$con = conectar();

$query = mysql_query("SELECT* FROM `pendencias` WHERE `n_circ` = '$_GET[ccto]' and `filial` = '$_GET[filial]' and `status` = 0");
ver_mysql($query);

if(mysql_num_rows($query) > 0) {

while ($row = mysql_fetch_array($query)) {
echo "Este circuito se encontrava-se na pend&ecirc;ncia $row[pendencia]:<br><br>\t$row[relatorio]";
echo "<br>";
}
echo "<script>\n";
echo "window.parent.lin_pen_frm.style.display = 'block';";
echo "if(window.parent.pen_sim.checked == true) { ";
echo "window.parent.lin_pen_new.style.display = 'block';";
echo "}";
echo "else {";
echo "window.parent.lin_pen_new.style.display = 'none';";
echo "}";
echo "if(window.parent.pen_nao.checked == true) { ";
echo "window.parent.obj_pen.disabled = false;";
echo "window.parent.lin_obj_pen.style.display = 'block';";
echo "}";
echo "else {";
echo "window.parent.lin_obj_pen.style.display = 'none';";
echo "window.parent.obj_pen.disabled = true;";
echo "}";
echo "</script>\n";
}
else {
echo "<script>\n";
echo "window.parent.lin_pen_frm.style.display = 'none';";
echo "window.parent.lin_pen_new.style.display = 'none';";
echo "</script>\n";
}

mysql_close($con);
?>
</body>

</html>
