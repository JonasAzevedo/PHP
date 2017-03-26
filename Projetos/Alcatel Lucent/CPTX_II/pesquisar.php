<!-- Consulta de Circuitos
       autor: Jonas da Silva Azevedo
       criado em: 10/03/2010 - 08:34
       última modificação:
-->

<?php
    include("menuPrincipal.html");

    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");

    function formataData($dataFormatar){
      $dataExp = explode(" ", $dataFormatar);
      $dataData = explode("-", $dataExp[0]);
      $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0] . " " . $dataExp[1];
      return $data;
    }
    
    //define qual e a figura da pendência
    function mostraFiguraPendencia($flagPend){
      if($flagPend == 0){
        return "<img class='imagemPendObj' alt='O circuito nao tem pendencia' src='./imagens/legenda/pend_nao.png'>"; //nao tem pendencia
      }
      elseif($flagPend == 1){
        return "<img class='imagemPendObj' alt='O circuito tem pendencia' src='./imagens/legenda/pend_sim.png'>"; //tem pendencia
      }
    }

    //define qual e a figura do objectel
    function mostraFiguraObjectel($flagObj){
      if($flagObj == 0){
        return "<img class='imagemPendObj' alt='O circuito tem objectel' src='./imagens/legenda/obj_completo.png'>"; //tem objectel
      }
      elseif($flagObj == 1){
        return "<img class='imagemPendObj' alt='O circuito nao tem objectel' src='./imagens/legenda/obj_incompleto.png'>"; //nao tem objectel
      }
      elseif($flagObj == 9){
        return "<img class='imagemPendObj' alt='O circuito nao tem objectel' src='./imagens/legenda/obj_nao_disp.png'>"; //nao tem objectel
      }
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" href="./estilos/pgPesquisar.css" type="text/css" />

    <script language="JavaScript" src="./js/pgPesquisar.js">
    </script>
    
    <script type="text/javascript" src="./jQuery/js/jquery-1.3.2.min.js">
    </script>

    <script type="text/javascript">
      <!--
      $(document).ready(function() {
        $('a[name=modal]').click(function(e) {
     	  e.preventDefault();

		  var id = $(this).attr('href');

          var maskHeight = $(document).height();
          var maskWidth = $(window).width();
          var vscroll = (document.all ? document.scrollTop : window.pageYOffset); //pega posiçao do scroll na vertical

		  $('#mask').css({'width':maskWidth,'height':maskHeight});

		  $('#mask').fadeIn(1000);
		  $('#mask').fadeTo("slow",0.8);

		  //Get the window height and width
		  var winH = $(window).height();
		  var winW = $(window).width();

		  $(id).css('top',  (winH/2-$(id).height()/2)+vscroll);
		  $(id).css('left', winW/2-$(id).width()/2);

		  $(id).fadeIn(2000);
        });

        $('.window .close').click(function (e) {
		  e.preventDefault();

   		  $('#mask').hide();
		  $('.window').hide();
        });

        $('#mask').click(function () {
		  $(this).hide();
		  $('.window').hide();
        });
      });
      // -->
    </script>


    <title>Consulta</title>
  </head>

  <body>
    <form name="frmPesquisar" method="POST" action="<?php echo $PHP_SELF;?>?pesquisar=true">
      <div class="dadosOpcoesPesquisa" id="cxDadosOpcoesPesquisa">
        <span class="titulo"><a href="#" name="lkLimpar" id=="lkLimpar" class="lnkLimpar" onClick="limpar();">Pesquisar:</a></span> <br />
        <!-- filial -->
        <div class="grupoCampos1">
          <span class="tituloCampo">Filial:</span>
          <select class="slctCamposPesquisa" name="cbSelFilial" id="cbSelFilial">
            <?php
              $filiais = array('FNS','PAE','BSA','GNA','CPE','CBA','CTA','PVO','RBO','PLT');
              $totFiliais = count($filiais);
              echo "<option value=\"#\""; if($_GET['pesquisar']=="true"){if($_POST['cbSelFilial']=="#"){
                echo "selected=\"selected\"";}} echo "></option>";
              for($x=0; $x<$totFiliais; $x++) {
                echo "<option value=\"$filiais[$x]\"";
                if($_GET['pesquisar']=="true"){if( $_POST['cbSelFilial']==$filiais[$x]){
                  echo " selected=\"selected\"";}}
                echo ">$filiais[$x]</option>";
              }
            ?>
          </select>
        </div>
        <div class="grupoCampos2">
          <span class="tituloCampo">Circuito:</span> <input type="text" class="inptCamposPesquisa" name="edCircuito" id="edCircuito" size="10" />
        </div>
        <div class="grupoCampos3">
          <span class="tituloCampo">Velocidade:</span> <input type="text" class="inptCamposPesquisa" name="edVelocidade" id="edVelocidade" size="2" />
        </div>
        <div class="grupoCampos1">
          <span class="tituloCampo">Tipo:</span>
          <select class="slctCamposPesquisa" name="cbSelTipo" id="cbSelTipo">
            <option value="#"></option>";
            <option value="E1">E1</option>";
            <option value="FE">FE</option>";
          </select>
        </div>
        <br />
        <div class="grupoCampos2">
          <span class="tituloCampo">Pendência:</span>
          <select class="slctCamposPesquisa" name="cbSelPendencia" id="cbSelPendencia">
            <option value="#"></option>";
            <option value="4026">4026</option>";
            <option value="3500">3500</option>";
            <option value="3031">3031</option>";
          </select>
        </div>
        <div class="grupoCampos3">
          <span class="tituloCampo">Objectel:</span>
          <select class="slctCamposPesquisa" name="cbSelObjectel" id="cbSelObjectel">
            <option value="#"></option>";
            <option value="Completo">Completo</option>";
            <option value="Incompleto">Incompleto</option>";
          </select>
        </div>
        <br />
        <div class="grupoCampos1">
          <span class="tituloCampo">Colaborador:</span>
          <select class="slctCamposPesquisa" name="cbSelColaborador" id="cbSelColaborador">
            <option value="#"></option>
            <?php
              $sql = "SELECT codigo,nome FROM usuario ORDER BY codigo";
              $pesqUsu = $bd->selecionaDados($sql);
              $tot = count($pesqUsu);
              if($tot != 0){
                foreach($pesqUsu as $mostra){
                  echo "<option value='" . $mostra->codigo . "'>" . $mostra->nome . "</option>";
                }
              }
            ?>
          </select>
          <!-- <input type="text" class="inptCamposPesquisa" name="edColaborador" id="edColaborador" size="10" /> -->
        </div>
        <div class="grupoCamposDataExec">
          <span class="tituloCampo">Data de Execução:</span>
          <input type="text" class="inptCamposPesquisa" name="edDataExecInicio" id="edDataExecInicio" size="10" />
          <span class="tituloCampo">a</span>
          <input type="text" class="inptCamposPesquisa" name="edDataExecFinal" id="edDataExecFinal" size="10" />
          <input type="hidden" name="edPagina" id="edPagina" value="" />
        </div>
      </div>
    </form>
    <a class="lnkPesquisar" name="lkPesquisar" id="lkPesquisar" onClick="validaPesquisa();"><img class='imgBotaoOpc' alt='Pesquisar' src='./imagens/pesquisa.jpg'></a>

    <hr class="divisao"/>
    <!-- montando pesquisa <hr> -->
    <?php
    if($_GET['pesquisar']==true){
      $sql = "SELECT o.*, u .nome ";
      $sql = $sql . "FROM os o, usuario u WHERE o.cod_usuario=u.codigo";
      $sqlTotal = "SELECT COUNT(o.codigo) AS total FROM os o, usuario u WHERE o.cod_usuario=u.codigo";
      if($_POST['cbSelFilial']!="#"){
        $sql = $sql . " AND o.filial = '" . $_POST['cbSelFilial'] . "'";
        $sqlTotal = $sqlTotal . " AND o.filial = '" . $_POST['cbSelFilial'] . "'";
      }
      if($_POST['edCircuito']!=""){
        $sql = $sql . " AND o.circuito = '" . $_POST['edCircuito'] . "'";
        $sqlTotal = $sqlTotal . " AND o.circuito = '" . $_POST['edCircuito'] . "'";
      }
      if($_POST['cbSelTipo']!="#"){
        $sql = $sql . " AND o.tipo = '" . $_POST['cbSelTipo'] . "'";
        $sqlTotal = $sqlTotal . " AND o.tipo = '" . $_POST['cbSelTipo'] . "'";
        if($_POST['cbSelTipo']!="FE"){
          $sql = $sql . " AND o.velocidade = '" . $_POST['edVelocidade'] . "'";
          $sqlTotal = $sqlTotal . " AND o.velocidade = '" . $_POST['edVelocidade'] . "'";
        }
      }
      if($_POST['cbSelPendencia']!="#"){
        $sql = $sql . " AND o.pendencia = '" . $_POST['cbSelPendencia'] . "'";
        $sqlTotal = $sqlTotal . " AND o.pendencia = '" . $_POST['cbSelPendencia'] . "'";
      }
      if($_POST['cbSelObjectel']!="#"){
        $sql = $sql . " AND o.status_objectel = '" . $_POST['cbSelObjectel'] . "'";
        $sqlTotal = $sqlTotal . " AND o.status_objectel = '" . $_POST['cbSelObjectel'] . "'";
      }
      if($_POST['cbSelColaborador']!="#"){
        $sql = $sql . " AND u.codigo = '" . $_POST['cbSelColaborador'] . "'";
        $sqlTotal = $sqlTotal . " AND u.codigo = '" . $_POST['cbSelColaborador'] . "'";
      }
      if(($_POST['edDataExecInicio']!="")and(($_POST['edDataExecFinal']!=""))){
        $sql = $sql . " AND o.data_executou BETWEEN '" . $_POST['edDataExecInicio'] . "' AND '" . $_POST['edDataExecFinal'] . "'";
        $sqlTotal = $sqlTotal . " AND o.data_executou BETWEEN '" . $_POST['edDataExecInicio'] . "' AND '" . $_POST['edDataExecFinal'] . "'";
      }
      
      if($_POST['edPagina']!=""){
        $iniLimt = (10 * $_POST['edPagina']);
        $sql = $sql . " ORDER BY o.codigo LIMIT " . $iniLimt . ",10";
      }
      else{
        $sql = $sql . " ORDER BY o.codigo LIMIT 0,10";
      }
      
      $dadosRes = $bd->selecionaDados($sql);
      $dadosTotal = $bd->selecionaDados($sqlTotal);

      $total = count($dadosRes);
      $totalGeral = count($dadosTotal);
      if($total != 0){
        echo "<table class='tblDadosPesquisa' id='tblDados' name='tblDados'>";
          //cabeçalho da tabela
          echo "<tr>";
            echo "<th>Filial</th>";
            echo "<th>Circuito</th>";
            echo "<th>Veloc.</th>";
            echo "<th>Tipo</th>";
            echo "<th>Data</th>";
            echo "<th>Pend.</th>";
            echo "<th>Obj.</th>";
            echo "<th>Colaborador</th>";
            echo "<th>Detalhes</th>";
          echo "</tr>";
          
          $i = 0;
          foreach($dadosRes as $mostra){
            echo "<tr align='center'>";
            echo "<td>" . $mostra->filial . "</td>";
            echo "<td>" . $mostra->circuito . "</td>";
            echo "<td>" . $mostra->velocidade . "</td>";
            echo "<td>" . $mostra->tipo . "</td>";
            echo "<td>" . formataData($mostra->data_executou) . "</td>";
            echo "<td>" . mostraFiguraPendencia($mostra->flag_pendencia) . "</td>";
            echo "<td>" . mostraFiguraObjectel($mostra->flag_objectel) . "</td>";
            echo "<td>" . $mostra->nome . "</td>";
            //echo "<td>" . "<img class='imagemPendObj' alt='Exibir Detalhes' src='./imagens/exibirMais.jpg'>" . "</td>";
            ?>
            <td>
              <table>
                <a href="<?php echo "#" . $mostra->codigo; ?>" name='modal'><?php echo "<img class='imagemPendObj' alt='Exibir Detalhes' src='./imagens/exibirMais.jpg'>" ?></a>
                <div id="boxes">
                  <div id="<?php echo $mostra->codigo; ?>" class="window dialog">
                    <a href="#" class="close">Fechar [X]</a>
                    <br/>
                    <?php
                      //selecionando histórico do circuito
                      $sqlHist = "SELECT o.*, u.nome FROM os o, usuario u ";
                      $sqlHist = $sqlHist . "WHERE o.cod_usuario=u.codigo ";
                      $sqlHist = $sqlHist . " AND o.filial='" . $mostra->filial . "'";
                      $sqlHist = $sqlHist . " AND o.circuito='" . $mostra->circuito . "'";
                      $sqlHist = $sqlHist . " ORDER BY o.data_executou";

                      $dadosHist = $bd->selecionaDados($sqlHist);
                      $totalHist = count($dadosHist);

                      echo "<fieldset>";
                      echo "<legend>&nbsp;&nbsp;Dados do Circuito&nbsp;&nbsp;</legend>";
                        echo "<span class='tituloCampo'>Filial:</span>";
                        echo "<span class='campoCircuito'>" . $dadosHist[0]->filial . "</span>";
                        echo "<span class='tituloCampo'>Circuito:</span>";
                        echo "<span class='campoCircuito'>" . $dadosHist[0]->circuito . "</span>";
                        echo "<span class='tituloCampo'>Data Executou:</span>";
                        echo "<span class='campoCircuito'>" . formataData($dadosHist[0]->data_executou) . "</span>";
                        echo "<br />";
                        echo "<span class='tituloCampo'>Tipo:</span>";
                        echo "<span class='campoCircuito'>" . $dadosHist[0]->tipo . "</span>";
                        echo "<span class='tituloCampo'>Velocidade:</span>";
                        echo "<span class='campoCircuito'>" . $dadosHist[0]->velocidade . "</span>";
                        echo "<br />";
                        echo "<span class='tituloCampo'>Pendência:</span>";
                        if($dadosHist[0]->flag_pendencia == 1){ //existe pendência
                          echo "<span class='campoCircuito'>" .$dadosHist[0]->pendencia . "</span>";
                          echo "<span class='tituloCampo'>Observação:</span>";
                          echo "<span class='campoCircuito'>" .$dadosHist[0]->descricao_pendencia . "</span>";
                        }
                        else{
                          echo "<span class='campoCircuito'>" ."Não houve pendência"  . "</span>";
                        }
                        echo "<br />";
                        echo "<span class='tituloCampo'>Objectel:</span>";
                        if($dadosHist[0]->flag_objectel != 9){ //existe objectel
                          echo "<span class='campoCircuito'>" .$dadosHist[0]->status_objectel . "</span>";
                          echo "<span class='tituloCampo'>Descrição:</span>";
                          echo "<span class='campoCircuito'>" .$dadosHist[0]->descricao_objectel . "</span>";
                        }
                        else{
                          echo "<span class='campoCircuito'>" ."Objectel não informado"  . "</span>";
                        }
                        echo "<br /><br />";
                        //mostrando restante do histórico do circuito
                        if($totalHist > 1){
                          for($i=1;$i<$totalHist;$i++){
                            echo "<span class='tituloCampo'>Data:</span>";
                            echo "<span class='campoCircuito'>" .formataData($dadosHist[$i]->data_executou) . "</span>";
                            echo "<span class='tituloCampo'>Colaborador:</span>";
                            echo "<span class='campoCircuito'>" .$dadosHist[$i]->nome . "</span>";
                            echo "<br />";
                            if($dadosHist[$i-1]->velocidade != $dadosHist[$i]->velocidade){
                              echo "<span class='tituloCampo'>Tipo:</span>";
                              echo "<span class='campoCircuito'>" . $dadosHist[$i]->tipo . "</span>";
                              echo "<span class='tituloCampo'>Velocidade:</span>";
                              echo "<span class='campoCircuito'>" . $dadosHist[$i]->velocidade . "</span>";
                              echo "<br />";
                            }
                            echo "<span class='tituloCampo'>Pendência:</span>";
                            if($dadosHist[$i]->flag_pendencia == 1){ //existe pendência
                              echo "<span class='campoCircuito'>" .$dadosHist[$i]->pendencia . "</span>";
                              echo "<span class='tituloCampo'>Observação:</span>";
                              echo "<span class='campoCircuito'>" .$dadosHist[$i]->descricao_pendencia . "</span>";
                            }
                            else{
                              echo "<span class='campoCircuito'>" ."Não houve pendência"  . "</span>";
                            }
                            echo "<br />";
                            echo "<span class='tituloCampo'>Objectel:</span>";
                            if($dadosHist[$i]->flag_objectel != 9){ //existe objectel
                              echo "<span class='campoCircuito'>" .$dadosHist[$i]->status_objectel . "</span>";
                              if($dadosHist[$i]->status_objectel != "Completo"){
                                echo "<span class='tituloCampo'>Descrição:</span>";
                                echo "<span class='campoCircuito'>" .$mostraHist[$i]->descricao_objectel . "</span>";
                              }
                            }
                            else{
                              echo "<span class='campoCircuito'>" ."Objectel não informado"  . "</span>";
                            }
                            echo "<br /><br />";
                          } //for
                        } //if($totalHist > 1)
                        
                      echo "</fieldset>";
                    ?>
                  </div>
                  <!-- Máscara para cobrir a tela -->
                  <div id="mask"></div>
                </div>
              </table>
            </td>
            <?php
            echo "</tr>";
          } //foreach
          echo "</table>";
      } //if($total != 0)

      echo "<div class='grupoRodape'>";
        echo "<br /><br /><br />";
        echo "<span class='txtRodape'> OS's Página: " . $total ."</span>";
        echo "<br />";

      
        $totPaginas = $dadosTotal[0]->total / 10;
        if(is_int($totPaginas)){
        }
        else{
          $totPaginas++;
        }
        $totPaginas = floor($totPaginas);

        echo "<br />";
        echo "<center>";
      
        if($_POST['edPagina']!=""){
          $pg = $_POST['edPagina'] + 1;
        }
        else {
          $pg = 0;
        }

        //PAGINAÇÃO
        //se existe uma página selecionada e existe páginas para mostrar
        if(($pg<>0)and($total>0)){
          if($totPaginas > 5){
            //se a página selecionada foi a 1ª
            if($pg==1){
              //atual
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$pg.");'>".$pg."</a>";
              echo "&nbsp;&nbsp";
              //próxima
              $p = $pg + 1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> > </a>";
              echo "&nbsp;&nbsp";
              //última
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
            }
            elseif($pg==2){
              //anterior
              $p = $pg-1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> < </a>";
              echo "&nbsp;&nbsp";
              //atual
              $p = $pg;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'>".$p."</a>";
              echo "&nbsp;&nbsp";
              //próxima
              $p = $pg+1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> > </a>";
              echo "&nbsp;&nbsp";
              //última
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
            }
            elseif($pg+1==$totPaginas){
              //1ª
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(0);'>1</a>";
              echo "&nbsp;&nbsp";
              //anterior
              $p = $pg-1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> < </a>";
              echo "&nbsp;&nbsp";
              //atual
              $p = $pg;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'>".$p."</a>";
              echo "&nbsp;&nbsp";
              //próxima
              $p = $pg+1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> > </a>";
              echo "&nbsp;&nbsp";
            }
            elseif($pg==$totPaginas){
              //1ª
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(0);'>1</a>";
              echo "&nbsp;&nbsp";
              //anterior
              $p = $pg-1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> < </a>";
              echo "&nbsp;&nbsp";
              //atual
              $p = $pg;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'>".$p."</a>";
              echo "&nbsp;&nbsp";
            }
            else{
              //1ª
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(0);'>1</a>";
              echo "&nbsp;&nbsp";
              //anterior
              $p = $pg-1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> < </a>";
              echo "&nbsp;&nbsp";
              //atual
              $p = $pg;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'>".$p."</a>";
              echo "&nbsp;&nbsp";
              //próxima
              $p = $pg+1;
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> > </a>";
              echo "&nbsp;&nbsp";
              //última
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
            }
          } //if($totPaginas > 5){
          elseif(($totPaginas > 1)and($totPaginas <= 5)){//se existem entre 2 e 5 páginas
            for ($i=1; $i<=$totPaginas; $i++){
              echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$i.");'>" . $i . "</a>"; //-1 pra iniciar do registro 0, senão pega o registro 50 como o 1º
              echo "&nbsp;&nbsp";
            } //for
          } //elseif(($totPaginas > 1)and($totPaginas <= 5))
        } //if($pg<>0){
        else{
          if(($total>0)and($totPaginas > 1)){ //se existe páginas para mostrar
            $pg = $pg + 1;
            //atual
            echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$pg.");'>".$pg."</a>";
            echo "&nbsp;&nbsp";
            //próxima
            $p = $pg + 1;
            echo "<a class='lnkPaginacao' href='javascript:mudaPagina(".$p.");'> > </a>";
            echo "&nbsp;&nbsp";
            //última
            if($totPaginas > 2){
              echo "<a class='lnkPaginacao' href ='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
            }
          }
        }
      echo "</div>";
      //apresentando total de OS's
      echo "<span class='totalOSs'>OS's: " . $dadosTotal[0]->total . "</span>";
      
    } //if($_GET['pesquisar']==true)
   ?>

  </body>
  
</html>
