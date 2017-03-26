<?php
  /* Justificativa de OS's Encerradas
  Jonas da Silva Azevedo
  Criado: 21/01/2010 - 13:49
*/
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");
  if($_GET['pesquisar']==true){
    $pes=true;
  }
  else {
    $pes=false;
  }
  
  function formataData($dataFormatar){
    $dataExp = explode("/", $dataFormatar);
    $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
    return $data;
  }
  
  function formataData_2($dataFormatar){
    $dataExp = explode("-", $dataFormatar);
    $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
    return $data;
  }
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="estilos.css" />

    <!--
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js">
    -->
    <script type="text/javascript" src="./jQuery/js/jquery-1.3.2.min.js">
    </script>

    <script type="text/javascript">
        function salvar(codigo,idOrdem,url) {
          var valida;
          valida = confirm('Tem certeza que deseja salvar o ID ' + idOrdem + ' ?');
          if(valida == true) {
            window.open(url,'_self');
          }
        }
    </script>

    <script language="JavaScript">
      function mudaPagina(pg) {
        if(pg>0){
          pg = pg-1;
        }
        document.consultaOS_ForaPrazo.edPagina.value = pg;
        document.forms['consultaOS_ForaPrazo'].submit();
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
           var vScroll = (document.all ? document.scrollTop : window.pageYOffset); //pega posiçao do scroll

		  $('#mask').css({'width':maskWidth,'height':maskHeight});

		  $('#mask').fadeIn(1000);
		  $('#mask').fadeTo("slow",0.8);

		  //Get the window height and width
		  var winH = $(window).height();
		  var winW = $(window).width();

		  $(id).css('top',  (winH/2-$(id).height()/2 + vScroll));
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
        height:550px;
        padding:5px;
        background-color:#ffffff;
      }

      .close{display:block; text-align:right;}
      // -->
    </style>

    <title>Consulta OS's Encerradas Fora do Prazo</title>
    </head>
      <body>
        <center>
          <p>
            <a href='logoff.php'>Sair</a>
          </p>
          <p>
            <a href="index.php">Principal</a>
          </p>
          <h2>CONSULTA DE OS's ENCERRADAS FORA DO PRAZO</h2>
        </center>
        <p></p>
        <form name="consultaOS_ForaPrazo" method="POST" action="<?php echo $PHP_SELF;?>?pesquisar=true">
          <center>
          <p><b>Nº OS CRM:</b> <input type="text" span="text4" name="edNumeroOS_CRM" maxlength="30" value="<?php if($pes == true){echo $_POST['edNumeroOS_CRM'];} ?>"/>&nbsp;&nbsp;&nbsp;
          <b>ID da Ordem:</b> <input type="text" span="text4" name="edID_Ordem" maxlength="20" value="<?php if($pes == true){echo $_POST['edID_Ordem'];}?>"/>&nbsp;&nbsp;&nbsp;
          <b>Setor Responsável:</b> <select name="cbBxSetorResponsavel" size="1" style="width: 100px;">
                                       <option value="Todos" selected>Todos</option>
                                       <option value="CD"<?php if($pes == true){if($_POST['cbBxSetorResponsavel']=="CD"){echo "selected";}}?>>CD</option>
                                       <option value="TX"<?php if($pes == true){if($_POST['cbBxSetorResponsavel']=="TX"){echo "selected";}}?>>TX</option>
                                       <option value="VOZ_AV"<?php if($pes == true){if($_POST['cbBxSetorResponsavel']=="VOZ_AV"){echo "selected";}}?>>VOZ  AV</option>
                                     </select>&nbsp;&nbsp;&nbsp;
          <b>Data:</b> <input type="text" span="text4" name="edDtInicio" maxlength="10" size="10" value="<?php if($pes == true) {echo $_POST['edDtInicio'];} ?>" /> entre
                       <input type="text" span="text4" name="edDtFinal" maxlength="10" size="10" value="<?php if($pes == true) {echo $_POST['edDtFinal'];} ?>" /> ('dd/mm/yyyy')
            <input type="hidden" name="edPagina" value="" />
          </p>
          <p align="center">
            <input type="submit" value="Pesquisar" class="buttons1" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="reset" value="Limpar" class="buttons2" />
          </p>
          <p>
            <hr size="1" width="100%" align="center" noshade>
          </p>
          </center>
        </form>
        <br/>
        <?php
          if($_GET['pesquisar']==true){
            $consulta = "SELECT o.* FROM os_encerrada o WHERE o.aprovNoPrazo='Vencidas' AND cod_usuario = 0 ";
            $consultaTotal = "SELECT COUNT(o.codigo) AS total FROM os_encerrada o WHERE o.aprovNoPrazo='Vencidas' AND cod_usuario = 0 ";
            if($_POST['edNumeroOS_CRM']!=""){
              $consulta = $consulta . " AND o.numero_da_os_crm LIKE '%" . $_POST['edNumeroOS_CRM'] . "%'";
              $consultaTotal = $consultaTotal . " AND o.numero_da_os_crm LIKE '%" . $_POST['edNumeroOS_CRM'] . "%'";
            }
            if($_POST['edID_Ordem']!=""){
              $consulta = $consulta . " AND o.id_da_ordem = '" . $_POST['edID_Ordem'] . "'";
              $consultaTotal = $consultaTotal . " AND o.id_da_ordem = '" . $_POST['edID_Ordem'] . "'";
            }
            if(($_POST['cbBxSetorResponsavel']!="Todos")and($_POST['cbBxSetorResponsavel']!="")){
              $consulta = $consulta . " AND o.gerencia = '" . $_POST['cbBxSetorResponsavel'] . "'";
              $consultaTotal = $consultaTotal . " AND o.gerencia = '" . $_POST['cbBxSetorResponsavel'] . "'";
            }
            if(($_POST['edDtInicio']!="")and($_POST['edDtFinal']!="")){
              $consulta = $consulta . " AND o.diaEncerramento BETWEEN '" . formataData($_POST['edDtInicio']) . "' AND '" . formataData($_POST['edDtFinal']) . "' ";
              $consultaTotal = $consultaTotal . " AND o.diaEncerramento BETWEEN '" . formataData($_POST['edDtInicio']) . "' AND '" . formataData($_POST['edDtFinal']) . "' ";
            }
            //$consulta = $consulta . " ORDER BY o.codigo,o.diaEncerramento LIMIT 50";
            if($_POST['edPagina']!=""){
              $iniLimt = (50 * $_POST['edPagina']);// + 1;
              $consulta = $consulta . " ORDER BY o.codigo,o.diaEncerramento LIMIT " . $iniLimt . ",50";
            }
            else{
              $consulta = $consulta . " ORDER BY o.codigo,o.diaEncerramento LIMIT 50";
            }
            $dadosRes = $bd->selecionaDados($consulta);
            $dadosTotal = $bd->selecionaDados($consultaTotal);
            
            echo "<table id='tblDadosSDH' border='1' align='center' cellpadding='10' cellpacing='1'>";
              echo "<tr>";
                echo "<th>ID da Ordem</th>";
                echo "<th>Nº OS CRM</th>";
                echo "<th>Data Fechamento</th>";
                echo "<th>Tmp Aprov.</th>";
                echo "<th>Setor</th>";
                echo "<th>Responsabilidade</th>";
                echo "<th>Motivo</th>";
                echo "<th>Salvar</th>";
              echo "</tr>";

            $total = count($dadosRes);

            if($total<>0){
              echo "<form name='mostraOS_ForaPrazo' method='POST' action='salvaJustificativa.php'>";
              $resMotivo = $bd->selecionaDados("SELECT * FROM motivos_vencimento_os m WHERE m.ativo=1 ORDER BY m.codigo");
              $totMotivo = count($resMotivo);
              $resSetores = $bd->selecionaDados("SELECT * FROM setores_responsabilidade s WHERE s.ativo=1 ORDER BY s.codigo");
              $totSetores = count($resSetores);
            
              $i = 0;
              foreach($dadosRes as $mostra){
                echo "<tr align='center'>";
                ?>
                <td>
                <table>
                  <a href="<?php echo "#" . $mostra->codigo; ?>" name='modal'><?php echo $mostra->id_da_ordem ?></a>
                  <div id="boxes">
                    <div id="<?php echo $mostra->codigo; ?>" class="window dialog">
                    <a href="#" class="close">Fechar [X]</a>
                    <div style="border-bottom:#999999 solid 1px; margin-top:5px;"></div>
                      <br/>
                        <?php
                          echo "<fieldset>";
                          echo "<legend>&nbsp;&nbsp;Dados da OS Encerrada&nbsp;&nbsp;</legend>";
                          echo "<p><b>";
                            echo "Código: " . "</b>" . $mostra->codigo;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Nome do Cliente: " . "</b>" . $mostra->nome_do_cliente;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Nome do Consultor: " . "</b>" . $mostra->nome_do_consultor;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Nº OS: " . "</b>" . $mostra->numero_da_os_crm;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "ID da Ordem: " . "</b>" . $mostra->id_da_ordem;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Nº Terminal: " . "</b>" . $mostra->numero_do_terminal;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Produto: " . "</b>" . $mostra->produto;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Modalidade: " . "</b>" . $mostra->modalidade;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Tipo da OS: " . "</b>" . $mostra->tipo_da_os;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Tipo: " . "</b>" . $mostra->tipo;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Estado: " . "</b>" . $mostra->estado;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Status do Processo: " . "</b>" . $mostra->status_do_processo;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Multifilial: " . "</b>" . $mostra->multifilial;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Velocidade do Circuito: " . "</b>" . $mostra->velocidade_do_circuito;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Data Solicitação: " . "</b>" . $mostra->data_da_solicitacao;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Data Criação da Ordem: " . "</b>" . $mostra->data_de_criacao_da_ordem;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Data Promessa: " . "</b>" . $mostra->data_promessa;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Data Aprazamento: " . "</b>" . $mostra->data_aprazamento;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Data Esperada Finalização: " . "</b>" . $mostra->data_esperada_para_finalizacao_da_ordem;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Data Fechamento OS: " . "</b>" . $mostra->data_de_fechamento_da_os;
                          echo "</p>";
                          echo "<p><b>";
                            echo "Aprovisionada no Prazo: " . "</b>" . $mostra->aprovNoPrazo;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Gerência: " . "</b>" . $mostra->gerencia;
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            echo "Dia Encerramento: " . "</b>" . formataData_2($mostra->diaEncerramento);
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
                echo "<td>" . $mostra->numero_da_os_crm . "</td>";
                echo "<td>" . $mostra->data_de_fechamento_da_os . "</td>";
                echo "<td>";
                  $str = str_replace(",", ".", $mostra->tempo_cnbrt_c); //substitui todas as vírgulas por ponto
                  $format = number_format($str, 2, '.',''); //formatando número
                  echo $format;
                echo "</td>";
                echo "<td>" . $mostra->gerencia . "</td>";
                echo "<td>";
                //echo "<select name='cbBxSetores" . $mostra->codigo . "' size='1' style='width: 150px;'>";

                echo "<select name='cbBxSetores[]' size='1' style='width: 150px;'>";
                      echo "<option value='' selected>";
                if($totSetores>0){
                  foreach($resSetores as $mostraSetores){
                    echo "<option value='" . $mostraSetores->nome . "'>" . $mostraSetores->nome . "</option>";
                  }
                }
                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo "<select name='cbBxMotivo[]' size='1' style='width: 150px;'>";
                echo "<option value='' selected>";
                if($totMotivo>0){
                  foreach($resMotivo as $mostraMotivo){
                    echo "<option value='" . $mostraMotivo->motivo . "'>" . $mostraMotivo->motivo . "</option>";
                  }
                }
                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo "<input type='checkbox' name='ckBxSalva[]' value='" . $i . "'/>";
                echo "<input type='hidden' name='edCodigo[]' value='" . $mostra->codigo . "' size='1' />";
                $i++;
                echo "</td>";
             echo "</tr>";
            }
            }
            echo "</table>";
            echo "<br>";
            echo "<center><i>";
            echo "<input type='submit' name='btnSalvar' value='Salvar' class='buttonsSalvar'/>";
            echo "<br><br>";

            echo "OS's Página: " . $total;
            echo "</i></center>";
            echo "</form>";
            
            $totPaginas = $dadosTotal[0]->total / 50;
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
            
        ?>
      </body>
</html>

