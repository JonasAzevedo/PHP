<HTML>
<HEAD>
 <script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>
</HEAD>
<BODY>
  <div id="camada" style="padding: 10px; background-color: #ff8800">Clique em um bot�o</div>
  <input type="button" value="Bot�o A" onclick="$('#camada').html('Clicou no bot�o <b>A</b>')">
  <input type="button" value="Bot�o B" onclick="$('#camada').html('Recebido um clique no bot�o <b>B</b>')">
  
  <br /><br /><br />
  <span id="camadaSPAN" style="padding: 10px; background-color: #789">Clique em um bot�o</span>
  <input type="button" value="Bot�o A" onclick="$('#camadaSPAN').html('Clicou no bot�o <b>A</b>')">
  <input type="button" value="Bot�o B" onclick="$('#camadaSPAN').html('Recebido um clique no bot�o <b>B</b>')">

</BODY>
</HTML>
