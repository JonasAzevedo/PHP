<?php include("funcoes.php"); ?>
<html>
<head>
<script>
function fechar() {
window.close();
}
</script>

<style type="text/css">
#flutuante {
position: absolute;
right: 0px;
top: 0px;
width: 200px;
height: 155px;
padding-left: 10px;
border: 2px solid #cccccc;
background-color: #e0e0e0;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	cursor: pointer;
}
</style>
</head>
<body>

<center>
<?php
echo "<img src='graf_ind_prot.php?";
if(isset($_GET['mes'])) {
echo "mes=$_GET[mes]";
}
if(isset($_GET['ano'])){
echo "&ano=$_GET[ano]";
}
echo "'>";
?>
</center>
<center>
<input type='button' value='fechar' onclick='fechar()'>
</center>
</body>
</html>
