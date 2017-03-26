<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgProdutosDestaque.php
  Função: página com os produtos em destaque
  Data de Criação: 22/02/2011 - 18:56
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: http://localhost/VENDA_CAMISETA/paginas/pgProdutosDestaque.php
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  SolicitarArquivos()
  InicializarVariaveis()
  IniciarHTML()
  IniciarBody()
  IniciarDivPrincipal()
  BuscarProdutosDestaque() //monta sql e seleciona os produtos em destaque
  ExibirProdutosDestaque() //exibe os produtos em destaque
  FecharDivPrincipal()
  FecharBody()
  FecharHTML()
-->

<?php
    class PgProdutosDestaque{
      private $Fbd;
      private $oDadosProdutosDestaque;
      private $TotalProdDestaque;
      
      function __construct(){
        $this->SolicitarArquivos();
        $this->InicializarVariaveis();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->IniciarDivPrincipal();
        $this->BuscarProdutosDestaque();
        if($this->TotalProdDestaque > 0){
          $this->ExibirProdutosDestaque();
        }
        $this->FecharDivPrincipal();
        $this->FecharBody();
        $this->FecharHTML();
      }
      
      
	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/ConexaoBD.php");
	  }


	  //inicializa variáveis
	  function InicializarVariaveis(){
        $this->Fbd = Conexao::GetInstanciaConexao();
        $this->oDadosProdutosDestaque = null;
        $this->TotalProdDestaque = 0;
	  }
      
      
      //inicia HTML
      private function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
          //echo "<script type='text/javascript' src='./jQuery/js/jquery-1.4.4.min.js'></script>"; //pgCabecalho.class.php
          echo "<script type='text/javascript' src='./jQuery/plugin/coin-slider/coin-slider.min.js'></script>";
          echo "<script type='text/javascript' src='./js/jPgProdutosDestaque.js'></script>";

          // echo "<link rel='stylesheet' href='./jQuery/plugin/coin-slider/coin-slider-styles.css' type='text/css' />";
          echo "<link rel='stylesheet' href='./css/cPgProdutosDestaque.css' type='text/css' />";
        echo "</head>";
      } //fim - IniciarHTML()
      
      
      //iniciar a tag body
      private function IniciarBody(){
        echo "<body>";
      }


      //inicia a div principal do site
      private function IniciarDivPrincipal(){
        echo "<div class='divPrincProdutosDestaque' name='divPrincProdutosDestaque' id='divPrincProdutosDestaque'>";
      }
      
      
      //monta sql e seleciona os produtos em destaque
      private function BuscarProdutosDestaque(){
        $sSql = "SELECT pd.cdProdutoDestaque,pd.flAtivo,pd.data_expira,pd.imagem,pd.nome AS 'nome_imagem', ";
        $sSql .= " c.cdCamiseta,c.nome AS 'nome_camiseta'";
        $sSql .= " FROM produto_destaque pd";
        $sSql .= " JOIN camiseta c ON c.cdCamiseta = pd.cdFkCamiseta";
        $sSql .= " WHERE pd.flAtivo = 'S'";
        $sSql .= " AND CURRENT_TIMESTAMP <= pd.data_expira";
        $sSql .= " AND c.flAtivo = 'S'";

        $this->oDadosProdutosDestaque = $this->Fbd->PesquisarSQL($sSql);
        if($this->oDadosProdutosDestaque){
          $this->TotalProdDestaque = count($this->oDadosProdutosDestaque);
        }
      } //fim - BuscarProdutosDestaque()
      
      
      //exibe os produtos em destaque
      private function ExibirProdutosDestaque(){
        echo "<div class='coin-slider' id='coin-slider'>";
          $i = 1;
          foreach($this->oDadosProdutosDestaque as $oRegistro){
            $sLink = "./paginas/pgVisualizarProduto.php?sTipoProduto=camiseta&nCdProduto=".$oRegistro->cdCamiseta."&sChamou=paginaPrincipal";
            echo "<a href = '".$sLink."'>";

/*comentado, pois foi adicionado link nos produtos em destaque
            if($i == 1){
              echo " target='_blank'>";
            }
            else{
              echo ">";
            }
*/
            echo "<img class='imgFig' src='".$oRegistro->imagem."'>";
            if($oRegistro->nome_imagem != ""){
              echo "<span>".$oRegistro->nome_imagem."</span>";
            }
            echo "</a>";
            $i++;
          } //fim - foreach()
          
        echo "</div>";
      } //fim -  ExibirProdutosDestaque()
      

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

    } //fim - class PgProdutosDestaque
?>
