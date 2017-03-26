<?php
  /* tela principal do motivos de vencimento das OS's
  Jonas da Silva Azevedo
  Criado: 25/01/2010 - 09:20
*/
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");
  //código adaptado - POG
  if($_GET['pesquisar']==true){
    $pes=true;
  }
  else {
    $pes=true;
  }
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js">
    </script>
    <script type="text/javascript">
      <!--
        function deleta(motivo,url) {
          var valida;
          valida = confirm('Tem certeza que deseja deletar o motivo '+ motivo +' ?')
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

    <link rel="stylesheet" type="text/css" href="estilos.css" />
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
        width:800px;
        height:500px;
        padding:10px;
        background-color:#ffffff;
      }
      .close{display:block; text-align:right;}
      // -->
    </style>

    <title>Motivos dos Vencimentos das OS's</title>
    </head>
      <body>
        <center>
          <p>
            <a href='logoff.php'>Sair</a>
          </p>
          <p>
            <a href="index.php">Principal</a> &nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="cadMotivoVencimentoOS.php?opcao=consulta">Cadastrar Motivo Vencimento</a>
          </p>
          <h2>Motivo Vencimento OS's</h2>
        </center>
        <p></p>
        <form name="consultaMotivoVencimento" method="POST" action="<?php echo $PHP_SELF;?>?pesquisar=true">
          <p align="center"><b>Status:</b> <select name="cbBxStatus" size="1" style="width: 100px;">
                              <option value=" " selected></option>
                              <option value="1" <?php if($pes==true){if($_POST['cbBxStatus']=="1"){echo "selected";}} ?>>Ativo</option>
                              <option value="2" <?php if($pes==true){if($_POST['cbBxStatus']=="2"){echo "checked";}} ?>>Inativo</option>
                            </select>&nbsp;&nbsp;&nbsp;
             <b>Motivo:</b> <input type="text" name="edMotivo" size="150" maxlength="100" value="<?php if($pes==true){echo $_POST['edMotivo'];}?>" />
          </p>
          <p align="center">
            <input type="submit" value="Pesquisar" class="buttons1" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="reset" value="Limpar" class="buttons2" />
          </p>
          <p>
            <hr size="1" width="100%" align="center" noshade>
          </p>
        </form>
        <?php
          if($pes==true){
            $achouWhere=false;
            $consulta = "SELECT m.* FROM motivos_vencimento_os m ";
            if(isset($_POST['cbBxStatus'])){
              if($_POST['cbBxStatus']!=" "){
                $consulta = $consulta . " WHERE m.ativo=" . $_POST['cbBxStatus'];
                $achouWhere=true;
              }
            }
            if(isset($_POST['edMotivo'])){
              if($_POST['edMotivo']!=" "){
                if($achouWhere==false){
                  $consulta = $consulta . " WHERE m.motivo LIKE '%" . $_POST['edMotivo'] . "%'";
                }
                else{
                  $consulta = $consulta . " AND m.motivo LIKE '%" . $_POST['edMotivo'] . "%'";
                }
                $achouWhere=true;
              }
            }
            $consulta = $consulta . " ORDER BY m.codigo";
            $dadosRes = $bd->selecionaDados($consulta);
            $total = count($dadosRes);
            if($total<>0){
            echo "<table id='tblMotivoVencimentoOS' border='1' align='center' cellpadding='10' cellpacing='1'>";
              echo "<tr>";
                echo "<th>Motivo</th>";
                echo "<th>Descrição</th>";
                echo "<th>Status</th>";
                echo "<th>Exibir</th>";
                echo "<th>Editar</th>";
                echo "<th>Excluir</th>";
              echo "</tr>";
              foreach($dadosRes as $mostra){
                echo "<tr align='center'>";
                echo "<td>" . $mostra->motivo . "</td>";
                echo "<td>" . $mostra->descricao . "</td>";
                echo "<td>";
                if($mostra->ativo=="1"){echo "Ativo";}elseif($mostra->ativo=="2"){echo "Inativo";}
                echo "</td>";
                ?>
                <td>
                <table>
                  <a href="<?php echo "#" . $mostra->codigo; ?>" name='modal'>Exibir</a>
                  <div id="boxes">
                    <div id="<?php echo $mostra->codigo; ?>" class="window dialog">
                    <a href="#" class="close">Fechar [X]</a>
                    <div style="border-bottom:#999999 solid 1px; margin-top:5px;"></div>
                      <br/>
                        <?php
                          echo "<fieldset>";
                          echo "<legend>&nbsp;&nbsp;Motivo do Vencimento das OS's&nbsp;&nbsp;</legend>";
                          echo "<b>";
                          echo "<p>";
                          echo "Código: " . "</b>" . $mostra->codigo;
                          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                          echo "<b>" . "Status: " . "</b>";
                          if($mostra->ativo=="1"){echo "Ativo";}elseif($mostra->ativo=="2"){echo "Inativo";}
                          echo "</p>";
                          echo "<p>";
                          echo "<b>";
                          echo "Motivo: " . "</b>" . $mostra->motivo;
                          echo "</p>";
                          echo "<p>";
                          echo "<b>";
                          echo "Descrição: " . "</b>" . $mostra->descricao;
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
                echo "<td> <a href=" . "cadMotivoVencimentoOS.php?opcao=consulta&codigo=" . $mostra->codigo . ">Editar</a> </td>";
                echo "<td> <input type='button' name='excluir' class='buttonsExcluir' value='excluir' onclick=\"deleta('".$mostra->motivo ."','deletaMotivoVencimentoOS.php?opcao=consulta&codigo=" . $mostra->codigo . "')\"</td>";
                echo "</tr>";
                }
                echo "</table>";
                echo "<b>";
                echo "<center>";
                echo "Total de Motivos: " . $total;
                echo "</b></center>";
            }
          }
            ?>
      </body>
</html>
