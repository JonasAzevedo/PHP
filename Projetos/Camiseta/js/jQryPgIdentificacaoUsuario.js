/*******************************************************************
********************************************************************
  Nome: jQryPgIdentificacaoUsuario.js
  Função: arquivo com funções jQuery da página pgIdentificacaoUsuario.php
  Data de Criação: 27/03/2011 - 20:25
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function(){
    $('.txtValorItemLogin').focus(function(evt){
      $(this).css("backgroundColor", "#AAA");
    });
    $('.txtValorItemLogin').blur(function(evt){
      $(this).css("backgroundColor", "#FFF");
    });

    $('#lnkRealizarLogin').click(function(evt){
      evt.preventDefault();
    });


    $('.txtValorOpcRecuperarSenha').focus(function(evt){
      $(this).css("backgroundColor", "#AAA");
    });
    $('.txtValorOpcRecuperarSenha').blur(function(evt){
      $(this).css("backgroundColor", "#FFF");
    });


    /*******************************************************************************************
    ************************** teclar enter nos campos login ou senha **************************
    *******************************************************************************************/
    $('.txtValorItemLogin').keypress(function(e){
      if(e.which == 13){
        $('#lnkRealizarLogin').click();
      }
    });
      
    /*******************************************************************************************
    *************************************** recuperar senha ************************************
    *******************************************************************************************/
    $('#btnRecuperarSenha').click(function(evt){
      var dados = "login=" + $('#txtValorOpcRecuperarSenhaLogin').val() + "&email=" + $('#txtValorOpcRecuperarSenhaEmail').val();
      var bOK = false;
      $.ajax({
        type: "POST",
        url: "./pgAjaxRecuperarSenha.php",
        data: dados,
        success: function(data){
          $('#spnInformacaoRecuperouSenha').text(data);
          $("#spnInformacaoRecuperouSenha").css("display", "block");
          if(data == "Email enviado com sucesso."){
            bOK = true;
          }
        },
        beforeSend: function(){
          $('#spnInformacaoRecuperouSenha').text("");
          $("#spnInformacaoRecuperouSenha").css("display", "none");
          $("#imgRecuperarSenhaProcessando").css("display", "block");
        },
        complete: function(data){
          $("#imgRecuperarSenhaProcessando").css("display", "none");
          if(bOK == true){
            setTimeout(function(){
              $("#spnInformacaoRecuperouSenha").css("display", "none");
              $('#mask').hide();
              $('.window').hide();
            },1000);
          }
        },
      }); //fim - ajax
    }); //fim - #btnRecuperarSenha

});
