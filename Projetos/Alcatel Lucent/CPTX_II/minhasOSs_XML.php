<!-- tela para apresentar minhas OSs
       autor: Jonas da Silva Azevedo
       criado em: 09/03/2010 - 09:57
       última modificação:
-->

<?php
 session_start();

 require_once("sessao.php");
 require_once("conexao.php");
 $bd = new conexao("localhost","root","","os_sac");
 
 //recebe data
 $dataPesq = $_POST["data"];
 
 //query
 $sql = "SELECT * FROM os WHERE cod_usuario='" . $_SESSION["codigoUsuario"] . "' ";
 $sql = $sql . "AND CAST(data_executou AS DATE)='". $data . "'";

 //executa a query
 $pesqOS = $bd->selecionaDados($sql);
 $totalOS_dia = count($pesqOS);

 //verifica se voltou algo
 if($totalOS_dia) {
   //XML
   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<cidades>\n";

   //PERCORRE ARRAY
   for($i=0; $i<$row; $i++) {
      $codigo    = mysql_result($sql, $i, "id_cidade");
	  $descricao = mysql_result($sql, $i, "dsc_cidade");
      $xml .= "<cidade>\n";
      $xml .= "<codigo>".$codigo."</codigo>\n";
      $xml .= "<descricao>".$descricao."</descricao>\n";
      $xml .= "</cidade>\n";
   }//FECHA FOR

   $xml.= "</cidades>\n";

   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1");
}//FECHA IF (row)

//PRINTA O RESULTADO
echo $xml;
?>
