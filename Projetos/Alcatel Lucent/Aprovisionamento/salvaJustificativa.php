<?php
  /* Salvar Justificativa de OS's Encerradas
     Jonas da Silva Azevedo
     Criado: 22/01/2010 - 13:38
  */
  require("sessao.php");
  require("conexaoBD.php");
  $bd = new conexao("localhost","root","","aprovisionamento");

  ini_set("session.save_path","C:\wamp\www\aprovisionamento\Sessions"); //muda diretório que será salva a sessãos
  session_start();
  
  echo "<link rel='stylesheet' type='text/css' href='estilos.css' />";

  echo "<center>";
  echo "<b>";
  echo "<h2>";
  echo "<br><br><br><br><br><br>";

  $motivos = $_POST['cbBxMotivo'];
  $setores = $_POST['cbBxSetores'];
  $salva = $_POST['ckBxSalva'];
  $codigo = $_POST['edCodigo'];

  if($salva!=null){
    echo "Você será redirecionado em instantes!";
    echo "</h2>";
    echo "</b>";
    foreach($salva as $res){
      $idx = $res;
      $sql;
      if(($motivos[$idx]!="")and($setores[$idx]!="")){
        $sql = "UPDATE os_encerrada SET motivo_vencimento='" . $motivos[$idx] . "', setor_responsavel='" . $setores[$idx];
        $sql = $sql . "', cod_usuario=" . $_SESSION['codigoUsuario'] .  ", data_justificativa=CURRENT_TIMESTAMP WHERE codigo=" . $codigo[$idx];
        if(!($editou = $bd->executaSQL($sql))){
          echo "Erro para editar o ID de código " . $codigo[$idx];
        }
        else {
          echo "Gravação realizada com sucesso para o ID " . $codigo[$idx];
          echo "<br>";
        } //else {
      } //if(($motivos[$idx]!="")and($setores[$idx]!="")){
    } //foreach($salva as $res){
  } //if($salva!=nul){
  else{
    echo "Nenhum registro selecionado para edição!";
    echo "</h2>";
    echo "</b>";
  }
    
  echo "</center>";
  echo "<meta http-equiv='refresh' content='0;url=./osJustificar.php?pesquisar=true'>";
?>
