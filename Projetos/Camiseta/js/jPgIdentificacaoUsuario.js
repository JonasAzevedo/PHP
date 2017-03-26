/*******************************************************************
********************************************************************
  Nome: jPgIdentificacaoUsuario.js
  Função: arquivo com funções JavaScript da página pgIdentificacaoUsuario.php
  Data de Criação: 14/02/2011 - 10:41
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  IniciaAJAX_Sessao() //inicia objeto AJAX

  AJAX
  VerificarExisteSessaoLoginUsuario() //verifica se usuário realizou login, para ao recarregar página carregar sessão atual
  CarregarSessaoLoginUsuario() //carrega dados se existe a sessão de login do usuário. onreadystatechange(VerificarExisteSessaoLoginUsuario)
  
  ControlarExibicaoDivUsuario(pbUsuarioLogado) //controla a exibição das div's, depende se o login foi realizado
  
  AJAX
  RealizarLoginUsuario(psLogin,psSenha) //realiza o login do usuário, com base nos parâmetros psLogin e psSenha
  CarregarLoginUsuario() //carrega dados se o login foi realizado. onreadystatechange(RealizarLoginUsuario)
  
  AJAX
  RealizarLogoffUsuario() //realiza o logoff do usuário, com base no usuário logado
  CarregarLogoffUsuario() //carrega dados se o logoff foi realizado. onreadystatechange(RealizarLogoffUsuario)
  
  LimparCamposLogin() //limpa os campos de login
  LimparCarrinhoCompras() //limpa os campos do carrinho de compras
  MostrarDadosUsuarioLogado(psUsuario,pnTotalItens) //mostra os dados do usuário logado
  MostrarDadosUsuarioNaoLogado(pnTotalItens) //mostra os dados do usuário quando o login ainda não foi realizado
  FinalizarCompra() //finaliza a compra
  AlterarCor(oComp, oCor) //altera a cor do componente
  
  AJAX
  RecuperarSenha(psLogin,psEmail) //tenta recuperar a senha do usuário, com base nos parâmetros psLogin e psEmail
  CarregarRecuperarSenha() //carrega dados se a senha foi recuperada. onreadystatechange(RecuperarSenha)
*/

function IniciaAJAX_IdentifUsu(){
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
} //fim - IniciaAJAX_IdentifUsu()


function VerificarExisteSessaoLoginUsuario(){
    oAjaxExisteSessaoLoginUsuario = IniciaAJAX_IdentifUsu();
    if(oAjaxExisteSessaoLoginUsuario){
      oAjaxExisteSessaoLoginUsuario.onreadystatechange = CarregarSessaoLoginUsuario;
      sUrl = "pgAjaxVerificarSessaoLoginUsuario.php";
      oAjaxExisteSessaoLoginUsuario.open('GET', sUrl, true);
      oAjaxExisteSessaoLoginUsuario.send(null);
    }
    else{
      alert("AJAX não pode ser criado.");
    }
} //fim - VerificarExisteSessaoLoginUsuario()


function CarregarSessaoLoginUsuario(){
    if(oAjaxExisteSessaoLoginUsuario.readyState == 4){
      if(oAjaxExisteSessaoLoginUsuario.status == 200){
        var oJson = eval("("+oAjaxExisteSessaoLoginUsuario.responseText+")"); //retorno formato json

        var sExisteSessao = oJson.registro[0].existe_sessao;
        var nCodigo = oJson.registro[0].codigo;
        var sUsuario = oJson.registro[0].usuario;
        var sSenha = oJson.registro[0].senha;
        var sNome = oJson.registro[0].nome;
        var nIdLog = oJson.registro[0].id_log;
        var nItensPedido = oJson.registro[0].itens_pedido;

        if(sExisteSessao == "sim"){
          ControlarExibicaoDivUsuario(true);
          MostrarDadosUsuarioLogado(sNome, nItensPedido);
        }
        else{
          ControlarExibicaoDivUsuario(false);
          MostrarDadosUsuarioNaoLogado(nItensPedido);
        }
      }
    }
} //fim - CarregarSessaoLoginUsuario()


function ControlarExibicaoDivUsuario(pbUsuarioLogado){
    if(pbUsuarioLogado==true){
      document.getElementById("divUsuarioLogado").style.display = 'block';
      document.getElementById("divLoginUsuario").style.display = 'none';
    }
    else{
      document.getElementById("divUsuarioLogado").style.display = 'none';
      document.getElementById("divLoginUsuario").style.display = 'block';
    }
} //fim - ControlarExibicaoDivUsuario()


function RealizarLoginUsuario(psLogin,psSenha){
    oAjaxLoginUsuario = IniciaAJAX_IdentifUsu();
    if(oAjaxLoginUsuario){
      oAjaxLoginUsuario.onreadystatechange = CarregarLoginUsuario;
      sUrl = "pgAjaxRealizarLoginUsuario.php?login=" + psLogin + "&senha=" + psSenha;
      oAjaxLoginUsuario.open('GET', sUrl, true);
      oAjaxLoginUsuario.send(null);
    }
    else{
      alert("AJAX não pode ser criado.");
    }

} //fim - RealizarLoginUsuario()


