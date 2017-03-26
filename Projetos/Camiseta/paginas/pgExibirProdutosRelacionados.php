<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgExibirProdutosRelacionados.php
  Função: página que exibe os produtos relacionados
  Data de Criação: 21/03/2011 - 18:05
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  SolicitarArquivos()
  InicializarVariaveis()
  RetornarSubGrupoProdutoRelacional() //retorna o sub-grupo do produto relacional
  RetornarGrupoDoSubGrupo() //retorna o grupo do sub-grupo do produto relacional
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  BuscarExibirProdutosBloco1() //monta e executa o SQL, e exibe os produtos no bloco 1
  BuscarExibirProdutosBloco2() //monta e executa o SQL, e exibe os produtos no bloco 2
  BuscarExibirProdutosBloco3() //monta e executa o SQL, e exibe os produtos no bloco 3
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php

//    $pgExbirProdutosRelacionados = new PgExbirProdutosRelacionados('visualizarProdutos','3');
    class PgExbirProdutosRelacionados{
      //variáveis recebidas no __construct
      private $sTipoExibicao; //tipo de exibição; aonde será exibido. Valores possíveis: visualizarProdutos
      private $nCdProdutoRelacional; //código do produto relacional, para trazer os demais produtos a serem exibidos
      
      private $Fbd;
      private $sSql;
      
      private $nSubGrupo; //sub-grupo do produto relacional, para buscar produtos do mesmo sub-grupo
      private $nGrupo; //grupo do sub-grupo do produto relacional, para buscar produtos do mesmo grupo
      
      private $sCdProdutosIgnorados; //código dos produtos ignorados, para não retornar no SELECT

      private $nTotalBlocos; //total de blocos de produtos a serem exibidos
      private $nFigurasPorBloco; //figuras por bloco
      
      
      function __construct($psTipoExibicao,$pnCdProdutoRelacional){
        $this->sTipoExibicao = $psTipoExibicao;
        $this->nCdProdutoRelacional = $pnCdProdutoRelacional;

        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        //exibição de produtos relacionados, para a página pgVisualizarProduto.php
        if($this->sTipoExibicao == "visualizarProdutos"){
          $this->BuscarExibirProdutosBloco1();
          $this->BuscarExibirProdutosBloco2();
          $this->BuscarExibirProdutosBloco3();
        }
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }


	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("../classes/ConexaoBD.php");
	  }
	  

      private function InicializarVariaveis(){
        //bd
        $this->Fbd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        
        $this->sCdProdutosIgnorados = $this->nCdProdutoRelacional;
        
        $this->nSubGrupo = $this->RetornarSubGrupoProdutoRelacional();
        $this->nGrupo = $this->RetornarGrupoDoSubGrupo();
        
        if($this->sTipoExibicao == "visualizarProdutos"){
          $this->nTotalBlocos = 3;
          $this->nFigurasPorBloco = 3;
        }
      } //fim - InicializarVariaveis()
      
      
      //retorna o sub-grupo do produto relacional
      private function RetornarSubGrupoProdutoRelacional(){
        $nRetorno = 0;
        $this->sSql = "SELECT cdFkSubGrupo";
        $this->sSql .= "  FROM camiseta";
        $this->sSql .= " WHERE cdCamiseta = '" .$this->nCdProdutoRelacional. "'";
        $oDadosSubGrupo = $this->Fbd->PesquisarSQL($this->sSql);
        if($oDadosSubGrupo){
          $nRetorno = $oDadosSubGrupo[0]->cdFkSubGrupo;
        }
        return $nRetorno;
      } //fim - RetornarSubGrupoProdutoRelacional()


      //retorna o grupo do sub-grupo do produto relacional
      private function RetornarGrupoDoSubGrupo(){
        $nRetorno = 0;
        $this->sSql = "SELECT cdFkGrupo";
        $this->sSql .= "  FROM sub_grupo";
        $this->sSql .= " WHERE cdSubGrupo = '" .$this->nSubGrupo. "'";
        $oDadosGrupo = $this->Fbd->PesquisarSQL($this->sSql);
        if($oDadosGrupo){
          $nRetorno = $oDadosGrupo[0]->cdFkGrupo;
        }
        return $nRetorno;
      } //fim - RetornarGrupoDoSubGrupo()
      
        
      //inicia HTML
      private function IniciarHTML(){
	    echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
        echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-br' lang='pt-br'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='../css/cPgExibirProdutosRelacionados.css' type='text/css' />";

          if($this->sTipoExibicao != "visualizarProdutos"){ //página 'pai' já insere jQuery
            echo "<script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>";
          }
          echo "<script language='JavaScript' src='../js/jQryPgExibirProdutosRelacionados.js'></script>";
        echo "</head>";
      }


      //iniciar a tag body
      private function IniciarBody(){
        echo "<body>";
      }


      //inicia a div principal do site
      private function IniciarDivPrincipal(){
        echo "<div class='divExibirProdutosRelacionados' name='divExibirProdutosRelacionados' id='divExibirProdutosRelacionados'>";
          echo "<span class='spnDescExibirProdutoRelacionais' name='spnDescExibirProdutoRelacionais' id='spnDescExibirProdutoRelacionais'>";
            echo "Produtos relacionados:";
          echo "</span>";
      }
      
      
      //monta e executa o SQL, e exibe os produtos no bloco 1
      //produtos com o sub-grupo ao do produto relacional
      private function BuscarExibirProdutosBloco1(){
        $this->sSql = "SELECT c.cdCamiseta,c.nome AS 'nome_camiseta',";
        $this->sSql .= " i.imagem,i.nome AS 'nome_imagem'";
        $this->sSql .= " FROM camiseta c";
        $this->sSql .= " JOIN imagem_camiseta i ON c.cdCamiseta = i.cdFkCamiseta";
        $this->sSql .= " WHERE c.cdFkSubGrupo='" .$this->nSubGrupo. "'";
        $this->sSql .= " AND i.is_principal = 'S'";
        $this->sSql .= " AND c.cdCamiseta NOT IN(" .$this->sCdProdutosIgnorados. ")";
        $this->sSql .= " ORDER BY rand() LIMIT 3";
        $oDadosBloco1 = $this->Fbd->PesquisarSQL($this->sSql);
        if($oDadosBloco1){
          echo "<div class='divSlideShow' id='divSlideShow1'>";
            $i = 0;
            foreach($oDadosBloco1 as $oRegistro){
              $sLink = "./pgVisualizarProduto.php?sTipoProduto=camiseta&nCdProduto=" .$oRegistro->cdCamiseta. "&sChamou=paginaPrincipal";
              if($i == 0){
                echo "<a target='_blank' class='active' href='".$sLink."'>";
              }
              else{
                echo "<a target='_blank' href='".$sLink."'>";
              }
              echo "<img src='." .$oRegistro->imagem. "' alt='<i>" .$oRegistro->nome_camiseta. "</i>' />";
              echo "</a>";
              $this->sCdProdutosIgnorados .= "," .$oRegistro->cdCamiseta;
              $i++;
            }
          echo "</div>";
        }
        //se não achou produtos com este sub-grupo, procura produtos pelo grupo deste sub-grupo
        else{
          $this->sSql = "SELECT c.cdCamiseta,c.nome AS 'nome_camiseta',";
          $this->sSql .= " i.imagem,i.nome AS 'nome_imagem'";
          $this->sSql .= " FROM camiseta c";
          $this->sSql .= " JOIN sub_grupo s ON c.cdFkSubGrupo = s.cdSubGrupo";
          $this->sSql .= " JOIN grupo g ON s.cdFkGrupo = g.cdGrupo";
          $this->sSql .= " JOIN imagem_camiseta i ON c.cdCamiseta = i.cdFkCamiseta";
          $this->sSql .= " WHERE g.cdGrupo='" .$this->nGrupo. "'";
          $this->sSql .= " AND i.is_principal = 'S'";
          $this->sSql .= " AND c.cdCamiseta NOT IN(" .$this->sCdProdutosIgnorados. ")";
          $this->sSql .= " ORDER BY rand() LIMIT 3";
          $oDadosBloco1 = $this->Fbd->PesquisarSQL($this->sSql);
          if($oDadosBloco1){
            echo "<div class='divSlideShow' id='divSlideShow1'>";
              $i = 0;
              foreach($oDadosBloco1 as $oRegistro){
                $sLink = "./pgVisualizarProduto.php?sTipoProduto=camiseta&nCdProduto=" .$oRegistro->cdCamiseta. "&sChamou=paginaPrincipal";
                if($i == 0){
                  echo "<a target='_blank' class='active' href='".$sLink."'>";
                }
                else{
                  echo "<a target='_blank' href='".$sLink."'>";
                }
                echo "<img src='." .$oRegistro->imagem. "' alt='<i>" .$oRegistro->nome_camiseta. "</i>' />";
                echo "</a>";
                $this->sCdProdutosIgnorados .= "," .$oRegistro->cdCamiseta;
                $i++;
              }
            echo "</div>";
          }
        }
      } //fim - BuscarExibirProdutosBloco1()
      

      //monta e executa o SQL, e exibe os produtos no bloco 2
      //produtos com o grupo igual ao do sub-grupo do produto relacional
      private function BuscarExibirProdutosBloco2(){
        $this->sSql = "SELECT c.cdCamiseta,c.nome AS 'nome_camiseta',";
        $this->sSql .= " i.imagem,i.nome AS 'nome_imagem'";
        $this->sSql .= " FROM camiseta c";
        $this->sSql .= " JOIN sub_grupo s ON c.cdFkSubGrupo = s.cdSubGrupo";
        $this->sSql .= " JOIN grupo g ON s.cdFkGrupo = g.cdGrupo";
        $this->sSql .= " JOIN imagem_camiseta i ON c.cdCamiseta = i.cdFkCamiseta";
        $this->sSql .= " WHERE g.cdGrupo='" .$this->nGrupo. "'";
        $this->sSql .= " AND i.is_principal = 'S'";
        $this->sSql .= " AND c.cdCamiseta NOT IN(" .$this->sCdProdutosIgnorados. ")";
        $this->sSql .= " ORDER BY rand() LIMIT 3";
        $oDadosBloco2 = $this->Fbd->PesquisarSQL($this->sSql);
        if($oDadosBloco2){
          echo "<div class='divSlideShow' id='divSlideShow2'>";
            $i = 0;
            foreach($oDadosBloco2 as $oRegistro){
              $sLink = "./pgVisualizarProduto.php?sTipoProduto=camiseta&nCdProduto=" .$oRegistro->cdCamiseta. "&sChamou=paginaPrincipal";
              if($i == 0){
                echo "<a target='_blank' class='active' href='".$sLink."'>";
              }
              else{
                echo "<a target='_blank' href='".$sLink."'>";
              }
              echo "<img src='." .$oRegistro->imagem. "' alt='<i>" .$oRegistro->nome_camiseta. "</i>' />";
              echo "</a>";
              $this->sCdProdutosIgnorados .= "," .$oRegistro->cdCamiseta;
              $i++;
            }
          echo "</div>";
        }
      } //fim - BuscarExibirProdutosBloco2()
      
      
      //monta e executa o SQL, e exibe os produtos no bloco 3
      //produtos com o grupo igual ao do sub-grupo do produto relacional
      private function BuscarExibirProdutosBloco3(){
        $this->sSql = "SELECT c.cdCamiseta,c.nome AS 'nome_camiseta',";
        $this->sSql .= " i.imagem,i.nome AS 'nome_imagem'";
        $this->sSql .= " FROM camiseta c";
        $this->sSql .= " JOIN sub_grupo s ON c.cdFkSubGrupo = s.cdSubGrupo";
        $this->sSql .= " JOIN grupo g ON s.cdFkGrupo = g.cdGrupo";
        $this->sSql .= " JOIN imagem_camiseta i ON c.cdCamiseta = i.cdFkCamiseta";
        $this->sSql .= " WHERE g.cdGrupo='" .$this->nGrupo. "'";
        $this->sSql .= " AND i.is_principal = 'S'";
        $this->sSql .= " AND c.cdCamiseta NOT IN(" .$this->sCdProdutosIgnorados. ")";
        $this->sSql .= " ORDER BY rand() LIMIT 3";
        $oDadosBloco3 = $this->Fbd->PesquisarSQL($this->sSql);
        if($oDadosBloco3){
          echo "<div class='divSlideShow' id='divSlideShow3'>";
            $i = 0;
            foreach($oDadosBloco3 as $oRegistro){
              $sLink = "./pgVisualizarProduto.php?sTipoProduto=camiseta&nCdProduto=" .$oRegistro->cdCamiseta. "&sChamou=paginaPrincipal";
              if($i == 0){
                echo "<a target='_blank' class='active' href='".$sLink."'>";
              }
              else{
                echo "<a target='_blank' href='".$sLink."'>";
              }
              echo "<img src='." .$oRegistro->imagem. "' alt='<i>" .$oRegistro->nome_camiseta. "</i>' />";
              echo "</a>";
              $this->sCdProdutosIgnorados .= "," .$oRegistro->cdCamiseta;
              $i++;
            }
          echo "</div>";
        }
      } //fim - BuscarExibirProdutosBloco3()


      //finaliza a div principal
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

    } //fim - class PgExbirProdutosRelacionados
?>
