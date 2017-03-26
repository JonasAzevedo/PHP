<?php include("funcoes.php");

logout();

function pegarobjinc() {

$con = conectar();

$query = mysql_query("SELECT* FROM `objectel` WHERE status = '0'");

mysql_close($con);

return mysql_num_rows($query);

}

function pegarpen() {

$con = conectar();

$query = mysql_query("SELECT* FROM `pendencias` WHERE status = '0'");

mysql_close($con);

return mysql_num_rows($query);

}


?>
<html>
<title>CPTX - P&aacute;gina Inicial</title>

<style type="text/css">
<!--
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #333333;
}
a:active {
	text-decoration: none;
	color: #333333;
}
-->
.topo  {display: block;}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }



</style><head>



<!-- European format dd-mm-yyyy -->
<script language="JavaScript" src="calendar\calendar1.js"></script><!-- Date only with year scrolling -->
<!-- American format mm/dd/yyyy -->
<script language="JavaScript" src="calendar\calendar2.js"></script><!-- Date only with year scrolling -->

<script language='javascript'>
function sair(){
location.href='redirecionar.php?sair=1';
}

function enter(myfield, e) {

var keycode;
if(window.event) keycode = window.event.keyCode;
else if(e) keycode = e.which;
else return true;
if(keycode == 13) {
	myfield.form.submit();
	return false;
	}
else return true;
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') +  1).split('&');
 
    for(var i = 0; i < hashes.length; i++)
    {	
        hash = hashes[i].split('=');
		hash[1] = unescape(hash[1]);
		vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
 
    return vars;
}

var get1 = getUrlVars();

function submitor() {
var parar = false;	
	if(document.getElementById("login").value == null || document.getElementById("login").value == '') {
	alert("É necessário digitar um login!");
	parar = true;
	}
	if(document.getElementById("senha").value == null || document.getElementById("senha").value == '') {
	alert("É necessário digitar uma senha!");
	parar = true;
	}
	if(parar == false) {
	document.form_login.submit();
	}
}

function submitor() {
var parar = false;	
	if(document.getElementById("login").value == null || document.getElementById("login").value == '') {
	alert("É necessário digitar um login!");
	parar = true;
	}
	if(document.getElementById("senha").value == null || document.getElementById("senha").value == '') {
	alert("É necessário digitar uma senha!");
	parar = true;
	}
	if(parar == false) {
	document.form_login.submit();
	}
}

var win = null;
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,status=0,toolbar=0,location=0,menubar=0';
	win = window.open(pagina,nome,settings);
}

function red(mod) {
NovaJanela('vertab.php?mod='+mod,'Circuitos','950','450','yes');
}

</script>

<style type="text/css">
body{
overflow-y: hidden;
background-repeat: repeat-y;
background-color: #FFFFFF;
background-position: center;
background-image:url(bg.png);
margin-top: 0;
}

.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.rodape {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
#topo {
	background-color:#FFFFFF;
	top: 0px;

}

.style3 {
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	font-weight: bold;
}

table.total {
font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
}
table.total th {
font-size: 13px;
font-weight: bold;
}

.negrito {
cursor: pointer; 
color: black; 
font-weight:bold;
}

.azul {
cursor: pointer; 
color: blue;
font-weight:bold;
}

</style>
</head>
<body>

<form name="form_login" action="redirecionar.php?login=1" method="post"> 
<center>


