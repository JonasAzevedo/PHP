<?php
    session_start();
    require("sessao.php");
    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");

    include("menuPrincipal.html");
    
    //retorna último dia do mês
    function diasMes($mes,$ano){
      $d = mktime(0,0,0,$mes+1,0,$ano);
      return (date("d",$d));
    }
    
    $anoAtual = date("Y");
    $mesAtual = date("m");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <script language="JavaScript" src="./js/pgGraficos.js">
    </script>

    <link rel="stylesheet" href="./estilos/pgGraficos.css" type="text/css" />

    <title>Gráficos</title>
  </head>

  <body>
    <!-- Opções de Pesquisa -->
    <form name="frmPesquisa" id="frmPesquisa"  method="POST" action="<?php echo $PHP_SELF; ?>?acao=pesquisar">
      <div class="grupoOpc" id="grpCdAusencia">
        <p class="titulo">
          <span class="spnTitulo">Acompanhamento da Produção</span>
        </p>
        <div class="grupoPesquisa" id="grpPesquisa">
          <span class="descricao1">Opções de Pesquisa:</span>
          <span class="descricao2">Visualizar Por:</span>
          <select name="cbSelVisualizarPor" id="cbSelVisualizarPor">
            <option value="Filial" <?php if(isset($_POST['cbSelVisualizarPor'])){if($_POST['cbSelVisualizarPor']=="Filial"){echo "selected=\"selected\"";}} ?>>Filial</option>
            <option value="Colaborador" <?php if(isset($_POST['cbSelVisualizarPor'])){if($_POST['cbSelVisualizarPor']=="Colaborador"){echo "selected=\"selected\"";}} ?>>Colaborador</option>
          </select>
          <span class="descricao2">Ano:</span>
          <select name="cbSelAno" id="cbSelAno">
            <?php
              $sqlAno = "SELECT DISTINCT EXTRACT(YEAR FROM data_executou) AS ano FROM os";
              $resAno = $bd->selecionaDados($sqlAno);
              $totAno = count($resAno);
              if($totAno != 0){
                foreach($resAno as $mostraAno){
                  //apresentar dados se for ativada a pesquisa
                  if($_GET['acao']=="pesquisar"){
                    echo "<option value=\"" . $mostraAno->ano . "\" ";
                    if(isset($_POST['cbSelAno'])){
                      if($_POST['cbSelAno']==$mostraAno->ano){
                        echo "selected=\"selected\"";
                      }
                    }
                    echo "\">" . $mostraAno->ano . "</option>";
                  }
                  else{ //tela incial
                    echo "<option value=\"" . $mostraAno->ano . "\" ";
                    if($anoAtual==$mostraAno->ano){
                      echo "selected=\"selected\"";
                    }
                    echo "\">" . $mostraAno->ano . "</option>";
                  }
                } //foreach($resAno as $mostraAno)
              } //if($totAno != 0)
            ?>
          </select>
          <span class="descricao2">Mês:</span>
          <select name="cbSelMes" id="cbSelMes">
            <?php
              $sqlMes = "SELECT DISTINCT EXTRACT(MONTH FROM data_executou) AS mes FROM os";
              $resMes = $bd->selecionaDados($sqlMes);
              $totMes = count($resMes);
              if($totMes != 0){
                foreach($resMes as $mostraMes){
                  //apresentar dados se for ativada a pesquisa
                  if($_GET['acao']=="pesquisar"){
                    echo "<option value=\"" . $mostraMes->mes . "\" ";
                    if(isset($_POST['cbSelMes'])){
                      if($_POST['cbSelMes']==$mostraMes->mes){
                        echo "selected=\"selected\"";
                      }
                    }
                    echo "\">" . $mostraMes->mes . "</option>";
                  }
                  else{ //tela incial
                    echo "<option value=\"" . $mostraMes->mes . "\" ";
                    if($mesAtual==$mostraMes->mes){
                      echo "selected=\"selected\"";
                    }
                    echo "\">" . $mostraMes->mes . "</option>";
                  }
                } //foreach($resMes as $mostraMes)
              } //if($totMes != 0)
            ?>
          </select>
          <a href="#" name="lkPesquisar" id="lkPesquisar" class="lnkPesquisar" onClick="pessquisarOS();"><img class="imgBotaoOpc" alt="Pesquisar" src="./imagens/pesquisa.jpg"></a>
        </div>
      </form>
    </div>
    <!-- fim Opções de Pesquisa -->
    
    <!-- Dados para pesquisa -->
    <?php
      if($_GET['acao']=="pesquisar"){
        $tipoPesquisa = $_POST['cbSelVisualizarPor'];
        $mes = $_POST['cbSelMes'];
        $ano =  $_POST['cbSelAno'];
      }
      else{
        $tipoPesquisa = "Filial"; //padrão para pesquisa - tela inicial
        $mes = $mesAtual;
        $ano =  $anoAtual;
      }
    ?>

    <!-- Tabela para apresentação dos dados -->
      <!-- tabela 1 -->
      <table class="tblDados">
        <tr class="linha" onMouseOver="this.style.background='#00FF00'" onMouseOut="this.style.background='#FFFFFF'">
          <td class="cabecalhoNomeDia">Nome/Dia</td>
          <?php
            for($dia=1;$dia<=15;$dia++){
              echo "<td class='cabecalhoDia'>" . $dia . "</td>";
            }
          ?>
      </tr>
      <?php
        //zerando array que vai mostrar total de OS's por dia
        $totalDia = array();
        for($i=1;$i<=15;$i++){
          $totalDia[$i] = 0;
        }

        //montando SQL
        if($tipoPesquisa == "Filial"){ //pesquisar por filiais diferentes
          $sqlTiposPesquisa = "SELECT DISTINCT(filial) AS codigo,filial AS tipoPesquisa FROM os ORDER BY 2";
        }
        if($tipoPesquisa == "Colaborador"){ //pesquisar por colaboradores diferentes
          $sqlTiposPesquisa = "SELECT DISTINCT(codigo) AS codigo,nome AS tipoPesquisa FROM usuario ORDER BY 2";
        }
        $selTipoPesquisa = $bd->selecionaDados($sqlTiposPesquisa);
        $totTipoPesquisa = count($selTipoPesquisa);
        if($totTipoPesquisa != 0){
          foreach($selTipoPesquisa as $tipPesquisa){ //percorre todos os usuários
            //iniciando linha
            echo "<tr class='linha' onMouseOver='this.style.background=\"#00FF00\"' onMouseOut='this.style.background=\"#FFFFFF\"'>";
            $codPesq = $tipPesquisa->codigo;
            $descPesquisa = $tipPesquisa->tipoPesquisa;
            //coluna nome/dia
            if($tipoPesquisa == "Filial"){ //associar function JS para filial
              echo "<td class='nomeDiaLink' onClick='novaJanela(\"$codPesq\",\"\",\"0\",\"$mes\",\"$ano\");'>".$descPesquisa ."</td>"; //nome da filial
            }
            if($tipoPesquisa == "Colaborador"){ //associar function JS para colaborador
              echo "<td class='nomeDiaLink' onClick='novaJanela(\"\",\"$codPesq\",\"0\",\"$mes\",\"$ano\");'>".$descPesquisa ."</td>"; //nome do colaborador
            }
            //colunas dos 15 dias
            for($dia=1;$dia<=15;$dia++){ //percorre os primeiros 15 dias - 1ª metade do mês
              $data = $ano . "/" . $mes . "/" . $dia; //montando data para pegar total de OS's deste dia
              //montando SQL
              if($tipoPesquisa == "Filial"){ //pesquisar por filial
                $sqlTotOSs = "SELECT COUNT(codigo) AS total FROM os WHERE filial='" . $codPesq . "' ";
                $sqlTotOSs = $sqlTotOSs . "AND CAST(data_executou AS DATE)='" . $data . "'";
              }
              if($tipoPesquisa == "Colaborador"){ //pesquisar por colaboradores diferentes
                $sqlTotOSs = "SELECT COUNT(codigo) AS total FROM os WHERE cod_usuario='" . $codPesq . "' ";
                $sqlTotOSs = $sqlTotOSs . "AND CAST(data_executou AS DATE)='" . $data . "'";
              }
              //executando SQL
              $resTotalOSs = $bd->selecionaDados($sqlTotOSs);
              //apresentando  resultado do SQL
              if($resTotalOSs[0]->total != 0){ //apresenta link
                if($tipoPesquisa == "Filial"){ //pesquisar por filial
                  echo "<td class='diaDifZero' onClick='novaJanela(\"$codPesq\",\"\",\"$dia\",\"$mes\",\"$ano\");'>" . $resTotalOSs[0]->total . "</td>";
                }
                if($tipoPesquisa == "Colaborador"){ //pesquisar por colaborador
                  echo "<td class='diaDifZero' onClick='novaJanela(\"\",\"$codPesq\",\"$dia\",\"$mes\",\"$ano\");'>".$resTotalOSs[0]->total ."</td>";
                }
              }
              else{ //somente apresente o valor (0)
                echo "<td class='diaZero'>" . $resTotalOSs[0]->total . "</td>";
              }
              $totalDia[$dia] = $totalDia[$dia] + $resTotalOSs[0]->total; //somando total de OS's no dia no total da produção do dia
            } // for($dia=1;$dia<=15;$dia++)
            echo "</tr>";
          } //foreach($selTipoPesquisa as $tipPesquisa)
        } //if($totTipoPesquisa != 0)
        
        //mostrando total de OS's por dia - total da produção - última linha
        echo "<tr class='linha' onMouseOver='this.style.background=\"#00FF00\"' onMouseOut='this.style.background=\"#FFFFFF\"'>";
          echo "<td class='rodapeNomeDia'>Produção Geral</td>";
          for($dia=1;$dia<=15;$dia++){ //percorre os primeiros 15 dias - 1ª metade do mês
            if($totalDia[$dia] != 0){ //apresenta link
              if($tipoPesquisa == "Filial"){ //pesquisar por filial
                echo "<td class='rodapeDiaDifZero' onClick='novaJanela(\"Prod_Geral\",\"\",\"$dia\",\"$mes\",\"$ano\");'>" . $totalDia[$dia] . "</td>";
              }
              if($tipoPesquisa == "Colaborador"){ //pesquisar por colaborador
                  echo "<td class='rodapeDiaDifZero' onClick='novaJanela(\"\",\"Prod_Geral\",\"$dia\",\"$mes\",\"$ano\");'>" . $totalDia[$dia] . "</td>";
              }
            }
            else{ //somente apresente o valor (0)
              echo "<td class='rodapeDiaZero'>" . $totalDia[$dia] . "</td>";
            }
          } // for($dia=1;$dia<=15;$dia++)
        echo "</tr>";
      ?>
      </table>
      <!-- fim tabela 1 -->
      
      <!-- tabela 2 -->
      <?php
        $totDias = diasMes($mes,$ano);
      ?>
      <table class="tblDados">
        <tr class="linha" onMouseOver="this.style.background='#00FF00'" onMouseOut="this.style.background='#FFFFFF'">
          <td class="cabecalhoNomeDia">Nome/Dia</td>
          <?php
            for($dia=16;$dia<=$totDias;$dia++){
              echo "<td class='cabecalhoDia'>" . $dia . "</td>";
            }
          ?>
          <td class="cabecalhoDia">Total</td> <!-- &Sigma; -->
        </tr>
      <?php
        //zerando array que vai mostrar total de OS's por dia
        $totalDia = array();
        for($i=16;$i<=$totDias;$i++){
          $totalDia[$i] = 0;
        }
        
        $totGeral = 0;
        //montando SQL
        if($tipoPesquisa == "Filial"){ //pesquisar por filiais diferentes
          $sqlTiposPesquisa = "SELECT DISTINCT(filial) AS codigo,filial AS tipoPesquisa FROM os ORDER BY 2";
        }
        if($tipoPesquisa == "Colaborador"){ //pesquisar por colaboradores diferentes
          $sqlTiposPesquisa = "SELECT DISTINCT(codigo) AS codigo,nome AS tipoPesquisa FROM usuario ORDER BY 2";
        }
        $selTipoPesquisa = $bd->selecionaDados($sqlTiposPesquisa);
        $totTipoPesquisa = count($selTipoPesquisa);
        if($totTipoPesquisa != 0){
          foreach($selTipoPesquisa as $tipPesquisa){ //percorre todos os usuários
            //iniciando linha
            echo "<tr class='linha' onMouseOver='this.style.background=\"#00FF00\"' onMouseOut='this.style.background=\"#FFFFFF\"'>";
            $codPesq = $tipPesquisa->codigo;
            $descPesquisa = $tipPesquisa->tipoPesquisa;
            //coluna nome/dia
            if($tipoPesquisa == "Filial"){ //associar function JS para filial
              echo "<td class='nomeDiaLink' onClick='novaJanela(\"$codPesq\",\"\",\"0\",\"$mes\",\"$ano\");'>".$descPesquisa ."</td>"; //nome da filial
            }
            if($tipoPesquisa == "Colaborador"){ //associar function JS para colaborador
              echo "<td class='nomeDiaLink' onClick='novaJanela(\"\",\"$codPesq\",\"0\",\"$mes\",\"$ano\");'>".$descPesquisa ."</td>"; //nome do colaborador
            }
            //colunas da 2ª metade dos dias do mês
            for($dia=16;$dia<=$totDias;$dia++){ //percorre a 2ª metade dos dias do mês
              $data = $ano . "/" . $mes . "/" . $dia; //montando data para pegar total de OS's deste dia
              //montando SQL
              if($tipoPesquisa == "Filial"){ //pesquisar por filial
                $sqlTotOSs = "SELECT COUNT(codigo) AS total FROM os WHERE filial='" . $codPesq . "' ";
                $sqlTotOSs = $sqlTotOSs . "AND CAST(data_executou AS DATE)='" . $data . "'";
              }
              if($tipoPesquisa == "Colaborador"){ //pesquisar por colaboradores diferentes
                $sqlTotOSs = "SELECT COUNT(codigo) AS total FROM os WHERE cod_usuario='" . $codPesq . "' ";
                $sqlTotOSs = $sqlTotOSs . "AND CAST(data_executou AS DATE)='" . $data . "'";
              }
              //executando SQL
              $resTotalOSs = $bd->selecionaDados($sqlTotOSs);
              //apresentando  resultado do SQL
              if($resTotalOSs[0]->total != 0){ //apresenta link
                if($tipoPesquisa == "Filial"){ //pesquisar por filial
                  echo "<td class='diaDifZero' onClick='novaJanela(\"$codPesq\",\"\",\"$dia\",\"$mes\",\"$ano\");'>" . $resTotalOSs[0]->total . "</td>";
                }
                if($tipoPesquisa == "Colaborador"){ //pesquisar por colaborador
                  echo "<td class='diaDifZero' onClick='novaJanela(\"\",\"$codPesq\",\"0\",\"$mes\",\"$ano\");'>".$resTotalOSs[0]->total ."</td>";
                }
              }
              else{ //somente apresente o valor (0)
                echo "<td class='diaZero'>" . $resTotalOSs[0]->total . "</td>";
              }
              $totalDia[$dia] = $totalDia[$dia] + $resTotalOSs[0]->total; //somando total de OS's no dia no total da produção do dia
            } // for($dia=16;$dia<=$totDias;$dia++)
            
            //coluna total de OS's no mês do colaborador
            $dataIni = $ano . "/" . $mes . "/01";
            $dataFin = $ano . "/" . $mes . "/31";
            if($tipoPesquisa == "Filial"){ //pesquisar por filial
              $sqlOSsMes = "SELECT COUNT(codigo) AS total FROM os WHERE filial='" . $codPesq  . "' ";
              $sqlOSsMes = $sqlOSsMes . "AND CAST(data_executou AS DATE) BETWEEN '" . $dataIni . "' AND '" . $dataFin . "'";
            }
            if($tipoPesquisa == "Colaborador"){ //pesquisar por colaborador
              $sqlOSsMes = "SELECT COUNT(codigo) AS total FROM os WHERE cod_usuario='" . $codPesq  . "' ";
              $sqlOSsMes = $sqlOSsMes . "AND CAST(data_executou AS DATE) BETWEEN '" . $dataIni . "' AND '" . $dataFin . "'";
            }
            $resOSsMes = $bd->selecionaDados($sqlOSsMes);
            if($resOSsMes[0]->total != 0){ //apresenta link
              if($tipoPesquisa == "Filial"){ //JS para filial
                echo "<td class='diaDifZero' onClick='novaJanela(\"$codPesq\",\"\",\"0\",\"$mes\",\"$ano\");'>" . $resOSsMes[0]->total . "</td>";
              }
              if($tipoPesquisa == "Colaborador"){ //JS para colaborador
                echo "<td class='diaDifZero' onClick='novaJanela(\"\",\"$codPesq\",\"0\",\"$mes\",\"$ano\");'>" . $resOSsMes[0]->total . "</td>";
              }
            }
            else{ //somente apresente o valor (0)
              echo "<td class='diaZero'>" . $resOSsMes[0]->total . "</td>";
            }
            $totGeral = $totGeral + $resOSsMes[0]->total;
            echo "</tr>";
          } //foreach($selTipoPesquisa as $tipPesquisa)
        } //if($totTipoPesquisa != 0)

        //mostrando total de OS's por dia - total da produção - última linha
        echo "<tr class='linha' onMouseOver='this.style.background=\"#00FF00\"' onMouseOut='this.style.background=\"#FFFFFF\"'>";
          echo "<td class='rodapeNomeDia'>Produção Geral</td>";
          for($dia=16;$dia<=$totDias;$dia++){ //percorre os últimos 15 dias - 2ª metade do mês
            if($totalDia[$dia] != 0){ //apresenta link
              if($tipoPesquisa == "Filial"){ //pesquisar por filial
                echo "<td class='rodapeDiaDifZero' onClick='novaJanela(\"Prod_Geral\",\"\",\"$dia\",\"$mes\",\"$ano\");'>" . $totalDia[$dia] . "</td>";
              }
              if($tipoPesquisa == "Colaborador"){ //pesquisar por colaborador
                  echo "<td class='rodapeDiaDifZero' onClick='novaJanela(\"\",\"Prod_Geral\",\"$dia\",\"$mes\",\"$ano\");'>" . $totalDia[$dia] . "</td>";
              }
            }
            else{ //somente apresente o valor (0)
              echo "<td class='rodapeDiaZero'>" . $totalDia[$dia] . "</td>";
            }
          } // for($dia=1;$dia<=15;$dia++)
          
          //total geral
          if($totGeral != 0){ //apresenta link
            if($tipoPesquisa == "Filial"){ //total geral das filiais
              echo "<td class='rodapeDiaDifZero' onClick='novaJanela(\"Prod_Geral\",\"\",\"0\",\"$mes\",\"$ano\");'>" . $totGeral . "</td>";
            }
            if($tipoPesquisa == "Colaborador"){ //total geral dos colaboradores
              echo "<td class='rodapeDiaDifZero' onClick='novaJanela(\"\",\"Prod_Geral\",\"0\",\"$mes\",\"$ano\");'>" . $totGeral . "</td>";
            }
          }
          else{ //somente apresente o valor (0)
            echo "<td class='rodapeDiaZero'>" . $totGeral . "</td>";
          }
        echo "</tr>";
      ?>
      
      </table>
      <!-- fim tabela 2 -->

  </body>
  
</html>
