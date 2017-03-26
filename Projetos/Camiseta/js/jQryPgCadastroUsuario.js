/*******************************************************************
********************************************************************
  Nome: jQryPgCadastroUsuario.js
  Função: arquivo com funções jQuery da página pgCadastroUsuario.php
  Data de Criação: 17/03/2011 - 10:39
  Data de Atualização: -
  Desenvolvido por: Jonas
********************************************************************
********************************************************************/

$(document).ready(function(){
    //divCadUsuarioConteudo
    $('#txtValorCadUsuarioNome').blur(function(evt){
      var vlr = $('#txtValorCadUsuarioNome').val();
      $('#txtValorCadUsuarioApelido').val(vlr);
    });
    
    
    $('#txtValorCadUsuarioApelido').focus(function(evt){
      $('#spnInformacaoCadUsuarioApelido').css("display", "block");
    });
    $('#txtValorCadUsuarioApelido').blur(function(evt){
      $('#spnInformacaoCadUsuarioApelido').css("display", "none");
    });
    
    
    $('#txtValorCadUsuarioTelefone').focus(function(evt){
      $('#spnInformacaoCadUsuarioTelefone').css("display", "block");
    });
    $('#txtValorCadUsuarioTelefone').blur(function(evt){
      $('#spnInformacaoCadUsuarioTelefone').css("display", "none");
    });
    $('#txtValorCadUsuarioTelefone').mask("(99)9999-9999");
    
    
    $('#txtValorCadUsuarioDataNascimento').focus(function(evt){
      $('#spnInformacaoCadUsuarioDataNascimento').css("display", "block");
    });
    $('#txtValorCadUsuarioDataNascimento').blur(function(evt){
      $('#spnInformacaoCadUsuarioDataNascimento').css("display", "none");
    });
    $('#txtValorCadUsuarioDataNascimento').mask("99/99/9999");
    

    $('#txtValorCadUsuarioEnderecoUF').mask("aa");

    
    $('#txtValorCadUsuarioEnderecoCEP').focus(function(evt){
      $('#spnInformacaoCadUsuarioCEP').css("display", "block");
    });
    $('#txtValorCadUsuarioEnderecoCEP').blur(function(evt){
      $('#spnInformacaoCadUsuarioCEP').css("display", "none");
    });
    $("#txtValorCadUsuarioEnderecoCEP").mask("99999-999");
    
    
    //divCadUsuarioLatDireita
    $('#aLnkQuemSomos').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioQuemSomos').show(1000);
    });
    $('#aLnkFecharQuemSomos').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioQuemSomos').hide("slow");
    });
    
    $('#aLnkVantagens').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioVantagens').show(1000);
    });
    $('#aLnkFecharVantagens').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioVantagens').hide("slow");
    });
    
    $('#aLnkServicosOferecidos').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioServicosOferecidos').show(1000);
    });
    $('#aLnkFecharServicosOferecidos').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioServicosOferecidos').hide("slow");
    });

    $('#aLnkPrivacidade').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioPrivacidade').show(1000);
    });
    $('#aLnkFecharPrivacidade').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioPrivacidade').hide("slow");
    });

    $('#aLnkFaleConosco').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioFaleConosco').show(1000);
    });
    $('#aLnkFecharFaleConosco').click(function(evt){
      evt.preventDefault();
      $('#divCadUsuarioFaleConosco').hide("slow");
    });
    
    
    $("#frmCadastroUsuario").validate({
      //define as regras
      rules:{
        txtValorCadUsuarioNome:{
          required: true
        },
        txtValorCadUsuarioEmail:{
          required: true, email: true
        },
        //IMPLEMENTAR VALIDAÇÃO DA DATA
/////        txtValorCadUsuarioDataNascimento:{
/////          date:true
/////        }
        txtValorCadUsuarioEnderecoUF:{
          required: true, minlength: 2
        },
        txtValorCadUsuarioEnderecoCidade:{
          required: true
        },
        txtValorCadUsuarioEnderecoBairro:{
          required: true
        },
        txtValorCadUsuarioEnderecoRua:{
          required: true
        },
      },
      //define as mensagens de erro para cada regra
      messages:{
        txtValorCadUsuarioNome:{
          required: "Digite o Nome"
        },
        txtValorCadUsuarioEmail:{
          required: "Digite o Email",
          email: "Digite um Email válido"
        },
        txtValorCadUsuarioEnderecoUF:{
          required: "Digite a UF",
          minlength: "A UF deve conter 2 caracteres"
        },
        txtValorCadUsuarioEnderecoCidade:{
          required: "Digite a Cidade"
        },
        txtValorCadUsuarioEnderecoBairro:{
          required: "Digite o Bairro"
        },
        txtValorCadUsuarioEnderecoRua:{
          required: "Digite a Rua"
        },
      },
    });

    
});
