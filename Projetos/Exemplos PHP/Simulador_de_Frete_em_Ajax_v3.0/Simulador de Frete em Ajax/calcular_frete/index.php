<?php

//Adaptado por: Anderson Lima 2007
//DIGIART - Design e Sistemas
//http://www.digiartstudio.net
// Adaptado por Ariel gonçalves 2009 para o sistema oscommerce 2.2-MS2
// v3.0 - Atualizado para o novo webservice dos Correios em 20/08/2010 by Patty - www.cybernetfx.com
// Fórum de Suporte: www.forumdowebmaster.com.br

//$peso = $_GET["peso"];
//$valor = $_GET["valor"];
//$nome_produto = $_GET["nome_produto"];
//$cep_origem = "CEP DA LOJA"; // Digite o CEP de sua loja no formato 00000-000
//$nome_loja = $_GET["nome_loja"];

$peso = 300;
$valor = 0;
$nome_produto = "camiseta";
$cep_origem = "89665000";
$nome_loja = "midwest";

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Cálculo do Frete:: <?php echo $nome_loja ?></title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #014282}
.style3 {color: #0000FF; font-size:10px}
-->
</style>
</head>
<link rel='stylesheet' href='css/estilos.css' type='text/css'>
<!-- Favor mantenha os créditos, script frete em ajax feito por Ariel gonçalves 2010 para o sistema oscommerce 2.2-MS2 -->
<script language="javascript" src="js/ajax.js"></script>
<body>
<table width="350" border="0" cellpadding="0" cellspacing="0" class="textos">
  <tr>
    <td height="60" colspan="2" valign="top" bgcolor="#FFFFFF" align="center"><img src="imagens/correios.jpg" width="200" height="50"></td>
  </tr>
  <tr>
    <td height="20" colspan="2" valign="middle" bgcolor="#FFFFFF" class="textosb" align="left"><div class="style2">Calcular Frete de: <?php echo $nome_produto ?></div></td>
  </tr>
  <tr>
   <td width="199" valign="top" bgcolor="#FFCC00">CEP Origem: <?php echo $cep_origem; ?><br>
      <input name="cepOrigem"  type="hidden" value="<?php echo $cep_origem ?>" id="cepOrigem" onKeyPress="return campo_numerico(event)" onKeyUp="mascara(this.value, this.id, '#####-###', event)"   size="9" maxlength="9"></td>
    <td width="151" valign="top" bgcolor="#FFCC00">CEP Destino:<br>
      <input name="cepDestino" type="text" class="input" id="cepDestino"  onKeyPress="return campo_numerico(event)" onKeyUp="mascara(this.value, this.id, '#####-###', event)" size="9" maxlength="9"></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFCC00">Peso do produto(GR): <?php echo $peso; ?><br>
      <input name="peso" type="hidden" value="<?php echo $peso; ?>" class="input" id="peso" onKeyPress="return campo_numerico(event)"  >
      <br>
      Valor declarado: <?php echo $valor; ?><br>
      <input name="valor" type="hidden" value="<?php echo $valor; ?>" class="input" id="valor" onKeyPress="return campo_numerico(event)"  ></td>
    <td valign="top" bgcolor="#FFCC00">Serviço:<br>
      <select name="servico" id="servico" >
        <option value="">>>Selecione<<</option>
        <option value="41106">PAC</option>
        <option value="40010">SEDEX</option>
        <option value="40215">SEDEX 10</option>
        <option value="40045">SEDEX a Cobrar</option>
        <option value="40290">SEDEX HOJE</option>
      </select>
    <br>
    <input type="submit" name="acao" id="acao" value="Calcular" onClick="Checacep(servico.value,cepOrigem.value,cepDestino.value,peso.value,valor.value);" onKeyDown="Checacep(servico.value,cepOrigem.value,cepDestino.value,peso.value,valor.value);"></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#000066" class="style1"><div align="right" class="style1">Valor do frete: <strong>R$
        <input name="resultado" type="text" class="input" id="resultado" size="35" readonly="true">
    </strong></div></td>
  </tr>
</table>
</body>
</html>
