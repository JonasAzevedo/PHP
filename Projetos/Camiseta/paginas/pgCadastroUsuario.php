<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgCadastroUsuario.php
  Função: página de cadastro de usuários
  Data de Criação: 09/02/2011 - 16:53
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  CriarDivCadUsuarioCabecalho()  //cria a div de cabeçalho
  CriarDivCadUsuarioFormularioCadastro()  //cria a div de conteúdo
  CriarDivLateralDireita() //cria a div da lateral direita
  CriarDivsAssociadasLinksLateralDireita() //cria as div's que serão associadas aos links da lateral direita
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    $pgCadastroUsuarios = new PgCadastroUsuarios();

    class PgCadastroUsuarios{
      function __construct(){
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarDivCadUsuarioCabecalho();
        $this->CriarDivCadUsuarioFormularioCadastro();
        $this->CriarDivLateralDireita();
        $this->CriarDivsAssociadasLinksLateralDireita();
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }

      //inicia HTML
      function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='../css/cPgCadastroUsuario.css' type='text/css' />";
          echo "<script type='text/javascript' src='../js/jPgCadastroUsuario.js'></script>";

          //jQuery
          echo "<script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>";
          //códigos jQuery da página
          echo "<script type='text/javascript' src='../js/jQryPgCadastroUsuario.js'></script>";
          //arquivo para o plugin jQuery de máscara para input's
          echo "<script type='text/javascript' src='../jQuery/plugin/masked_Input.js'></script>";
          //arquivo para o plugin jQuery de validação de formulário
          echo "<script language='JavaScript' src='../jQuery/plugin/validation/jquery.validate.js'></script>";
        echo "</head>";
      }
      

      //iniciar a tag body
      function IniciarBody(){
        echo "<body>";
      }


      //inicia a div principal do site
      function IniciarDivPrincipal(){
        echo "<div class='divCadastroUsuarios' name='divCadastroUsuarios' id='divCadastroUsuarios'>";
      }
      
      
      //cria a div de cabeçalho
      function CriarDivCadUsuarioCabecalho(){
        echo "<div class='divCadUsuarioCabecalho' name='divCadUsuarioCabecalho' id='divCadUsuarioCabecalho'>";
          echo "div do cabeçalho";
        echo "</div>";
      }
      
      
      //cria a div de conteúdo
      function CriarDivCadUsuarioFormularioCadastro(){
        echo "<div class='divCadUsuarioConteudo' name='divCadUsuarioConteudo' id='divCadUsuarioConteudo'>";
          echo "<div class='divTituloCadUsuario' name='divTituloCadUsuario' id='divTituloCadUsuario'>";
            echo "<span class='spnTituloCadastroUsuario' name='spnTituloCadastroUsuario' id='spnTituloCadastroUsuario'>" ."Cadastro de Usuário". "</span>";
          echo "</div>";
          
          echo "<form name='frmCadastroUsuario' id='frmCadastroUsuario' method='POST' onSubmit='return ValidarCadastroUsuario()' action='pgSubmeterUsuario.php?acao=novo'>";
            //nome
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaNome' id='divCadUsuarioLinhaNome'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioNome' id='spnTituloCadUsuarioNome'>" ."Nome: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioNome' id='lblTituloCadUsuarioNome'>Nome:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioNome' id='txtValorCadUsuarioNome' value='' maxlength='100' />";
            echo "</div>";

            //apelido - como você gostaria de ser chamado?
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaApelido' id='divCadUsuarioLinhaApelido'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioApelido' id='spnTituloCadUsuarioApelido'>" ."Apelido: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioApelido' id='lblTituloCadUsuarioApelido'>Apelido:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioApelido' id='txtValorCadUsuarioApelido' value='' maxlength='25' />";
              echo "<span class='spnInformacaoCadUsuario' name='spnInformacaoCadUsuarioApelido' id='spnInformacaoCadUsuarioApelido'>" ."digite aqui como você deseja ser chamado.". "</span>";
            echo "</div>";

            //email
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaEmail' id='divCadUsuarioLinhaEmail'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEmail' id='spnTituloCadUsuarioEmail'>" ."Email: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioEmail' id='lblTituloCadUsuarioEmail'>Email:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioEmail' id='txtValorCadUsuarioEmail' value='' maxlength='100' />";
            echo "</div>";

            //telefone
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaTelefone' id='divCadUsuarioLinhaTelefone'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioTelefone' id='spnTituloCadUsuarioTelefone'>" ."Telefone: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioTelefone' id='lblTituloCadUsuarioTelefone'>Telefone:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioTelefone' id='txtValorCadUsuarioTelefone' value='' maxlength='13' />";
              echo "<span class='spnInformacaoCadUsuario' name='spnInformacaoCadUsuarioTelefone' id='spnInformacaoCadUsuarioTelefone'>" ."Exemplo: (49)3555-1234". "</span>";
            echo "</div>";
          
            //data de nascimento
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaDataNascimento' id='divCadUsuarioLinhaDataNascimento'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioDataNascimento' id='spnTituloCadUsuarioDataNascimento'>" ."Data Nasc.: ". "</span>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioDataNascimento' id='txtValorCadUsuarioDataNascimento' value='' maxlength='10' />";
              echo "<span class='spnInformacaoCadUsuario' name='spnInformacaoCadUsuarioDataNascimento' id='spnInformacaoCadUsuarioDataNascimento'>" ."Exemplo: 11/09/2001". "</span>";
            echo "</div>";

            //sexo
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaSexo' id='divCadUsuarioLinhaSexo'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioSexo' id='spnTituloCadUsuarioSexo'>" ."Sexo: ". "</span>";
              echo "<input type='radio' class='rdGrupoSexo' name='rdGrupoSexo' id='rdGrupoSexoMasculino' value='Masculino' checked />";
                echo "<span class='spnSexo' name='spnSexoMasculino' id='spnSexoMasculino'>" ."Masculino ". "</span>";
              echo "<input type='radio' class='rdGrupoSexo' name='rdGrupoSexo' id='rdGrupoSexoFeminino' value='Feminino' />";
                echo "<span class='spnSexo' name='spnSexoFeminino' id='spnSexoFeminino'>" ."Feminino ". "</span>";
            echo "</div>";

            //título do endereço
            echo "<div class='divCadUsuarioLinhaTexto' name='divCadUsuarioLinhaTextoEndereco' id='divCadUsuarioLinhaTextoEndereco'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEndereco' id='spnTituloCadUsuarioEndereco'>" ."Endereço ". "</span>";
            echo "</div>";

            //endereço - uf
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaUF' id='divCadUsuarioLinhaUF'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEnderecoUF' id='spnTituloCadUsuarioEnderecoUF'>" ."UF: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioUF' id='lblTituloCadUsuarioUF'>UF:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioEnderecoUF' id='txtValorCadUsuarioEnderecoUF' value='' maxlength='2' />";
            echo "</div>";

            //endereço - cidade
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaCidade' id='divCadUsuarioLinhaCidade'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEnderecoCidade' id='spnTituloCadUsuarioEnderecoCidade'>" ."Cidade: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioCidade' id='lblTituloCadUsuarioCidade'>Cidade:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioEnderecoCidade' id='txtValorCadUsuarioEnderecoCidade' value='' maxlength='100' />";
            echo "</div>";

            //endereço - cep
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaCEP' id='divCadUsuarioLinhaCEP'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEnderecoCEP' id='spnTituloCadUsuarioEnderecoCEP'>" ."CEP: ". "</span>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioEnderecoCEP' id='txtValorCadUsuarioEnderecoCEP' value='' maxlength='9' />";
              echo "<a href='http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do?Metodo=menuEndereco' target='_blank' class='lnkBuscarCEP' name='lnkBuscarCEP' id='lnkBuscarCEP'>Não sei meu CEP</a>";
              echo "<span class='spnInformacaoCadUsuario' name='spnInformacaoCadUsuarioCEP' id='spnInformacaoCadUsuarioCEP'>" ."Exemplo: 89665-000". "</span>";
            echo "</div>";

            //endereço - bairro
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaBairro' id='divCadUsuarioLinhaBairro'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEnderecoBairro' id='spnTituloCadUsuarioEnderecoBairro'>" ."Bairro: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioBairro' id='lblTituloCadUsuarioBairro'>Bairro:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioEnderecoBairro' id='txtValorCadUsuarioEnderecoBairro' value='' maxlength='100' />";
            echo "</div>";
          
            //endereço - rua
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaRua' id='divCadUsuarioLinhaRua'>";
//xxxxx              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEnderecoRua' id='spnTituloCadUsuarioEnderecoRua'>" ."Rua: ". "</span>";
              echo "<label class='lblTituloCadUsuario' name='lblTituloCadUsuarioRua' id='lblTituloCadUsuarioRua'>Rua:</label>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioEnderecoRua' id='txtValorCadUsuarioEnderecoRua' value='' maxlength='100' />";
            echo "</div>";

            //endereço - número
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaNumero' id='divCadUsuarioLinhaNumero'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEnderecoNumero' id='spnTituloCadUsuarioEnderecoNumero'>" ."Nº: ". "</span>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioEnderecoNumero' id='txtValorCadUsuarioEnderecoNumero' value='' maxlength='20' />";
            echo "</div>";

            //endereço - complemento
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaComplemento' id='divCadUsuarioLinhaComplemento'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioEnderecoComplemento' id='spnTituloCadUsuarioEnderecoComplemento'>" ."Complemento: ". "</span>";
              echo "<textarea  name='txtAreaValorCadUsuarioEnderecoComplemento' id='txtAreaValorCadUsuarioEnderecoComplemento' maxlength='200'></textarea>";
            echo "</div>";
          
            //título do login
            echo "<div class='divCadUsuarioLinhaTexto' name='divCadUsuarioLinhaTextoLogin' id='divCadUsuarioLinhaTextoLogin'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioLogin' id='spnTituloCadUsuarioLogin'>" ."Login ". "</span>";
            echo "</div>";

            //login
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaLogin' id='divCadUsuarioLinhaLogin'>";
              echo "<span class='spnTituloCadUsuario' name='divCadUsuarioLinhaLogin' id='divCadUsuarioLinhaLogin'>" ."Login: ". "</span>";
              echo "<input type='text' class='txtValorCadUsuario' name='txtValorCadUsuarioLogin' id='txtValorCadUsuarioLogin' value='' maxlength='20' />";
            echo "</div>";

            //senha
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaSenha1' id='divCadUsuarioLinhaSenha1'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioSenha1' id='spnTituloCadUsuarioSenha1'>" ."Senha: ". "</span>";
              echo "<input type='password' class='txtValorCadUsuarioSenha' name='txtValorCadUsuarioSenha1' id='txtValorCadUsuarioSenha1' value='' maxlength='20' onkeyup='VerificarNivelSenha();' />";
              echo "<table class='tblNivelSenha' name='tblNivelSenha' id='tblNivelSenha'></table>";
            echo "</div>";
          
            //confirme senha
            echo "<div class='divCadUsuarioLinhaDados' name='divCadUsuarioLinhaSenha2' id='divCadUsuarioLinhaSenha2'>";
              echo "<span class='spnTituloCadUsuario' name='spnTituloCadUsuarioSenha2' id='spnTituloCadUsuarioSenha2'>" ."Confirme: ". "</span>";
              echo "<input type='password' class='txtValorCadUsuarioSenha' name='txtValorCadUsuarioSenha2' id='txtValorCadUsuarioSenha2' value='' maxlength='20' />";
            echo "</div>";
          
            //botões para salvar/limpar/cancelar
            echo "<div class='divCadUsuarioBotoes' name='divCadUsuarioBotoes' id='divCadUsuarioBotoes'>";
              echo "<input type='submit' class='btnSalvar' name='btnSalvar' id='btnSalvar' value='Salvar' />";
              echo "<input type='reset' class='btnLimpar' name='btnLimpar' id='btnLimpar' value='Limpar' onclick='Limpar();' />";
              echo "<input type='button' class='btnCancelar' name='btnCancelar' id='btnCancelar' value='Cancelar' />";
            echo "</div>";
          echo "</form>";
        echo "</div>";
      }
      
      
      //cria a div da lateral direita
      private function CriarDivLateralDireita(){
        echo "<div class='divCadUsuarioLatDireita' name='divCadUsuarioLatDireita' id='divCadUsuarioLatDireita'>";
          echo "<a href='' class='aLnkOpcLatDireita' name='aLnkQuemSomos' id='aLnkQuemSomos'>Quem Somos</a>";
          echo "<br />";
          echo "<a href='' class='aLnkOpcLatDireita' name='aLnkVantagens' id='aLnkVantagens'>Vantagens de ser usuário</a>";
          echo "<br />";
          echo "<a href='' class='aLnkOpcLatDireita' name='aLnkServicosOferecidos' id='aLnkServicosOferecidos'>Serviços oferecidos</a>";
          echo "<br />";
          echo "<a href='' class='aLnkOpcLatDireita' name='aLnkPrivacidade' id='aLnkPrivacidade'>Privacidade</a>";
          echo "<br />";
          echo "<a href='' class='aLnkOpcLatDireita' name='aLnkFaleConosco' id='aLnkFaleConosco'>Fale Conosco</a>";
        echo "</div>";
      } //fim - CriarDivLateralDireita()
      
      
      //cria as div's que serão associadas aos links da lateral direita
      private function CriarDivsAssociadasLinksLateralDireita(){
        //quem somos
        echo "<div class='divCadUsuarioOpcLatDireita' name='divCadUsuarioQuemSomos' id='divCadUsuarioQuemSomos'>";
          echo "<div class='divLinkFechar' name='divLinkFecharQuemSomos' id='divLinkFecharQuemSomos'>";
            echo "<a href='' class='aLnkFechar' name='aLnkFecharQuemSomos' id='aLnkFecharQuemSomos'>Fechar</a>";
          echo "</div>";
          echo "<div class='divPopupConteudo' name='divPopupConteudoQuemSomos' id='divPopupConteudoQuemSomos'>";
            echo "quem somos";
          echo "</div>";
        echo "</div>";
        
        //vantagens
        echo "<div class='divCadUsuarioOpcLatDireita' name='divCadUsuarioVantagens' id='divCadUsuarioVantagens'>";
          echo "<a href='' class='aLnkFechar' name='aLnkFecharVantagens' id='aLnkFecharVantagens'>Fechar</a>";
          echo "<br />";
          echo "vantagens";
        echo "</div>";

        //serviços oferecidos
        echo "<div class='divCadUsuarioOpcLatDireita' name='divCadUsuarioServicosOferecidos' id='divCadUsuarioServicosOferecidos'>";
          echo "<a href='' class='aLnkFechar' name='aLnkFecharServicosOferecidos' id='aLnkFecharServicosOferecidos'>Fechar</a>";
          echo "<br />";
          echo "serviços oferecidos";
        echo "</div>";

        //privacidade
        echo "<div class='divCadUsuarioOpcLatDireita' name='divCadUsuarioPrivacidade' id='divCadUsuarioPrivacidade'>";
          echo "<a href='' class='aLnkFechar' name='aLnkFecharPrivacidade' id='aLnkFecharPrivacidade'>Fechar</a>";
          echo "<br />";
          echo "privacidade";
        echo "</div>";

        //fale conosco
        echo "<div class='divCadUsuarioOpcLatDireita' name='divCadUsuarioFaleConosco' id='divCadUsuarioFaleConosco'>";
          echo "<a href='' class='aLnkFechar' name='aLnkFecharFaleConosco' id='aLnkFecharFaleConosco'>Fechar</a>";
          echo "<br />";
          echo "fale conosco";
        echo "</div>";
      } //fim - CriarDivsAssociadasLinksLateralDireita()
      

      //finaliza a div principal
      function FecharDivPrincipal(){
        echo "</div>";
      }


      //finaliza a tag body
      function FecharBody(){
        echo "</body>";
      }

      //finaliza HTML
      function FecharHTML(){
        echo "</html>";
      }
      
    } //fim - class PgCadastroUsuarios
?>
