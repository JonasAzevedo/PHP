<?php
  /* index
  Jonas da Silva Azevedo
*/
  include("conecta.php");
  include("sessao.php");
  if ($_GET['edicao']==true) {
    ?>
    <script language="JavaScript">
      <!--
        alert("Edição realizada com sucesso!")
      // -->
    </script>
    <?php
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
    !-->
    <script type="text/javascript">
        function deleta(rota,url) {
          var valida;
          valida = confirm('Tem certeza que deseja deletar a rota '+ rota +' ?')
          if(valida == true) {
            window.open(url,'_self');
          }
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
       -->
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
       -->
    </style>
    
    <link rel="StyleSheet" href="estilos.css" type="text/css"/>
    <title>ROUTE</title>
  </head>

      <body>
        <center>
            <p>
            <h6>
              <?php
                $hora = date("H");
                if($hora >= 0 && $hora < 12) {
                  echo "Bom Dia " . $_SESSION['nomeUsuario'];
                }
                elseif ($hora > 12 && $hora < 18) {
                  echo "Boa Tarde " . $_SESSION['nomeUsuario'];
                }
                else{
                  echo "Boa Noite " . $_SESSION['nomeUsuario'];
                }
                echo " - Este é o seu acesso nº: " . $_SESSION["totAcessos"];
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "<a href='cadastroUsuario.php?codigo=" . $_SESSION['codigoUsuario'] . "'>Meu Cadastro</a> &nbsp;&nbsp;|&nbsp;&nbsp";
                echo "<a href='logoff.php'>Sair</a>";
              ?>
            </h6>
            </p>
            <p>
            <h4>
              <a href="consultaSDH.php">Pesquisa</a> &nbsp;&nbsp;|&nbsp;&nbsp;
              <a href="cadastroSDH.php?opcao=principal">Cadastrar Rota</a>
            </h4>
            </p>
          <h2>MINHAS ROTAS SDH CADASTRADAS</h2>
        </center>
        <?php
        session_start();
        $sql = "SELECT r.*,u.nome FROM rotasdh r, usuario u WHERE status<>2 AND r.cod_usuario_cadastrou=u.codigo AND u.codigo=" .  $_SESSION['codigoUsuario'];
        $resultado = mysql_query($sql);
        echo "<table id='tblMinhasRotasSDH' border='1' align='center' cellpadding='10' cellpacing='1'>";
          echo "<tr>";
            echo "<th>Rota</th>";
            echo "<th>Anel</th>";
            echo "<th>Plataforma</th>";
            echo "<th>Filial</th>";
            //echo "<th>Data do Cadastro</th>";
            echo "<th>Exibir</th>";
            echo "<th>Editar</th>";
            echo "<th>Excluir</th>";
          echo "</tr>";

          while($linha = mysql_fetch_array($resultado)){
            echo "<tr align='center'>";
              echo "<td>" . $linha['rota'] . "</td>";
              echo "<td>" . $linha['anel'] . "</td>";
              echo "<td>" . $linha['plataforma'] . "</td>";
              echo "<td>" . $linha['filial'] . "</td>";
              $dataHora = explode(" ", $linha['data_cadastro']);
              $data = explode("-", $dataHora[0]);
              //echo "<td>" . $data[2] . "/" . $data[1] . "/" . $data[0] . " - " . $dataHora[1] . "</td>";
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
                      echo "Codigo: " . "</b>" . $linha['codigo'];
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
              echo "<td> <a href=" . "cadastroSDH.php?opcao=principal&codigo=" . $linha['codigo'] . ">Editar</a> </td>";
              //echo "<td> <a href=" . "Excluir.php?codigo=" . $linha['codigo'] . ">Excluir</a>  </td>";
              //echo "<td> <input type='button' name='exclui' value='excluir' onclick='deletaRotaSDH()'> </td>";
              echo "<td> <input type='button' name='excluir' value='excluir' onclick=\"deleta('".$linha['rota']."','deletaRotaSDH.php?opcao=principal&codigo=" . $linha['codigo'] . "')\"</td>";
            echo "</tr>";
          }
        echo "</table>";
        echo "<br>";
        echo "<center><b>";
        $total = mysql_num_rows($resultado);
        echo "Total de Rotas SDH que cadastrei: " . $total;
        echo "</b></center>";
        ?>
      </body>
</html>
