<?php
/*
************************************************************************************************************
*
* 	CREATED ON 11/01/2010  by Jonas da Silva Azevedo
* 			CONTATO: jonassazevedo@hotmail.com
*
*  		ÚLTIMA MODIFICAÇÃO   13/01/2010 by Jonas da Silva Azevedo
*
************************************************************************************************************
* 			::::: Sistema de Gerenciamento de Rotas SDH Inviáveis :::: (Alcatel-Lucent)
************************************************************************************************************
*/
  include("conecta.php");
  include("sessao.php");
  if($_GET['pesquisar']==true){
    $pes=true;
  }
  else {
    $pes=false;
  }
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    
    <script type="text/javascript" src="./jQuery/js/jquery-1.3.2.min.js">
    </script>
    <!--
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js">
    // -->
    <script type="text/javascript">
      <!--
        function deleta(rota,url) {
          var valida;
          valida = confirm('Tem certeza que deseja deletar a rota '+ rota +' ?')
          if(valida == true) {
            window.open(url,'_self');
          }

        }
      // -->
    </script>
    <script type="text/javascript">
      <!--
      $(document).ready(function() {
        $('a[name=modal]').click(function(e) {
     	  e.preventDefault();

		  var id = $(this).attr('href');

          var maskHeight = $(document).height();
          var maskWidth = $(window).width();

		  $('#mask').css({'width':maskWidth,'height':maskHeight});

		  $('#mask').fadeIn(1000);
		  $('#mask').fadeTo("slow",0.8);

		  //Get the window height and width
		  var winH = $(window).height();
		  var winW = $(window).width();

		  $(id).css('top',  winH/2-$(id).height()/2);
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
      body {
        font-family:verdana;
        font-size:15px;
      }

      a { text-decoration:none}
      a:hover { text-decoration:none}

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
        width:800px;
        height:500px;
        padding:10px;
        background-color:#ffffff;
      }

      .close{display:block; text-align:right;}
      // -->
    </style>

    <link rel="StyleSheet" href="estilos.css" type="text/css"/>
    <title>Consulta de SDH Inviáveis</title>
    </head>
      <body>
        <center>
          <p>
          <h6>
            <a href='logoff.php'>Sair</a>
          </h6>
          </p>
          <p>
          <h4>
            <a href="index.php">Principal</a> &nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="cadastroSDH.php?opcao=consulta">Cadastrar Rota</a>
          </h4>
          </p>
          <h1>Consulta de Rotas SDH Inviáveis</h1>
        </center>
        <p></p>
        <form name="consultaSDH" method="POST" action="<?php echo $PHP_SELF;?>?pesquisar=true">
          <p><b>Rota:</b> <input type="text" name="edRota" size="30" maxlength="200" value="<?php if($pes == true){echo $_POST['edRota'];} ?>"/>&nbsp;&nbsp;&nbsp;
          <b>Anel:</b> <input type="text" name="edAnel" size="30" maxlength="200" value="<?php if($pes == true){echo $_POST['edAnel'];}?>"/>&nbsp;&nbsp;&nbsp;
          <b>Plataforma:</b> <input type="radio" name="rdBtnPlataforma" value="Todas" <?php if($pes == true){if($_POST['rdBtnPlataforma']=="Todas"){echo "checked";}}else{echo "checked";}?>/>Todas &nbsp;
                             <input type="radio" name="rdBtnPlataforma" value="Marconi" <?php if($pes == true){if($_POST['rdBtnPlataforma']=="Marconi"){echo "checked";}}?>/>Marconi &nbsp;
                             <input type="radio" name="rdBtnPlataforma" value="Alcatel" <?php if($pes == true){if($_POST['rdBtnPlataforma']=="Alcatel"){echo "checked";}}?>/>Alcatel &nbsp;
                             <input type="radio" name="rdBtnPlataforma" value="Siemens" <?php if($pes == true){if($_POST['rdBtnPlataforma']=="Siemens"){echo "checked";}}?>/>Siemens &nbsp;&nbsp;&nbsp;
          <b>Filial:</b> <select name="cbBxFilial" size="1" style="width: 100px;">
                                       <option value="Todas" selected>Todas</option>
                                       <option value="AC"<?php if($pes == true){if($_POST['cbBxFilial']=="AC"){echo "selected";}}?>>AC</option>
                                       <option value="MS"<?php if($pes == true){if($_POST['cbBxFilial']=="MS"){echo "selected";}}?>>MS</option>
                                       <option value="MT"<?php if($pes == true){if($_POST['cbBxFilial']=="MT"){echo "selected";}}?>>MT</option>
                                       <option value="RO"<?php if($pes == true){if($_POST['cbBxFilial']=="RO"){echo "selected";}}?>>RO</option>
                                       <option value="GO"<?php if($pes == true){if($_POST['cbBxFilial']=="GO"){echo "selected";}}?>>GO</option>
                                       <option value="TO"<?php if($pes == true){if($_POST['cbBxFilial']=="TO"){echo "selected";}}?>>TO</option>
                                       <option value="RS"<?php if($pes == true){if($_POST['cbBxFilial']=="RS"){echo "selected";}}?>>RS</option>
                                       <option value="PR"<?php if($pes == true){if($_POST['cbBxFilial']=="PR"){echo "selected";}}?>>PR</option>
                                       <option value="SC"<?php if($pes == true){if($_POST['cbBxFilial']=="SC"){echo "selected";}}?>>SC</option>
                                     </select>
          </p>
          <p align="center">
            <input type="submit" value="Pesquisar" style="width: 200px; height: 35px; font-weight: bold;"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="reset" value="Limpar" style="width: 200px; height: 35px; font-weight: bold;"/>
          </p>
          <p>
            <hr size="1" width="100%" align="center" noshade>
          </p>
        </form>
        <?php
          if($_GET['pesquisar']==true){
            $consulta = "SELECT r.*,u.nome FROM rotasdh r, usuario u WHERE status<>2 AND r.cod_usuario_cadastrou=u.codigo";
            if($_POST['edRota']!=""){
              $consulta = $consulta . " AND r.rota LIKE '%" . $_POST['edRota'] . "%'";
            }
            if($_POST['edAnel']!=""){
              $consulta = $consulta . " AND r.anel LIKE '%" . $_POST['edAnel'] . "%'";
            }
            if($_POST['rdBtnPlataforma']!="Todas"){
              $consulta = $consulta . " AND r.plataforma = '" . $_POST['rdBtnPlataforma'] . "'";
            }
            if($_POST['cbBxFilial']!="Todas"){
              $consulta = $consulta . " AND r.filial = '" . $_POST['cbBxFilial'] . "'";
            }
            $consulta = $consulta . " ORDER BY r.codigo";

            $resultado = mysql_query($consulta);
            echo "<table id='tblDadosSDH' border='1' align='center' cellpadding='10' cellpacing='1'>";
              echo "<tr>";
                echo "<th>Usuário Cadastrou</th>";
                echo "<th>Rota</th>";
                echo "<th>Anel</th>";
                echo "<th>Plataforma</th>";
                echo "<th>Filial</th>";
                echo "<th>Exibir</th>";
                echo "<th>Editar</th>";
                echo "<th>Excluir</th>";
              echo "</tr>";
            
              while($linha = mysql_fetch_array($resultado)){
                echo "<tr align='center'>";
                  echo "<td>" . $linha['nome'] . "</td>";
                  echo "<td>" . $linha['rota'] . "</td>";
                  echo "<td>" . $linha['anel'] . "</td>";
                  echo "<td>" . $linha['plataforma'] . "</td>";
                  echo "<td>" . $linha['filial'] . "</td>";
                  $dataHora = explode(" ", $linha['data_cadastro']);
                  $data = explode("-", $dataHora[0]);
                  ?>
                  <!--Exibir-->
                  <td>
                    <table>
                      <a href="<?php echo "#" . $linha['codigo']; ?>" name='modal'>Exibir</a>
                      <div id="boxes">
                        <div id="<?php echo $linha['codigo']; ?>" class="window dialog">
                          <a href="#" class="close">Fechar [X]</a>
                          <div style="border-bottom:#999999 solid 1px; margin-top:5px;"></div>
                          <br/>
                          <?php
                          echo "<fieldset>";
                          echo "<legend>&nbsp;&nbsp;Rota SDH:&nbsp;&nbsp;</legend>";
                          echo "<b>";
                          echo "<p>";
                          echo "Código: " . "</b>" . $linha['codigo'];
                          echo "</p>";
                          echo "<b>";
                          echo "<p>";
                          echo "Usuário Cadastrou: " . "</b>" . $linha['nome'];
                          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                          echo "<b>";
                          echo "Data do Cadastro: " . "</b>" . $data[2] . "/" . $data[1] . "/" . $data[0] . " - " . $dataHora[1];
                          echo "</p>";
                          echo "<b>";
                          echo "<p>";
                          echo "Rota: " . "</b>" . $linha['rota'];
                          echo "</p>";
                          echo "<b>";
                          echo "<p>";
                          echo "Anel: " . "</b>" . $linha['anel'];
                          echo "</p>";
                          echo "<b>";
                          echo "<p>";
                          echo "Plataforma: " . "</b>" . $linha['plataforma'];
                          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                          echo "<b>";
                          echo "Filial: " . "</b>" . $linha['filial'];
                          echo "</p>";
                          echo "<b>";
                          echo "<p>";
                          echo "Indisponibilidade: " . "</b>" . $linha['indisponibilidade'];
                          echo "</p>";
                          echo "<b>";
                          echo "<p>";
                          echo "Rota Alternativa: " . "</b>" . $linha['rota_alternativa'];
                          echo "</p>";
                          if(isset($linha['cod_usuario_editou'])){
                            $sqlEditou = "SELECT * FROM usuario WHERE codigo=" . $linha['cod_usuario_editou'];
                            $buscaEditou = mysql_query($sqlEditou);
                            $linhaEditou = mysql_fetch_array($buscaEditou);
                            echo "<b>";
                            echo "<p>";
                            echo "Usuário Atualizou: " . "</b>" . $linhaEditou['nome'];
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "<b>";
                            $dataHoraEditou = explode(" ", $linha['ultima_edicao']);
                            $dataEditou = explode("-", $dataHoraEditou[0]);
                            echo "Data Atualização: " . "</b>" . $dataEditou[2] . "/" . $dataEditou[1] . "/" . $dataEditou[0] . " - " . $dataHoraEditou[1];
                            echo "</p>";
                          }
                          echo "</fieldset>";
                          ?>
                        </div>
                        <!-- Máscara para cobrir a tela -->
                        <div id="mask"></div>
                      </div>
                    </table>
                  </td>
                  <?php
                  echo "<td> <a href=" . "cadastroSDH.php?opcao=consulta&codigo=" . $linha['codigo'] . ">Editar</a> </td>";
                  echo "<td> <input type='button' name='excluir' value='excluir' onclick=\"deleta('".$linha['rota']."','deletaRotaSDH.php?opcao=consulta&codigo=" . $linha['codigo'] . "')\"</td>";
                echo "</tr>";
              }
            echo "</table>";
            
            echo "<br>";
            echo "<center><b>";
            $total = mysql_num_rows($resultado);
            echo "Total de Rotas SDH encontradas: " . $total;
            echo "</b></center>";
          }
        ?>

      </body>
      
      
</html>
