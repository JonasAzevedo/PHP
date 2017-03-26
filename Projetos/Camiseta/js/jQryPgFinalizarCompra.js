/*******************************************************************
********************************************************************
  Nome: jQryPgFinalizarCompra.js
  Função: arquivo com funções jQuery da página pgFinalizarCompra.php
  Data de Criação: 28/03/2011 - 09:50
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

/*
//function's:
  IrParaPasso(pnPasso) //altera o passo-a-passo atual
*/


$(document).ready(function(){
//altera o passo-a-passo atual
function IrParaPasso(pnPasso){
    if((pnPasso>0)&&(pnPasso<5)){
      $(".divFinCompPasso").css("display", "none");
      $("#divFinCompPasso"+pnPasso).css("display", "block");
    }
} //fim - IrParaPasso()

    //o padrão, é que o passo de confirmar produtos já esteja ok
    $("#divPassoPasso1").css("background-color", "#678");

    //máscara
    $('#txtValorEnderecoEntregaUF').mask("aa");
    $("#txtValorEnderecoEntregaCEP").mask("99999-999");

    /*******************************************************************************************
    ****************** validação do formulário para salvar endereço de entrega *****************
    *******************************************************************************************/
    $("#frmCadEnderecoEntrega").validate({
      //define as regras
      rules:{
        txtValorEnderecoEntregaUF:{
          required: true, minlength: 2
        },
        txtValorEnderecoEntregaCidade:{
          required: true
        },
        txtValorEnderecoEntregaCEP:{
          required: true,minlength: 9
        },
        txtValorEnderecoEntregaBairro:{
          required: true
        },
        txtValorEnderecoEntregaRua:{
          required: true
        },
      },
      //define as mensagens de erro para cada regra
      messages:{
        txtValorEnderecoEntregaUF:{
          required: "Digite a UF",
          minlength: "UF deve conter 2 caracteres",
        },
        txtValorEnderecoEntregaCidade:{
          required: "Digite a Cidade",
        },
        txtValorEnderecoEntregaCEP:{
          required: "Digite o CEP",
          minlength: "CEP deve conter 9 caracteres",
        },
        txtValorEnderecoEntregaBairro:{
          required: "Digite o Bairro",
        },
        txtValorEnderecoEntregaRua:{
          required: "Digite a Rua",
        },
      },
      //chamada AJAX para salvar endereço de entrega
      submitHandler: function(form){
        var dados = $(form).serialize();

        $.ajax({
          type: "POST",
          url: "../pgAjaxFinalizarEnderecoEntrega.php",
          data: dados,
          success: function(data){
            $('#spnInformacaoSalvouEndEntrega').text(data);
            $("#spnInformacaoSalvouEndEntrega").css("display", "block");
          },
          beforeSend: function(){
            $("#imgProcessandoSalvarEndEntrega").css("display", "block");
          },
          complete: function(){
            $("#imgProcessandoSalvarEndEntrega").css("display", "none");
            setTimeout(function(){
              $("#divPassoPasso2").css("background-color", "#678");
              IrParaPasso('3');
              $("#spnInformacaoSalvouEndEntrega").css("display", "none");
            }
            ,1000);
          }
        });
        return false;
      }
    });
    
    
    /*******************************************************************************************
    ************************************** calculando frete ************************************
    *******************************************************************************************/
      $('#btnCalcularFrete').click(function(evt){
        var nCdPedidoCompra = $('#edCdPedidoCompra').val();
        var dados = "nCdPedidoCompra=" + nCdPedidoCompra;

        $.ajax({
          type: "POST",
          url: "../pgAjaxCalcularFrete.php",
          data: dados,
          success: function(data){
            var oJson = eval(data);

            $('#spnVlrExibeDadosCalculoFreteCEP_Origem').text(oJson[0].CEP_Origem);
            $('#spnVlrExibeDadosCalculoFreteCEP_Destino').text(oJson[0].CEP_Destino);
            $('#spnVlrExibeDadosCalculoFretePeso').text(oJson[0].peso);
            $('#spnValorServicoFretePAC').text(oJson[0].valorPAC);
            $('#rdBtnServicoFretePAC').val(oJson[0].valorPAC);
            $('#spnValorServicoFreteSedex').text(oJson[0].valorSEDEX);
            $('#rdBtnServicoFreteSedex').val(oJson[0].valorSEDEX);
            $('#spnValorServicoFreteSedex10').text(oJson[0].valorSEDEX_10);
            $('#rdBtnServicoFreteSedex10').val(oJson[0].valorSEDEX_10);
            $('#spnValorServicoFreteSedexHoje').text(oJson[0].valorSEDEX_HOJE);
            $('#rdBtnServicoFreteSedexHoje').val(oJson[0].valorSEDEX_HOJE);
          },
          beforeSend: function(){
          },
          complete: function(){
          }
        }, "json");

      }); //fim - $('#btnCalcularFrete').click(function(evt)

    /*******************************************************************************************
    ************************************* selecionando frete ***********************************
    *******************************************************************************************/
      $('#btnSelecaoTipoFrete').click(function(evt){
        var nCdPedidoCompra = $('#edCdPedidoCompra').val();
        var dValor = "";
        var sID = "";
        $('.rdBtnServico').each(function(){
          if ($(this).is(':checked')){
            dValor = $(this).val();
            sID = $(this).attr('id');
          }
        });
        var dados = "nCdPedidoCompra=" + nCdPedidoCompra + "&sTipoFrete=" + sID + "&dValorFrete=" + dValor;

        $.ajax({
          type: "POST",
          url: "../pgAjaxSelecionarFrete.php",
          data: dados,
          success: function(data){
            alert(data);
          },
          beforeSend: function(){
          },
          complete: function(){
          }
        });
      }); //fim - $('#btnSelecaoTipoFrete').click(function(evt){

});