function CarregarLoginUsuario(){
    if(oAjaxLoginUsuario.readyState == 4){
      if(oAjaxLoginUsuario.status == 200){
        var oJson = eval("("+oAjaxLoginUsuario.responseText+")"); //retorno formato json
        alert(oJson);
        var sValidou = oJson.registro[0].validou;
        var nCodigo = oJson.registro[0].codigo;
        var sUsuario = oJson.registro[0].usuario;
        var sSenha = oJson.registro[0].senha;
        var sNome = oJson.registro[0].nome;
        var nTotItensPedido = oJson.registro[0].itens_pedido;
                   alert(sValidou);
        if(sValidou=="sim"){
          ControlarExibicaoDivUsuario(true);
          MostrarDadosUsuarioLogado(sNome, nTotItensPedido);
        }
        else{
          alert("Login inválido.");
          document.getElementById("txtValorItemLoginUsuario").focus();
          ControlarExibicaoDivUsuario(false);
          MostrarDadosUsuarioNaoLogado(nItensPedido);
        }
      }
    }
} //fim - CarregarLoginUsuario()


function RealizarLogoffUsuario(){
    oAjaxLogoffUsuario = IniciaAJAX_IdentifUsu();
    if(oAjaxLogoffUsuario){
      oAjaxLogoffUsuario.onreadystatechange = CarregarLogoffUsuario;
      sUrl = "pgAjaxRealizarLogoffUsuario.php";
      oAjaxLogoffUsuario.open('GET', sUrl, true);
      oAjaxLogoffUsuario.send(null);
    }
    else{
      alert("AJAX não pode ser criado.");
    }
} //fim - RealizarLogoffUsuario()


function CarregarLogoffUsuario(){
    if(oAjaxLogoffUsuario.readyState == 4){
      if(oAjaxLogoffUsuario.status == 200){
        var oJson = eval("("+oAjaxLogoffUsuario.responseText+")"); //retorno formato json
        var sLogoff = oJson.registro[0].logoff;
        if(sLogoff == "sim"){
          ControlarExibicaoDivUsuario(false);
          LimparCamposLogin();
          LimparCarrinhoCompras();//xxxxxxxxxxxxxx
        }
      }
    }
} //fim - CarregarLogoffUsuario()


function LimparCamposLogin(){
    document.getElementById("txtValorItemLoginUsuario").value = "";
    document.getElementById("txtValorItemLoginSenha").value = "";
    document.getElementById("spnValorLogadoUsuario").innerHTML = "";
    document.getElementById("spnValorLogadoCarrinhoCompras").innerHTML = "";
    document.getElementById("txtValorItemLoginUsuario").focus();
} //fim - LimparCamposLogin()


function LimparCarrinhoCompras(){
    document.getElementById("spnValorLoginCarrinhoCompras").innerHTML = "0";
    document.getElementById("lnkFinalizarCompraSemUsuarioLogado").style.visibility = 'hidden';
} //fim - LimparCarrinhoCompras()


function MostrarDadosUsuarioLogado(psUsuario, pnTotalItens){
    document.getElementById("spnValorLogadoUsuario").innerHTML = psUsuario;
    document.getElementById("spnValorLogadoCarrinhoCompras").innerHTML = pnTotalItens;
    if(pnTotalItens > 0){
      document.getElementById("lnkFinalizarCompraUsuarioLogado").style.visibility = 'visible';
    }
    else{
      document.getElementById("lnkFinalizarCompraUsuarioLogado").style.visibility = 'hidden';
    }
} //fim - MostrarDadosUsuarioLogado()


function MostrarDadosUsuarioNaoLogado(pnTotalItens){
    document.getElementById("spnValorLoginCarrinhoCompras").innerHTML = pnTotalItens;
    if(pnTotalItens > 0){
      document.getElementById("lnkFinalizarCompraSemUsuarioLogado").style.visibility = 'visible';
    }
    else{
      document.getElementById("spnValorLoginCarrinhoCompras").innerHTML = "0";
      document.getElementById("lnkFinalizarCompraSemUsuarioLogado").style.visibility = 'hidden';
    }
} //fim - MostrarDadosUsuarioNaoLogado()


function FinalizarCompra(){
    alert('implementar FinalizarCompra');
} //fim - FinalizarCompra()


//altera a cor do componente
function AlterarCor(oComp, oCor){
    oComp.style.backgroundColor = oCor;
}

/*
function RecuperarSenha(psLogin,psEmail){
    document.getElementById("imgRecuperarSenhaProcessando").style.display = 'block';
      
    oAjaxRecuperarSenha = IniciaAJAX_IdentifUsu();
    if(oAjaxRecuperarSenha){
      oAjaxRecuperarSenha.onreadystatechange = CarregarRecuperarSenha;
      sUrl = "pgAjaxRecuperarSenha.php?login=" + psLogin + "&email=" + psEmail;
      oAjaxRecuperarSenha.open('GET', sUrl, true);
      oAjaxRecuperarSenha.send(null);
    }
    else{
      alert("AJAX não pode ser criado.");
    }
} //fim - RecuperarSenha()


function CarregarRecuperarSenha(){
    if(oAjaxRecuperarSenha.readyState == 4){
      if(oAjaxRecuperarSenha.status == 200){
        var oJson = eval("("+oAjaxRecuperarSenha.responseText+")"); //retorno formato json
        var sRetorno = oJson.registro[0].retorno;

        document.getElementById("imgRecuperarSenhaProcessando").style.display = 'none';
        alert(sRetorno);
      }
    }
} //fim - CarregarRecuperarSenha()
*/
