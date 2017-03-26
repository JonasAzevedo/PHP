/*******************************************************************
********************************************************************
  Nome: jSelecaoProdutos.js
  Fun��o: arquivo com fun��es JavaScript para sele��o de produtos.
  Data de Cria��o: 09/02/2011 - 11:08
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: pgAjaxSelecionaProdutos.php?chamou=inicio&tipo_prod=camiseta&sub_grupo=0
********************************************************************
********************************************************************/

/*
//function's:
  RetornarInteiro(psValor) //verifica se par�metro � um n�mero inteiro, se n�o for retorna zero
  ReplaceAll(psString, psToken, psNewtoken) //substitui na string do par�metro psString, todas as ocorr�ncias do par�metro psToken, pelo par�metro psNewtoken
  FormatarValorMonetario(psValor) //formata par�metro psValor para o formato monet�rio. Entrada: 10 / Sa�da: R$ 10,50
  IniciarExibicaoProdutos() //exibe os produtos quando a p�gina principal � carregada
  PesquisandoProdutos() //exibe os produtos quando usar a op��o de pesquisa
  NavegandoMenuNavegacao(pnSubGrupo,psFiltro) //exibe os produtos quando usar o menu de navega��o
  SelecionandoLinkPagina() //exibe os produtos quando selecionar um link de uma p�gina
  DefinirFiltro(psFiltro) //define o filtro usado na sele��o dos produtos
  
  AJAX
  SelecionarProdutos(psChamou,psTipoProduto,pnSubGrupo,pnPagina) //controla a sele��o de produtos
  CarregarProdutos() //carrega produtos nos componentes. onreadystatechange(SelecionarProdutos)

  AJAX
  AtualizarGuiaNavegacao() //atualiza os link's de navega��o entre os produtos
  CarregarRegistroPaginasNavegacao() //carrega n�mero das p�gina de navega��o nos componentes. onreadystatechange(AtualizarGuiaNavegacao)
  
  AjustarLinkClicado(nLink) //ajusta os link's das p�ginas, alterando as cores do link clicado e dos demais. SelecionandoLinkPagina()
*/

function RetornarInteiro(psValor){
    if(isNaN(parseInt(psValor))){
      return 0;
    }
    else{
      if(psValor > 0){
        return psValor;
      }
      else{
        return 0;
      }
    }
} //fim - RetornarInteiro()


function ReplaceAll(psString, psToken, psNewtoken) {
    while(psString.indexOf(psToken) != -1){
      psString = psString.replace(psToken, psNewtoken);
    }
    return psString;
} //fim - ReplaceAll()


function FormatarValorMonetario(psValor){
    var sRetorno = "";
    var sTexto = new String(psValor);
    var num = new NumberFormat();
    num.setInputDecimal('.');
    num.setNumber(sTexto);
    num.setPlaces('2', false);
    //num.setCurrencyValue('R$');
    num.setCurrencyValue('');
    num.setCurrency(true);
    num.setCurrencyPosition(num.LEFT_OUTSIDE);
    num.setNegativeFormat(num.LEFT_DASH);
    num.setNegativeRed(false);
    num.setSeparators(true, ',', ',');
    sRetorno = num.toFormatted();
   //formata valor para o padr�o brasileiro
    sRetorno = ReplaceAll(sRetorno, '.', '@');
    sRetorno = ReplaceAll(sRetorno, ',', '#');
    sRetorno = ReplaceAll(sRetorno, '@', ',');
    sRetorno = ReplaceAll(sRetorno, '#', '.');

    return sRetorno;
} //FormatarValorMonetario()


function IniciarExibicaoProdutos(){
    SelecionarProdutos('inicio','camiseta','0','0');
    VerificarExisteSessaoLoginUsuario(); //mostrar div correta se o usu�rio est� logado. Casos de apertar 'F5'. jPgIdentificacaoUsuario.js
}

function PesquisandoProdutos(){
    SelecionarProdutos('pesquisando','camiseta','0','0');
}

function DefinirFiltro(psFiltro){
    document.getElementById("spnFiltroRealizado").innerHTML = psFiltro;
}

function NavegandoMenuNavegacao(pnSubGrupo,psFiltro){
    DefinirFiltro(psFiltro);
    SelecionarProdutos('navegando','camiseta',pnSubGrupo,'0');
}

function SelecionandoLinkPagina(nLink,nPagina){
    SelecionarProdutos('link','camiseta','0',nPagina);
    AjustarLinkClicado(nLink);
}

