<?php

//Adaptado por: Anderson Lima 2007
//DIGIART - Design e Sistemas
//http://www.digiartstudio.net
// Adaptado por Ariel gon�alves 2009 para o sistema oscommerce 2.2-MS2
// v3.0 - Atualizado para o novo webservice dos Correios em 20/08/2010 by Patty - www.cybernetfx.com
// F�rum de Suporte: www.forumdowebmaster.com.br

header('Content-Type: text/html; charset=ISO-8859-1');
setlocale(LC_CTYPE,"pt_BR"); 

// Data no passado
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// Sempre modificado
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");


$cepOrigem = $_GET["origem"]; // Recebe o cep Origem da loja

/* Abaixo recebe o cep de Destino do cliente e faz uma valida��o para verificar se ele digitou e se tiver digitado verifica se tem 8 caracteres */
$cepDestino = $_GET["destino"];
if($cepDestino == "") {
echo "Preencha o CEP de Destino!";
exit;
}
elseif($cepDestino == ""  || strlen($cepDestino) < 9) {
echo "CEP deve conter 8 n�meros!";
exit;

}

/* Abaixo recebe o tipo de servi�� escolhido pelo cliente PAC, SEDEX e outros e faz uma valida��o para verificar se realmente o cliente escolheu algum servi�o  */
$srv = $_GET["servico"];

if($srv == "") {
echo "Favor selecione o tipo de servi�o!";
exit;
}


// alterei aqui o peso
$peso = $_GET["peso"];
if($peso == "") {
echo "Selecione a Qtd que deseja do produto!";
exit;
}


/* Aredonda o peso, se der menos que 300 arredonda para 500, foi feito isso pois havia diverg�ncias do frete calculado por esse m�dulo e o frete calculado ao finalizar o pedido */
$peso = $peso;
if($peso <= "300") {
$peso = "500";
}


$peso = $peso/1000;  // se o peso da sua loja for em kg comente essa linha
$valor = $_GET["valor"];

//Checa se � SEDEX a cobrar

if($srv == '40045') {
// esta � a URL dos correios
$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cepOrigem."&sCepDestino=".$cepDestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=25&nVlAltura=5&nVlLargura=15&sCdMaoPropria=n&nVlValorDeclarado=1&sCdAvisoRecebimento=n&nCdServico=".$srv."&nVlDiametro=20&StrRetorno=xml";

} else {

// esta � a URL dos correios
$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cepOrigem."&sCepDestino=".$cepDestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=25&nVlAltura=5&nVlLargura=15&sCdMaoPropria=n&nVlValorDeclarado=1&sCdAvisoRecebimento=n&nCdServico=".$srv."&nVlDiametro=20&StrRetorno=xml";

}

// captura as linhas da URL retornada
$fonte = file($url);
// varro as linhas e procuro o valor do frete, no caso est� na linha 660
// caso n�o retorne descomene a linha dentro do foreach e veja qual a linha que retorna o valor


foreach ($fonte as $www) {
	
	$bsc = "/\<Valor>(.*)\<\/Valor>/";
	$bsc2 = "/\<MsgErro>(.*)\<\/MsgErro>/";
	if(preg_match($bsc,$www,$retorno)){
		
		//$preco = number_format($retorno[1],2,',','.');

		$preco = str_replace(',','.',$retorno[0]);
		$preco = strip_tags($preco);	
		
	}

	if(preg_match($bsc2,$www,$retorno)){
		
		$descricao = $retorno[1];


		
	}


}


// Se os correios estiver fora do ar aparece uma mensagem

if($preco == '') {
echo "Erro, correios n�o respondeu!";
}


if(empty($descricao)) { echo $preco; } else { echo $descricao; }
?>
