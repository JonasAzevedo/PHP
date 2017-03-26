/*******************************************************************
********************************************************************
  Nome: jPgCadastroUsuario.js
  Fun��o: arquivo com fun��es JavaScript da p�gina pgCadastroUsuario.php
  Data de Cria��o: 12/02/2011 - 12:08
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  IsCurrentBrowser(browserName) //verifica o tipo do navegador
  IniciarAJAXTemp() //inicia objeto AJAX
  ValidarCadastroUsuario() //valida o formul�rio de cadastro de usu�rio
  ValidarCampoEhNulo(psCampo,psValor) //valida se o campo est� com o seu valor nulo
  ValidarEmail(psEmail) //valida email
  ValidarInteiro(psValor) //verifica se par�metro � um n�mero inteiro
  VerificarDataIsValida(psData) //verifica se a data � v�lida
  VerificarSenhaConfere(psSenha,psSenhaConfere) //verifica se a senha confere
  VerificarPossuiEspa�oBrancoOuCaracteresEspeciais(psCampo,psValor) //valida seo campo possui espa�o em branco ou caracteres especiais
  PossuiMinimoCaracteresExigidos(psCampo,psValor,pnQtde) ////valida seo campo possui o m�nimo de caracteres exigidos no par�metro pnQtde

  AJAX
  VerificarUsuarioEstaCadastrado(psNome,psEmail,psLogin) //verifica se o nome, email ou login j� existe
  InformarUsuarioEstaCadastrado() //informa se o nome ou email j� existe.  onreadystatechange(VerificarUsuarioEstaCadastrado)
  
  VerificarNivelSenha() //verifica n�vel da senha informada
  MostrarNivelSenha() //mostra a for�a do n�vel da senha
*/

var bRetornoVerificaUsuarioCadastado = true; //necess�rio para fun��o AJAX


function IsCurrentBrowser(browserName){
  if(navigator.userAgent.search(browserName) != -1){
    return true;
  }
  else{
    return false;
  }
} //fim - IsCurrentBrowser()


function IniciarAJAXTemp(){
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
} //fim - IniciarAJAXTemp()


function ValidarCadastroUsuario(){
    var bRetorno = true;
    
    //nome
/*    bRetorno = ValidarCampoEhNulo("Nome",txtValorCadUsuarioNome.value);
    if(bRetorno == false){
      document.getElementById("txtValorCadUsuarioNome").focus();
    }

    //email
    if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("Email",txtValorCadUsuarioEmail.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioEmail").focus();
      }
      else{
        bRetorno = ValidarEmail(txtValorCadUsuarioEmail.value);
        if(bRetorno == false){
          document.getElementById("txtValorCadUsuarioEmail").focus();
        }
      }
    }
*/
    //data de nascimento
    if(bRetorno == true){
      bRetorno = VerificarDataIsValida(txtValorCadUsuarioDataNascimento.value);
      if(bRetorno == false){
        alert("Data de Nascimento � inv�lida.");
        document.getElementById("txtValorCadUsuarioDataNascimento").focus();
      }
    }

    //uf
    //uf n�o � nulo
/*    if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("UF",txtValorCadUsuarioEnderecoUF.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioEnderecoUF").focus();
      }
    }

    //uf deve possuir 2 caracteres
    if(bRetorno == true){
      bRetorno = PossuiMinimoCaracteresExigidos("UF", txtValorCadUsuarioEnderecoUF.value, 2);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioEnderecoUF").focus();
      }
    }
  */
    //cidade
/*    if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("Cidade",txtValorCadUsuarioEnderecoCidade.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioEnderecoCidade").focus();
      }
    }
*/
    //bairro
 /*   if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("Bairro",txtValorCadUsuarioEnderecoBairro.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioEnderecoBairro").focus();
      }
    }
    
    //rua
    if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("Rua",txtValorCadUsuarioEnderecoRua.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioEnderecoRua").focus();
      }
    }
*/
    //login
    //login n�o � nulo
    if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("Login",txtValorCadUsuarioLogin.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioLogin").focus();
      }
    }
    
    //login n�o deve possuir espa�os em branco ou caracteres especiais
    if(bRetorno == true){
      bRetorno = VerificarPossuiEspa�oBrancoOuCaracteresEspeciais("Login",txtValorCadUsuarioLogin.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioLogin").focus();
      }
    }

    //login deve possuir no m�nimo 5 caracteres
    if(bRetorno == true){
      bRetorno = PossuiMinimoCaracteresExigidos("Login", txtValorCadUsuarioLogin.value, 5);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioLogin").focus();
      }
    }

    //senha
    //senha n�o � nula
    if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("Senha",txtValorCadUsuarioSenha1.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioSenha1").focus();
      }
    }
    
    //confirme senha n�o � nula
    if(bRetorno == true){
      bRetorno = ValidarCampoEhNulo("Confirme Senha",txtValorCadUsuarioSenha2.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioSenha2").focus();
      }
    }
    
    //senha e confirme senha, s�o iguais
    if(bRetorno == true){
      bRetorno = VerificarSenhaConfere(txtValorCadUsuarioSenha1.value, txtValorCadUsuarioSenha2.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioSenha1").focus();
      }
    }

    //senha n�o deve possuir espa�os em branco ou caracteres especiais
    if(bRetorno == true){
      bRetorno = VerificarPossuiEspa�oBrancoOuCaracteresEspeciais("Senha", txtValorCadUsuarioSenha1.value);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioSenha1").focus();
      }
    }

    //senha deve possuir no m�nimo 5 caracteres
    if(bRetorno == true){
      bRetorno = PossuiMinimoCaracteresExigidos("Senha", txtValorCadUsuarioSenha1.value, 5);
      if(bRetorno == false){
        document.getElementById("txtValorCadUsuarioSenha1").focus();
      }
    }
    
    //nome, email ou login j� existe
    if(bRetorno == true){
      bRetornoVerificaUsuarioCadastado = true;
      VerificarUsuarioEstaCadastrado(txtValorCadUsuarioNome.value, txtValorCadUsuarioEmail.value, txtValorCadUsuarioLogin.value);
      bRetorno = bRetornoVerificaUsuarioCadastado;
    }

    return bRetorno;
} //fim - ValidarCadastroUsuario()


