<?php
    session_start();
    require("sessao.php");
    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");

    include("menuPrincipal.html");

    function formataData($dataFormatar){
      $dataExp = explode(" ", $dataFormatar);
      $dataData = explode("-", $dataExp[0]);
      $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0];
      return $data;
    }
    
    function formataDataCadastrar($dataFormatar){
      $dataExp = explode("-", $dataFormatar);
      $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
      return $data;
      
    }
    //cadastrar ausência
    if($_GET['acao']=="cadastrar"){
      $datIni = formataDataCadastrar($_POST['cad_edDataInicio']);
      $datFin = formataDataCadastrar($_POST['cad_edDataFinal']);
      $just = $_POST['cad_edJustificativa'];
      $sql = "INSERT INTO ausencia(cod_usuario,data_inicio,data_final,justificativa,status)";
      $sql = $sql . "VALUES('" . $_SESSION['codigoUsuario'] . "','" . $datIni . "','" . $datFin . "','" . $just . "','0')";
      if($bd->executaSQL($sql)){
        ?>
        <script language="JavaScript">
          window.alert("Ausência cadastrada com sucesso");
        </script>
        <?php
      }
      else{
        ?>
        <script language="JavaScript">
          window.alert("Ausência nao pode ser cadastrada");
        </script>
        <?php
      }
    }//cadastrar ausência
    
    //página que irá mostrar
    if($_GET['acao']=="pesquisar"){
      if(isset($_POST['edPagina'])){
        $pg = $_POST['edPagina'];
      }
      else{
        $pg = 1;
      }
    }
    else{
      $pg = 1;
    }
    $pg--;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <!-- European format dd-mm-yyyy -->
    <script language="JavaScript" src="./js/calendar/calendar1.js"></script><!-- Date only with year scrolling -->
    <!-- American format mm/dd/yyyy -->
    <script language="JavaScript" src="./js/calendar/calendar2.js"></script><!-- Date only with year scrolling -->

    <script language="JavaScript" src="./js/pgAusencia.js">
    </script>

    <link rel="stylesheet" href="./estilos/pgAusencia.css" type="text/css" />

    <title>Ausências</title>
  </head>
  
  <body>
    <!-- tabela das ausências -->
    <div class="grupoAusencias">
      <?php
        $sqlAusencias = "SELECT a.*, u.nome FROM ausencia a, usuario u ";
        $sqlAusencias = $sqlAusencias . "WHERE a.cod_usuario=u.codigo ORDER BY data_inicio DESC LIMIT ".$pg.",7";
        $resAusencia = $bd->selecionaDados($sqlAusencias);
        $totAus = count($resAusencia);
        if($totAus != 0){ //então monta tabela
          echo "<table class='tblAusencias'>";
          echo "<tr>";
            echo "<th>Colaborador</th>";
            echo "<th>Data de Inicio</th>";
            echo "<th>Data Final</th>";
            echo "<th>Justificativa</th>";
          echo "</tr>";
          foreach($resAusencia as $ausencia){ //percorre toda as ausências
          echo "<tr>";
            echo "<td>" . $ausencia->nome . "</td>";
            echo "<td>" . formataData($ausencia->data_inicio) . "</td>";
            echo "<td>" . formataData($ausencia->data_final) . "</td>";
            echo "<td>" . $ausencia->justificativa . "</td>";
          echo "</tr>";
          } //foreach
          echo "</table>";
        }//if($totAus != 0)
        else{
          echo "<span class='spnNenhuma'>";
            echo "Nenhuma Ausência cadastrada!";
          echo "</span>";
        }
      ?>
    </div>
    
    <?php
      //calculando total de páginas
      $sqlTotAusencias = "SELECT COUNT(codigo) AS total FROM ausencia a";
      $resTotAusencias = $bd->selecionaDados($sqlTotAusencias);
      $totPaginas = $resTotAusencias[0]->total / 7; //7 OS's por página
      if(is_int($totPaginas)){
      }
      else{
        $totPaginas++;
      }
      $totPaginas = floor($totPaginas);
    ?>
    
    <!-- paginação -->
    <div class="grupoPaginacao">
      <?php
      $pg++;
      $aux;
      $controle;
        //se existirem páginas
        if($totPaginas > 0){
          //se houver no máximo 5 páginas, mostra todas
          if($totPaginas <= 5){
            for($i=1;$i<=$totPaginas;$i++){
              if($pg == $i){ //se esta é a página selecionada
                echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(".$i.");'>".$i."</a>";
              }
              else{
                echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$i.");'>".$i."</a>";
              }
              echo "&nbsp;&nbsp";
            }
          }
          //se houver mais que 5 páginas
          elseif($totPaginas > 5){
            $controle = $totPaginas - $pg; //saber se a página selecionada está no inicio,meio ou fim, de todas as páginas
            //se a página selecionado é uma das 3 primeiras
            if($pg<=3){
              if($pg==1){
                echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(1);'>1</a>";
              }
              else{
                echo "<a class='lnkPgNormal' href='javascript:mudaPagina(1);'>1</a>";
              }
              if($pg==2){
                echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(2);'>2</a>";
              }
              else{
                echo "<a class='lnkPgNormal' href='javascript:mudaPagina(2);'>2</a>";
              }
              if($pg==3){
                echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(3);'>3</a>";
              }
              else{
                echo "<a class='lnkPgNormal' href='javascript:mudaPagina(3);'>3</a>";
              }
              $aux = $totPaginas-1;
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$aux.");'>></a>";
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
              $controle = -1; //evitar de entrar no bloco errado
            } //if($pg<=3)

            //se a página selecionado é uma das 3 últimas
            if(($controle<=2)and($controle!=-1)){
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(1);'>1</a>";
              $aux = $totPaginas - 3;
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$aux.");'><</a>";
              $aux = $totPaginas - 2;
              if($aux==$pg){
                echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(".$aux.");'>".$aux."</a>";
              }
              else{
                echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$aux.");'>".$aux."</a>";
              }
              $aux = $totPaginas - 1;
              if($aux==$pg){
                echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(".$aux.");'>".$aux."</a>";
              }
              else{
                echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$aux.");'>".$aux."</a>";
              }
              if($totPaginas==$pg){
                echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
              }
              else{
                echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
              }
            } //if(($controle<=2)and($controle!=-1))
            
            //se a página selecionado está no meio do total das páginas
            if(($controle>2)and($controle!=-1)){
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(1);'>1</a>";
              $aux = $pg - 1;
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$aux.");'><</a>";
              echo "<a class='lnkPgSelecionada' href='javascript:mudaPagina(".$pg.");'>".$pg."</a>";
              $aux = $pg + 1;
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$aux.");'>></a>";
              echo "<a class='lnkPgNormal' href='javascript:mudaPagina(".$totPaginas.");'>".$totPaginas."</a>";
            } //if(($controle>2)and($controle!=-1))
          } //elseif($totPaginas > 5)
        } //if($totPaginas > 0)
      ?>

    </div>
    
    <hr class="divisao" />
    
    <!-- cadastrar uma nova ausência -->
    <div class="grupoCadastro">
      <form name="frmAusencia" id="frmAusencia" method="POST" action="<?php echo $PHP_SELF; ?>?acao=cadastrar">
        <span class='spnNovaAusencia'>Nova Ausência:</span>
        <br />
        <span class='spnDtaInicio'>Data Início:</span>
          <input type="text" class="edData" name="edDataInicio" id="edDataInicio" maxlength="10" />
          <a href="javascript:cal1.popup();" class="lnkData" id="lnkDataInicio" ><img class="imgData" src="./imagens/calendar/cal.gif" alt="Clique aqui para selecionar uma data"></a>&nbsp;
          <script language="JavaScript">
            document.getElementById('edDataInicio').disabled = true;
            var cal1 = new calendar1(document.forms['frmAusencia'].elements['edDataInicio']);
            cal1.year_scroll = true;
            cal1.time_comp = false;
          </script>

        <span class='spnDescricao'>Data Final:</span>
          <input type="text" class="edData" name="edDataFinal" id="edDataFinal" maxlength="10" />
          <a href="javascript:cal2.popup();" class="lnkData" id="lnkDataFinal" ><img class="imgData" src="./imagens/calendar/cal.gif" alt="Clique aqui para selecionar uma data"></a>&nbsp;
          <script language="JavaScript">
            document.getElementById('edDataFinal').disabled = true;
            var cal2 = new calendar1(document.forms['frmAusencia'].elements['edDataFinal']);
            cal2.year_scroll = true;
            cal2.time_comp = false;
          </script>

        <span class='spnDescricao'>Justificativa:</span>
          <textarea name="txtAreJustificativa" id="txtAreJustificativa" class="txtAreaJustificativa"></textarea>

        <a href="#" class="lnkInserir" name="lkInserir" id="lkInserir" onClick="validaInserir();">OK</a>
      </form>
    </div>

  <!-- formulário para cadastro -->
  <form name="frmCadastrar" id="frmCadastrar" method="POST" action="<?php echo $PHP_SELF; ?>?acao=cadastrar">
    <input type="hidden" name="cad_edDataInicio" id="cad_edDataInicio" />
    <input type="hidden" name="cad_edDataFinal" id="cad_edDataFinal" />
    <input type="hidden" name="cad_edJustificativa" id="cad_edJustificativa" />
  </form>
  
  <!-- formulário para mudar página -->
  <form name="frmMudarPagina" id="frmMudarPagina" method="POST" action="<?php echo $PHP_SELF; ?>?acao=pesquisar">
    <input type="hidden" name="edPagina" id="edPagina" />
  </form>

  </body>
  
</html>
