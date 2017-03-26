<HTML>
<HEAD>
 <script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>
</HEAD>
<BODY>
  <div id="camada" style="padding: 10px; background-color: #ff8800">Clique em um botão</div>
  <input type="button" value="Botão A" onclick="$('#camada').html('Clicou no botão <b>A</b>')">
  <input type="button" value="Botão B" onclick="$('#camada').html('Recebido um clique no botão <b>B</b>')">
  
  <br /><br /><br />
  <span id="camadaSPAN" style="padding: 10px; background-color: #789">Clique em um botão</span>
  <input type="button" value="Botão A" onclick="$('#camadaSPAN').html('Clicou no botão <b>A</b>')">
  <input type="button" value="Botão B" onclick="$('#camadaSPAN').html('Recebido um clique no botão <b>B</b>')">

</BODY>
</HTML>