function ValidarCampoEhNulo(psCampo,psValor){
    var bRetorno = true;
    
    psValor = psValor.replace(/^\s+|\s+$/g,"");
    if(psValor == ""){
      alert("Campo obrigat�rio: " + psCampo);
      bRetorno = false;
	}

    return bRetorno;
} //fim - ValidarCampoEhNulo()


function ValidarEmail(psEmail){
    var bRetorno = true;
	//checando se o endere�o de email � v�lido
	if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(psEmail))) {
		alert("Endere�o de e-mail inv�lido.");
		bRetorno = false;
	}
	return bRetorno;
} //fim - ValidarEmail()


function ValidarInteiro(psValor){
    if(isNaN(parseInt(psValor))){
      return false;
    }
    else{
      if(psValor > 0){
        return true;
      }
      else{
        return false;
      }
    }
} //fim - ValidarInteiro()


function VerificarDataIsValida(psData){
    var bBissexto = false;
    var sData = psData;
    var nTam = psData.length;
    var bValidou = true;

    if(nTam == 10){
      var sDia = sData.substr(0,2);
      var sMes = sData.substr(3,2);
      var sAno = sData.substr(6,4);
      if((ValidarInteiro(sDia))&&(ValidarInteiro(sMes))&&(ValidarInteiro(sAno))){
        //validando m�s - (valida dia no switch)
        if((sMes>=1)&&(sMes<=12)){
          switch (sMes){
            case '01':
            case '03':
            case '05':
            case '07':
            case '08':
            case '10':
            case '12':
              if(sDia > 31){
                bValidou = false;
              }
              break;
            case '04':
            case '06':
            case '09':
            case '11':
              if(sDia > 30){
                bValidou = false;
              }
              break;
            case '02': // validando ano bissexto - (fevereiro)
              if((sAno % 4 == 0)||(sAno % 100 == 0)||(sAno % 400 == 0)){
                bBissexto = true;
              }
              if((bBissexto == true)&&(sDia > 29)){
                bValidou = false;
              }
              if((bBissexto == false)&&(sDia > 28)){
                bValidou = false;
              }
              break;
          } //fim - switch (sMes)
        } //fim - if((sMes>=1)&&(sMes<=12))
        else{
          bValidou = false;
        }
      } //fim - if((validarInteiro(sDia))&&(validarInteiro(sMes))&&(validarInteiro(sAno)))
      else{
        bValidou = false;
      }
      
      //validando ano
      if(sAno == "0000"){
        bValidou = false;
      }
      if(sAno.length != 4){
        bValidou = false;
      }
    } //fim - if(nTam == 10)
    
    return bValidou;
} //fim - VerificarDataIsValida()


function VerificarSenhaConfere(psSenha,psSenhaConfere){
    if(psSenha != psSenhaConfere){
      alert("Senha n�o confere.");
      return false;
    }
    else{
      return true;
    }
} //fim - VerificarSenhaConfere()


function VerificarPossuiEspa�oBrancoOuCaracteresEspeciais(psCampo,psValor){
    var bRetorno = true;
    //verifica se tem espa�os em branco
    if(psValor.search( /\s/g ) != -1){
      alert(psCampo + " n�o permite espa�os em branco.");
      bRetorno = false;
    }
    if(bRetorno == true){
      //verifica se tem caracteres especiais
      if(psValor.search( /[^a-z0-9]/i ) != -1){
        alert(psCampo + " n�o permite caracteres especiais.");
        bRetorno = false;
      }
    }
    return bRetorno;
} //fim - VerificarPossuiEspa�oBrancoOuCaracteresEspeciais()


