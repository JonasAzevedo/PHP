<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $nome = trim($_POST['nome']);
    if (trim($_POST['idade']) > 1)
    {
        $idade = $_POST['idade'] + 30;
        $nome = $nome . " Envelhecido(a)";
    }
    else
    {
        $idade = 0;
        $nome = $nome . " Bebê";
    }
    $resposta = array("nome" => $nome, "idade" => $idade);
    $resposta = json_encode($resposta);
    echo $resposta;
?>