<table border="0" cellpadding="0" cellspacing="0" width="848">
<!-- fwtable fwsrc="topo_edit_producao.png" fwbase="topo.png" fwstyle="Dreamweaver" fwdocid = "2142344543" fwnested="0" -->
  <tr>
   <td><img src="imagens\spacer.gif" width="11" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="51" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="15" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="85" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="19" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="61" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="18" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="62" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="18" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="55" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="15" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="49" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="245" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="65" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="6" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="65" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="8" height="1" border="0" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td colspan="17"><img name="topo_r1_c1" src="imagens\topo_r1_c1.png" width="848" height="52" border="0" id="topo_r1_c1" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="52" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="3"><img name="topo_r2_c1" src="imagens\topo_r2_c1.png" width="11" height="20" border="0" id="topo_r2_c1" alt="" /></td>
   <td><div align="center" class="style1"><a href="index.php">Início</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c3" src="imagens\topo_r2_c3.png" width="15" height="20" border="0" id="topo_r2_c3" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="ausencia.php">Aus&ecirc;ncias</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c5" src="imagens\topo_r2_c5.png" width="19" height="20" border="0" id="topo_r2_c5" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="registro.php">Registro</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c7" src="imagens\topo_r2_c7.png" width="18" height="20" border="0" id="topo_r2_c7" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="consulta.php">Consulta</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c9" src="imagens\topo_r2_c9.png" width="18" height="20" border="0" id="topo_r2_c9" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="admin.php">Gráficos</a></div></td>
   <td rowspan="3"><div align="center" class="style1"><img name="topo_r2_c11" src="imagens\topo_r2_c11.png" width="15" height="20" border="0" id="topo_r2_c11" alt="" /></div></td>
   <td><div align="center" class="style1"><a href="sobre.php">Sobre</a></div></td>
   <td rowspan="3"><img name="topo_r2_c13" src="imagens\topo_r2_c13.png" width="245" height="20" border="0" id="topo_r2_c13" alt="" /></td>
   <td rowspan="2"><a href='conf.php'><img name="topo_r2_c14" src="imagens\topo_r2_c14.png" width="65" height="17" border="0" id="topo_r2_c14" alt="" /></a></td>
   <td rowspan="3"><img name="topo_r2_c15" src="imagens\topo_r2_c15.png" width="6" height="20" border="0" id="topo_r2_c15" alt="" /></td>
   <td rowspan="2"><a href="redirecionar.php?sair=1"><img name="topo_r2_c16" src="imagens\topo_r2_c16.png" width="65" height="17" border="0" id="topo_r2_c16" alt="" /></a></td>
   <td rowspan="3"><img name="topo_r2_c17" src="imagens\topo_r2_c17.png" width="8" height="20" border="0" id="topo_r2_c17" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="15" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2"><img name="topo_r3_c2" src="imagens\topo_r3_c2.png" width="51" height="5" border="0" id="topo_r3_c2" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c4" src="imagens\topo_r3_c4.png" width="85" height="5" border="0" id="topo_r3_c4" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c6" src="imagens\topo_r3_c6.png" width="61" height="5" border="0" id="topo_r3_c6" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c8" src="imagens\topo_r3_c8.png" width="62" height="5" border="0" id="topo_r3_c8" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c10" src="imagens\topo_r3_c10.png" width="55" height="5" border="0" id="topo_r3_c10" alt="" /></td>
   <td rowspan="2"><img name="topo_r3_c12" src="imagens\topo_r3_c12.png" width="49" height="5" border="0" id="topo_r3_c12" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="2" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img name="topo_r4_c14" src="imagens\topo_r4_c14.png" width="65" height="3" border="0" id="topo_r4_c14" alt="" /></td>
   <td><img name="topo_r4_c16" src="imagens\topo_r4_c16.png" width="65" height="3" border="0" id="topo_r4_c16" alt="" /></td>
   <td><img src="imagens\spacer.gif" width="1" height="3" border="0" alt="" /></td>
  </tr>
</table>


</center>
<br><br><br>
<table class='total' width='392' align='center'>
<tr>
<th width="246" align='right'>Pendenciados:</th>
<td width="134" align='left' class='azul'><span onClick="red('pen');"><?php echo pegarpen(); ?></span></td>
</tr>
<tr>
<th align='right'>Objectel Incompleto:</th>
<td align='left' class='azul'><span onClick="red('obj');"><?php echo pegarobjinc(); ?></span></td>
</tr>
</table>
</body>
</html>