/* par�metros:
    psChamou: quem fez a chamada para este m�todo - Valores Poss�veis: inicio,pesquisando,navegando,link
    psTipoProduto: tipo de produto da pesquisa - Valores Poss�veis: camiseta
    pnSubGrupo: sub-grupo para filtrar os produtos - Valores Poss�veis: caracter do tipo inteiro
    pnPagina: n�mero da p�gina que se est� navegando. Link de navega��o. - Valores Poss�veis: caracter do tipo inteiro
*/
function SelecionarProdutos(psChamou,psTipoProduto,pnSubGrupo,pnPagina){
    oAjaxProdutos = IniciarAJAX();
    if(oAjaxProdutos){
      if(psTipoProduto == "camiseta"){
        if(psChamou == "inicio"){
          oAjaxProdutos.onreadystatechange = CarregarProdutos;
          sUrl = "pgAjaxSelecionaProdutos.php?chamou="+psChamou+"&tipo_prod="+psTipoProduto+"&sub_grupo="+pnSubGrupo;
        }
        else if(psChamou == "pesquisando"){
          oAjaxProdutos.onreadystatechange = CarregarProdutos;
          sUrl = "pgAjaxSelecionaProdutos.php?chamou="+psChamou+"&tipo_prod="+psTipoProduto+"&filtroPesquisa="+txtValorItemPesquisa.value;
        }
        else if(psChamou == "navegando"){
          oAjaxProdutos.onreadystatechange = CarregarProdutos;
          sUrl = "pgAjaxSelecionaProdutos.php?chamou="+psChamou+"&tipo_prod="+psTipoProduto+"&sub_grupo="+pnSubGrupo;
        }
        else if(psChamou == "link"){
          oAjaxProdutos.onreadystatechange = CarregarProdutos;
          sUrl = "pgAjaxSelecionaProdutos.php?chamou="+psChamou+"&pagina="+pnPagina;
        }
        oAjaxProdutos.open('GET', sUrl, true);
        oAjaxProdutos.send(null);
      }
    }
    else{
      alert("AJAX n�o pode ser criado.");
    }
} //fim - SelecionarProdutos()


