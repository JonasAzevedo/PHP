/*******************************************************************
********************************************************************
  Nome: jQryPgVisualizarProduto.js
  Função: arquivo com funções jQuery da página pgVisualizarProduto.php
  Data de Criação: 18/03/2011 - 14:24
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function(){
    //máscara
    $("#txtCompProdQtde").numeric();
    
    /*******************************************************************************************
    *********************************** avaliação da camiseta **********************************
    *******************************************************************************************/
    var nClicou = 0;

    //clicou na estrela 1
    $('#aLnkAvaliar1').click(function(evt){
      evt.preventDefault();
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_branca.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_branca.jpg');
      $('#imgAvaliar4').attr('src','../figuras/estrela_branca.jpg');
      $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      nClicou = 1;
      $('#hidItemAvaliado').val(nClicou);
    });
    
    //clicou na estrela 2
    $('#aLnkAvaliar2').click(function(evt){
      evt.preventDefault();
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_branca.jpg');
      $('#imgAvaliar4').attr('src','../figuras/estrela_branca.jpg');
      $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      nClicou = 2;
      $('#hidItemAvaliado').val(nClicou);
    });
    
    //clicou na estrela 3
    $('#aLnkAvaliar3').click(function(evt){
      evt.preventDefault();
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar4').attr('src','../figuras/estrela_branca.jpg');
      $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      nClicou = 3;
      $('#hidItemAvaliado').val(nClicou);
    });
    
    //clicou na estrela 4
    $('#aLnkAvaliar4').click(function(evt){
      evt.preventDefault();
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar4').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      nClicou = 4;
      $('#hidItemAvaliado').val(nClicou);
    });
    
    //clicou na estrela 5
    $('#aLnkAvaliar5').click(function(evt){
      evt.preventDefault();
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar4').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar5').attr('src','../figuras/estrela_amarela.jpg');
      nClicou = 5;
      $('#hidItemAvaliado').val(nClicou);
    });
    
    //mouse em cima da estrela 1
    $('#aLnkAvaliar1').mouseover(function(evt){
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
    });

    //mouse em cima da estrela 2
    $('#aLnkAvaliar2').mouseover(function(evt){
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
    });

    //mouse em cima da estrela 3
    $('#aLnkAvaliar3').mouseover(function(evt){
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_amarela.jpg');
    });

    //mouse em cima da estrela 4
    $('#aLnkAvaliar4').mouseover(function(evt){
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar4').attr('src','../figuras/estrela_amarela.jpg');
    });

    //mouse em cima da estrela 5
    $('#aLnkAvaliar5').mouseover(function(evt){
      $('#imgAvaliar1').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar2').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar3').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar4').attr('src','../figuras/estrela_amarela.jpg');
      $('#imgAvaliar5').attr('src','../figuras/estrela_amarela.jpg');
    });
    
    
    function ControlarLinkAvaliarMouseLeave(){
      if(nClicou == 0){
        $('#imgAvaliar1').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar2').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar3').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar4').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      }
      else if(nClicou == 1){
        $('#imgAvaliar2').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar3').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar4').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      }
      else if(nClicou == 2){
        $('#imgAvaliar3').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar4').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      }
      else if(nClicou == 3){
        $('#imgAvaliar4').attr('src','../figuras/estrela_branca.jpg');
        $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      }
      else if(nClicou == 4){
        $('#imgAvaliar5').attr('src','../figuras/estrela_branca.jpg');
      }
    } //fim - ControlarLinkAvaliarMouseLeave()
    
    //mouse saiu de cima da estrela 1
    $('#aLnkAvaliar1'). mouseleave(function(evt){
      ControlarLinkAvaliarMouseLeave();
    });

    //mouse saiu de cima da estrela 2
    $('#aLnkAvaliar2'). mouseleave(function(evt){
      ControlarLinkAvaliarMouseLeave();
    });

    //mouse saiu de cima da estrela 3
    $('#aLnkAvaliar3'). mouseleave(function(evt){
      ControlarLinkAvaliarMouseLeave();
    });
    
    //mouse saiu de cima da estrela 4
    $('#aLnkAvaliar4'). mouseleave(function(evt){
      ControlarLinkAvaliarMouseLeave();
    });

    //mouse saiu de cima da estrela 5
    $('#aLnkAvaliar5'). mouseleave(function(evt){
      ControlarLinkAvaliarMouseLeave();
    });
    
    
    /*******************************************************************************************
    ************ validação do formulário para enviar email de indicação de camiseta ************
    *******************************************************************************************/
    $("#frmIndicarProduto").validate({
      //define as regras
      rules:{
        //txtValorOpcIndicarParaAmigoDe:{
        txtValorOpcIndicarParaAmigoPara:{
          //txtValorOpcIndicarParaAmigoPara será obrigatório (required) e precisará ser um e-mail válido (email)
          required: true, email: true
        }
      },
      //define as mensagens de erro para cada regra
      messages:{
        txtValorOpcIndicarParaAmigoPara:{
          required: "Digite o e-mail do seu amigo",
          email: "Digite um e-mail válido"
        }
      },
      //chamada AJAX para enviar email
      submitHandler: function(form){
        var dados = $(form).serialize();

        $.ajax({
          type: "POST",
          url: "../pgAjaxIndicarCamisetaAmigo.php",
          data: dados,
          success: function(data){
            $('#spnInformacaoEnviouEmail').text(data);
            $("#spnInformacaoEnviouEmail").css("display", "block");
          },
          beforeSend: function(){
            $("#imgIndicarProdutoProcessando").css("display", "block");
          },
          complete: function(){
            $("#imgIndicarProdutoProcessando").css("display", "none");
            setTimeout(function(){
              $("#txtValorOpcIndicarParaAmigoDe").val('');
              $("#txtValorOpcIndicarParaAmigoPara").val('');
              $("#spnInformacaoEnviouEmail").css("display", "none");
              $('#mask').hide();
              $('.window').hide();
              }
            ,1000);

          }
        });
        return false;
      }
    });


    /*******************************************************************************************
    *********************** validação do formulário para comprar produtos **********************
    *******************************************************************************************/
    $("#frmComprarProduto").validate({
      //define as regras
      rules:{
        txtCompProdQtde:{
          required: true
        },
        sctTamanho: 'required'
      },
      //define as mensagens de erro para cada regra
      messages:{
        txtCompProdQtde:{
          required: "Digite a quantidade"
        },
        sctTamanho: "Selecione um tamanho"
      },
      //chamada AJAX para enviar email
      submitHandler: function(form){
        var dados = $(form).serialize();
        alert(dados);

        $.ajax({
          type: "POST",
          url: "../pgAjaxComprarItemProduto.php",
          data: dados,
          success: function(data){
            $('#spnInformacaoComprouProduto').text(data);
            $("#spnInformacaoComprouProduto").css("display", "block");
          },
          beforeSend: function(){
            $("#imgComprarProdutoProcessando").css("display", "block");
          },
          complete: function(){
            $("#imgComprarProdutoProcessando").css("display", "none");
            setTimeout(function(){
              $("#txtCompProdQtde").val('1');
              //reset tamanho
              $("#spnInformacaoComprouProduto").css("display", "none");
              $('#mask').hide();
              $('.window').hide();
              }
            ,1000);
          }
        });
        return false;
      }
    });

});
