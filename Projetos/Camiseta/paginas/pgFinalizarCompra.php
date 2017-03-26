<?php
/*******************************************************************
********************************************************************
  Nome: pgFinalizarCompra.php
  Função: página que realiza a finalização da compra
  Data de Criação: 22/02/2011 - 10:03
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: http://localhost/VENDA_CAMISETA/paginas/pgFinalizarCompra.php
********************************************************************
*******************************************************************/

/*
//function's:
  IniciarSession()
  FormatarValorMonetario($pdValor) //formata parâmetro '$pdValor' para valor monetário
  SolicitarArquivos()
  InicializarVariaveis()
  IniciarHTML()
  IniciarBody()
  CriarDivFinCompCabecalho() //cria a div de cabeçalho
  CriarDivFinCompLateralEsquerda() //cria a div da lateral esquerda
  SelecionarImagensProdutosMinhCompra() //seleciona as imagens dos produtos da minha compra
  SelecionarProdutosMinhaCompra() //seleciona os produtos da minha compra
  CriarDivFinCompConteudo() //cria a div do conteúdo
  RealizarLogin() //realiza login do usuário
  CriarDivRecuperarSenha() //cria a div para auxiliar usuário a recuperar a senha
  ExibirProdutosMinhaCompra() //exibe os produtos da minha compra - (passo 1)
  ExibirEnderecoEntrega() //exibe o endereço de entrega - (passo 2)
  ExibirCalcularFrete() //exibe o cálculo do frete - (passo 3)
  CriarDivFinCompConteudoBranco() //cria a div com conteúdo em branco, caso não tenha produtos em minha compra
  CriarCampoHidden() //cria os campos hidden necessários para a página
  FecharBody()
  FecharHTML()
*/

    $pgFinalizarCompra = new PgFinalizarCompra();

    class PgFinalizarCompra{
      //bd
      private $Fbd;
      private $sSql;

      private $nCdUsuario; //usuário que está realizando a compra. $_SESSION
      private $nCdPedidoCompra; //código do pedido da compra
      
      private $oDadosMeuCarrinho; //meu carrinho - dados da minha compra
      private $nTotalProdutos; //total de produtos da minha compra
      
      private $oDadosFigurasMeuCarrinho; //figuras dos produtos do meu carrinho. Figura principal de cada produto
      private $nTotalFigurasProdutos; //total de figuras dos produtos da minha compra
      
      private $dValorTotal; //valor total da compra

      function __construct(){
        $this->IniciarSession();
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->CriarDivFinCompCabecalho();
        //somente pode finalizar compra, se existe um pedido de compra
        if($this->nCdPedidoCompra != 0){
          //busca produtos comprados
          $this->SelecionarProdutosMinhaCompra();
          if($this->nTotalProdutos > 0){
            //busca figuras dos produtos comprados
            $this->SelecionarImagensProdutosMinhCompra();
            $this->CriarDivFinCompLateralEsquerda(); //div irá conter as imagens dos produtos comprados
            $this->CriarDivFinCompConteudo();
          }
          else{
            $this->CriarDivFinCompConteudoBranco();
          }
          $this->CriarCampoHidden();
        }
        
        $this->FecharBody();
        $this->FecharHTML();
      }


      //inicia a sessão que armazena os do usuário logado no site
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      }
      

      //formata parâmetro '$pdValor' para valor monetário
      private function FormatarValorMonetario($pdValor){
        //$sValor = str_replace(array(".", ","), "", $pdValor);
        $sValor = str_replace(array(","), "", $pdValor);
        $dNumFormatado = number_format($sValor,2,',','.');
        return $dNumFormatado;
      } //fim - FormatarValorMonetario()


	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("../classes/ConexaoBD.php");
	  }


      private function InicializarVariaveis(){
        if(isset($_SESSION["nCodigo"])){
          $this->nCdUsuario = $_SESSION["nCodigo"];
        }
        else{
          $this->nCdUsuario = 0;
        }

        //pedido_compra
        if(isset($_SESSION["nIdCompra"])){
          $this->nCdPedidoCompra = $_SESSION["nIdCompra"];
        }
        else{
          $this->nCdPedidoCompra = 0;
        }

        //bd
        $this->Fbd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        
        $this->oDadosMeuCarrinho = null;
        $this->nTotalProdutos = 0;
        
        $this->oDadosFigurasMeuCarrinho = null;
        $this->nTotalFigurasProdutos = 0;
        
        $this->dValorTotal = 0;
      } //fim - InicializarVariaveis()


      //inicia HTML
      private function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='../css/cPgFinalizarCompra.css' type='text/css' />";
          echo "<script language='JavaScript' src='../js/jPgFinalizarCompra.js'></script>";
          //jQuery
          echo "<script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>";
          //códigos jQuery da página
          echo "<script type='text/javascript' src='../js/jQryPgFinalizarCompra.js'></script>";
          //arquivos para o plugin de janela modal do jQuery
          echo "<script language='JavaScript' src='../jQuery/plugin/janelaModal.js'></script>";
          echo "<link rel='stylesheet' href='../css/jQuery/janelaModal.css' type='text/css' />";
          //arquivo para o plugin jQuery de máscara para input's
          echo "<script type='text/javascript' src='../jQuery/plugin/masked_Input.js'></script>";
          //arquivo para o plugin jQuery de validação de formulário
          echo "<script language='JavaScript' src='../jQuery/plugin/validation/jquery.validate.js'></script>";
        echo "</head>";
      }
      

      //iniciar a tag body
      private function IniciarBody(){
        echo "<body>";
      }


      //cria a div de cabeçalho
      private function CriarDivFinCompCabecalho(){
        echo "<div class='divFinCompCabecalho' name='divFinCompCabecalho' id='divFinCompCabecalho'>";
          echo "div do cabeçalho";
        echo "</div>";
      }


      //cria a div da lateral esquerda
      private function CriarDivFinCompLateralEsquerda(){
        echo "<div class='divFinCompLateralEsquerda' name='divFinCompLateralEsquerda' id='divFinCompLateralEsquerda'>";
          //mostra as imagens dos produtos comprados
          if($this->nTotalFigurasProdutos > 0){
            $i = 1;
            $sFigura;
            foreach($this->oDadosFigurasMeuCarrinho as $oRegistro){
            $sFigura = "." . $oRegistro->imagem;
              echo "<img class='imgProdutoComprado' name='imgProdutoComprado".$i."' id='imgProdutoComprado".$i."' src='" .$sFigura. "' />";
              $i++;
            }
          }
          else{
            echo "Não há imagens dos produtos comprados para serem exibidas.div da lateral esquerda";
          }

        echo "</div>";
      }


      //seleciona as imagens dos produtos da minha compra
      private function SelecionarImagensProdutosMinhCompra(){
        if ($this->nCdPedidoCompra != 0){
          $this->sSql = "SELECT i.cdImagemCamiseta, i.imagem, i.nome";
          $this->sSql .= " FROM imagem_camiseta i";
          $this->sSql .= " WHERE i.cdFkCamiseta IN";
          $this->sSql .= " (SELECT ipc.cdFkProduto FROM item_pedido_compra ipc";
          $this->sSql .= " WHERE ipc.cdFkPedidoCompra = '".$this->nCdPedidoCompra."'";
          $this->sSql .= "AND ipc.status = 'aberto')";
          $this->sSql .= " AND i.is_principal = 'S'";
          
          $this->oDadosFigurasMeuCarrinho = $this->Fbd->PesquisarSQL($this->sSql);

          if($this->oDadosFigurasMeuCarrinho){
            $this->nTotalFigurasProdutos = count($this->oDadosFigurasMeuCarrinho);
          }
          else{
            $this->nTotalFigurasProdutos = 0;
          }
        }
      } //fim - SelecionarImagensProdutosMinhCompra()
      
      
      //seleciona os produtos da minha compra
      private function SelecionarProdutosMinhaCompra(){
        if ($this->nCdPedidoCompra != 0){
          $this->sSql = "SELECT i.cdItemPedidoCompra,i.tipo_produto,i.quantidade,i.valor_unitario,";
          $this->sSql .= " i.valor_total,i.tamanho_camiseta,";
          $this->sSql .= " c.cdCamiseta,c.nome AS 'nome_produto',c.valor,c.desconto,c.descricao,";
          $this->sSql .= " s.nome AS 'nome_sub_grupo',";
          $this->sSql .= " g.nome AS 'nome_grupo'";
          $this->sSql .= " FROM item_pedido_compra i";
          $this->sSql .= " JOIN camiseta c ON i.cdFkProduto = c.cdCamiseta";
          $this->sSql .= " JOIN sub_grupo s ON c.cdFkSubGrupo = s.cdSubGrupo";
          $this->sSql .= " JOIN grupo g ON s.cdFkGrupo = g.cdGrupo";
          $this->sSql .= " WHERE i.cdFkPedidoCompra = '".$this->nCdPedidoCompra."'";
          $this->sSql .= " AND i.status = 'aberto'";
          $this->oDadosMeuCarrinho = $this->Fbd->PesquisarSQL($this->sSql);

          if($this->oDadosMeuCarrinho){
            $this->nTotalProdutos = count($this->oDadosMeuCarrinho);
          }
          else{
            $this->nTotalProdutos = 0;
          }
        }
      } //fim - SelecionarProdutosMinhaCompra()


      //cria a div do conteúdo
      private function CriarDivFinCompConteudo(){
        echo "<div class='divFinCompConteudo' name='divFinCompConteudo' id='divFinCompConteudo'>";
          //div passo 0: realizar login
          if($this->nCdUsuario == 0){
          echo "<div class='divFinCompPasso' name='divFinCompPasso0' id='divFinCompPasso0'>";
            $this->RealizarLogin();
            $this->CriarDivRecuperarSenha();
          echo "</div>";
          }
          
          else{
            //div passo 1: produtos da compra
            echo "<div class='divFinCompPasso' name='divFinCompPasso1' id='divFinCompPasso1'>";
              $this->ExibirProdutosMinhaCompra();
            echo "</div>";
          
            //div passo 2: endereço de entrega
            echo "<div class='divFinCompPasso' name='divFinCompPasso2' id='divFinCompPasso2'>";
              $this->ExibirEnderecoEntrega();
            echo "</div>";
          
            //div passo 3: calcular frete
            echo "<div class='divFinCompPasso' name='divFinCompPasso3' id='divFinCompPasso3'>";
              $this->ExibirCalcularFrete();
            echo "</div>";
          
            //div passo 4: forma de pagamento
            echo "<div class='divFinCompPasso' name='divFinCompPasso4' id='divFinCompPasso4'>";
              echo "div passo 4: forma de pagamento";
            echo "</div>";

            //div de navegação no passo-a-passo. Andamento da finalização da compra
            echo "<div class='divFinCompNavegaPassoPasso' name='divFinCompNavegaPassoPasso' id='divFinCompNavegaPassoPasso'>";
              $this->ExibirNavegacaoPassoPassoFinalizarCompra();
            echo "</div>";
          }
        echo "</div>"; //fim - div do conteúdo - divFinCompConteudo
      } //fim - CriarDivFinCompConteudo()
      
      
      //realiza login do usuário
      private function RealizarLogin(){
        echo  "<div class='divLoginUsuario' name='divLoginUsuarioTitulo' id='divLoginUsuarioTitulo'>";
          echo "<span class='spnTituloRealizarLogin' name='spnTituloRealizarLoginTitulo' id='spnTituloRealizarLoginTitulo'>";
            echo "Para Finalizar a Compra, deve ser realizado o login.";
          echo "</span>";
          echo "<span class='spnTituloRealizarLogin' name='spnTituloRealizarLoginAqui' id='spnTituloRealizarLoginAqui'>";
            echo "Caso ainda não for cadastrado, realize o login ";
            echo "<a href='./pgCadastroUsuario.php' class='lnkCadastroUsuario' name='lnkCadastroUsuario' id='lnkCadastroUsuario'>aqui</a>";
          echo "</span>";
         echo  "</div>";

        echo  "<div class='divLoginUsuario' name='divLoginUsuarioLogin' id='divLoginUsuarioLogin'>";
          echo "<span class='spnTituloLogin' name='spnTituloLoginUsuario' id='spnTituloLoginUsuario'>" ."Login: ". "</span>";
          echo "<input type='text' class='txtValorItemLogin' name='txtValorItemLoginUsuario' id='txtValorItemLoginUsuario' value='' maxlength='10' onFocus=\"AlterarCor(this,'#AAA')\" onBlur=\"AlterarCor(this,'#FFF')\" />";
        echo  "</div>";

        echo  "<div class='divLoginUsuario' name='divLoginUsuarioSenha' id='divLoginUsuarioSenha'>";
          echo "<span class='spnTituloLogin' name='spnTituloLoginSenha' id='spnTituloLoginSenha'>" ."Senha: ". "</span>";
          echo "<input type='password' class='txtValorItemLogin' name='txtValorItemLoginSenha' id='txtValorItemLoginSenha' value='' maxlength='20' onFocus=\"AlterarCor(this,'#AAA')\" onBlur=\"AlterarCor(this,'#FFF')\" />";
          //atributo name do link abaixo, deve ser igual ao atributo id da div que será a janela modal
          //atributo class usado no arquivo janelaModal.js
          echo "<a href='#janelaRecuperarSenha' class='lnkRecuperarSenha' name='modal'>Esqueci minha senha</a>";
        echo  "</div>";
        
        echo  "<div class='divLoginUsuario' name='divLoginUsuarioEntrar' id='divLoginUsuarioEntrar'>";
          echo "<input type='button' class='btnLoginUsuario' name='btnLoginUsuario' id='btnLoginUsuario' value='Entrar' onclick='RealizarLoginUsuarioFinalizandoCompra(txtValorItemLoginUsuario.value,txtValorItemLoginSenha.value)' />";
        echo  "</div>";
      } //fim - RealizarLogin()
      
      
      //cria a div para auxiliar usuário a recuperar a senha
      private function CriarDivRecuperarSenha(){
        echo "<div id='boxes'>";
          echo "<div id='janelaRecuperarSenha' class='window dialog'>";
            echo "<a href='#' class='close'>Fechar [X]</a>";
            echo "<fieldset class='fsetOpcoes'>";
            echo "<legend>&nbsp;&nbsp;Recuperação de Senha&nbsp;&nbsp;</legend>";
                echo "<span class='spnTituloEsqueciMinhaSenha' name='spnTituloEsqueciMinhaSenha' id='spnTituloEsqueciMinhaSenha'>";
                echo "Se você já possui cadastro em nosso site e esqueceu sua senha, digite abaixo seu login ou e-mail:";
              echo "</span>";

              echo "<span class='spnTituloOpcRecuperarSenha' name='spnTituloOpcRecuperarSenhaLogin' id='spnTituloOpcRecuperarSenhaLogin'>" ."Login: ". "</span>";
              echo "<input type='text' class='txtValorOpcRecuperarSenha' name='txtValorOpcRecuperarSenhaLogin' id='txtValorOpcRecuperarSenhaLogin' value='' maxlength='20' />";

              echo "<br />";

              echo "<span class='spnTituloOpcRecuperarSenha' name='spnTituloOpcRecuperarSenhaEmail' id='spnTituloOpcRecuperarSenhaEmail'>" ."Email: ". "</span>";
              echo "<input type='text' class='txtValorOpcRecuperarSenha' name='txtValorOpcRecuperarSenhaEmail' id='txtValorOpcRecuperarSenhaEmail' value='' maxlength='100' />";

              echo "<br />";

              echo "<input type='button' class='btnRecuperarSenha' name='btnRecuperarSenha' id='btnRecuperarSenha' value='Recuperar' onclick='RecuperarSenha(txtValorOpcRecuperarSenhaLogin.value,txtValorOpcRecuperarSenhaEmail.value)' />";
              echo "<img class='imgRecuperarSenhaProcessando' name='imgRecuperarSenhaProcessando' id='imgRecuperarSenhaProcessando' src='../figuras/processando/barra.gif' />";
            echo "</fieldset>";
          echo "</div>";

          //Máscara para cobrir a tela
          echo "<div id='mask'></div>";
        echo "</div>";
      } //CriarDivRecuperarSenha()


      //exibe os produtos da minha compra - (passo 1)
      private function ExibirProdutosMinhaCompra(){
        echo "<span class='spnTituloDivPasso' name='spnTituloDivPassoProdutosCompra' id='spnTituloDivPassoProdutosCompra'>";
          echo "<u>" . "Produtos da Compra" . "</u>";
        echo "</span>";
        echo "<br /><br />";
        
        echo "<table class='tblMinhasCompras' name='tblMinhasCompras' id='tblMinhasCompras'>";
          echo "<thead>";
            echo "<tr>";
              echo "<th>" . "Tipo Produto" . "</th>"; //tipo_produto
              echo "<th>" . "Categoria" . "</th>"; //nome_grupo + nome_sub_grupo
              echo "<th>" . "Nome Produto" . "</th>"; //nome_produto
              echo "<th>" . "Quantidade" . "</th>"; //quantidade
              echo "<th>" . "Tamanho" . "</th>"; //tamanho
              echo "<th>" . "Valor Total" . "</th>"; //valor_total
              echo "<th>" . "Ver" . "</th>";
              echo "<th>" . "Deletar" . "</th>";
            echo "</tr>";
          echo "</thead>";
          
          echo "<tbody>";
            foreach($this->oDadosMeuCarrinho as $oRegistro){
              echo "<tr>";
                //tipo_produto
                echo "<td>";
                  echo $oRegistro->tipo_produto;
                echo "</td>";
                //nome_grupo + nome_sub_grupo
                echo "<td>";
                  echo $oRegistro->nome_grupo . " - " .  $oRegistro->nome_sub_grupo;
                echo "</td>";
                //nome_produto
                echo "<td>";
                  echo $oRegistro->nome_produto;
                echo "</td>";
                //quantidade
                echo "<td>";
                  echo $oRegistro->quantidade;
                echo "</td>";
                //tamanho
                echo "<td>";
                  echo $oRegistro->tamanho_camiseta;
                echo "</td>";
                //valor_total
                $this->dValorTotal = $this->dValorTotal + $oRegistro->valor_total;
                $oRegistro->valor_total = $this->FormatarValorMonetario($oRegistro->valor_total);
                echo "<td>";
                  echo $oRegistro->valor_total;
                echo "</td>";
                //ver
                echo "<td>";
                  echo "<a href='pgVisualizarProduto.php?sTipoProduto=".$oRegistro->tipo_produto."&nCdProduto=".$oRegistro->cdCamiseta."&sChamou=finalizarCompra' ";
                  echo "class='lnkVer' name='lnkVer' id='lnkVer'>";
                    echo "Ver";
                  echo "</a>";
                echo "</td>";
                //deletar
                echo "<td>";
                  echo "<a href='pgDeletarItemPedidoCompra.php?chamou=pgFinalizarCompra&cdItemPedidoCompra=" . $oRegistro->cdItemPedidoCompra ."' ";
                  echo "class='lnkDeletar' name='lnkDeletar' id='lnkDeletar'>";
                    echo "Excluir";
                  echo "</a>";
                echo "</td>";
              echo "</tr>";
            } //foreach
          echo "</tbody>";
        echo "</table>";
        
        //valor total
        $this->dValorTotal = $this->FormatarValorMonetario($this->dValorTotal);
        echo "<span class='spnValorTotal' name='spnValorTotal' id='spnValorTotal'>";
          echo "Valor Total: " . $this->dValorTotal;
        echo "</span>";
        
      } //fim - ExibirProdutosMinhaCompra()
      
      
      //exibe o endereço de entrega - (passo 2)
      private function ExibirEnderecoEntrega(){
        //dados para serem exibidos o endereço de entrega. Os valores padrão serão aqueles cadastrados na tabela 'usuario'
        $nCdUsuario = 0;
        $sEnderecoUF = "";
        $sEnderecoCidade = "";
        $sEnderecoCEP = "";
        $sEnderecoBairro = "";
        $sEnderecoRua = "";
        $sEnderecoNumero = "";
        $sEnderecoComplemento = "";
        //pesquisa pelo endereço cadastrado na tabela 'usuario'
        if ($this->nCdUsuario != 0){
          $this->sSql = "SELECT u.cdUsuario,u.endereco_uf,u.endereco_cidade,u.endereco_cep,";
          $this->sSql .= " u.endereco_bairro,u.endereco_rua,u.endereco_numero,u.endereco_complemento";
          $this->sSql .= " FROM usuario u";
          $this->sSql .= " WHERE u.cdUsuario = '".$this->nCdUsuario."'";
          $oDadosUsuario = $this->Fbd->PesquisarSQL($this->sSql);
          if($oDadosUsuario){
            $nCdUsuario = $oDadosUsuario[0]->cdUsuario;
            $sEnderecoUF = $oDadosUsuario[0]->endereco_uf;
            $sEnderecoCidade = $oDadosUsuario[0]->endereco_cidade;
            $sEnderecoCEP = $oDadosUsuario[0]->endereco_cep;
            $sEnderecoBairro = $oDadosUsuario[0]->endereco_bairro;
            $sEnderecoRua = $oDadosUsuario[0]->endereco_rua;
            $sEnderecoNumero = $oDadosUsuario[0]->endereco_numero;
            $sEnderecoComplemento = $oDadosUsuario[0]->endereco_complemento;
          }
        }

        //formulário para cadastrar o endereço de entrega
        //plugin validation do jQuery
        echo "<span class='spnTituloDivPasso' name='spnTituloDivPassoEnderecoEntrega' id='spnTituloDivPassoEnderecoEntrega'>";
          echo "<u>" . "Endereço de Entrega" . "</u>";
        echo "</span>";
        echo "<br /><br />";
        echo "<form id='frmCadEnderecoEntrega' name='frmCadEnderecoEntrega' method='post' action=''>";
          //uf
          echo "<label class='lblTituloEnderecoEntrega' name='lblTituloEnderecoEntregaUF' id='lblTituloEnderecoEntregaUF'>";
            echo "UF:";
          echo "</label>";
          echo "<input type='text' class='txtValorEnderecoEntrega' name='txtValorEnderecoEntregaUF' id='txtValorEnderecoEntregaUF' value='".$sEnderecoUF."' maxlength='2' />";
          echo "<br />";
          //cidade
          echo "<label class='lblTituloEnderecoEntrega' name='lblTituloEnderecoEntregaCidade' id='lblTituloEnderecoEntregaCidade'>";
            echo "Cidade:";
          echo "</label>";
          echo "<input type='text' class='txtValorEnderecoEntrega' name='txtValorEnderecoEntregaCidade' id='txtValorEnderecoEntregaCidade' value='".$sEnderecoCidade."' maxlength='100' />";
          echo "<br />";
          echo "<div class='divLinhaEndEntrega' name='divLinhaEndEntregaCEP' id='divLinhaEndEntregaCEP'>";
            //cep
            echo "<label class='lblTituloEnderecoEntrega' name='lblTituloEnderecoEntregaCEP' id='lblTituloEnderecoEntregaCEP'>";
              echo "CEP:";
            echo "</label>";
            echo "<input type='text' class='txtValorEnderecoEntrega' name='txtValorEnderecoEntregaCEP' id='txtValorEnderecoEntregaCEP' value='".$sEnderecoCEP."' maxlength='9' />";
            echo "<a href='http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do?Metodo=menuEndereco' target='_blank' class='lnkBuscarCEP' name='lnkBuscarCEP' id='lnkBuscarCEP'>Não sei meu CEP</a>";
          echo "</div>";
          echo "<br />";
          //bairro
          echo "<label class='lblTituloEnderecoEntrega' name='lblTituloEnderecoEntregaBairro' id='lblTituloEnderecoEntregaBairro'>";
            echo "Bairro:";
          echo "</label>";
          echo "<input type='text' class='txtValorEnderecoEntrega' name='txtValorEnderecoEntregaBairro' id='txtValorEnderecoEntregaBairro' value='".$sEnderecoBairro."' maxlength='100' />";
          echo "<br />";
          //rua
          echo "<label class='lblTituloEnderecoEntrega' name='lblTituloEnderecoEntregaRua' id='lblTituloEnderecoEntregaRua'>";
            echo "Rua:";
          echo "</label>";
          echo "<input type='text' class='txtValorEnderecoEntrega' name='txtValorEnderecoEntregaRua' id='txtValorEnderecoEntregaRua' value='".$sEnderecoRua."' maxlength='100' />";
          echo "<br />";
          //número
          echo "<label class='lblTituloEnderecoEntrega' name='lblTituloEnderecoEntregaNumero' id='lblTituloEnderecoEntregaNumero'>";
            echo "Nº:";
          echo "</label>";
          echo "<input type='text' class='txtValorEnderecoEntrega' name='txtValorEnderecoEntregaNumero' id='txtValorEnderecoEntregaNumero' value='".$sEnderecoNumero."' maxlength='20' />";
          echo "<br />";
           //complemento
          echo "<label class='lblTituloEnderecoEntrega' name='lblTituloEnderecoEntregaComplemento' id='lblTituloEnderecoEntregaComplemento'>";
            echo "Complemento:";
          echo "</label>";
          echo "<textarea  name='txtAreaValorEnderecoEntregaComplemento' id='txtAreaValorEnderecoEntregaComplemento' maxlength='200'>".$sEnderecoComplemento."</textarea>";
          echo "<br />";
          //salvar como endereço padrão
          echo "<input type='checkbox' name='ckBxEnderecoPadrao' id='ckBxEnderecoPadrao' value='salvarEnderecoPadrao' checked/>";
          echo "<span class='spnTituloEnderecoEntrega' name='spnTituloEnderecoEntregaEnderecoPadrao' id='spnTituloEnderecoEntregaEnderecoPadrao'>" ."Endereço Padrão ". "</span>";
          echo "<br />";
        
          //botões para salvar/limpar
          echo "<div class='divCadUsuarioBotoes' name='divCadUsuarioBotoes' id='divCadUsuarioBotoes'>";
            echo "<input type='submit' class='btnFinCompEnderecoEntrega' name='btnFinCompEnderecoEntrega' id='btnFinCompEnderecoEntrega' value='Salvar' />";
            //onclick='CadastrarEnderecoEntrega();' />";
            echo "<input type='reset' class='btnLimpar' name='btnLimpar' id='btnLimpar' value='Limpar' />";
            //onclick='LimparEnderecoEntrega();' />";
          echo "</div>";
          
           echo "<img class='imgProcessandoSalvarEndEntrega' name='imgProcessandoSalvarEndEntrega' id='imgProcessandoSalvarEndEntrega' src='../figuras/processando/loader1.gif' />";
           echo "<span class='spnInformacaoSalvouEndEntrega' name='spnInformacaoSalvouEndEntrega' id='spnInformacaoSalvouEndEntrega'>";
             echo "";
           echo "</span>";
        echo "</form>";
      } //fim - ExibirEnderecoEntrega()
      
      
      //exibe o cálculo do frete - (passo 3)
      private function ExibirCalcularFrete(){
        echo "<span class='spnTituloDivPasso' name='spnTituloDivPassoCalculoFrete' id='spnTituloDivPassoCalculoFrete'>";
          echo "<u>" . "Cálculo do Frete" . "</u>";
        echo "</span>";
        echo "<br /><br />";
        
        //div que exibe os dados usados no cálculo do frete. CEP origem e destino, peso dos produtos
        echo "<div class='divExibeDadosCalculoFrete' name='divExibeDadosCalculoFrete' id='divExibeDadosCalculoFrete'>";
          echo "<span class='spnTitExibeDadosCalculoFrete' name='spnTitExibeDadosCalculoFreteCEP_Origem' id='spnTitExibeDadosCalculoFreteCEP_Origem'>";
            echo "CEP Origem: ";
          echo "</span>";
          echo "<span class='spnVlrExibeDadosCalculoFrete' name='spnVlrExibeDadosCalculoFreteCEP_Origem' id='spnVlrExibeDadosCalculoFreteCEP_Origem'>";
            echo "CEP Origem XXXX";
          echo "</span>";
          echo "<br />";
          
          echo "<span class='spnTitExibeDadosCalculoFrete' name='spnTitExibeDadosCalculoFreteCEP_Destino' id='spnTitExibeDadosCalculoFreteCEP_Destino'>";
            echo "CEP Destino: ";
          echo "</span>";
          echo "<span class='spnVlrExibeDadosCalculoFrete' name='spnVlrExibeDadosCalculoFreteCEP_Destino' id='spnVlrExibeDadosCalculoFreteCEP_Destino'>";
            echo "CEP Destino XXXX";
          echo "</span>";
          echo "<br />";
          
          echo "<span class='spnTitExibeDadosCalculoFrete' name='spnTitExibeDadosCalculoFretePeso' id='spnTitExibeDadosCalculoFretePeso'>";
            echo "Peso (kg): ";
          echo "</span>";
          echo "<span class='spnVlrExibeDadosCalculoFrete' name='spnVlrExibeDadosCalculoFretePeso' id='spnVlrExibeDadosCalculoFretePeso'>";
            echo "Peso XXXX";
          echo "</span>";
          echo "<br />";
        
        
        echo "</div>"; //fim - divExibeDadosCalculoFrete

        
        
        echo "<input type='button' class='btnCalcularFrete' name='btnCalcularFrete' id='btnCalcularFrete' value='Calcular' />";
        echo "<br />";
        
        
        echo "<input type='radio' class ='rdBtnServico' name='rdBtnServicoFrete' id='rdBtnServicoFretePAC' value='a' />";
        echo "<span class='spnServicoFrete' name='spnServicoFretePAC' id='spnServicoFretePAC'>";
          echo "PAC";
        echo "</span>";
        echo "<span class='spnValorServicoFrete' name='spnValorServicoFretePAC' id='spnValorServicoFretePAC'>";
          echo "vlr PAC";
        echo "</span>";
        echo "<br />";
        
        echo "<input type='radio' class ='rdBtnServico' name='rdBtnServicoFrete' id='rdBtnServicoFreteSedex' value='' />";
        echo "<span class='spnServicoFrete' name='spnServicoFreteSedex' id='spnServicoFreteSedex'>";
          echo "Sedex";
        echo "</span>";
        echo "<span class='spnValorServicoFrete' name='spnValorServicoFreteSedex' id='spnValorServicoFreteSedex'>";
          echo "vlr Sedex";
        echo "</span>";
        echo "<br />";
        
        echo "<input type='radio' class ='rdBtnServico' name='rdBtnServicoFrete' id='rdBtnServicoFreteSedex10' value='' />";
        echo "<span class='spnServicoFrete' name='spnServicoFreteSedex10' id='spnServicoFreteSedex10'>";
          echo "Sedex 10";
        echo "</span>";
        echo "<span class='spnValorServicoFrete' name='spnValorServicoFreteSedex10' id='spnValorServicoFreteSedex10'>";
          echo "vlr Sedex 10";
        echo "</span>";
        echo "<br />";
        
        echo "<input type='radio' class ='rdBtnServico' name='rdBtnServicoFrete' id='rdBtnServicoFreteSedexHoje' value='' />";
        echo "<span class='spnServicoFrete' name='spnServicoFreteSedexHoje' id='spnServicoFreteSedexHoje'>";
          echo "Sedex Hoje";
        echo "</span>";
        echo "<span class='spnValorServicoFrete' name='spnValorServicoFreteSedexHoje' id='spnValorServicoFreteSedexHoje'>";
          echo "vlr Sedex Hoje";
        echo "</span>";
        echo "<br />";
        
        echo "<input type='button' class='btnSelecaoTipoFrete' name='btnSelecaoTipoFrete' id='btnSelecaoTipoFrete' value='Selecionar Frete' />";
      } //fim - ExibirCalcularFrete()

      
      //exibe a navegação do passo-a-passo do andamento da finalização da compra
      private function ExibirNavegacaoPassoPassoFinalizarCompra(){
        /*
        echo "<div class='divPassoPasso' name='divPassoPasso0' id='divPassoPasso0'>";
          echo "<a href='javascript: AlterarPassoFinalizarCompra(\"realizarLogin\");' class='lnkAlterarPassoFinComp' name='lnkAlterarPassoFinCompRealizarLogin' id='lnkAlterarPassoFinCompRealizarLogin'>";
            echo "PASSO 0 - REALIZAR LOGIN";
          echo "</a>";
        echo "</div>";
        */
      
        echo "<div class='divPassoPasso' name='divPassoPasso1' id='divPassoPasso1'>";
          echo "<a href='javascript: AlterarPassoFinalizarCompra(\"confirmarProdutos\");' class='lnkAlterarPassoFinComp' name='lnkAlterarPassoFinCompConfirmarProdutos' id='lnkAlterarPassoFinCompConfirmarProdutos'>";
            echo "PASSO 1 - CONFIRMAR PRODUTOS";
          echo "</a>";
        echo "</div>";
        
        echo "<div class='divPassoPasso' name='divPassoPasso2' id='divPassoPasso2'>";
          echo "<a href='javascript: AlterarPassoFinalizarCompra(\"enderecoEntrega\");' class='lnkAlterarPassoFinComp' name='lnkAlterarPassoFinCompEnderecoEntrega' id='lnkAlterarPassoFinCompEnderecoEntrega'>";
            echo "PASSO 2 - ENDEREÇO DE ENTREGA";
          echo "</a>";
        echo "</div>";
        
        echo "<div class='divPassoPasso' name='divPassoPasso3' id='divPassoPasso3'>";
          echo "<a href='javascript: AlterarPassoFinalizarCompra(\"calcularFrete\");' class='lnkAlterarPassoFinComp' name='lnkAlterarPassoFinCompCalcularFrete' id='lnkAlterarPassoFinCompCalcularFrete'>";
            echo "PASSO 3 - CALCULAR FRETE";
          echo "</a>";
        echo "</div>";
        
        echo "<div class='divPassoPasso' name='divPassoPasso4' id='divPassoPasso4'>";
          echo "<a href='javascript: AlterarPassoFinalizarCompra(\"formaPagamento\");' class='lnkAlterarPassoFinComp' name='lnkAlterarPassoFinCompFormaPagamento' id='lnkAlterarPassoFinCompFormaPagamento'>";
            echo "PASSO 4 - FORMA DE PAGAMENTO";
          echo "</a>";
        echo "</div>";
      } //fim - ExibirNavegacaoPassoPassoFinalizarCompra()
      

      //cria a div com conteúdo em branco, caso não tenha produtos em minha compra
      private function CriarDivFinCompConteudoBranco(){
        echo "<div class='divFinCompConteudoBranco' name='divFinCompConteudoBranco' id='divFinCompConteudoBranco'>";
          echo "div conteudo em branco";
        echo "</div>";
      } //fim - CriarDivFinCompConteudoBranco()
      

      //cria os campos hidden necessários para a página
      private function CriarCampoHidden(){
        echo "<input type='hidden' name='edCdPedidoCompra' id='edCdPedidoCompra' value='" .$this->nCdPedidoCompra. "' />";
      } //fim - CriarCampoHidden()
      
      
      //finaliza a tag body
      private function FecharBody(){
        echo "</body>";
      }
      

      //finaliza HTML
      private function FecharHTML(){
        echo "</html>";
      }

    } //fim - class PgFinalizarCompra
?>