function CarregarProdutos(){
    if(oAjaxProdutos.readyState == 4){
      if(oAjaxProdutos.status == 200){
        //vari�veis para acessar elementos atrav�s do document.getElementById
        var id = 0;
        var divProduto = "divProduto";
        var spnNome = "spnVlrCaracProdNome";
        var spnValor = "spnVlrCaracProdValor";
        var spnDescontoTitulo = "spnTitCaracProdDesconto";
        var spnDesconto = "spnVlrCaracProdDesconto";
        var spnDescricao = "spnVlrCaracProdDescricao";
        var edIdProduto = "edIdProduto";
        //3 imagens do produto
        var imgFigura1 = "imgFigura";
        var lnkFigura1 = "aLnkFigura1";
        var lnkFigura2 = "aLnkFigura2";
        var lnkFigura3 = "aLnkFigura3";
          
        //n�o encontrou registros
        if(oAjaxProdutos.responseText == ""){
          document.getElementById("divNenhumProduto").style.display = 'block';
          //esconder as div's sem produto
          for(x=0; x<9; x++){
            id++;
            document.getElementById(spnNome + id).innerHTML = "";
            document.getElementById(spnValor + id).innerHTML = "";
            document.getElementById(spnDesconto + id).innerHTML = "";
            document.getElementById(spnDescricao + id).innerHTML = "";
            //figuras
            document.getElementById(imgFigura1 + id).src = "";
            document.getElementById(lnkFigura1 + id).href = "";
            document.getElementById(lnkFigura2 + id).href = "";
            document.getElementById(lnkFigura3 + id).href = "";
            document.getElementById(lnkFigura1 + id).rel = "";
            document.getElementById(lnkFigura2 + id).rel = "";
            document.getElementById(lnkFigura3 + id).rel = "";

            document.getElementById(edIdProduto + id).value = "";

            document.getElementById(divProduto + id).style.display = 'none';
          }
          //escondendo link de navega��o entre as p�ginas
          var lnkPg = "lnkPg";
          for(x=1; x<=5; x++){
            document.getElementById(lnkPg + x).style.visibility = 'hidden';
          }
        }
        //retorno AJAX � diferente de vazio ("")
        else{
          document.getElementById("divNenhumProduto").style.display = 'none';
          var oJson = eval("("+oAjaxProdutos.responseText+")");

          //saber quantidade de retorno em formato JSON
           var nTotalJson = 0;
           for (var k in oJson.registro) {
             nTotalJson++;
           }
         
           if(nTotalJson > 9){
             nTotalJson = 9;
           }
         
           var sImagemComplemento = "complemento";
           //mostrando produtos, retornados via JSON
           for(x=0; x<nTotalJson; x++){
             id = id + 1;
             if (oJson.registro[x].cdCamiseta){
               document.getElementById(divProduto + id).style.display = 'block';
               //nome
               document.getElementById(spnNome + id).innerHTML = oJson.registro[x].nome;
               //valor
               dValor = oJson.registro[x].valor;
               dValor = FormatarValorMonetario(dValor);
               document.getElementById(spnValor + id).innerHTML = dValor;
               //desconto
               nDesconto = oJson.registro[x].desconto;
               nDesconto = RetornarInteiro(nDesconto);
               if(nDesconto > 0){
                 nDesconto = FormatarValorMonetario(nDesconto);
                 document.getElementById(spnDesconto + id).innerHTML = nDesconto;
                 document.getElementById(spnDescontoTitulo + id).style.visibility = 'visible';
                 document.getElementById(spnDesconto + id).style.visibility = 'visible';
               }
               else{
                 document.getElementById(spnDesconto + id).innerHTML = "0";
                 document.getElementById(spnDescontoTitulo + id).style.visibility = 'hidden';
                 document.getElementById(spnDesconto + id).style.visibility = 'hidden';
               }
               //descri��o
               document.getElementById(spnDescricao + id).innerHTML = oJson.registro[x].descricao;
               //figuras
               if(oJson.registro[x].figura1 != sImagemComplemento){
                 document.getElementById(imgFigura1 + id).src = oJson.registro[x].figura1;
                 document.getElementById(lnkFigura1 + id).href = oJson.registro[x].figura1;
                 document.getElementById(lnkFigura1 + id).rel = "figuras" + id;

               }
               else{
                 document.getElementById(imgFigura1 + id).src = "";
                 document.getElementById(lnkFigura1 + id).href = "";
                 document.getElementById(lnkFigura1 + id).rel = "";
               }
            
               if(oJson.registro[x].figura2 != sImagemComplemento){
                 document.getElementById(lnkFigura2 + id).href = oJson.registro[x].figura2;
                 document.getElementById(lnkFigura2 + id).rel = "figuras" + id;
               }
               else{
                 document.getElementById(lnkFigura2 + id).href = "";
                 document.getElementById(lnkFigura2 + id).rel = "";
               }
            
               if(oJson.registro[x].figura3 != sImagemComplemento){
                 document.getElementById(lnkFigura3 + id).href = oJson.registro[x].figura3;
                 document.getElementById(lnkFigura3 + id).rel = "figuras" + id;
               }
               else{
                 document.getElementById(lnkFigura3 + id).href = "";
                 document.getElementById(lnkFigura3 + id).rel = "";
               }
               //cdCamiseta
               document.getElementById(edIdProduto + id).value = oJson.registro[x].cdCamiseta;
             }
           }//for

           //esconder as div's sem produto
           if(nTotalJson < 9){
             for(x=nTotalJson; x<9; x++){
               id++;
               document.getElementById(spnNome + id).innerHTML = "";
               document.getElementById(spnValor + id).innerHTML = "";
               document.getElementById(spnDesconto + id).innerHTML = "";
               document.getElementById(spnDescricao + id).innerHTML = "";
               //figuras
               document.getElementById(imgFigura1 + id).src = "";
               document.getElementById(lnkFigura1 + id).href = "";
               document.getElementById(lnkFigura2 + id).href = "";
               document.getElementById(lnkFigura3 + id).href = "";
               document.getElementById(lnkFigura1 + id).rel = "";
               document.getElementById(lnkFigura2 + id).rel = "";
               document.getElementById(lnkFigura3 + id).rel = "";

               document.getElementById(edIdProduto + id).value = "";

               document.getElementById(divProduto + id).style.display = 'none';
             }
           }
           AtualizarGuiaNavegacao(); //atualiza a guia de navega��o com base na quantidade de produtos
        }
      }
    }
} //fim - CarregarProdutos()


