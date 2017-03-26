/*******************************************************************
********************************************************************
  Nome: jQryPgProdutos.js
  Função: arquivo com funções jQuery da página pgProdutos.php
  Data de Criação: 27/03/2011 - 14:49
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function(){
    /*******************************************************************************************
    ************************** ao posicionar o mouse sobre a divProduto ************************
    *******************************************************************************************/
   $(".divProduto").mouseover(function(event){
     $(this).removeClass("divProduto");
     $(this).addClass("divProdutoFoco");
   });
   //ao retirar o mouse sobre a divProduto
   $(".divProduto").mouseout(function(event){
     $(this).removeClass("divProdutoFoco");
     $(this).addClass("divProduto");
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
        $.ajax({
          type: "POST",
          url: "./pgAjaxComprarItemProduto.php",
          data: dados,
          success: function(data){
            $('#spnInformacaoComprouProduto').text(data);
            $("#spnInformacaoComprouProduto").css("display", "inline-block");
          },
          beforeSend: function(){
            $("#imgComprarProdutoProcessando").css("display", "inline-block");
          },
          complete: function(){
            $("#imgComprarProdutoProcessando").css("display", "none");
            setTimeout(function(){
              $("#txtCompProdQtde").val('1');
              $('#sctTamanho option[value="P"]').attr({ selected : "selected" }); //reset tamanho
              $("#spnInformacaoComprouProduto").css("display", "none");
              $('#mask').hide();
              $('.window').hide();
              }
            ,1000);
            
            //atualizar o total de itens do pedido da compra
            $.ajax({
              type: "POST",
              url: "./pgAjaxRetornarTotalItensPedido.php",
              data: null,
              success: function(nTot){
                $('#spnValorLogadoCarrinhoCompras').text(nTot);
                $('#spnValorLoginCarrinhoCompras').text(nTot);
                if(nTot > 0){
                  $("#lnkFinalizarCompraSemUsuarioLogado").css("visibility", "visible");
                  $("#lnkFinalizarCompraUsuarioLogado").css("visibility", "visible");
                }
                else{
                  $("#lnkFinalizarCompraSemUsuarioLogado").css("visibility", "hidden");
                  $("#lnkFinalizarCompraUsuarioLogado").css("visibility", "hidden");
                }
              }
            });
          }
        });
        return false;
      }

    });

});
