<?php
  require("sessao.php");

  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");
  
  function formataData($dataFormatar){
    $dataExp = explode("-", $dataFormatar);
    $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
    return $data;
  }

  if($_GET['codigo']!=""){
     $sql = "SELECT * FROM os_encerrada o WHERE o.id_da_ordem='" . $_GET['codigo'] . "'";
     $dadosPesquisa = $bd->selecionaDados($sql);
     $total = count($dadosPesquisa);
     if($total!=0){
       echo "<center>";
       echo "<p><b>";
         echo "Nº OS: " . "</b>" . $dadosPesquisa[0]->numero_da_os_crm;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "ID da Ordem: " . "</b>" . $dadosPesquisa[0]->id_da_ordem;
       echo "</p>";
       echo "<p><b>";
         echo "Nome do Cliente: " . "</b>" . $dadosPesquisa[0]->nome_do_cliente;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Nome do Consultor: " . "</b>" . $dadosPesquisa[0]->nome_do_consultor;
       echo "</p>";
       echo "<p><b>";
         echo "Nº Terminal: " . "</b>" . $dadosPesquisa[0]->numero_do_terminal;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Produto: " . "</b>" . $dadosPesquisa[0]->produto;
       echo "</p>";
       echo "<p><b>";
         echo "Modalidade: " . "</b>" . $dadosPesquisa[0]->modalidade;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Tipo da OS: " . "</b>" . $dadosPesquisa[0]->tipo_da_os;
       echo "</p>";
       echo "<p><b>";
         echo "Tipo: " . "</b>" . $dadosPesquisa[0]->tipo;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Estado: " . "</b>" . $dadosPesquisa[0]->estado;
       echo "</p>";
       echo "<p><b>";
         echo "Status do Processo: " . "</b>" . $dadosPesquisa[0]->status_do_processo;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Multifilial: " . "</b>" . $dadosPesquisa[0]->multifilial;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Velocidade do Circuito: " . "</b>" . $dadosPesquisa[0]->velocidade_do_circuito;
       echo "</p>";
       echo "<p><b>";
         echo "Data Solicitação: " . "</b>" . $dadosPesquisa[0]->data_da_solicitacao;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Data Criação da Ordem: " . "</b>" . $dadosPesquisa[0]->data_de_criacao_da_ordem;
       echo "</p>";
       echo "<p><b>";
         echo "Data Promessa: " . "</b>" . $dadosPesquisa[0]->data_promessa;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Data Aprazamento: " . "</b>" . $dadosPesquisa[0]->data_aprazamento;
       echo "</p>";
       echo "<p><b>";
         echo "Data Esperada Finalização: " . "</b>" . $dadosPesquisa[0]->data_esperada_para_finalizacao_da_ordem;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Data Fechamento OS: " . "</b>" . $dadosPesquisa[0]->data_de_fechamento_da_os;
       echo "</p>";
       echo "<p><b>";
         echo "Aprovisionada no Prazo: " . "</b>" . $dadosPesquisa[0]->aprovNoPrazo;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Gerência: " . "</b>" . $dadosPesquisa[0]->gerencia;
         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         echo "<b>";
         echo "Dia Encerramento: " . "</b>" . formataData($dadosPesquisa[0]->diaEncerramento);
       echo "</p>";
       echo "</center>";
     }
     else{
       echo "<center>";
       echo "Nenhuma OS encontrada com o ID " . $_GET['codigo'];
       echo "</center>";
     }
  }
  else{
    echo "<center>";
    echo "Informe um valor válido para a OS";
    echo "</center>";
  }
?>