function PossuiMinimoCaracteresExigidos(psCampo,psValor, pnQtde){
    var bRetorno = true;
    if(psValor.length < pnQtde){
      alert(psCampo + " deve possuir no m�nimo " + pnQtde + " caracteres.");
      bRetorno = false;
    }
    return bRetorno;
} //fim - PossuiMinimoCaracteresExigidos()


function VerificarUsuarioEstaCadastrado(psNome,psEmail,psLogin){
    oAjaxVerificarUsuario = IniciarAJAXTemp();
    if(oAjaxVerificarUsuario){
      oAjaxVerificarUsuario.onreadystatechange = InformarUsuarioEstaCadastrado;
      sUrl = "../pgAjaxVerificaExisteCadastroUsuario.php?chamou=cadNovoUsuario&nome="+psNome+"&email="+psEmail+"&login="+psLogin;
      //oAjaxVerificarUsuario.open('GET', sUrl, true); //ajax ass�ncrono
      oAjaxVerificarUsuario.open('GET', sUrl, false); //ajax s�ncrono
      oAjaxVerificarUsuario.send(null);
    }
    else{
      alert("AJAX n�o pode ser criado.");
    }
} //fim - VerificarUsuarioEstaCadastrado()


function InformarUsuarioEstaCadastrado(){
    if(oAjaxVerificarUsuario.readyState == 4){
      if(oAjaxVerificarUsuario.status == 200){
        var oJson = eval("("+oAjaxVerificarUsuario.responseText+")");
        var nTotNome;
        var nTotEmail;
        var nTotLogin;

        nTotNome = oJson.registro[0].totalNome;
        nTotEmail = oJson.registro[0].totalEmail;
        nTotLogin = oJson.registro[0].totalLogin;
        
        if(nTotNome > 0){
          alert('Usu�rio com este nome j� cadastrado.');
          document.getElementById("txtValorCadUsuarioNome").focus();
          bRetornoVerificaUsuarioCadastado = false;
        }
        else if(nTotEmail > 0){
          alert('Usu�rio com este email j� cadastrado.');
          document.getElementById("txtValorCadUsuarioEmail").focus();
          bRetornoVerificaUsuarioCadastado = false;
        }
        else if(nTotLogin > 0){
          alert('Usu�rio com este login j� cadastrado.');
          document.getElementById("txtValorCadUsuarioLogin").focus();
          bRetornoVerificaUsuarioCadastado = false;
        }
      }
    }
} //fim - InformarUsuarioEstaCadastrado()


//verifica n�vel da senha informada
function VerificarNivelSenha(){
    sSenha = document.getElementById("txtValorCadUsuarioSenha1").value;
	nForca = 0;
	oMostraNivel = document.getElementById("tblNivelSenha");
	if((sSenha.length >= 5) && (sSenha.length <= 7)){
	  nForca += 10;
	}else if(sSenha.length > 7){
	  nForca += 25;
	}
	if(sSenha.length >= 5){
  	  if(sSenha.match(/[a-z]+/)){ //letras min�culas
	    nForca += 20;
      }
      //senha n�o vai ter letras mai�culas
      //if(sSenha.match(/[A-Z]+/)){
	  //  nForca += 20;
	  //}
	  if(sSenha.match(/\d+/)){ //n�meros
	    nForca += 20;
      }
	  if(sSenha.match(/\W+/)){ //caracteres especiais
	    nForca += 20;
      }
    }
    return MostrarNivelSenha();
} //fim - VerificarNivelSenha()


//mostra a for�a do n�vel da senha
function MostrarNivelSenha(){
    document.getElementById("tblNivelSenha").style.display = 'block';
    
	if(nForca <= 30){
	  oMostraNivel.innerHTML = '<tr><td bgcolor="red" width="'+nForca+'"></td><td>Fraca</td></tr>';
	}
    else if((nForca >= 31) && (nForca <= 64)){
	  oMostraNivel.innerHTML = '<tr><td bgcolor="yellow" width="'+nForca+'"></td><td>Justa</td></tr>';;
	}
    else if((nForca >= 65) && (nForca <= 84)){
	  oMostraNivel.innerHTML = '<tr><td bgcolor="blue" width="'+nForca+'"></td><td>Forte</td></tr>';
	}
    else if(nForca >= 85){
	  oMostraNivel.innerHTML = '<tr><td bgcolor="green" width="'+nForca+'"></td><td>Excelente</td></tr>';
	}
} //fim - MostrarNivelSenha()


function Limpar(){
    document.getElementById("tblNivelSenha").style.display = 'none';
} //fim - Limpar()