function AtualizarGuiaNavegacao(){
    oAjaxNavegacao = IniciarAJAX();
    if(oAjaxNavegacao){
      oAjaxNavegacao.onreadystatechange = CarregarRegistroPaginasNavegacao;
      url = "pgAjaxSelecionaLinksNavegacao.php";
      oAjaxNavegacao.open('GET', url, true);
      oAjaxNavegacao.send(null);
    }
    else{
      alert("AJAX n�o pode ser criado.");
    }
} //fim - AtualizarGuiaNavegacao()


function CarregarRegistroPaginasNavegacao(){
    if(oAjaxNavegacao.readyState == 4){
      if(oAjaxNavegacao.status == 200){
        var oJson = eval("("+oAjaxNavegacao.responseText+")");

        if(oJson.registro[0].lnkNavega1 != ""){
          document.getElementById("lnkPg1").style.visibility = 'visible';
          document.getElementById("lnkPg1").innerHTML = oJson.registro[0].lnkNavega1;
        }
        else{
          document.getElementById("lnkPg1").innerHTML = "";
          document.getElementById("lnkPg1").style.visibility = 'hidden';
        }

        if(oJson.registro[0].lnkNavega2 != ""){
          document.getElementById("lnkPg2").style.visibility='visible';
          document.getElementById("lnkPg2").innerHTML = oJson.registro[0].lnkNavega2;
        }
        else{
          document.getElementById("lnkPg2").innerHTML = "";
          document.getElementById("lnkPg2").style.visibility = 'hidden';
        }

        if(oJson.registro[0].lnkNavega3 != ""){
          document.getElementById("lnkPg3").style.visibility = 'visible';
          document.getElementById("lnkPg3").innerHTML = oJson.registro[0].lnkNavega3;
        }
        else{
          document.getElementById("lnkPg3").innerHTML = "";
          document.getElementById("lnkPg3").style.visibility='hidden';
        }

        if(oJson.registro[0].lnkNavega4 != ""){
          document.getElementById("lnkPg4").style.visibility = 'visible';
          document.getElementById("lnkPg4").innerHTML = oJson.registro[0].lnkNavega4;
        }
        else{
          document.getElementById("lnkPg4").innerHTML = "";
          document.getElementById("lnkPg4").style.visibility = 'hidden';
        }

        if(oJson.registro[0].lnkNavega5 != ""){
          document.getElementById("lnkPg5").style.visibility='visible';
          document.getElementById("lnkPg5").innerHTML = oJson.registro[0].lnkNavega5;
        }
        else{
          document.getElementById("lnkPg5").innerHTML = "";
          document.getElementById("lnkPg5").style.visibility='hidden';
        }
      }
    }
} //fim - CarregarRegistroPaginasNavegacao()


function AjustarLinkClicado(nLink){
    if(nLink == 1){
      document.getElementById("lnkPg1").style.color = 'gray';
      document.getElementById("lnkPg2").style.color = 'black';
      document.getElementById("lnkPg3").style.color = 'black';
      document.getElementById("lnkPg4").style.color = 'black';
      document.getElementById("lnkPg5").style.color = 'black';
    }
    else if(nLink == 2){
      document.getElementById("lnkPg1").style.color = 'black';
      document.getElementById("lnkPg2").style.color = 'gray';
      document.getElementById("lnkPg3").style.color = 'black';
      document.getElementById("lnkPg4").style.color = 'black';
      document.getElementById("lnkPg5").style.color = 'black';
    }
    else if(nLink == 3){
      document.getElementById("lnkPg1").style.color = 'black';
      document.getElementById("lnkPg2").style.color = 'black';
      document.getElementById("lnkPg3").style.color = 'gray';
      document.getElementById("lnkPg4").style.color = 'black';
      document.getElementById("lnkPg5").style.color = 'black';
    }
    else if(nLink == 4){
      document.getElementById("lnkPg1").style.color = 'black';
      document.getElementById("lnkPg2").style.color = 'black';
      document.getElementById("lnkPg3").style.color = 'black';
      document.getElementById("lnkPg4").style.color = 'gray';
      document.getElementById("lnkPg5").style.color = 'black';
    }
    else if(nLink == 5){
      document.getElementById("lnkPg1").style.color = 'black';
      document.getElementById("lnkPg2").style.color = 'black';
      document.getElementById("lnkPg3").style.color = 'black';
      document.getElementById("lnkPg4").style.color = 'black';
      document.getElementById("lnkPg5").style.color = 'gray';
    }
} //fim - AjustarLinkClicado()
