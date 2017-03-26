<?php

    $idade = $_POST['idade'];
    $nome = trim($_POST['nome']);

//    $resposta = array("nome" => $nome, "idade" => $idade);
//    $resposta = json_encode($resposta);

//  $resposta = "{'dados':[";
  $resposta .= "[{'nome':'Jonas','idade':'25'},";
  $resposta .= "{'nome':'Jonas2','idade':'252'}";
  $resposta .= "]";//}";
  $resposta = json_encode($resposta);
  echo $resposta;
?>
