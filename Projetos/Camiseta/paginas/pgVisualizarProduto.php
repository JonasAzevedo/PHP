<?php
/*******************************************************************
********************************************************************
  Nome: pgVisualizarProduto.php
  Função: página para visualizar detalhes do produto
  Data de Criação: 02/03/2011 - 16:34
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: http://localhost/VENDA_CAMISETA/paginas/pgVisualizarProduto.php?sTipoProduto=camiseta&nCdProduto=1&sChamou=finalizarCompra
********************************************************************
*******************************************************************/

/*
//function's:
  IniciarSession()
  SolicitarArquivos()
  InicializarVariaveis()
  VerificarProdutoFoiAvaliado() //verifica se o produto já foi avaliado pelo usuário logado
  VerificarAvaliacaoDoUsuarioProduto() //verifica qual foi a avaliação dada pelo usuário logado para o produto
  CadastrarAvaliacaoProduto() //cadastra a avaliação do produto. A seleção e o INSERT é realizado na mesma página
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  CriarDivVisualizarProdCabecalho() //cria a div de cabeçalho
  PesquisarDadosCamiseta() //pesquisa pelos dados da camiseta
  PesquisarImagensCamiseta() //pesquisa pelas imagens da camiseta
  IniciarDivConteudo() //inicia a div do conteúdo
  CriarDivConteudoDadosProduto() //inicia a div do conteúdo que irá conter os dados do produto
  CriarDivConteudoImagens() //cria a div para visualizar as imagens dos produto
  CriarDivConteudoDados() //cria a div para visualizar os dados do produto
  CriarDivConteudoBranco() //cria a div com conteúdo em branco, caso o produto passado por parâmetro não exista
  CriarDivAvaliacaoCamiseta() //cria a div para avaliação da camiseta
  ProcessarMostrarResultadoAvaliacoes() //processa e mostra resultado das avaliações já computadas
  CriarDivVoltarPaginaChamou() //cria a div com o link para retornar para a página que chamou esta
  FecharDivConteudoDadosProduto() //fecha a div do conteúdo que contém os dados do produto
  FecharDivConteudo() //fecha a div do conteúdo
  CriarDivLateralDireita() //cria a div da lateral direita que irá conter os produtos que tenham relação com o que está sendo visualizado
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
  RealizarLogin() //realiza login do usuário
  CriarDivRecuperarSenha() //cria a div para auxiliar usuário a recuperar a senha
  CriaDivIndiqueParaAmigo() //cria a div para indicar a camiseta para um amigo
  CriaDivComprarProduto() //cria a div para comprar produto
  CriaDivMascaraJanelaModal() //cria a div com id='mask' para ser usada nas janelas modais
*/

    $pgVisualizarProduto = new PgVisualizarProduto();

    class PgVisualizarProduto{
      //bd
      private $Fbd;
      private $sSql;
      
      //métodos gerais
      private $FMetGer;
      
      private $nCdUsuario; //usuário. $_SESSION
      private $sNomeUsuario;

      private $nCdProduto; //produto a ser visualizado. $_GET
      private $sTipoProduto; //camiseta
      private $sChamou; //finalizarCompra, paginaPrincipal
      
      private $nItemAvaliado; //valor selecionado para avaliar produto. $_POST
      
      private $oDadosProduto; //dados do produto
      private $nTotalProdutos; //total de produtos
      private $oDadosImagemProduto; //dados da imagem do produto
      private $nTotalImagensProdutos; //total de imagens do produtos
      private $bProdutoFoiAvaliado; //verifica se o usuário já avaliou o produto

      function __construct(){
        $this->IniciarSession();
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        if(($this->nCdProduto != 0)and($this->nCdUsuario != 0)and($this->nItemAvaliado != 0)){
          $this->CadastrarAvaliacaoProduto();
        }
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->CriarDivVisualizarProdCabecalho();
        $this->IniciarDivConteudo();
        
        if(($this->nCdProduto != 0)and($this->sTipoProduto == "camiseta")){
          $this->PesquisarDadosCamiseta();
          $this->PesquisarImagensCamiseta();
          if($this->nTotalProdutos > 0){
            $this->CriarDivConteudoDadosProduto();
            $this->CriarDivConteudoImagens();
            $this->CriarDivConteudoDados();
            $this->CriaDivComprarProduto();
            $this->CriaDivIndiqueParaAmigo();
            $this->CriarDivAvaliacaoCamiseta();
            $this->CriarDivVoltarPaginaChamou();
            $this->FecharDivConteudoDadosProduto();
            $this->CriarDivLateralDireita();
          }
          else{
            $this->CriarDivConteudoBranco();
          }
        }
        else{
          $this->CriarDivConteudoBranco();
        }

        $this->CriaDivMascaraJanelaModal();
        $this->FecharDivConteudo();
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }


      //inicia a sessão que armazena os do usuário logado no site
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      }
      

	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("../classes/ConexaoBD.php");
        require_once("../classes/metodosGerais.php");
	  }


      private function InicializarVariaveis(){
        //_SESSION
        if(isset($_SESSION["nCodigo"])){
          $this->nCdUsuario = $_SESSION["nCodigo"];
        }
        else{
          $this->nCdUsuario = 0;
        }
        
        if(isset($_SESSION["sNome"])){
          $this->sNomeUsuario = $_SESSION["sNome"];
        }
        else{
          $this->sNomeUsuario = 0;
        }
        
        //_GET
        if(isset($_GET['sTipoProduto'])){
          $this->sTipoProduto = $_GET["sTipoProduto"];
        }
        else{
          $this->sTipoProduto = "";
        }

        if(isset($_GET['nCdProduto'])){
          $this->nCdProduto = $_GET["nCdProduto"];
        }
        else{
          $this->nCdProduto = 0;
        }
        
        if(isset($_GET['sChamou'])){
          $this->sChamou = $_GET["sChamou"];
        }
        else{
          $this->sChamou = "";
        }
        
        //_POST
        if(isset($_POST['hidItemAvaliado'])){
          $this->nItemAvaliado = $_POST["hidItemAvaliado"];
        }
        else{
          $this->nItemAvaliado = 0;
        }

        //bd
        $this->Fbd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //métodos gerais
        $this->FMetGer = MetodosGerais::GetInstanciaMetodosGerais();
        
        $this->oDadosProduto = null;
        $this->nTotalProdutos = 0;
        $this->oDadosImagemProduto = null;
        $this->nTotalImagensProdutos = 0;
        $this->bProdutoFoiAvaliado = $this->VerificarProdutoFoiAvaliado();
      } //fim - InicializarVariaveis()
      
      
      //verifica se o produto já foi avaliado pelo usuário logado
      private function VerificarProdutoFoiAvaliado(){
        $bRetorno = False;
        if(($this->nCdProduto != 0)and($this->nCdUsuario != 0)and($this->sTipoProduto != "")){
          $this->sSql = "SELECT COUNT(idAvaliacaoProduto) as total FROM avaliacao_produto";
          $this->sSql .= " WHERE tipo_produto='" .$this->sTipoProduto. "'";
          $this->sSql .= " AND cdFkProduto='" .$this->nCdProduto. "'";
          $this->sSql .= " AND cdFkUsuario='" .$this->nCdUsuario. "'";
          $oDadosAvaliacao = $this->Fbd->PesquisarSQL($this->sSql);
          $nTotalAvaliacao = 0;
          if($oDadosAvaliacao){
            $nTotalAvaliacao = $oDadosAvaliacao[0]->total;
          }
          if($nTotalAvaliacao == 0){
            $bRetorno = False;
          }
          else{
            $bRetorno = True;
          }
        }
        else{
          $bRetorno = False;
        }
        return $bRetorno;
      } //fim - VerificarProdutoFoiAvaliado()
      
      
      //verifica qual foi a avaliação dada pelo usuário logado para o produto
      private function VerificarAvaliacaoDoUsuarioProduto(){
        $nRetorno = 0;
        if(($this->nCdProduto != 0)and($this->nCdUsuario != 0)and($this->sTipoProduto != "")){
          $this->sSql = "SELECT avaliacao FROM avaliacao_produto";
          $this->sSql .= " WHERE tipo_produto='" .$this->sTipoProduto. "'";
          $this->sSql .= " AND cdFkProduto='" .$this->nCdProduto. "'";
          $this->sSql .= " AND cdFkUsuario='" .$this->nCdUsuario. "'";
          $oDadosAvaliacao = $this->Fbd->PesquisarSQL($this->sSql);
          if($oDadosAvaliacao){
            $nRetorno = $oDadosAvaliacao[0]->avaliacao;
          }
        }
        return $nRetorno;
      } //fim - VerificarAvaliacaoDoUsuarioProduto()

      
      //cadastra a avaliação do produto. A seleção e o INSERT é realizado na mesma página
      private function CadastrarAvaliacaoProduto(){
        $this->sSql = "SELECT COUNT(idAvaliacaoProduto) as total FROM avaliacao_produto";
        $this->sSql .= " WHERE tipo_produto='" .$this->sTipoProduto. "'";
        $this->sSql .= " AND cdFkProduto='" .$this->nCdProduto. "'";
        $this->sSql .= " AND cdFkUsuario='" .$this->nCdUsuario. "'";
        $oDadosAvaliacao = $this->Fbd->PesquisarSQL($this->sSql);
        $nTotalAvaliacao = 0;
        if($oDadosAvaliacao){
          $nTotalAvaliacao = $oDadosAvaliacao[0]->total;
        }
        //um usuário só pode avaliar uma vez um produto, por isso o SELECT acima
        if($nTotalAvaliacao == 0){
          $this->sSql = "INSERT INTO avaliacao_produto(tipo_produto,cdFkProduto,cdFkUsuario,avaliacao,data_avaliacao)";
          $this->sSql .= " VALUES('" .$this->sTipoProduto. "','" .$this->nCdProduto. "','" .$this->nCdUsuario;
          $this->sSql .= "','" .$this->nItemAvaliado. "',CURRENT_TIMESTAMP)";
          $bInseriu = mysql_query($this->sSql, $this->Fbd->oCon);
        }
        if($bInseriu){
          $this->bProdutoFoiAvaliado = $this->VerificarProdutoFoiAvaliado();
        }
      } //fim - CadastrarAvaliacaoProduto()


      //inicia HTML
      private function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='../css/cPgVisualizarProduto.css' type='text/css' />";
          echo "<script type='text/javascript' src='../js/jPgVisualizarProduto.js'></script>";
          //jQuery
          echo "<script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>";
          //códigos jQuery da página
          echo "<script type='text/javascript' src='../js/jQryPgVisualizarProduto.js'></script>";
          //arquivos para o plugin jQuery para janela modal
          echo "<link rel='stylesheet' href='../css/jQuery/cJnlModalPgVisualizarProduto.css' type='text/css' />";
          echo "<script language='JavaScript' src='../js/jQryJanelaModalPgVisualizarProduto.js'></script>";
          //arquivo para o plugin jQuery de validação de formulário
          echo "<script language='JavaScript' src='../jQuery/plugin/validation/jquery.validate.js'></script>";
          
          echo "<script language='JavaScript' src='../jQuery/plugin/alphanumeric.js'></script>";
       echo "</head>";
      }


      //iniciar a tag body
      private function IniciarBody(){
        echo "<body>";
      }
      

      //inicia a div principal do site
      private function IniciarDivPrincipal(){
        echo "<div class='divVisualizarProduto' name='divVisualizarProduto' id='divVisualizarProduto'>";
      }


      //cria a div de cabeçalho
      private function CriarDivVisualizarProdCabecalho(){
        echo "<div class='divVisualizarProdCabecalho' name='divVisualizarProdCabecalho' id='divVisualizarProdCabecalho'>";
          echo "div do cabeçalho";
        echo "</div>";
      }
      

      //pesquisa pelos dados da camiseta
      private function PesquisarDadosCamiseta(){
        $this->sSql = "SELECT c.cdCamiseta,c.cdFkSubGrupo,c.nome AS 'nome_produto',c.valor,c.desconto,c.flAtivo,c.descricao,";
        $this->sSql .= " sg.nome AS 'nome_sub_grupo',";
        $this->sSql .= " g.nome AS 'nome_grupo'";
        $this->sSql .= " FROM camiseta c";
        $this->sSql .= " JOIN sub_grupo sg ON c.cdFkSubGrupo = sg.cdSubGrupo";
        $this->sSql .= " JOIN grupo g ON sg.cdFkGrupo = g.cdGrupo";
        $this->sSql .= " WHERE c.cdCamiseta = '".$this->nCdProduto."'";
        $this->oDadosProduto = $this->Fbd->PesquisarSQL($this->sSql);
        if($this->oDadosProduto){
          $this->nTotalProdutos = count($this->oDadosProduto);
        }
        else{
          $this->nTotalProdutos = 0;
        }
      } //fim - PesquisarDadosCamiseta()
      
      
      //pesquisa pelas imagens da camiseta
      private function PesquisarImagensCamiseta(){
        $this->sSql = "SELECT i.cdImagemCamiseta,i.imagem,i.nome";
        $this->sSql .= " FROM imagem_camiseta i";
        $this->sSql .= " WHERE i.cdFkCamiseta = '".$this->nCdProduto."'";
        $this->oDadosImagemProduto = $this->Fbd->PesquisarSQL($this->sSql);
        if($this->oDadosImagemProduto){
          $this->nTotalImagensProdutos = count($this->oDadosImagemProduto);
        }
        else{
          $this->nTotalImagensProdutos = 0;
        }
      } //fim - PesquisarImagensCamiseta()
      
      
      //inicia a div do conteúdo
      private function IniciarDivConteudo(){
        echo "<div class='divVisualizarProdConteudo' name='divVisualizarProdConteudo' id='divVisualizarProdConteudo'>";
      } //fim - IniciarDivConteudo()
      
      
      //inicia a div do conteúdo que irá conter os dados do produto
      private function CriarDivConteudoDadosProduto(){
        echo "<div class='divVisualizarProdConteudoDadosProduto' name='divVisualizarProdConteudoDadosProduto' id='divVisualizarProdConteudoDadosProduto'>";
      } //fim - CriarDivConteudoDadosProduto()
      

      //cria a div para visualizar as imagens dos produto
      private function CriarDivConteudoImagens(){
        if($this->sTipoProduto == "camiseta"){
          //div com dados da imagem da camiseta - três imagens
          echo "<div class='divConteudoImagens' name='divConteudoImagens' id='divConteudoImagens'>";
            //imagem 1
            if(($this->oDadosImagemProduto[0]->imagem != "")and($this->oDadosImagemProduto[0]->imagem != "complemento")){
              echo "<div class='divVisualizarProdImagem' name='divVisualizarProdImagem1' id='divVisualizarProdImagem1'>";
                echo "<span class='spnVlrVisualizarProdNomeImagem' name='spnVlrVisualizarProdNomeImagem1' id='spnVlrVisualizarProdNomeImagem1'>";
                   echo $this->oDadosImagemProduto[0]->nome;
                echo "</span>";

                echo "<img class='imgVisualizarProdFigura' name='imgVisualizarProdFigura1' id='imgVisualizarProdFigura1' src='." .$this->oDadosImagemProduto[0]->imagem."' />";
              echo "</div>";
            }
            //imagem 2
            if(($this->oDadosImagemProduto[1]->imagem != "")and($this->oDadosImagemProduto[1]->imagem != "complemento")){
              echo "<div class='divVisualizarProdImagem' name='divVisualizarProdImagem2' id='divVisualizarProdImagem2'>";
                echo "<span class='spnVlrVisualizarProdNomeImagem' name='spnVlrVisualizarProdNomeImagem2' id='spnVlrVisualizarProdNomeImagem2'>";
                  echo $this->oDadosImagemProduto[1]->nome;
                echo "</span>";

                echo "<img class='imgVisualizarProdFigura' name='imgVisualizarProdFigura2' id='imgVisualizarProdFigura2' src='." .$this->oDadosImagemProduto[1]->imagem."' />";
              echo "</div>";
            }
            //imagem 3
            if(($this->oDadosImagemProduto[2]->imagem != "")and($this->oDadosImagemProduto[2]->imagem != "complemento")){
              echo "<div class='divVisualizarProdImagem' name='divVisualizarProdImagem3' id='divVisualizarProdImagem3'>";
                echo "<span class='spnVlrVisualizarProdNomeImagem' name='spnVlrVisualizarProdNomeImagem3' id='spnVlrVisualizarProdNomeImagem3'>";
                  echo $this->oDadosImagemProduto[2]->nome;
                echo "</span>";

                echo "<img class='imgVisualizarProdFigura' name='imgVisualizarProdFigura3' id='imgVisualizarProdFigura3' src='." .$this->oDadosImagemProduto[2]->imagem."' />";
              echo "</div>";
            }
          echo "</div>"; //fim - div dados da imagem produto - 'divConteudoImagens'
        }
      } //fim - CriarDivConteudoImagens()
      
      
      //cria a div para visualizar os dados do produto
      private function CriarDivConteudoDados(){
        if($this->sTipoProduto == "camiseta"){
          //div com dados do produto
          echo "<div class='divConteudoDados' name='divConteudoDados' id='divConteudoDados'>";
            //grupo e subGrupo
            echo "<span class='spnVlrVisProdCaracProduto' name='spnVlrVisProdCaracProdutoGrupoSubGrupo' id='spnVlrVisProdCaracProdutoGrupoSubGrupo'>";
              echo $this->oDadosProduto[0]->nome_grupo ." - ". $this->oDadosProduto[0]->nome_sub_grupo;
            echo "</span>";

            echo "<input type='button' class='btnComprarProduto' name='btnComprarProduto' id='#janelaComprarProduto'";
            echo "value='Comprar' />";

            //atributo href do link abaixo, deve ser igual ao atributo id da div que será a janela modal
            echo "<a href='#janelaIndicarAmigo' class='lnkIndiqueAmigo' name='modal'>Indique para um amigo</a>";
            echo "<br />";

            //nome
            echo "<span class='spnTituloVisProdCaracProduto' name='spnTituloVisProdCaracProdutoNome' id='spnTituloVisProdCaracProdutoNome'>" ."Nome ". "</span>";
            echo "<span class='spnVlrVisProdCaracProduto' name='spnVlrVisProdCaracProdutoNome' id='spnVlrVisProdCaracProdutoNome'>";
              echo $this->oDadosProduto[0]->nome_produto;
            echo "</span>";
            echo "<br />";

            if($this->oDadosProduto[0]->desconto > 0){
              //valor
              $this->dValor = $this->FMetGer->FormatarValorMonetario($this->oDadosProduto[0]->valor);
              echo "<span class='spnTituloVisProdCaracProduto' name='spnTituloVisProdCaracProdutoValorAntigo' id='spnTituloVisProdCaracProdutoValorAntigo'>" ."De R$ ". "</span>";
              echo "<span class='spnVlrVisProdCaracProduto' name='spnVlrVisProdCaracProdutoValorAntigo' id='spnVlrVisProdCaracProdutoValorAntigo'>";
                echo $this->dValor;
              echo "</span>";

              //valor - desconto
              $this->dValor = $this->dValor - $this->oDadosProduto[0]->desconto;
              $this->dValor = $this->FMetGer->FormatarValorMonetario($this->dValor);
              echo "<span class='spnTituloVisProdCaracProduto' name='spnTituloVisProdCaracProdutoDescontoPor' id='spnTituloVisProdCaracProdutoDescontoPor'>" ."Por R$ ". "</span>";
              echo "<span class='spnVlrVisProdCaracProduto' name='spnVlrVisProdCaracProdutoDescontoPor' id='spnVlrVisProdCaracProdutoDescontoPor'>";
                echo $this->dValor;
              echo "</span>";
              echo "</br>";
            }
            else{
              //valor
              $this->dValor = $this->FMetGer->FormatarValorMonetario($this->oDadosProduto[0]->valor);
              echo "<span class='spnTituloVisProdCaracProduto' name='spnTituloVisProdCaracProdutoValor' id='spnTituloVisProdCaracProdutoValor'>" ."R$ ". "</span>";
              echo "<span class='spnVlrVisProdCaracProduto' name='spnVlrVisProdCaracProdutoValor' id='spnVlrVisProdCaracProdutoValor'>";
                echo $this->dValor;
              echo "</span>";
              echo "<br />";
            }

            //desconto
            $this->dDesconto = $this->FMetGer->FormatarValorMonetario($this->oDadosProduto[0]->desconto);
            echo "<span class='spnTituloVisProdCaracProduto' name='spnTituloVisProdCaracProdutoDescontoDesconto' id='spnTituloVisProdCaracProdutoDescontoDesconto'>" ."Desconto ". "</span>";
            echo "<span class='spnVlrVisProdCaracProduto' name='spnVlrVisProdCaracProdutoDescontoDesconto' id='spnVlrVisProdCaracProdutoDescontoDesconto'>";
              echo $this->dDesconto;
            echo "</span>";
            echo "<br />";

            //descrição
            echo "<span class='spnTituloVisProdCaracProduto' name='spnTituloVisProdCaracProdutoDescricao' id='spnTituloVisProdCaracProdutoDescricao'>" ."Descrição ". "</span>";
            echo "<span class='spnVlrVisProdCaracProduto' name='spnVlrVisProdCaracProdutoDescricao' id='spnVlrVisProdCaracProdutoDescricao'>";
              echo $this->oDadosProduto[0]->descricao;
            echo "</span>";
          echo "</div>"; // //fim - div 'divConteudoDados'
        }
      } //fim - CriarDivConteudoDados()
      

      //cria a div para indicar a camiseta para um amigo
      private function CriaDivIndiqueParaAmigo(){
        echo "<div id='boxes'>";
          echo "<div id='janelaIndicarAmigo' class='window dialog'>";
            echo "<a href='#' class='close'>Fechar [X]</a>";
            echo "<fieldset class='fsetOpcoes'>";
            echo "<legend>&nbsp;&nbsp;Indique esta Camiseta para um Amigo&nbsp;&nbsp;</legend>";
              echo "<span class='spnTituloIndicarParaAmigo' name='spnTituloIndicarParaAmigo' id='spnTituloIndicarParaAmigo'>";
                echo "Indique esta camiseta para um amigo. Informe o email do seu amigo abaixo:";
              echo "</span>";
              
              //formulário para enviar email de indicação de produto
              //o formulário foi inserido em função do plugin validation do jQuery
              echo "<form id='frmIndicarProduto' name='frmIndicarProduto' method='post' action=''>";
                echo "<input type='hidden' name='edCdUsuarioDe' id='edCdUsuarioDe' value='".$this->nCdUsuario."' />";
                echo "<input type='hidden' name='edCdProduto' id='edCdProduto' value='".$this->nCdProduto."' />";
                echo "<input type='hidden' name='edTipoProduto' id='edTipoProduto' value='".$this->sTipoProduto."' />";
                echo "<label class='lblTituloOpcIndicarParaAmigo' name='lblTituloOpcIndicarParaAmigoDe' id='lblTituloOpcIndicarParaAmigoDe'>";
                  echo "De:";
                echo "</label>";
                echo "<input type='text' class='txtValorOpcIndicarParaAmigo' name='txtValorOpcIndicarParaAmigoDe' id='txtValorOpcIndicarParaAmigoDe' value='' maxlength='100' />";
                echo "<br />";

                echo "<label class='lblTituloOpcIndicarParaAmigo' name='lblTituloOpcIndicarParaAmigoPara' id='lblTituloOpcIndicarParaAmigoPara'>";
                  echo "Para:";
                echo "</label>";
                echo "<input type='text' class='txtValorOpcIndicarParaAmigo' name='txtValorOpcIndicarParaAmigoPara' id='txtValorOpcIndicarParaAmigoPara' value='' maxlength='100' />";
                echo "<br />";

                echo "<input type='submit' class='btnIndicarAmigo' name='btnIndicarAmigo' id='btnIndicarAmigo' value='Enviar' />";
                echo "<img class='imgIndicarProdutoProcessando' name='imgIndicarProdutoProcessando' id='imgIndicarProdutoProcessando' src='../figuras/processando/loader1.gif' />";
                echo "<span class='spnInformacaoEnviouEmail' name='spnInformacaoEnviouEmail' id='spnInformacaoEnviouEmail'>";
                   echo "";
                echo "</span>";
              echo "</form>";
            echo "</fieldset>";
          echo "</div>";
        echo "</div>";
      } //CriaDivIndiqueParaAmigo()
      
      
      //cria a div com conteúdo em branco, caso o produto passado por parâmetro não exista
      private function CriarDivConteudoBranco(){
        echo "<div class='divVisualizarProdConteudoBranco' name='divVisualizarProdConteudoBranco' id='divVisualizarProdConteudoBranco'>";
          echo "div conteudo em branco";
          //criar mecanismo para retornar a página anterior
        echo "</div>";
      } //fim - CriarDivConteudoBranco()
      

      //cria a div para avaliação da camiseta
      private function CriarDivAvaliacaoCamiseta(){
        echo "<div class='divAvaliacaoCamiseta' name='divAvaliacaoCamiseta' id='divAvaliacaoCamiseta'>";
          //div para o usuário avaliar a camiseta
          echo "<div class='divAvaliacaoUsuario' name='divAvaliacaoUsuario' id='divAvaliacaoUsuario'>";
            //avaliar camiseta
            //só pode avaliar se usuário ainda não avaliou produto, e se existe um usuário logado
            if(($this->bProdutoFoiAvaliado == False)and($this->nCdUsuario != 0)){
              echo "<div class='divAvaliacaoUsuarioOpcoesTitulo' name='divAvaliacaoUsuarioOpcoesTitulo' id='divAvaliacaoUsuarioOpcoesTitulo'>";
                echo "<span class='spnAvaliacaoUsuarioOpcTitulo' name='spnAvaliacaoUsuarioOpcTitulo' id='spnAvaliacaoUsuarioOpcTitulo'>";
                   echo $this->sNomeUsuario. ", avalie este produto:";
                   echo "<br/><br/><br/>";
                echo "</span>";
              echo "</div>";
              
              echo "<div class='divAvaliacaoUsuarioOpcoes' name='divAvaliacaoUsuarioOpcoes' id='divAvaliacaoUsuarioOpcoes'>";
                echo "<a href='' class='aLnkAvaliar' name='aLnkAvaliar1' id='aLnkAvaliar1'>";
                  echo "<img class='imgAvaliar' name='imgAvaliar1' id='imgAvaliar1' src='../figuras/estrela_branca.jpg' />";
                echo "</a>";
                echo "<a href='' class='aLnkAvaliar' name='aLnkAvaliar2' id='aLnkAvaliar2'>";
                  echo "<img class='imgAvaliar' name='imgAvaliar2' id='imgAvaliar2' src='../figuras/estrela_branca.jpg' />";
                echo "</a>";
                echo "<a href='' class='aLnkAvaliar' name='aLnkAvaliar3' id='aLnkAvaliar3'>";
                  echo "<img class='imgAvaliar' name='imgAvaliar3' id='imgAvaliar3' src='../figuras/estrela_branca.jpg' />";
                echo "</a>";
                echo "<a href='' class='aLnkAvaliar' name='aLnkAvaliar4' id='aLnkAvaliar4'>";
                  echo "<img class='imgAvaliar' name='imgAvaliar4' id='imgAvaliar4' src='../figuras/estrela_branca.jpg' />";
                echo "</a>";
                echo "<a href='' class='aLnkAvaliar' name='aLnkAvaliar5' id='aLnkAvaliar5'>";
                  echo "<img class='imgAvaliar' name='imgAvaliar5' id='imgAvaliar5' src='../figuras/estrela_branca.jpg' />";
                echo "</a>";
          
                $sLink = $_SERVER["PHP_SELF"] . "?sTipoProduto=" . $this->sTipoProduto;
                $sLink .= "&nCdProduto=" . $this->nCdProduto;
                $sLink .= "&sChamou=" . $this->sChamou;

                echo "<form name='frmAvaliar' method='POST' action='" .$sLink. "'>";
                  echo "<input type='hidden' name='hidItemAvaliado' id='hidItemAvaliado' value='' />";
                  echo "<input type='submit' class='btnAvaliar' name='btnAvaliar' id='btnAvaliar' value='Avaliar' />";
                echo "</form>";
              echo "</div>"; //fim - divAvaliacaoUsuarioOpcoes
            } //fim - dados para avaliar produto
          
            //usuário já avaliou o produto
            else if($this->bProdutoFoiAvaliado == True){
              echo "<span class='spnAvisoProdutoFoiAvaliado' name='spnAvisoProdutoFoiAvaliado' id='spnAvisoProdutoFoiAvaliado'>";
                echo $this->sNomeUsuario. ", você já avaliou este produto. Veja sua avaliação: ";
              echo "</span>";
              
              echo "<div class='divMinhaAvaliacaoProduto' name='divMinhaAvaliacaoProduto' id='divMinhaAvaliacaoProduto'>";
                $nMinhaAvaliacao = $this->VerificarAvaliacaoDoUsuarioProduto();
                switch ($nMinhaAvaliacao){
                  case 1:
                    echo "<img class='imgMinhaAvaliacao' name='imgMinhaAvaliacao1' id='imgMinhaAvaliacao1' src='../figuras/minha_avaliacao/aval1.jpg' />";
                    echo "<span class='spnMinhaAvaliacaoDesc' name='spnMinhaAvaliacaoDesc1' id='spnMinhaAvaliacaoDesc1'>";
                      echo "Péssimo";
                    echo "</span>";
                    break;
                  case 2:
                    echo "<img class='imgMinhaAvaliacao' name='imgMinhaAvaliacao2' id='imgMinhaAvaliacao2' src='../figuras/minha_avaliacao/aval2.jpg' />";
                    echo "<span class='spnMinhaAvaliacaoDesc' name='spnMinhaAvaliacaoDesc2' id='spnMinhaAvaliacaoDesc2'>";
                      echo "Ruim";
                    echo "</span>";
                    break;
                  case 3:
                    echo "<img class='imgMinhaAvaliacao' name='imgMinhaAvaliacao3' id='imgMinhaAvaliacao3' src='../figuras/minha_avaliacao/aval3.jpg' />";
                    echo "<span class='spnMinhaAvaliacaoDesc' name='spnMinhaAvaliacaoDesc3' id='spnMinhaAvaliacaoDesc3'>";
                      echo "Regular";
                    echo "</span>";
                    break;
                  case 4:
                    echo "<img class='imgMinhaAvaliacao' name='imgMinhaAvaliacao4' id='imgMinhaAvaliacao4' src='../figuras/minha_avaliacao/aval4.jpg' />";
                    echo "<span class='spnMinhaAvaliacaoDesc' name='spnMinhaAvaliacaoDesc4' id='spnMinhaAvaliacaoDesc4'>";
                      echo "Bom";
                    echo "</span>";
                    break;
                  case 5:
                    echo "<img class='imgMinhaAvaliacao' name='imgMinhaAvaliacao5' id='imgMinhaAvaliacao5' src='../figuras/minha_avaliacao/aval5.jpg' />";
                    echo "<span class='spnMinhaAvaliacaoDesc' name='spnMinhaAvaliacaoDesc5' id='spnMinhaAvaliacaoDesc5'>";
                      echo "Ótimo";
                    echo "</span>";
                    break;
                }
              echo "</div>"; //fim - divMinhaAvaliacaoProduto
            } //fim - usuário já avaliou o produto
            //sem usuário logado para avaliar produto
            else if($this->nCdUsuario == 0){
              $this->RealizarLogin();
              $this->CriarDivRecuperarSenha();
            }
          echo "</div>"; //fim - divAvaliacaoUsuario
          
          $this->ProcessarMostrarResultadoAvaliacoes();
          
        echo "</div>"; //fim - divAvaliacaoCamiseta
      } //fim - CriarDivAvaliacaoCamiseta()
      
      
      //processa e mostra resultado das avaliações já computadas
      private function ProcessarMostrarResultadoAvaliacoes(){
        //div com o resultado das avaliações já realizadas para este produto
        $nOtimo = 0;
        $nBom = 0;
        $nRegular = 0;
        $nRuim = 0;
        $nPessimo = 0;
        $nTotalAvaliacoes = 0;
        $dIndicePerc = 0;
        $dPercOtimo = 0;
        $dPercBom = 0;
        $dPercRegular = 0;
        $dPercRuim = 0;
        $dPercPessimo = 0;
        
        $this->sSql = "SELECT COUNT(idAvaliacaoProduto) as total, avaliacao FROM avaliacao_produto";
        $this->sSql .= " WHERE tipo_produto='" .$this->sTipoProduto. "'";
        $this->sSql .= " AND cdFkProduto='" .$this->nCdProduto. "'";
        $this->sSql .= " GROUP BY avaliacao ORDER BY avaliacao DESC";
        $oDadosAvaliacao = $this->Fbd->PesquisarSQL($this->sSql);
        $nTotalAvaliacoes = count($oDadosAvaliacao);
        if($nTotalAvaliacoes > 0){
          foreach($oDadosAvaliacao as $oRegistro){
            if($oRegistro->avaliacao == 5){
              $nOtimo = $oRegistro->total;
            }
            if($oRegistro->avaliacao == 4){
              $nBom = $oRegistro->total;
            }
            if($oRegistro->avaliacao == 3){
              $nRegular = $oRegistro->total;
            }
            if($oRegistro->avaliacao == 2){
              $nRuim = $oRegistro->total;
            }
            if($oRegistro->avaliacao == 1){
              $nPessimo = $oRegistro->total;
            }
          } //fim - foreach
          $dIndicePerc = 100 / ($nOtimo + $nBom + $nRegular + $nRuim + $nPessimo);
          $dPercOtimo = round($dIndicePerc * $nOtimo, 2);
          $dPercBom = round($dIndicePerc * $nBom, 2);
          $dPercRegular = round($dIndicePerc * $nRegular, 2);
          $dPercRuim = round($dIndicePerc * $nRuim, 2);
          $dPercPessimo = round($dIndicePerc * $nPessimo, 2);
        } //fim - if($nTotalAvaliacoes > 0)

        echo "<div class='divResultadoAvaliacoes' name='divResultadoAvaliacoes' id='divResultadoAvaliacoes'>";
          if($nTotalAvaliacoes > 0){
            echo "<span class='spnTituloResultadoAvaliacoes' name='spnTituloResultadoAvaliacoes' id='spnTituloResultadoAvaliacoes'>";
              echo "Avaliações:";
            echo "</span>";
            echo "<br />";
          
            echo "<table class='tblAvaliacoes' name='tblAvaliacoes' id='tblAvaliacoes'>";
              echo "<tr>";
                echo "<td class='tdColuna1'>";
                  $nWidth = ceil($dPercOtimo); //arredonda para cima
                  echo "<div style='width:".$nWidth."%' class='divBarraAvaliado' name='divBarraAvaliado1' id='divBarraAvaliado1'>";
                  echo "</div>";
                echo "</td>";
                echo "<td class='tdColuna2'>";
                  $dPercOtimo = $this->FMetGer->FormatarValorMonetario($dPercOtimo);
                  echo "ótimo " .$dPercOtimo. "%";
                echo "</td>";
              echo "</tr>";
            
              echo "<tr>";
                echo "<td class='tdColuna1'>";
                  $nWidth = ceil($dPercBom); //arredonda para cima
                  echo "<div style='width:".$nWidth."%' class='divBarraAvaliado' name='divBarraAvaliado2' id='divBarraAvaliado2'>";
                  echo "</div>";
                echo "</td>";
                echo "<td class='tdColuna2'>";
                  $dPercBom = $this->FMetGer->FormatarValorMonetario($dPercBom);
                  echo "bom " .$dPercBom. "%";
                echo "</td>";
              echo "</tr>";
            
              echo "<tr>";
                echo "<td class='tdColuna1'>";
                  $nWidth = ceil($dPercRegular); //arredonda para cima
                  echo "<div style='width:".$nWidth."%' class='divBarraAvaliado' name='divBarraAvaliado3' id='divBarraAvaliado3'>";
                 echo "</div>";
                echo "</td>";
                echo "<td class='tdColuna2'>";
                  $dPercRegular = $this->FMetGer->FormatarValorMonetario($dPercRegular);
                  echo "regular " .$dPercRegular. "%";
                echo "</td>";
              echo "</tr>";
            
              echo "<tr>";
                echo "<td class='tdColuna1'>";
                  $nWidth = floor($dPercRuim); //arredonda para baixo
                  echo "<div style='width:".$nWidth."%' class='divBarraAvaliado' name='divBarraAvaliado4' id='divBarraAvaliado4'>";
                  echo "</div>";
                echo "</td>";
                echo "<td class='tdColuna2'>";
                  $dPercRuim = $this->FMetGer->FormatarValorMonetario($dPercRuim);
                  echo "ruim " .$dPercRuim. "%";
                echo "</td>";
              echo "</tr>";
            
              echo "<tr>";
                echo "<td class='tdColuna1'>";
                  $nWidth = floor($dPercPessimo); //arredonda para baixo
                  echo "<div style='width:".$nWidth."%' class='divBarraAvaliado' name='divBarraAvaliado5' id='divBarraAvaliado5'>";
                  echo "</div>";
                echo "</td>";
                echo "<td class='tdColuna2'>";
                  $dPercPessimo = $this->FMetGer->FormatarValorMonetario($dPercPessimo);
                  echo "péssimo " .$dPercPessimo. "%";
                echo "</td>";
              echo "</tr>";
            echo "</table>";
          } //fim - if($nTotalAvaliacoes > 0)
          //este produto ainda não recebeu avaliações
          else{
            echo "<span class='spnProdutoSemAvaliacao' name='spnProdutoSemAvaliacao' id='spnProdutoSemAvaliacao'>";
              echo "Este produto ainda não recebeu avaliações.";
              echo "<br />";
              echo "Seja o primeiro a avaliar.";
            echo "</span>";
          }
        echo "</div>"; //fim - divResultadoAvaliacoes
      } //fim - ProcessarMostrarResultadoAvaliacoes()


      //cria a div com o link para retornar para a página que chamou esta
      private function CriarDivVoltarPaginaChamou(){
        echo "<div class='divVoltarPaginaChamou' name='divVoltarPaginaChamou' id='divVoltarPaginaChamou'>";
          if($this->sChamou == "finalizarCompra"){
            echo "<a href='pgFinalizarCompra.php' class='lnkVoltarPaginaChamou' name='lnkVoltarPaginaChamou' id='lnkVoltarPaginaChamou'>Voltar Finalizar Compra</a>";
          }
          else if($this->sChamou == "paginaPrincipal"){
            echo "<a href='../index.php' class='lnkVoltarPaginaChamou' name='lnkVoltarPaginaChamou' id='lnkVoltarPaginaChamou'>Voltar Página Inicial</a>";
          }
          else{
            echo "<a href='../index.php' class='lnkVoltarPaginaChamou' name='lnkVoltarPaginaChamou' id='lnkVoltarPaginaChamou'>Voltar Página Inicial</a>";
          }
        echo "</div>";
      } //fim - CriarDivVoltarPaginaChamou()
      

      //fecha a div do conteúdo que contém os dados do produto
      private function FecharDivConteudoDadosProduto(){
        echo "</div>"; //divVisualizarProdConteudoDadosProduto
      } //fim - FecharDivConteudoDadosProduto()
      
      
      //cria a div da lateral direita que irá conter os produtos que tenham relação com o que está sendo visualizado
      private function CriarDivLateralDireita(){
        echo "<div class='divLateralDireita' name='divLateralDireita' id='divLateralDireita'>";
          require_once(".\pgExibirProdutosRelacionados.php");
          $this->pgExbirProdutosRelacionados = new PgExbirProdutosRelacionados('visualizarProdutos',$this->nCdProduto);
        echo "</div>";
      } //fim - CriarDivLateralDireita()


      //fecha a div do conteúdo
      private function FecharDivConteudo(){
        echo "</div>"; //divVisualizarProdConteudo
      } //fim - FecharDivConteudo()
      

      private function FecharDivPrincipal(){
        echo "</div>";
      }
      

       //finaliza a tag body
      private function FecharBody(){
        echo "</body>";
      }


      //finaliza HTML
      private function FecharHTML(){
        echo "</html>";
      }
      
      
      //realiza login do usuário
      private function RealizarLogin(){
        echo  "<div class='divLoginUsuario' name='divLoginUsuarioTitulo' id='divLoginUsuarioTitulo'>";
          echo "<span class='spnTituloRealizarLogin' name='spnTituloRealizarLoginTitulo' id='spnTituloRealizarLoginTitulo'>";
            echo "Para Avaliar Produtos, deve ser realizado o login.";
          echo "</span>";
          echo "</br>";
          echo "<span class='spnTituloRealizarLogin' name='spnTituloRealizarLoginAqui' id='spnTituloRealizarLoginAqui'>";
            echo "Caso ainda não for cadastrado, realize o cadastro ";
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
          //atributo href do link abaixo, deve ser igual ao atributo id da div que será a janela modal
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
        echo "</div>";
      } //CriarDivRecuperarSenha()
      

      //cria a div para comprar produto
      private function CriaDivComprarProduto(){
        echo "<div id='boxes'>";
          echo "<div id='janelaComprarProduto' class='window dialog'>";
            echo "<a href='#' class='close'>Fechar [X]</a>";
            echo "<fieldset class='fsetOpcoes'>";
            echo "<legend>&nbsp;&nbsp;Comprar&nbsp;&nbsp;</legend>";
              echo "<span class='spnTituloComprarProduto' name='spnTituloComprarProduto' id='spnTituloComprarProduto'>";
                echo $this->sTipoProduto . " - " . $this->oDadosProduto[0]->nome_produto;
              echo "</span>";
              //formulário para realizar a compra do produto
              echo "<form id='frmComprarProduto' name='frmComprarProduto' method='post' action=''>";
                echo "<input type='hidden' name='edCdProduto' id='edCdProduto' value='".$this->nCdProduto."' />";
                echo "<input type='hidden' name='edTipoProduto' id='edTipoProduto' value='".$this->sTipoProduto."' />";
                //quantidade
                echo "<label class='lblTituloCompProd' name='lblTituloCompProdQtde' id='lblTituloCompProdQtde'>";
                  echo "Qtde:";
                echo "</label>";
                echo "<input type='text' class='txtCompProd' name='txtCompProdQtde' id='txtCompProdQtde' value='1' maxlength='3'>";
                echo "<br />";
                //tamanho
                echo "<label class='lblTituloCompProd' name='lblTituloCompProdTamanho' id='lblTituloCompProdTamanho'>";
                  echo "Tamanho:";
                echo "</label>";
                echo "<select type='text' size='1' class='sctCompProd' name='sctTamanho' id='sctTamanho'>";
                  echo "<option selected value='' class='sctOptTamanho'></option>";
                  $this->FMetGer->ExibirTamanhos("sctOptTamanho");
                echo "</select>";
                echo "<br />";
                //comprar
                echo "<input type='submit' class='btnCompProd' name='btnCompProdComprar' id='btnCompProdComprar' value='Comprar' />";
                echo "<img class='imgComprarProdutoProcessando' name='imgComprarProdutoProcessando' id='imgComprarProdutoProcessando' src='../figuras/processando/loader1.gif' />";
                echo "<span class='spnInformacaoComprouProduto' name='spnInformacaoComprouProduto' id='spnInformacaoComprouProduto'>";
                   echo "";
                echo "</span>";
              echo "</form>";
            echo "</fieldset>";
          echo "</div>";
        echo "</div>";
      } //CriaDivComprarProduto()

      
      //cria a div com id='mask' para ser usada nas janelas modais
      private function CriaDivMascaraJanelaModal(){
        //máscara para cobrir a tela
        echo "<div id='mask'></div>";
      } //fim - CriaDivMascaraJanelaModal()
      
    } //fim - class PgVisualizarProduto
?>
