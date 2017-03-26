<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgIdentificacaoUsuario.php
  Função: página que realiza a identificação/login do usuário
  Data de Criação: 14/02/2011 - 10:39
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
  IncluirDivLoginUsuario()  //inclui a div que realiza o login do usuário
  CriarDivRecuperarSenha() //cria a div para auxiliar usuário a recuperar a senha
  IncluirDivUsuarioLogado()  //inclui a div para apresentar os dados do usuário logado
  FecharDivPrincipal()
  FecharBody()
  VerificarQueDivDeveSerExibida()  //verifica qual div deve ser exibida, com base se já foi gerada a sessão
  FecharHTML()
-->

<?php
    class PgIdentificacaoUsuario{

	  function __construct(){
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->IncluirDivLoginUsuario();
        $this->CriarDivRecuperarSenha();
        $this->IncluirDivUsuarioLogado();
        $this->FecharDivPrincipal();
        $this->VerificarQueDivDeveSerExibida();
        $this->FecharBody();
        $this->FecharHTML();
	  }
	  
      //inicia HTML
      private function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='./css/cPgIdentificacaoUsuario.css' type='text/css' />";
          echo "<script language='JavaScript' src='./js/jPgIdentificacaoUsuario.js'></script>";
          echo "<script language='JavaScript' src='./js/jQryPgIdentificacaoUsuario.js'></script>";
          //arquivos para o plugin de janela modal do jQuery
          echo "<script language='JavaScript' src='./jQuery/plugin/janelaModal.js'></script>";
          echo "<link rel='stylesheet' href='./css/jQuery/cJnlModalIdentificacaoUsuario.css' type='text/css' />";
        echo "</head>";
      } //fim - iniciarHTML()
      

      //iniciar a tag body
      private function IniciarBody(){
        echo "<body>";
      } //fim - iniciarBody()


      //inicia a div principal
      private function IniciarDivPrincipal(){
        echo "<div class='divPrincIdentificacaoUsuario' name='divPrincIdentificacaoUsuario' id='divPrincIdentificacaoUsuario'>";
      } //fim - iniciarDivPrincipal()


      //inclui a div que realiza o login do usuário
      private function IncluirDivLoginUsuario(){
        echo "<div class='divLoginUsuario' name='divLoginUsuario' id='divLoginUsuario'>";
        
          //meus itens - finalizar pedido
          echo  "<div class='divLinhaLoginUsuario' name='divLinhaLoginUsuario1' id='divLinhaLoginUsuario1'>";
            echo "<span class='spnTituloLogin' name='spnTituloLoginCarrinhoCompras' id = 'spnTituloLoginCarrinhoCompras'>" ."Meu Carrinho: ". "</span>";
            echo "<span class='spnValorLogin' name='spnValorLoginCarrinhoCompras' id='spnValorLoginCarrinhoCompras'>" ."0". "</span>";
            echo "<a href='./paginas/pgFinalizarCompra.php' class='lnkFinalizarCompra' name='lnkFinalizarCompraSemUsuarioLogado' id='lnkFinalizarCompraSemUsuarioLogado'>Finalizar Compra</a>";
          echo "</div>";
          
          //realizar login
          echo  "<div class='divLinhaLoginUsuario' name='divLinhaLoginUsuario2' id='divLinhaLoginUsuario2'>";
            echo "<span class='spnTituloLogin' name='spnTituloLoginUsuario' id='spnTituloLoginUsuario'>" ."Login: ". "</span>";
            echo "<input type='text' class='txtValorItemLogin' name='txtValorItemLoginUsuario' id='txtValorItemLoginUsuario' value='' maxlength='10' />";
            echo "<span class='spnTituloLogin' name='spnTituloLoginSenha' id='spnTituloLoginSenha'>" ."Senha: ". "</span>";
            echo "<input type='password' class='txtValorItemLogin' name='txtValorItemLoginSenha' id='txtValorItemLoginSenha' value='' maxlength='20' />";

            echo "<a href='' onclick='RealizarLoginUsuario(txtValorItemLoginUsuario.value,txtValorItemLoginSenha.value)' ";
            echo "class='lnkRealizarLogin' name='lnkRealizarLogin' id='lnkRealizarLogin'>";
              echo "<img class='imgRealizarLogin' name='imgRealizarLogin' id='imgRealizarLogin' src='./figuras/botao.png' />";
            echo "</a>";
          echo  "</div>";


          //esqueci minha senha - cadastro de usuário
          echo  "<div class='divLinhaLoginUsuario' name='divLinhaLoginUsuario3' id='divLinhaLoginUsuario3'>";
            //atributo name do link abaixo, deve ser igual ao atributo id da div que será a janela modal
            //atributo class usado no arquivo janelaModal.js
            echo "<a href='#janelaRecuperarSenha' class='lnkRecuperarSenha' name='modal'>Esqueci minha senha</a>";
            echo "<a href='./paginas/pgCadastroUsuario.php' class='lnkCadastroUsuario' name='lnkCadastroUsuario' id='lnkCadastroUsuario'>Realizar Cadastro</a>";
          echo  "</div>";
        echo "</div>"; //fim - divLoginUsuario
      } //fim - IncluirDivLoginUsuario()
      
      
      //cria a div para auxiliar usuário a recuperar a senha
      private function CriarDivRecuperarSenha(){
        echo "<div id='boxes'>";
          echo "<div id='janelaRecuperarSenha' class='window dialog'>";
            echo "<a href='#' class='close'>Fechar [X]</a>";
              echo "<br />";
              echo "<span class='spnTituloEsqueciMinhaSenha' name='spnTituloEsqueciMinhaSenha' id='spnTituloEsqueciMinhaSenha'>";
                echo "Se você já possui cadastro em nosso site e esqueceu sua senha, digite abaixo seu login ou e-mail:";
              echo "</span>";
              echo "<br /><br />";

              echo "<span class='spnTituloOpcRecuperarSenha' name='spnTituloOpcRecuperarSenhaLogin' id='spnTituloOpcRecuperarSenhaLogin'>" ."Login: ". "</span>";
              echo "<input type='text' class='txtValorOpcRecuperarSenha' name='txtValorOpcRecuperarSenhaLogin' id='txtValorOpcRecuperarSenhaLogin' value='' maxlength='20' />";
              echo "<br />";

              echo "<span class='spnTituloOpcRecuperarSenha' name='spnTituloOpcRecuperarSenhaEmail' id='spnTituloOpcRecuperarSenhaEmail'>" ."Email: ". "</span>";
              echo "<input type='text' class='txtValorOpcRecuperarSenha' name='txtValorOpcRecuperarSenhaEmail' id='txtValorOpcRecuperarSenhaEmail' value='' maxlength='100' />";
              echo "<br />";

              //echo "<input type='button' class='btnRecuperarSenha' name='btnRecuperarSenha' id='btnRecuperarSenha' value='Recuperar' onclick='RecuperarSenha(txtValorOpcRecuperarSenhaLogin.value,txtValorOpcRecuperarSenhaEmail.value)' />";
              echo "<input type='button' class='btnRecuperarSenha' name='btnRecuperarSenha' id='btnRecuperarSenha' value='Recuperar' />";
              echo "<img class='imgRecuperarSenhaProcessando' name='imgRecuperarSenhaProcessando' id='imgRecuperarSenhaProcessando' src='./figuras/processando/barra.gif' />";
              echo "<span class='spnInformacaoRecuperouSenha' name='spnInformacaoRecuperouSenha' id='spnInformacaoRecuperouSenha'>";
                echo "";
              echo "</span>";
          echo "</div>";

          //Máscara para cobrir a tela
          echo "<div id='mask'></div>";
        echo "</div>";
      } //CriarDivRecuperarSenha()


      //inclui a div para apresentar os dados do usuário logado
      private function IncluirDivUsuarioLogado(){
        echo "<div class='divUsuarioLogado' name='divUsuarioLogado' id='divUsuarioLogado'>";
        
          echo  "<div class='divLinhaUsuarioLogado' name='divLinhaUsuarioLogado1' id='divLinhaUsuarioLogado1'>";
            echo "<span class='spnTituloLogado' name='spnTituloLogadoUsuario' id='spnTituloLogadoUsuario'>" ."Olá ". "</span>";
            echo "<span class='spnValorLogado' name='spnValorLogadoUsuario' id='spnValorLogadoUsuario'>" ."". "</span>";
            echo "<a href='javascript: RealizarLogoffUsuario();' class='lnkLogoff' name='lnkLogoff' id='lnkLogoff'>(Sair)</a>";
          echo "</div>";
          
          echo  "<div class='divLinhaUsuarioLogado' name='divLinhaUsuarioLogado2' id='divLinhaUsuarioLogado2'>";
            echo "<img class='imgFiguraCarrinho' name='imgFiguraCarrinho' id='imgFiguraCarrinho' src='./figuras/carrinho.jpg' />";
            echo "<span class='spnTituloLogado' name='spnTituloLogadoCarrinhoCompras' id = 'spnTituloLogadoCarrinhoCompras'>" ."Meu Carrinho: ". "</span>";
            echo "<span class='spnValorLogado' name='spnValorLogadoCarrinhoCompras' id='spnValorLogadoCarrinhoCompras'>" ."". "</span>";
            echo "<a href='./paginas/pgFinalizarCompra.php' class='lnkFinalizarCompra' name='lnkFinalizarCompraUsuarioLogado' id='lnkFinalizarCompraUsuarioLogado'>Finalizar Compra</a>";
          echo "</div>";
          
          echo  "<div class='divLinhaUsuarioLogado' name='divLinhaUsuarioLogado3' id='divLinhaUsuarioLogado3'>";
            echo "<a href='./paginas/pgUsuarioMeuCadastro.php' class='lnkMeuCadastro' name='lnkMeuCadastro' id='lnkMeuCadastro'>Meu Cadastro</a>";
          echo "</div>";

        echo "</div>";
      } //fim - IncluirDivUsuarioLogado()


      //finaliza a div principal
      private function FecharDivPrincipal(){
        echo "</div>";
      }

      //finaliza tag body
      private function FecharBody(){
        echo "</body>";
      }


      //verifica qual div deve ser exibida, com base se já foi gerada a sessão
      private function VerificarQueDivDeveSerExibida(){
        ?>
        <script language='JavaScript'>
          VerificarExisteSessaoLoginUsuario();
        </script>
        <?php
      } //fim - VerificarQueDivDeveSerExibida()


      //finaliza HTML
      private function FecharHTML(){
        echo "</html>";
      }

    } //fim - class PgIdentificacaoUsuario
?>
