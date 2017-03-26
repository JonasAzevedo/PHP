/*******************************************************************
********************************************************************
  Nome: jPgFinalizarCompra.js
  Função: arquivo com funções JavaScript da página pgFinalizarCompra.php
  Data de Criação: 22/02/2011 - 10:04
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  IniciarAJAX_FinalizarCompra() //inicia objeto AJAX
  AlterarPassoFinalizarCompra()
  CadastrarEnderecoEntrega() //realiza o cadastro do endereço de entrega

  AJAX
  CadastrarEnderecoEntrega() //realiza o cadastro do endereço de entrega
  InformarCadastrouEnderecoEntrega() //informa se cadastrou o endereço de entrega. onreadystatechange(CadastrarEnderecoEntrega)
  
  LimparEnderecoEntrega() //limpa os dados de cadastro do endereço de entrega
  
  AJAX
  RealizarLoginUsuarioFinalizandoCompra(psLogin,psSenha) //realiza o login do usuário (ao estar finalizando a compra), com base nos parâmetros psLogin e psSenha
  CarregarLoginUsuarioFinalizandoCompra() //carrega dados se o login foi realizado. onreadystatechange(RealizarLoginUsuarioFinalizandoCompra)
*/

function IniciarAJAX_FinalizarCompra(){
  var xml_http;

  try {
    xml_http = new XMLHttpRequest();
  } catch(ee) {
    try {
      xml_http = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {
        xml_http = new ActiveXObject("Microsoft.XMLHTTP");
      } catch(E){
        xml_http = false;
      }
    }
  }
  return xml_http;
} //fim - IniciarAJAX_FinalizarCompra()


function AlterarPassoFinalizarCompra(psPasso){
    if(psPasso == "confirmarProdutos"){
      document.getElementById("divFinCompPasso1").style.display = 'block';
      document.getElementById("divFinCompPasso2").style.display = 'none';
      document.getElementById("divFinCompPasso3").style.display = 'none';
      document.getElementById("divFinCompPasso4").style.display = 'none';
    }
    else if(psPasso == "enderecoEntrega"){
      document.getElementById("divFinCompPasso1").style.display = 'none';
      document.getElementById("divFinCompPasso2").style.display = 'block';
      document.getElementById("divFinCompPasso3").style.display = 'none';
      document.getElementById("divFinCompPasso4").style.display = 'none';
    }
    else if(psPasso == "calcularFrete"){
      document.getElementById("divFinCompPasso1").style.display = 'none';
      document.getElementById("divFinCompPasso2").style.display = 'none';
      document.getElementById("divFinCompPasso3").style.display = 'block';
      document.getElementById("divFinCompPasso4").style.display = 'none';
    }
    else if(psPasso == "formaPagamento"){
      document.getElementById("divFinCompPasso1").style.display = 'none';
      document.getElementById("divFinCompPasso2").style.display = 'none';
      document.getElementById("divFinCompPasso3").style.display = 'none';
      document.getElementById("divFinCompPasso4").style.display = 'block';
    }
    else{
      document.getElementById("divFinCompPasso1").style.display = 'none';
      document.getElementById("divFinCompPasso2").style.display = 'none';
      document.getElementById("divFinCompPasso3").style.display = 'none';
      document.getElementById("divFinCompPasso4").style.display = 'none';
    }
} //fim - AlterarPassoFinalizarCompra()


