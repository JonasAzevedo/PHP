<?php
/*******************************************************************
********************************************************************
  Nome: pgComprarProduto.php
  Função: página que apresenta produto a ser comprado, e realiza a compra
  Data de Criação: 15/02/2011 - 09:24
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: http://localhost/VENDA_CAMISETA/paginas/pgComprarProduto.php?sTipoProduto=camiseta&nCdProduto=4
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
  CriarDivCompProdCabecalho()  //cria a div de cabeçalho
  CriarDivCompProdLateralDireita()  //cria a div da lateral direita
  PesquisarProduto()  //pesquisa pelo produto que está sendo comprado
  CriarDivCompProdConteudo()  //cria a div do conteúdo
  ExibirTamanhos()  //imprime no select os tamanhos das camisetas
  CriarDivCompProdConteudoBranco()  //cria a div com conteúdo em branco, caso a camiseta passada por parâmetro não exista
  SelecionarProdutosMeuCarrinho()  //seleciona produtos do meu carrinho
  CriarDivCompProdLateralEsquerda()  //cria a div da lateral esquerda
  FecharBody()
  FecharHTML()
*/

    $pgComprarProduto = new PgComprarProduto();

    class PgComprarProduto{
      //bd
      private $Fbd;
      private $sSql;
    
      private $nCdProduto; //produto a ser comprado. $_GET
      private $nCdUsuario; //usuário que está realizando a compra. $_SESSION
      private $nCdPedidoCompra; //código do pedido da compra
      
      private $sTipoProduto; //camiseta
      
      private $oDadosMeuCarrinho; //armazena os dados do meu carrinho, exibir na div lateral esquerda.
      
      //dados do produto
      //camiseta
      private $nCdCamiseta;
      private $sNomeProduto;
      private $dValor;
      private $dDesconto;
      private $sFlAtivo;
      private $sDescricao;
      private $sNomeSubGrupo;
      private $sNomeGrupo;
      //imagens da camiseta
      private $sNomeImagem1;
      private $imgImagem1;
      private $sNomeImagem2;
      private $imgImagem2;
      private $sNomeImagem3;
      private $imgImagem3;
        
      function __construct(){
        $this->IniciarSession();
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->CriarDivCompProdCabecalho();
        $this->CriarDivCompProdLateralDireita();

        //somente pode comprar produto, se foi informado um produto e o seu tipo
        if(($this->nCdProduto != 0)and($this->sTipoProduto != "")){
          $this->PesquisarProduto();
          //se encontrou a camiseta, apresenta conteúdo com os dados da camiseta
          if($this->nCdCamiseta != 0){
            $this->CriarDivCompProdConteudo();
          }
          else{
            $this->CriarDivCompProdConteudoBranco();
          }
          $this->SelecionarProdutosMeuCarrinho();
          $this->CriarDivCompProdLateralEsquerda();
        }
        else{
          $this->CriarDivCompProdConteudoBranco();
        }

        $this->FecharBody();
        $this->FecharHTML();
      }
      

      //formata parâmetro '$pdValor' para valor monetário
      private function FormatarValorMonetario($pdValor){
        //$sValor = str_replace(array(".", ","), "", $pdValor);
        $sValor = str_replace(array(","), "", $pdValor);
        $dNumFormatado = number_format($sValor,2,',','.');
        return $dNumFormatado;
      } //fim - FormatarValorMonetario()
      

      //inicia a sessão que armazena os do usuário logado no site
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      }
      
      
	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("../classes/ConexaoBD.php");
	  }


      private function InicializarVariaveis(){
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
        
        //dados da camiseta
        $this->nCdCamiseta = 0;
        $this->sNomeProduto = "";
        $this->dValor = 0;
        $this->dDesconto = 0;
        $this->sFlAtivo = "";
        $this->sDescricao = "";
        $this->sNomeSubGrupo = "";
        $this->sNomeGrupo = "";
        $this->sNomeImagem1 = "";
        $this->imgImagem1 = "";
        $this->sNomeImagem2 = "";
        $this->imgImagem2 = "";
        $this->sNomeImagem3 = "";
        $this->imgImagem3 = "";
      } //fim - InicializarVariaveis()
      

      //inicia HTML
      function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='../css/cPgComprarProduto.css' type='text/css' />";
          echo "<script type='text/javascript' src='../js/jPgComprarProduto.js'></script>";
          
          echo "<script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>";
          echo "<script type='text/javascript' src='../jQuery/plugin/lightbox.js'></script>";
          echo "<link rel='stylesheet' href='../css/jQuery/lightbox.css' type='text/css' />";
       echo "</head>";
      }


      //iniciar a tag body
      function IniciarBody(){
        echo "<body>";
      }
      
      
      //cria a div de cabeçalho
      function CriarDivCompProdCabecalho(){
        echo "<div class='divCompProdCabecalho' name='divCompProdCabecalho' id='divCompProdCabecalho'>";
          echo "div do cabeçalho";
        echo "</div>";
      }
      
      
      //cria a div da lateral direita
      function CriarDivCompProdLateralDireita(){
        echo "<div class='divCompProdLateralDireita' name='divCompProdLateralDireita' id='divCompProdLateralDireita'>";
          echo "div da lateral direita";
        echo "</div>";
      }
      
      
      //pesquisa pelo produto que está sendo comprado
      function PesquisarProduto(){
        //pesquisando pelos dados do produto
        
        if($this->sTipoProduto == "camiseta"){
          //camiseta
          $this->sSql = "SELECT c.*, s.nome AS 'nome_sub_grupo', g.nome AS 'nome_grupo'";
          $this->sSql .= " FROM camiseta c";
          $this->sSql .= " JOIN sub_grupo s ON c.cdFkSubGrupo = s.cdSubGrupo";
          $this->sSql .= " JOIN grupo g ON s.cdFkGrupo = g.cdGrupo";
          $this->sSql .= " WHERE c.CdCamiseta = '" .$this->nCdProduto. "'";
        
          $oDadosProduto = $this->Fbd->PesquisarSQL($this->sSql);
        
          if($oDadosProduto){
            $this->nCdCamiseta = $oDadosProduto[0]->cdCamiseta;
            $this->sNomeProduto = $oDadosProduto[0]->nome;
            $this->dValor = $oDadosProduto[0]->valor;
            $this->dDesconto = $oDadosProduto[0]->desconto;
            $this->sFlAtivo = $oDadosProduto[0]->flAtivo;
            $this->sDescricao = $oDadosProduto[0]->descricao;
            $this->sNomeSubGrupo = $oDadosProduto[0]->nome_sub_grupo;
            $this->sNomeGrupo = $oDadosProduto[0]->nome_grupo;
          }
        
          //imagens da camiseta
          if($this->nCdCamiseta != 0){
            $this->sSql = "SELECT i.* FROM imagem_camiseta i";
            $this->sSql .= " WHERE i.cdFkCamiseta = '" .$this->nCdCamiseta. "'";

            $oDadosCamiseta = $this->Fbd->PesquisarSQL($this->sSql);
          
            if($oDadosCamiseta){
              if($oDadosCamiseta[0]->imagem != "complemento"){
                $this->sNomeImagem1 = $oDadosCamiseta[0]->nome;
                $this->imgImagem1 = "." . $oDadosCamiseta[0]->imagem;
              }
              else{
                $this->sNomeImagem1 = "";
                $this->imgImagem1 = "";
              }
              
              if($oDadosCamiseta[1]->imagem != "complemento"){
                $this->sNomeImagem2 = $oDadosCamiseta[1]->nome;
                $this->imgImagem2 = "." . $oDadosCamiseta[1]->imagem;
              }
              else{
                $this->sNomeImagem2 = "";
                $this->imgImagem2 = "";
              }
              
              if($oDadosCamiseta[2]->imagem != "complemento"){
                $this->sNomeImagem3 = $oDadosCamiseta[2]->nome;
                $this->imgImagem3 = "." . $oDadosCamiseta[2]->imagem;
              }
              else{
                $this->sNomeImagem3 = "";
                $this->imgImagem3 = "";
              }
            }
          }
        } //fim - if($this->sTipoProduto == "camiseta")
      } //fim - PesquisarProduto()
      
      
      //cria a div do conteúdo
      function CriarDivCompProdConteudo(){
        echo "<div class='divCompProdConteudo' name='divCompProdConteudo' id='divCompProdConteudo'>";

          //div com dados da imagem do produto - três imagens
          echo "<div class='divCompProdDadosImagemProduto' name='divCompProdDadosImagemProduto' id='divCompProdDadosImagemProduto' >";
            //imagem 1
            if($this->imgImagem1 != ""){
              echo "<div class='divCompProdImagemProduto' name='divCompProdImagemProduto1' id='divCompProdImagemProduto1' >";
                echo "<span class='spnVlrCompProdNomeImagem' name='spnVlrCompProdNomeImagem1' id='spnVlrCompProdNomeImagem1'>";
                  echo $this->sNomeImagem1;
                echo "</span>";

                echo "<a href='" .$this->imgImagem1. "' rel='lightbox' title='" .$this->sNomeImagem1. "'>";
                  echo "<img class='imgComProdFiguraProduto' name='imgComProdFigura1' id='imgComProdFigura1' src='" .$this->imgImagem1 ."' />";
                echo "</a>";
              echo "</div>";
            }
            //imagem 2
            if($this->imgImagem2 != ""){
              echo "<div class='divCompProdImagemProduto' name='divCompProdImagemProduto2' id='divCompProdImagemProduto2' >";
                echo "<span class='spnVlrCompProdNomeImagem' name='spnVlrCompProdNomeImagem2' id='spnVlrCompProdNomeImagem2'>";
                  echo $this->sNomeImagem2;
                echo "</span>";

                echo "<a href='" .$this->imgImagem2. "' rel='lightbox' title='" .$this->sNomeImagem2. "'>";
                  echo "<img class='imgComProdFiguraProduto' name='imgComProdFigura2' id='imgComProdFigura2' src='" .$this->imgImagem2 ."' />";
                echo "</a>";
              echo "</div>";
            }
            //imagem 3
            if($this->imgImagem3 != ""){
              echo "<div class='divCompProdImagemProduto' name='divCompProdImagemProduto3' id='divCompProdImagemProduto3' >";
                echo "<span class='spnVlrCompProdNomeImagem' name='spnVlrCompProdNomeImagem3' id='spnVlrCompProdNomeImagem3'>";
                  echo $this->sNomeImagem3;
                echo "</span>";

                echo "<a href='" .$this->imgImagem3. "' rel='lightbox' title='" .$this->sNomeImagem3. "'>";
                  echo "<img class='imgComProdFiguraProduto' name='imgComProdFigura3' id='imgComProdFigura3' src='" .$this->imgImagem3 ."' />";
                echo "</a>";
              echo "</div>";
            }
          echo "</div>"; //fim - div dados da imagem produto

          //div com dados do produto
          echo "<div class='divCompProdDados' name='divCompProdDados' id='divCompProdDados'>";
          
            //grupo e subGrupo
            echo "<span class='spnVlrCompProdCaracProduto' name='spnVlrCompProdCaracProdutoGrupoSubGrupo' id='spnVlrCompProdCaracProdutoGrupoSubGrupo'>";
            echo $this->sNomeGrupo ." - ". $this->sNomeSubGrupo;
            echo "</span>";
            echo "<br />";

            //nome
            echo "<span class='spnCompProdTituloCaracProduto' name='spnCompProdTituloCaracProdutoNome' id='spnCompProdTituloCaracProdutoNome'>" ."Nome ". "</span>";
            echo "<span class='spnVlrCompProdCaracProduto' name='spnVlrCompProdCaracProdutoNome' id='spnVlrCompProdCaracProdutoNome'>";
            echo $this->sNomeProduto;
            echo "</span>";
            echo "<br />";

            if($this->dDesconto > 0){
              //valor
              $this->dValor = $this->FormatarValorMonetario($this->dValor);
              echo "<span class='spnCompProdTituloCaracProduto' name='spnCompProdTituloCaracProdutoValorAntigo' id='spnCompProdTituloCaracProdutoValorAntigo'>" ."De R$ ". "</span>";
              echo "<span class='spnVlrCompProdCaracProduto' name='spnVlrCompProdCaracProdutoValorAntigo' id='spnVlrCompProdCaracProdutoValorAntigo'>";
              echo $this->dValor;
              echo "</span>";
              
              //valor - desconto
              $this->dValor = $this->dValor - $this->dDesconto;
              $this->dValor = $this->FormatarValorMonetario($this->dValor);
              echo "<span class='spnCompProdTituloCaracProduto' name='spnCompProdTituloCaracProdutoValorDesconto' id='spnCompProdTituloCaracProdutoValorDesconto'>" ."Por R$ ". "</span>";
              echo "<span class='spnVlrCompProdCaracProduto' name='spnVlrCompProdCaracProdutoValorDesconto' id='spnVlrCompProdCaracProdutoValorDesconto'>";
              echo $this->dValor;
              echo "</span>";

              echo "</br>";
            }
            else{
              //valor
              $this->dValor = $this->FormatarValorMonetario($this->dValor);
              echo "<span class='spnCompProdTituloCaracProduto' name='spnCompProdTituloCaracProdutoValor' id='spnCompProdTituloCaracProdutoValor'>" ."R$ ". "</span>";
              echo "<span class='spnVlrCompProdCaracProduto' name='spnVlrCompProdCaracProdutoValor' id='spnVlrCompProdCaracProdutoValor'>";
              echo $this->dValor;
              echo "</span>";
              echo "<br />";
            }

            //desconto
            $this->dDesconto = $this->FormatarValorMonetario($this->dDesconto);
            echo "<span class='spnCompProdTituloCaracProduto' name='spnCompProdTituloCaracProdutoDesconto' id='spnCompProdTituloCaracProdutoDesconto'>" ."Desconto ". "</span>";
            echo "<span class='spnVlrCompProdCaracProduto' name='spnVlrCompProdCaracProdutoDesconto' id='spnVlrCompProdCaracProdutoDesconto'>";
            echo $this->dDesconto;
            echo "</span>";
            echo "<br />";
            
            //descrição
            echo "<span class='spnCompProdTituloCaracProduto' name='spnCompProdTituloCaracProdutoDescricao' id='spnCompProdTituloCaracProdutoDescricao'>" ."Descrição ". "</span>";
            echo "<span class='spnVlrCompProdCaracProduto' name='spnVlrCompProdCaracProdutoDescricao' id='spnVlrCompProdCaracProdutoDescricao'>";
            echo $this->sDescricao;
            echo "</span>";
            echo "<br />";

            //campos id's - hidden
            echo "<input type='hidden' name='edTipoProduto' id='edTipoProduto' value='".$this->sTipoProduto."' />";
            echo "<input type='hidden' name='edIdProduto' id='edIdProduto' value='".$this->nCdCamiseta."' />";
          echo "</div>"; //fim - div com dados do produto - divCompProdDados
          
          
          //div com as opções para a compra do produto
          echo "<div class='divCompProdComprar' name='divCompProdComprar' id='divCompProdComprar'>";
            //quantidade
            echo "<span class='spnTituloCompProdQtde' name='spnTituloCompProdQtde' id='spnTituloCompProdQtde'>" ."Qtde: ". "</span>";
            echo "<input type='text' class='txtCompProdQtdeCompra' name='txtCompProdVlrQtdeCompra' id='txtCompProdVlrQtdeCompra' value='1' maxlength='3'>";
            //tamanho
            echo "<span class='spnTituloCompProdTamanho' name='spnTituloCompProdTamanho' id='spnTituloCompProdTamanho'>" ."Tamanho: ". "</span>";
            echo "<select size='1' class='sctTamanho' name='sctTamanho' id='sctTamanho'>";
              echo "<option selected value='#' class='sctOptTamanho'></option>";
              $this->ExibirTamanhos();
            echo "</select>";
            //comprar
            echo "<input type='button' class='btnCompProdComprar' name='btnCompProdComprar' id='btnCompProdComprar' value='Comprar' onclick='ComprarItemProduto(edTipoProduto.value,edIdProduto.value,txtCompProdVlrQtdeCompra.value,sctTamanho.value);'/>";
          echo "</div>"; //fim - div com as opções para a compra do produto - divCompProdComprar
          
          echo "<div class='divCompProdVoltar' name='divCompProdVoltar' id='divCompProdVoltar'>";
            echo "<a href='../index.php' class='lnkVoltarIndex' name='lnkVoltarIndex' id='lnkVoltarIndex'>";
              echo "Cancelar";
            echo "</a>";
          echo "</div>";

        echo "</div>"; //fim - div do conteúdo - divCompProdConteudo
      } //fim - CriarDivCompProdConteudo


      //imprime no select os tamanhos das camisetas
      private function ExibirTamanhos(){
        $oDadosCamiseta;
        $sSql = "SELECT * FROM tamanho_camiseta";
        $oDadosCamiseta = $this->Fbd->PesquisarSQL($sSql);
        
        foreach($oDadosCamiseta as $oRegistro){
          echo "<option value='".$oRegistro->sigla."' class='sctOptTamanho'>".$oRegistro->nome."</option>";
        }
      } //fim - ExibirTamanhos()

      
      //cria a div com conteúdo em branco, caso a camiseta passada por parâmetro não exista
      function CriarDivCompProdConteudoBranco(){
        echo "<div class='divCompProdConteudoBranco' name='divCompProdConteudoBranco' id='divCompProdConteudoBranco'>";
          echo "div conteudo em branco";
        echo "</div>";
      }
      
      
      //seleciona produtos do meu carrinho
      function SelecionarProdutosMeuCarrinho(){
        if ($this->nCdPedidoCompra != 0){
          $sSql = "SELECT i.cdItemPedidoCompra,i.tipo_produto,i.quantidade,i.valor_unitario,i.valor_total,";
          $sSql .= " c.nome AS 'nome_produto',c.valor,c.desconto,c.descricao,";
          $sSql .= " s.nome AS 'nome_sub_grupo',";
          $sSql .= " g.nome AS 'nome_grupo'";
          $sSql .= " FROM item_pedido_compra i";
          $sSql .= " JOIN camiseta c ON i.cdFkProduto = c.cdCamiseta";
          $sSql .= " JOIN sub_grupo s ON c.cdFkSubGrupo = s.cdSubGrupo";
          $sSql .= " JOIN grupo g ON s.cdFkGrupo = g.cdGrupo";
          $sSql .= " WHERE i.cdFkPedidoCompra = '".$this->nCdPedidoCompra."'";
          $sSql .= " AND status = 'aberto'";
          $this->oDadosMeuCarrinho = $this->Fbd->PesquisarSQL($sSql);
        }
      } //fim - SelecionarProdutosMeuCarrinho(){
      
      
      //cria a div da lateral esquerda
      function CriarDivCompProdLateralEsquerda(){
        echo "<div class='divCompProdLateralEsquerda' name='divCompProdLateralEsquerda' id='divCompProdLateralEsquerda'>";
          echo "<img class='imgFiguraCarrinho' name='imgFiguraCarrinho' id='imgFiguraCarrinho' src='../figuras/carrinho.jpg' />";

          $dValorTotal = 0;
          if($this->oDadosMeuCarrinho != 0){
            $i = 1;
            echo "<table class='tblMeuCarrinho' name='tblMeuCarrinho' id='tblMeuCarrinho'>";
            echo "<thead>";
              echo "<tr>";
                echo "<th>" . "Nome Produto" . "</th>";
                echo "<th>" . "Quantidade" . "</th>";
                echo "<th>" . "Valor(R$)" . "</th>";
              echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
              foreach($this->oDadosMeuCarrinho as $oRegistro){
                echo "<tr>";
                  //nome_produto
                  echo "<td>";
                    echo "<span class='spnCompProdLatEsq' name='spnCompProdLatEsqNomeProduto".$i."' id='spnCompProdLatEsqNomeProduto".$i."'>";
                      echo $oRegistro->nome_produto;
                    echo "</span>";
                  echo "</td>";
                  //quantidade
                  echo "<td>";
                    echo "<span class='spnCompProdLatEsq' name='spnCompProdLatEsqQuantidade".$i."' id='spnCompProdLatEsqQuantidade".$i."'>";
                      echo $oRegistro->quantidade;
                    echo "</span>";
                  echo "</td>";
                  //valor
                  $dValorTotal = $dValorTotal + $oRegistro->valor_total;
                  $oRegistro->valor_total = $this->FormatarValorMonetario($oRegistro->valor_total);
                  echo "<td>";
                    echo "<span class='spnCompProdLatEsq' name='spnCompProdLatEsqValorTotal".$i."' id='spnCompProdLatEsqValorTotal".$i."'>";
                      echo $oRegistro->valor_total;
                    echo "</span>";
                  echo "</td>";
                echo "</tr>";
              }
              echo "</tbody>";
            echo "</table>";
            
            //valor total
            $dValorTotal = $this->FormatarValorMonetario($dValorTotal);
            echo "<span class='spnValorTotal' name='spnValorTotal' id='spnValorTotal'>";
              echo "Valor Total: " . $dValorTotal;
            echo "</span>";
          }
        echo "</div>";
      } //fim - CriarDivCompProdLateralEsquerda()
      

      //finaliza a tag body
      function FecharBody(){
        echo "</body>";
      }


      //finaliza HTML
      function FecharHTML(){
        echo "</html>";
      }

    } //fim - class PgComprarProduto
?>
