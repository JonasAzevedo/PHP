<?php
  /* Justificativa de OS's Encerradas
  Jonas da Silva Azevedo
  Criado: 21/01/2010 - 13:49
  Modificado em: 09/04/2010 - 11:30
*/
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","misty");
  
  $sql = "INSERT INTO log (cod_usuario,entrada) VALUES ('0',CURRENT_TIMESTAMP)";
  $insere = $bd->executaSQL($sql);
  
  if($_GET['pesquisar']==true){
    $pes=true;
  }
  else {
    $pes=false;
  }
  
  function formataData($dataFormatar){
    $dataExp = explode(" ", $dataFormatar);
    $dataExp2 = explode("-", $dataExp[0]);
    $data = $dataExp2[2] . "/" . $dataExp2[1] . "/" . $dataExp2[0] . " " . $dataExp[1];
    return $data;
  }

?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="estilos.css" />

    <script type="text/javascript" src="./jQuery/js/jquery-1.3.2.min.js">
    </script>

    <script language="JavaScript">
      function limpaComponentes() {
        document.getElementById('edObjectID').value="";
        document.getElementById('cbBxFacilityTypeCircuit').value="Todos";
        document.getElementById('edIDCircuitoCRM').value="";
        document.getElementById('cbBxFilial').value="Todos";
        document.getElementById('cbBxStatusObjectel').value="Todos";
        document.getElementById('cbBxStatusSAC').value="Todos";
        document.getElementById('cbBxTipoCircuito').value="Todos";
        document.getElementById('cbBxVelocidade').value="Todos";
        document.getElementById('cbBxControle').value="Todos";
         document.forms["consultaCircuito"].submit();
       }
    </script>

    <script language="JavaScript">
      function importaDados() {
        document.frmImportar.imp_objID.value = document.getElementById('edObjectID').value;
        document.frmImportar.imp_TipoCircuitoObj.value = document.getElementById('cbBxFacilityTypeCircuit').value;
        document.frmImportar.imp_ID_CircuitoCRM.value = document.getElementById('edIDCircuitoCRM').value;
        document.frmImportar.imp_Filial.value = document.getElementById('cbBxFilial').value;
        document.frmImportar.imp_StatusObj.value = document.getElementById('cbBxStatusObjectel').value;
        document.frmImportar.imp_StatusSAC.value = document.getElementById('cbBxStatusSAC').value;
        document.frmImportar.imp_TipoCircuitoSAC.value = document.getElementById('cbBxTipoCircuito').value;
        document.frmImportar.imp_Velocidade.value = document.getElementById('cbBxVelocidade').value;
        document.frmImportar.imp_controle.value = document.getElementById('cbBxControle').value;
        document.forms['frmImportar'].submit();
      }
    </script>

    <script language="JavaScript">
      function mudaPagina(pg) {
        if(pg>0){
          pg = pg-1;
        }
        document.consultaCircuito.edPagina.value = pg;
        document.forms['consultaCircuito'].submit();
      }
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

    <style type="text/css">
      <!--
      #mask {
        position:absolute;
        left:0;
        top:0;
        z-index:9000;
        background-color:#000;
        display:none;
      }

      #boxes .window {
        position:absolute;
        left:0;
        top:0;
        width:440px;
        height:200px;
        display:none;
        z-index:9999;
        padding:20px;
      }

      #boxes .dialog {
        width:820px;
        height:560px;
        padding:5px;
        background-color:#ffffff;
      }

      .close{display:block; text-align:right;}
      // -->
    </style>

    <title>Misty</title>
    </head>
      <body background bgcolor="#E1E1C4">
        <center>
          <h3>CONSULTA DE STATUS DE CIRCUITO</h3>
        </center>
        <div align="right" border="solid">
          <i>
          <?php
            $sql = "SELECT MAX(codigo) AS total FROM circuitos"; //código "coringa"
            $maxCircuito = $bd->selecionaDados($sql);
            echo "-->  " . $maxCircuito[0]->total;
          ?>
          </i>
        </div>
        <form name="consultaCircuito" method="POST" action="<?php echo $PHP_SELF;?>?pesquisar=true">
          <fieldset>
            <legend><b><u>&nbsp;PESQUISAR&nbsp;</u></b></legend>
              <b>OBJECTEL:</b>&nbsp;&nbsp;&nbsp;
                Object ID:
                <input type="text" id="edObjectID" name="edObjectID" size="20" maxlength="11" value="<?php if(isset($_POST['edObjectID'])) {echo $_POST['edObjectID'];}?>" />
                &nbsp;&nbsp;&nbsp;
                Tipo Circuito:
                <select id="cbBxFacilityTypeCircuit" name="cbBxFacilityTypeCircuit" size="1">
                  <option <?php if(isset($_POST['cbBxFacilityTypeCircuit'])){ if($_POST['cbBxFacilityTypeCircuit'] == "Todos"){ echo "selected"; }}?> value="Todos">Todos</option>
                  <?php
                    $sqlTipoCircuito = "SELECT DISTINCT(facilityCircuitType) FROM circuitos c";
                    $tipoCircuito = $bd->selecionaDados($sqlTipoCircuito);
                    $totTipoCircuito = count($tipoCircuito);
                    if($totTipoCircuito != 0){
                      foreach($tipoCircuito as $mostraTipoCircuito){
                        echo "<option ";
                        if(isset($_POST['cbBxFacilityTypeCircuit'])){
                          if($_POST['cbBxFacilityTypeCircuit'] == $mostraTipoCircuito->facilityCircuitType){
                            echo "selected=\"selected\"";
                          }
                        }
                        echo "value=\"" . $mostraTipoCircuito->facilityCircuitType . "\">" . $mostraTipoCircuito->facilityCircuitType . "</option>";
                      } //foreach
                    } //if($totTipoCircuito != 0){
                  ?>
                </select>
                &nbsp;&nbsp;&nbsp;
                ID Circuito CRM:
                <input type="text" id="edIDCircuitoCRM" name="edIDCircuitoCRM" size="20" maxlength="50" value="<?php if(isset($_POST['edIDCircuitoCRM'])) {echo $_POST['edIDCircuitoCRM']; } ?>" />
                &nbsp;&nbsp;&nbsp;
                Filial:
                <select id="cbBxFilial" name="cbBxFilial" size="1">
                  <option <?php if(isset($_POST['cbBxFilial'])){ if($_POST['cbBxFilial'] == "Todos"){ echo "selected"; }}?> value="Todos">Todos</option>
                  <?php
                    $sqlFiliais = "SELECT DISTINCT(filial) FROM circuitos c";
                    $tipoFiliais = $bd->selecionaDados($sqlFiliais);
                    $totTipoFilial = count($tipoFiliais);
                    if($totTipoFilial != 0){
                      foreach($tipoFiliais as $mostraTipoFiliais){
                        echo "<option ";
                        if(isset($_POST['cbBxFilial'])){
                          if($_POST['cbBxFilial'] == $mostraTipoFiliais->filial){
                            echo "selected=\"selected\"";
                          }
                        }
                        echo "value=\"" . $mostraTipoFiliais->filial . "\">" . $mostraTipoFiliais->filial . "</option>";
                      } //foreach
                    } //if($totTipoFilial != 0){
                  ?>
                </select>
                &nbsp;&nbsp;&nbsp;
                Status Objectel:
                <select id="cbBxStatusObjectel" name="cbBxStatusObjectel" size="1">
                  <option <?php if(isset($_POST['cbBxStatusObjectel'])){ if($_POST['cbBxStatusObjectel'] == "Todos"){ echo "selected"; }}?> value="Todos">Todos</option>
                  <?php
                    $sqlStatusObj = "SELECT DISTINCT(status) FROM circuitos c";
                    $tipoStatusObj = $bd->selecionaDados($sqlStatusObj);
                    $totTipoStatusObj = count($tipoStatusObj);
                    if($totTipoStatusObj != 0){
                      foreach($tipoStatusObj as $mostraTipoStatusObj){
                        echo "<option ";
                        if(isset($_POST['cbBxStatusObjectel'])){
                          if($_POST['cbBxStatusObjectel'] == $mostraTipoStatusObj->status){
                            echo "selected=\"selected\"";
                          }
                        }
                        echo "value=\"" . $mostraTipoStatusObj->status . "\">". $mostraTipoStatusObj->status . "</option>";
                      } //foreach
                    } //if($totTipoStatusObj != 0){
                  ?>
                </select>
               <br><br>
              <b>SAC:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Status:
                <select id="cbBxStatusSAC" name="cbBxStatusSAC" size="1">
                  <option <?php if(isset($_POST['cbBxStatusSAC'])){ if($_POST['cbBxStatusSAC'] == "Todos"){ echo "selected"; }}?> value="Todos">Todos</option>
                  <?php
                    $sqlStatusSAC = "SELECT DISTINCT(statusSAC) FROM circuitos c";
                    $tipoStatusSAC = $bd->selecionaDados($sqlStatusSAC);
                    $totTipoStatusSAC = count($tipoStatusSAC);
                    if($totTipoStatusSAC != 0){
                      foreach($tipoStatusSAC as $mostraTipoStatusSAC){
                        echo "<option ";
                        if(isset($_POST['cbBxStatusSAC'])){
                          if($_POST['cbBxStatusSAC'] == $mostraTipoStatusSAC->statusSAC){
                            echo "selected=\"selected\"";
                          }
                        }
                        echo "value=\"" . $mostraTipoStatusSAC->statusSAC . "\">" . $mostraTipoStatusSAC->statusSAC . "</option>";
                      } //foreach
                    } //if($totTipoStatusSAC != 0){
                  ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Tipo Circuito:
                <select id="cbBxTipoCircuito" name="cbBxTipoCircuito" size="1">
                  <option <?php if(isset($_POST['cbBxTipoCircuito'])){ if($_POST['cbBxTipoCircuito'] == "Todos"){ echo "selected"; }}?> value="Todos">Todos</option>
                  <?php
                    $sqlTipoCircuitoSAC = "SELECT DISTINCT(tipoCircuitoSAC) FROM circuitos c";
                    $tipoCircuitoSAC = $bd->selecionaDados($sqlTipoCircuitoSAC);
                    $totTipoCircuitoSAC = count($tipoCircuitoSAC);
                    if($totTipoCircuitoSAC != 0){
                      foreach($tipoCircuitoSAC as $mostraTipoCircuitoSAC){
                        echo "<option ";
                        if(isset($_POST['cbBxTipoCircuito'])){
                          if($_POST['cbBxTipoCircuito'] == $mostraTipoCircuitoSAC->tipoCircuitoSAC){
                            echo "selected=\"selected\"";
                          }
                        }
                        echo "value=\"" . $mostraTipoCircuitoSAC->tipoCircuitoSAC . "\">" . $mostraTipoCircuitoSAC->tipoCircuitoSAC . "</option>";
                      } //foreach
                    } //if($totTipoCircuitoSAC != 0){
                  ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Velocidade:
                <select id="cbBxVelocidade" name="cbBxVelocidade" size="1">
                  <option <?php if(isset($_POST['cbBxVelocidade'])){ if($_POST['cbBxVelocidade'] == "Todos"){ echo "selected"; }}?> value="Todos">Todos</option>
                  <?php
                    $sqlVelocidadeSAC = "SELECT DISTINCT(velocidadeSAC) FROM circuitos c";
                    $tipoVelocidadeSAC = $bd->selecionaDados($sqlVelocidadeSAC);
                    $totVelocidadeSAC = count($tipoVelocidadeSAC);
                    if($totVelocidadeSAC != 0){
                      foreach($tipoVelocidadeSAC as $mostraTipoVelocidadeSAC){
                        echo "<option ";
                        if(isset($_POST['cbBxVelocidade'])){
                          if($_POST['cbBxVelocidade'] == $mostraTipoVelocidadeSAC->velocidadeSAC){
                            echo "selected=\"selected\"";
                          }
                        }
                        echo "value=\"" . $mostraTipoVelocidadeSAC->velocidadeSAC . "\">" . $mostraTipoVelocidadeSAC->velocidadeSAC . "</option>";
                      } //foreach
                    } //if($totVelocidadeSAC != 0){
                  ?>
                </select>
                <input type="hidden" name="edPagina" value="" />
                <br/><br/>
                <b>CONTROLE:</b>&nbsp;&nbsp;&nbsp;
                <select id="cbBxControle" name="cbBxControle" size="1">
                  <option <?php if(isset($_POST['cbBxControle'])){ if($_POST['cbBxControle'] == "Todos"){ echo "selected"; }}?> value="Todos">Todos</option>
                  <option <?php if(isset($_POST['cbBxControle'])){ if($_POST['cbBxControle'] == "Novos"){ echo "selected"; }}?> value="Novos">Novos</option>
                  <option <?php if(isset($_POST['cbBxControle'])){ if($_POST['cbBxControle'] == "Antigos"){ echo "selected"; }}?> value="Antigos">Antigos</option>
                </select>
                <div align="center">
                  <input  type="submit" name="pesquisa" value="Pesquisar" style="width: 200px; height: 35px; font-weight: bold;"/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input  type="button" name="btnImportar" value="Importar" onClick="importaDados();" style="width: 200px; height: 35px; font-weight: bold;"/>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input  type="button" name="btnLimpar" value="Limpar" onClick="limpaComponentes();" style="width: 200px; height: 35px; font-weight: bold;"/>
                </div>
            </fieldset>
          </p>
          </center>
        </form>
        <br/>
        <?php
          if($_GET['pesquisar']==true){
            $consulta = "SELECT c.* FROM circuitos c WHERE c.processo<>0 "; //forçar o uso do WHERE
            $consultaTotal = "SELECT COUNT(c.codigo) AS total FROM circuitos c WHERE c.processo<>0 "; //forçar o uso do WHERE
            //dados Objectel
            if($_POST['edObjectID']!=""){
              $consulta = $consulta . " AND c.ObjectID LIKE '%" . $_POST['edObjectID'] . "%'";
              $consultaTotal = $consultaTotal . " AND c.ObjectID LIKE '%" . $_POST['edObjectID'] . "%'";
            }
            if(($_POST['cbBxFacilityTypeCircuit']!="")and($_POST['cbBxFacilityTypeCircuit']!="Todos")){
              $consulta = $consulta . " AND c.facilityCircuitType = '" . $_POST['cbBxFacilityTypeCircuit'] . "'";
              $consultaTotal = $consultaTotal . " AND c.facilityCircuitType = '" . $_POST['cbBxFacilityTypeCircuit'] . "'";
            }
            if($_POST['edIDCircuitoCRM']!=""){
              $consulta = $consulta . " AND c.identificadorCircuitoCRM LIKE '%" . $_POST['edIDCircuitoCRM'] . "%'";
              $consultaTotal = $consultaTotal . " AND c.identificadorCircuitoCRM LIKE '%" . $_POST['edIDCircuitoCRM'] . "%'";
            }
            if(($_POST['cbBxFilial']!="")and($_POST['cbBxFilial']!="Todos")){
              $consulta = $consulta . " AND c.filial = '" . $_POST['cbBxFilial'] . "'";
              $consultaTotal = $consultaTotal . " AND c.filial = '" . $_POST['cbBxFilial'] . "'";
            }
            if(($_POST['cbBxStatusObjectel']!="")and($_POST['cbBxStatusObjectel']!="Todos")){
              $consulta = $consulta . " AND c.status = '" . $_POST['cbBxStatusObjectel'] . "'";
              $consultaTotal = $consultaTotal . " AND c.status = '" . $_POST['cbBxStatusObjectel'] . "'";
            }
            //dados SAC
            if(($_POST['cbBxStatusSAC']!="")and($_POST['cbBxStatusSAC']!="Todos")){
              $consulta = $consulta . " AND c.statusSAC = '" . $_POST['cbBxStatusSAC'] . "'";
              $consultaTotal = $consultaTotal . " AND c.statusSAC = '" . $_POST['cbBxStatusSAC'] . "'";
            }
            if(($_POST['cbBxTipoCircuito']!="")and($_POST['cbBxTipoCircuito']!="Todos")){
              $consulta = $consulta . " AND c.tipoCircuitoSAC = '" . $_POST['cbBxTipoCircuito'] . "'";
              $consultaTotal = $consultaTotal . " AND c.tipoCircuitoSAC = '" . $_POST['cbBxTipoCircuito'] . "'";
            }
            if(($_POST['cbBxVelocidade']!="")and($_POST['cbBxVelocidade']!="Todos")){
              $consulta = $consulta . " AND c.velocidadeSAC = '" . $_POST['cbBxVelocidade'] . "'";
              $consultaTotal = $consultaTotal . " AND c.velocidadeSAC = '" . $_POST['cbBxVelocidade'] . "'";
            }
            //controle
            if($_POST['cbBxControle']=="Novos"){
              $consulta = $consulta . " AND c.processo ='1'";
              $consultaTotal = $consultaTotal . " AND c.processo ='1'";
            }
            else if($_POST['cbBxControle']=="Antigos"){
              $consulta = $consulta . " AND c.processo ='37'";
              $consultaTotal = $consultaTotal . " AND c.processo ='37'";
            }
            if($_POST['edPagina']!=""){
              $iniLimt = (10 * $_POST['edPagina']);
              $consulta = $consulta . " ORDER BY c.codigo LIMIT " . $iniLimt . ",10";
            }
            else{
              $consulta = $consulta . " ORDER BY c.codigo LIMIT 10";
            }
            //echo "$consulta";
            $dadosRes = $bd->selecionaDados($consulta);
            $dadosTotal = $bd->selecionaDados($consultaTotal);

            echo "<table id='tblDadosCircuito' border='1' align='center' cellpadding='10' cellpacing='1'>";
              echo "<tr>";
                echo "<th>Object ID</th>";
                echo "<th>Facility Circuit Type</th>";
                echo "<th>Identificador Circuito CRM</th>";
                echo "<th>Status Objectel</th>";
                echo "<th>Velocidade SAC</th>";
                echo "<th>Status SAC</th>";
                echo "<th>Filial</th>";
                if($_POST['cbBxControle'] != "Antigos"){
                  echo "<th>Base Antiga</th>";
                }
                else{
                  echo "<th>Base Nova</th>";
                }
              echo "</tr>";
              
            $total = count($dadosRes);

            if($total<>0){
              echo "<form name='mostraCircuitos' method='POST' action='salvaCircuitos.php'>";
              $i = 0;
              foreach($dadosRes as $mostra){
                echo "<tr align='center'>";
                ?>
                <td>
                <table>
                  <a href="<?php echo "#" . $mostra->codigo; ?>" name='modal'><?php echo $mostra->objectID ?></a>
                  <div id="boxes">
                    <div id="<?php echo $mostra->codigo; ?>" class="window dialog">
                    <a href="#" class="close">Fechar [X]</a>
                    <!--
                      <div style="border-bottom:#999999 solid 1px; margin-top:5px;"></div>
                    -->
                      <br/>
                        <?php
                          echo "<fieldset>";
                          echo "<legend>&nbsp;&nbsp;Dados do Circuito&nbsp;&nbsp;</legend>";
                          echo "<p><b>";
                            echo "<u>";
                            echo "DADOS OBJECTEL";
                            echo "</u>";
                          echo "</b></p>";
                          echo "<p><b>";
                            echo "Object ID: " . "</b>" . $mostra->objectID;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Facility Circuit Type: " . "</b>" . $mostra->facilityCircuitType;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Filial: " . "</b>" . $mostra->filial;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Identificador Facilidade: " . "</b>" . $mostra->identificadorFacilidade;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Identificador Legado: " . "</b>" . $mostra->identificadorLegado;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Identificador Cicruito CRM: " . "</b>" . $mostra->identificadorCircuitoCRM;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Status: " . "</b>" . $mostra->status;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Criado Por: " . "</b>" . $mostra->criadoPor;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Data Criação: " . "</b>" . $mostra->dataCriacao;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Comentários: " . "</b>" . $mostra->comentarios;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Servico: " . "</b>" . $mostra->servico;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Circuito Completo: " . "</b>" . $mostra->circuitoCompleto;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Porta Lógica Circuito TDM: " . "</b>" . $mostra->portaLogicaCircuitoTDM;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                          echo "</p>";
                          echo "<p><b>";
                            echo "Última Atualização pelo Usuário: " . "</b>" . $mostra->ultimaAtualizacaoPorUsuario;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Última Atualização: " . "</b>" . $mostra->ultimaAtualizacao;
                          echo "</p>";
                          echo "<p><b>";
                            echo "<u>";
                            echo "DADOS SAC";
                            echo "</u>";
                          echo "</b></p>";
                          echo "<p><b>";
                            echo "Status SAC: " . "</b>" . $mostra->statusSAC;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Tipo Circuito SAC: " . "</b>" . $mostra->tipoCircuitoSAC;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Velocidade SAC: " . "</b>" . $mostra->velocidadeSAC;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Titular SAC: " . "</b>" . $mostra->titularSAC;
                          echo "</p>";
                          echo "</p><b>";
                            echo "Data Criação SAC: " . "</b>" . formataData($mostra->dataCriacaoSAC);
                          echo "</p>";
                          echo "</fieldset>";
                          ?>
                    </div>
                    <!-- Máscara para cobrir a tela -->
                    <div id="mask"></div>
                  </div>
                </table>
                </td>
                <?php
                //echo "<td>" . $mostra->objectID . "</td>";
                echo "<td>" . $mostra->facilityCircuitType . "</td>";
                echo "<td>" . $mostra->identificadorCircuitoCRM . "</td>";
                echo "<td>" . $mostra->status . "</td>";
                echo "<td>" . $mostra->velocidadeSAC . "</td>";
                echo "<td>" . $mostra->statusSAC . "</td>";
                echo "<td>" . $mostra->filial . "</td>";
                echo "<td>";
                echo "<input type='checkbox' name='ckBxSalva[]' value='" . $i . "' />";
                echo "<input type='hidden' name='edCodigo[]' value='" . $mostra->codigo . "' size='1' />";
                echo "<input type='hidden' name='edProcesso[]' value='" . $mostra->processo . "' />";
                $i++;
                echo "</td>";
              echo "</tr>";
             }
            }
            echo "</table>";
            echo "<br>";
            echo "<center>";
            echo "<br><br>";
            echo "<input type='submit' name='btnSalvar' value='Salvar' />";
            echo "</i></center>";
            echo "</form>";

            $totPaginas = $dadosTotal[0]->total / 10;
            if(is_int($totPaginas)){
            }
            else{
              $totPaginas++;
            }
            $totPaginas = floor($totPaginas);

            echo "<br/>";
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
                  echo "<a href='javascript:mudaPagina(".$pg.");'>".$pg."</a>";
                  echo "&nbsp;&nbsp";
                  //próxima
                  $p = $pg + 1;
                  echo "<a href='javascript:mudaPagina(".$p.");'> > </a>";
                  echo "&nbsp;&nbsp";
                  //última
                  echo "<a href ='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
                }
                elseif($pg==2){
                  //anterior
                  $p = $pg-1;
                  echo "<a href ='javascript:mudaPagina(".$p.");'> < </a>";
                  echo "&nbsp;&nbsp";
                  //atual
                  $p = $pg;
                  echo "<a href ='javascript:mudaPagina(".$p.");'>".$p."</a>";
                  echo "&nbsp;&nbsp";
                  //próxima
                  $p = $pg+1;
                  echo "<a href ='javascript:mudaPagina(".$p.");'> > </a>";
                  echo "&nbsp;&nbsp";
                  //última
                  echo "<a href ='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
                }
                elseif($pg+1==$totPaginas){
                  //1ª
                  echo "<a href ='javascript:mudaPagina(0);'>1</a>";
                  echo "&nbsp;&nbsp";
                  //anterior
                  $p = $pg-1;
                  echo "<a href ='javascript:mudaPagina(".$p.");'> < </a>";
                  echo "&nbsp;&nbsp";
                  //atual
                  $p = $pg;
                  echo "<a href ='javascript:mudaPagina(".$p.");'>".$p."</a>";
                  echo "&nbsp;&nbsp";
                  //próxima
                  $p = $pg+1;
                  echo "<a href ='javascript:mudaPagina(".$p.");'> > </a>";
                  echo "&nbsp;&nbsp";
                }
                elseif($pg==$totPaginas){
                  //1ª
                  echo "<a href ='javascript:mudaPagina(0);'>1</a>";
                  echo "&nbsp;&nbsp";
                  //anterior
                  $p = $pg-1;
                  echo "<a href ='javascript:mudaPagina(".$p.");'> < </a>";
                  echo "&nbsp;&nbsp";
                  //atual
                  $p = $pg;
                  echo "<a href ='javascript:mudaPagina(".$p.");'>".$p."</a>";
                  echo "&nbsp;&nbsp";
                }
                else{
                  //1ª
                  echo "<a href ='javascript:mudaPagina(0);'>1</a>";
                  echo "&nbsp;&nbsp";
                  //anterior
                  $p = $pg-1;
                  echo "<a href ='javascript:mudaPagina(".$p.");'> < </a>";
                  echo "&nbsp;&nbsp";
                  //atual
                  $p = $pg;
                  echo "<a href ='javascript:mudaPagina(".$p.");'>".$p."</a>";
                  echo "&nbsp;&nbsp";
                  //próxima
                  $p = $pg+1;
                  echo "<a href ='javascript:mudaPagina(".$p.");'> > </a>";
                  echo "&nbsp;&nbsp";
                  //última
                  echo "<a href ='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
                }
              } //if($totPaginas > 5){
              elseif(($totPaginas > 1)and($totPaginas <= 5)){//se existem entre 2 e 5 páginas
                for ($i=1; $i<=$totPaginas; $i++){
                  echo "<a href ='javascript:mudaPagina(".$i.");'>" . $i . "</a>"; //-1 pra iniciar do registro 0, senão pega o registro 50 como o 1º
                  echo "&nbsp;&nbsp";
                } //for
              } //elseif(($totPaginas > 1)and($totPaginas <= 5))
            } //if($pg<>0){
            else{
              if(($total>0)and($totPaginas > 1)){ //se existe páginas para mostrar
                $pg = $pg + 1;
                //atual
                echo "<a href='javascript:mudaPagina(".$pg.");'>".$pg."</a>";
                echo "&nbsp;&nbsp";
                //próxima
                $p = $pg + 1;
                echo "<a href='javascript:mudaPagina(".$p.");'> > </a>";
                echo "&nbsp;&nbsp";
                //última
                if($totPaginas > 2){
                  echo "<a href ='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
                }
              }
            }
            echo "</center>";
            }
            if($dadosTotal[0]->total != null){
              echo "<br>";
              echo "<center>";
              //echo "OS's Página: " . $total;
              echo "Total de OS's: " . $dadosTotal[0]->total;
              echo "</i></center>";
            }

        ?>
    <!-- cadastrando um novo registro -->
      <form name="frmImportar" method="POST" action="mostraDados.php?pesquisar=true">
        <input type="hidden" name="imp_objID" id="imp_objID" />
        <input type="hidden" name="imp_TipoCircuitoObj" id="imp_TipoCircuitoObj" />
        <input type="hidden" name="imp_ID_CircuitoCRM" id="imp_ID_CircuitoCRM"/>
        <input type="hidden" name="imp_Filial" id="imp_Filial" />
        <input type="hidden" name="imp_StatusObj" id="imp_StatusObj" />
        <input type="hidden" name="imp_StatusSAC" id="imp_StatusSAC" />
        <input type="hidden" name="imp_TipoCircuitoSAC" id="imp_TipoCircuitoSAC" />
        <input type="hidden" name="imp_Velocidade" id="imp_Velocidade" />
        <input type="hidden" name="imp_controle" id="imp_controle" />
      </form>

      </body>
</html>
