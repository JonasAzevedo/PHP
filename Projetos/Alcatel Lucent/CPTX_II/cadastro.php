<?php
    session_start();
    require("sessao.php");
    require("conexao.php");
    $bd = new conexao("localhost","root","","os_sac");
    
    include("menuPrincipal.html");
    
    function formataData($dataFormatar){
      $dataExp = explode(" ", $dataFormatar);
      $dataData = explode("-", $dataExp[0]);
      $data = $dataData[2] . "/" . $dataData[1] . "/" . $dataData[0] . " " . $dataExp[1];
      return $data;
    }
    
    //pesquisar por circuito
    if($_GET['acao']=="pesquisar"){
      $sql = "SELECT * FROM os WHERE filial='" . $_POST['cad_edPesFilial'] . "' AND circuito='" . $_POST['cad_edPesCircuito'] . "' ";
      $sql = $sql . "ORDER BY data_executou";
      $pesqCirc = $bd->selecionaDados($sql);
      $totalCirc = count($pesqCirc);
      if($totalCirc != 0){
        ?>
        <script language="JavaScript">
          window.alert("Circuito ja cadastrado");
        </script>
        <?php
      } //$total != 0
    }//pesquisar
    
    //cadastrar circuito
    if($_GET['acao']=="cadastrar"){
      $dat = formataData($_POST['cad_edData']);
      $sqlOS = "INSERT INTO os(cod_usuario,filial,circuito,velocidade,tipo,data_executou,flag_pendencia,pendencia,";
      $sqlOS = $sqlOS . "descricao_pendencia,flag_objectel,status_objectel,descricao_objectel,obs_cadastro_mesma_data,";
      $sqlOS = $sqlOS . "obs_finalizacao_os,data_cadastro)";
      $sqlOS = $sqlOS . "VALUES('" . $_SESSION['codigoUsuario'] . "','" . $_POST['cad_edFilial'] . "','" . $_POST['cad_edCircuito'] . "','" ;
      $sqlOS = $sqlOS . $_POST['cad_edVelocidade'] . "','" . $_POST['cad_edTipoCirc'] . "','" . $dat . "','";
      $sqlOS = $sqlOS . $_POST['cad_edFlagPendencia'] . "','" . $_POST['cad_edPendencia'] . "','";
      $sqlOS = $sqlOS . $_POST['cad_edDescPendencia'] . "','" . $_POST['cad_edFlagObjectel'] . "','";
      $sqlOS = $sqlOS . $_POST['cad_edStatusObjectel'] . "','" . $_POST['cad_edDescObjectel'] . "','";
      $sqlOS = $sqlOS . $_POST['cad_edObsCadastroMesmaData'] . "','" . $_POST['cad_edObsFinalizacaoOS'] . "',";
      $sqlOS = $sqlOS . "CURRENT_TIMESTAMP)";
      if($bd->executaSQL($sqlOS)){
        ?>
        <script language="JavaScript">
          window.alert("Circuito cadastrado com sucesso");
        </script>
        <?php
      }
      else{
        ?>
        <script language="JavaScript">
          window.alert("Circuito nao pode ser cadastrado");
        </script>
        <?php
      }
    }//os
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <!-- European format dd-mm-yyyy -->
    <script language="JavaScript" src="./js/calendar/calendar1.js"></script><!-- Date only with year scrolling -->
    <!-- American format mm/dd/yyyy -->
    <script language="JavaScript" src="./js/calendar/calendar2.js"></script><!-- Date only with year scrolling -->
    
    <script language="JavaScript" src="./js/pgCadastro.js">
    </script>

    <link rel="stylesheet" href="./estilos/pgCadastro.css" type="text/css" />
    
    <title>Cadastro de OS's</title>
  </head>

  <!-- montando cabeçalho body -->
  <?php
    if($_GET['acao']=="pesquisar"){
      if($totalCirc != 0){
        echo "<body onLoad='exibeCamposCircuito(1);'>";
      }
      else{
        echo "<body onLoad='inicio();'>";
      }
    }
    else{
      echo "<body onLoad='inicio();'>";
    }
  ?>
    <!-- dados para cadastro de um circuito -->
    <p class="titulo"> Registro de Circuitos: </p>

    <!-- circuito -->
    <div class="grupoOpc" id="cxCircuito1">
      <div class="grupoTitulo">
        <span class="descricao1">Circuito: </span>
      </div>
      <div class="grupoDados">
        <!-- filial -->
        <select name="cbSelFilial" id="cbSelFilial" onChange="verificaCircuito(this.id);">
          <?php
            $filiais = array('FNS','PAE','BSA','GNA','CPE','CBA','CTA','PVO','RBO','PLT');
            $totFiliais = count($filiais);
            echo "<option value=\"#\""; if($_GET['acao']=="pesquisar"){if($_POST['cad_edPesFilial']=="#"){
                                          echo "select=\"selected\"";}} echo "></option>";
            for($x=0; $x<$totFiliais; $x++) {
              echo "<option value=\"$filiais[$x]\"";
              if($_GET['acao']=="pesquisar"){if( $_POST['cad_edPesFilial']==$filiais[$x]){
                echo " selected=\"selected\"";}}
              echo ">$filiais[$x]</option>";
            }
          ?>
        </select> &nbsp;&nbsp;&nbsp;
        <!-- circuito -->
        <input type="text" name="edCircuito" id="edCircuito" size="7" maxlength="7" value="<?php if($_GET['acao']=="pesquisar") {echo $_POST["cad_edPesCircuito"];} ?>" onKeyUp="verificaCircuito(this.id);" />
      </div>
    </div>
    <!-- velocidade -->
    <div class="grupoOpc" id="cxCircuito2">
      <div class="grupoTitulo">
        <span class="descricao1"> Velocidade: </span>
      </div>
      <div class="grupoDados">
        <input type="text" name="edVelocidade" id="edVelocidade" size="4" maxlength="5"
        value="<?php if($_GET['acao']=="pesquisar") {
                       if($total==1){
                         echo $pesqCirc[0]->velocidade;
                       }
                       else{
                         echo $_POST['cad_edPesVelocidade'];
                       }
                     }
                     else{
                       echo "E1";
                     }
               ?>" onBlur="verificaCircuito(this.id);" /> &nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="ckBxTipCirc" id="ckBxTipCirc" onClick="verificaVelocidade();" onBlur="verificaCircuito(this.id);"
        <?php if($_GET['acao']=="pesquisar") {
                if($total==1){
                  if ($pesqCirc[0]->tipo=="FE"){
                    echo "checked=true";
                  }
                }
                else{
                  if ($_POST['cad_edPesTipoCirc']=="FE"){
                    echo "checked=true";
                  }
                }
              }
        ?> /> FE
      </div>
    </div>
    <!-- data de execução -->
    <div class="grupoOpc" id="cxCircuito3">
      <div class="grupoTitulo">
        <span class="descricao1"> Data de Execução: </span>
      </div>
      <div class="grupoDados">
        <form name="form_mnt" id="form_mnt">
          <input type="text" name="edDataExec" id="edDataExec" size="16" maxlength="19"
          value="<?php if($_GET['acao']=="pesquisar") {
                         if($total==1){
                           echo $pesqCirc[0]->data_executou;
                         }
                         else{
                           echo $_POST['cad_edPesDataExecucao'];
                         }
                       }
                 ?>" />
          <a href="javascript:cal3.popup();" id="lnkData" ><img src="./imagens/calendar/cal.gif" width="16" height="16" border="0" alt="Clique aqui para selecionar uma data"></a>&nbsp;
        </form>
        <script language="JavaScript">
          document.getElementById('edDataExec').disabled = true;
   	      var cal3 = new calendar1(document.forms['form_mnt'].elements['edDataExec']);
	      cal3.year_scroll = true;
	      cal3.time_comp = true;
        </script>
      </div>
    </div>
    <!-- descrição -->
    <div  class="grupoOpc" id="cxCircuito4">
      <div class="grupoTitulo">
        <span class="descricao1"> Descrição: </span>
      </div>
      <div class="grupoDados">
        <textarea name="mmDescricao" id="mmDescricao" rows="2" cols="30" ><?php if($_GET['acao']=="pesquisar") {if($total==1){echo $pesqCirc[0]->descricao;}else{echo $_POST["cad_edPesDescricao"];}}?></textarea>
      </div>
    </div>
    <br />
    <!-- pendência -->
    <div  class="grupoOpc" id="cxPendencia1">
      <div class="grupoTitulo">
        <span class="descricao1">Pendência:</span>
      </div>
      <div class="grupoDados">
        <input type="radio" name="rdBtnPendencia" id="rdBtnPendenciaNao" value="nao" OnClick="verificaPendencia();">Não &nbsp;&nbsp;&nbsp;
        <input type="radio" name="rdBtnPendencia" id="rdBtnPendenciaSim" value="sim" OnClick="verificaPendencia();">Sim
      </div>
      <div class="grupoTitulo" id="cxTitCodPend">
        <span class="descricao2"> Código da Pendência: </span> <br />
      </div>
      <div class="grupoDados" id="cxCodPend">
        <select name="selCodPen" id="selCodPen">
          <option value="4026">4026 - COMERCIAL</option>
          <option value="3500">3500 - RPI</option>
          <option value="3031">3031 - GPRD</option>
        </select> <br />
      </div>
      <div class="grupoTitulo" id="cxTitJustPend">
        <span class="descricao2">Justificativa:</span>
      </div>
      <div class="grupoDados" id="cxJustPend">
        <textarea name="mmJustificativaPendencia" id="mmJustificativaPendencia" rows="2" cols="30" onKeyUp="verificaPendencia();"></textarea>
      </div>
    </div>
    <br />
    <!-- objectel -->
    <div  class="grupoOpc" id="cxObjectel1">
      <div class="grupoTitulo">
        <span class="descricao1">Objectel:</span>
      </div>
      <div class="grupoDados">
        <input type="radio" name="rdBtnObjectel" id="rdBtnObjectelCompleto" value="completo" onClick="verificaObjectel();">Completo &nbsp;&nbsp;&nbsp;
        <input type="radio" name="rdBtnObjectel" id="rdBtnObjectelIncompleto" value=iIncompleto" onClick="verificaObjectel();">Incompleto
      </div>
      <div class="grupoTitulo" id="cxTitObjJust">
        <span class="descricao2">Justificativa:</span>
      </div>
      <div class="grupoDados" id="cxObjJust">
        <textarea name="mmJustificativaObjectel" id="mmJustificativaObjectel" rows="2" cols="30"></textarea>
      </div>
    </div>
    <br /><br />
    <div class="grupoOpcBotoes" id="cxBotoes">
      <a href="#" name="lkInserir" id=="lkInserir" class="lnkInserir" onClick="validaInserir();">INSERIR</a>
      <a href="#"  name="lkLimpar" id=="lkLimpar" class="lnkLimpar" onClick="limpar();">LIMPAR</a>
    </div>
    
    <br /><br />

    <div class="dadosCircExistente" id="cxCircuitoExist">
      <?php
      if($totalCirc != 0){
        $pend = "";
        $obj = "";
        foreach($pesqCirc as $mostra){
          if($mostra->flag_pendencia == 1){
            $pend = $pend . "USUARIO: " . $mostra->cod_usuario . "<br />";
            $pend = $pend . "PENDENCIA: " . $mostra->pendencia . "<br />";
            $pend = $pend . "DESCRIÇAO: " . $mostra->descricao_pendencia . "<br />";
            $pend = $pend . "DATA: " . formatadata($mostra->data_executou) . "<br />";
            $pend = $pend . "<br /> <br />";
          }
          if($mostra->flag_objectel == 1){
            $obj = $obj . "STATUS: " . $mostra->status_objectel . "<br />";
            $obj = $obj . "DESCRIÇAO: " . $mostra->descricao_objectel . "<br />";
            $obj = $obj . "DATA: " . formatadata($mostra->data_executou) . "<br />";
            $obj = $obj . "<br /> <br />";
          }
        }
      }
      
      if($pend != ""){
        echo "<center>";
        echo "<h4>" . "PENDENCIA" . "</h4>";
        echo "</center>";
        echo $pend;
      }
      if($obj != ""){
        echo "<center>";
        echo "<h4>" . "OBJECTEL" . "</h4>";
        echo "</center>";
        echo $obj;
      }
      ?>
    </div>

    <!-- pesquisando por registro -->
    <form name="frmPesqCirc" id="frmPesqCirc" method="POST" action="<?php echo $PHP_SELF; ?>?acao=pesquisar">
      <input type="hidden" name="cad_edPesFilial" id="cad_edPesFilial"/>
      <input type="hidden" name="cad_edPesCircuito" id="cad_edPesCircuito" />
      <input type="hidden" name="cad_edPesVelocidade" id="cad_edPesVelocidade" />
      <input type="hidden" name="cad_edPesTipoCirc" id="cad_edPesTipoCirc" />
      <input type="hidden" name="cad_edPesDataExecucao" id="cad_edPesDataExecucao" />
      <input type="hidden" name="cad_edPesDescricao" id="cad_edPesDescricao" />
    </form>

    <!-- cadastrando um novo registro -->
    <form name="frmRegistro" method="POST" action="<?php echo $PHP_SELF; ?>?acao=cadastrar">
      <input type="hidden" name="cad_edFilial" id="cad_edFilial" />
      <input type="hidden" name="cad_edCircuito" id="cad_edCircuito" />
      <input type="hidden" name="cad_edVelocidade" id="cad_edVelocidade"/>
      <input type="hidden" name="cad_edTipoCirc" id="cad_edTipoCirc" />
      <input type="hidden" name="cad_edData" id="cad_edData" />
      <input type="hidden" name="cad_edFlagPendencia" id="cad_edFlagPendencia" />
      <input type="hidden" name="cad_edPendencia" id="cad_edPendencia" />
      <input type="hidden" name="cad_edDescPendencia" id="cad_edDescPendencia" />
      <input type="hidden" name="cad_edFlagObjectel" id="cad_edFlagObjectel" />
      <input type="hidden" name="cad_edStatusObjectel" id="cad_edStatusObjectel" />
      <input type="hidden" name="cad_edDescObjectel" id="cad_edDescObjectel" />
      <input type="hidden" name="cad_edObsCadastroMesmaData" id="cad_edObsCadastroMesmaData" />
      <input type="hidden" name="cad_edObsFinalizacaoOS" id="cad_edObsFinalizacaoOS" />
    </form>

  </body>

</html>

<!-- Cadastro de Circuitos
       autor: Jonas da Silva Azevedo
       criado em: 03/03/2010 - 20:00
       última modificação: 08/03/2010 - 20:26
-->