//realiza o cadastro do endereço de entrega
function CadastrarEnderecoEntrega(){
   //valor dos campos de cadastro do endereço de entrega
   var sUF = document.getElementById("txtValorEnderecoEntregaUF").value;
   var sCidade = document.getElementById("txtValorEnderecoEntregaCidade").value;
   var sCEP = document.getElementById("txtValorEnderecoEntregaCEP").value;
   var sBairro = document.getElementById("txtValorEnderecoEntregaBairro").value;
   var sRua = document.getElementById("txtValorEnderecoEntregaRua").value;
   var sNumero = document.getElementById("txtValorEnderecoEntregaNumero").value;
   var sComplemento = document.getElementById("txtAreaValorEnderecoEntregaComplemento").value;
   if(document.getElementById("ckBxEnderecoPadrao").checked){
     sSalvarEnderecoPadrao = "sim";
   }
   else{
     sSalvarEnderecoPadrao = "nao";
   }
   
   //iniciando chamada AJAX
  oAjaxFinalizarEnderecoEntrega = IniciarAJAX_FinalizarCompra();
  if(oAjaxFinalizarEnderecoEntrega){
    oAjaxFinalizarEnderecoEntrega.onreadystatechange = InformarCadastrouEnderecoEntrega;
    sUrl = "../pgAjaxFinalizarEnderecoEntrega.php?uf="+sUF+"&cidade="+sCidade+"&cep="+sCEP+"&bairro="+sBairro+"&rua="+sRua+"&numero="+sNumero+"&complemento="+sComplemento+"&salvarEnderecoPadrao="+sSalvarEnderecoPadrao;
    oAjaxFinalizarEnderecoEntrega.open('GET', sUrl, false);
    oAjaxFinalizarEnderecoEntrega.send(null);
  }
  else{
    alert("AJAX não pode ser criado.");
  }
} //fim - CadastrarEnderecoEntrega()


//informa se cadastrou o endereço de entrega. onreadystatechange(CadastrarEnderecoEntrega)
function InformarCadastrouEnderecoEntrega(){
    if(oAjaxFinalizarEnderecoEntrega.readyState == 4){
      if(oAjaxFinalizarEnderecoEntrega.status == 200){
        var oJson = eval("("+oAjaxFinalizarEnderecoEntrega.responseText+")");
        var sSalvouEndereco;

        sSalvouEndereco = oJson.registro[0].salvou_endereco;
        if(sSalvouEndereco == "sim"){
          AlterarPassoFinalizarCompra("calcularFrete");
        }
      }
    }
} //fim - InformarCadastrouEnderecoEntrega()


//limpa os dados de cadastro do endereço de entrega
function  LimparEnderecoEntrega(){
    document.getElementById("txtValorEnderecoEntregaUF").value = "";
    document.getElementById("txtValorEnderecoEntregaCidade").value = "";
    document.getElementById("txtValorEnderecoEntregaCEP").value = "";
    document.getElementById("txtValorEnderecoEntregaBairro").value = "";
    document.getElementById("txtValorEnderecoEntregaRua").value = "";
    document.getElementById("txtValorEnderecoEntregaNumero").value = "";
    document.getElementById("txtAreaValorEnderecoEntregaComplemento").value = "";
    document.getElementById("ckBxEnderecoPadrao").checked = false;
} //fim - LimparEnderecoEntrega()


function RealizarLoginUsuarioFinalizandoCompra(psLogin,psSenha){
    oAjaxLoginUsuario = IniciarAJAX_FinalizarCompra();
    if(oAjaxLoginUsuario){
      oAjaxLoginUsuario.onreadystatechange = CarregarLoginUsuarioFinalizandoCompra;
      sUrl = "../pgAjaxRealizarLoginUsuario.php?login=" + psLogin + "&senha=" + psSenha;
      oAjaxLoginUsuario.open('GET', sUrl, true);
      oAjaxLoginUsuario.send(null);
    }
    else{
      alert("AJAX não pode ser criado.");
    }

} //fim - RealizarLoginUsuarioFinalizandoCompra()


function CarregarLoginUsuarioFinalizandoCompra(){
    if(oAjaxLoginUsuario.readyState == 4){
      if(oAjaxLoginUsuario.status == 200){
        var oJson = eval("("+oAjaxLoginUsuario.responseText+")"); //retorno formato json
        var sValidou = oJson.registro[0].validou;

        if(sValidou=="sim"){
          window.location.reload(); //refresh na página
        }
        else{
          alert("Login inválido.");
          document.getElementById("txtValorItemLoginUsuario").focus();
        }
      }
    }
} //fim - CarregarLoginUsuarioFinalizandoCompra()




   $(document).ready(function(){

	  $('#conteudo').hide();

      $('a#exibir').click(function(){

		$('#conteudo').show('slow');

   	   });

      $('a#ocultar').click(function(){

   		$('#conteudo').hide('slow');
      })

});
