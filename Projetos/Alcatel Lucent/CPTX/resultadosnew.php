<html>
<?php
if(isset($_GET['filial'])) {

echo "<form name='hid3' id='hid3' method='POST'>";
echo "<input type='hidden' name='tr' id='tr'>";
	if(isset($_GET['dia'])) {
	echo "<input type='hidden' name='dia' id='dia' value='$_GET[dia]'>";
	}
	else {
	echo "<input type='hidden' name='dia' id='dia' value='" . null . "'>";
	}
echo "<input type='hidden' name='mes' id='mes' value='$_GET[mes]'>";
echo "<input type='hidden' name='ano' id='ano' value='$_GET[ano]'>";
echo "<input type='hidden' name='filial' id='filial' value='$_GET[filial]'>";
echo "</form>";

}

else {

echo "<form name='hid3' id='hid3' method='POST'>";
echo "<input type='hidden' name='tr' id='tr'>";
echo "<input type='hidden' name='dia' id='dia' value='$_GET[dia]'>";
echo "<input type='hidden' name='mes' id='mes' value='$_GET[mes]'>";
echo "<input type='hidden' name='ano' id='ano' value='$_GET[ano]'>";
echo "</form>";

}
?>



<script>
document.hid3.action = "resultados.php";
document.hid3.tr.value = window.opener.document.hid2.tr.value;
document.hid3.submit();
</script>


</html>
