<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxSelecionaLinksNavegacao.php
  Fun��o: p�gina que retorna os links de navega��o entre os produtos - usa Ajax
  Data de Cria��o: 11/02/2011 - 09:15
  Data de Atualiza��o: -
  Desenvolvido por: Jonas
  Acessando p�gina: -
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  IniciarSession()
  InicializarVariaveis()
  MontarSQLPesquisarTotalProdutos() //monta o SQL de pesquisa de total de produtos, com base nos filtros armazenados na session 'dados_sql'
  PesquisarTotalProdutos() //pesquisa pelos link's de navega��o
  CalcularTotalPaginas() //calcula o total de p�ginas com base no total de produtos
  MontarLinksNavegacao() //monta os link's de navega��o, calculando o n�mero das p�ginas, com base no total de p�ginas
  RetornarRegistroJSON() //retorno AJAX em formato JSON
*/

    $selecionarLinksNavegacao = new SelecionarLinksNavegacao();

    class SelecionarLinksNavegacao{
      //bd
      private $oBd;
      private $sSql;

      //vari�veis que est�o na session
      private $sTipoProduto;
      private $nSubGrupo;
      private $sFiltroPesquisa;
      private $nPgSelecionada;

      //vari�veis para calcular o total de p�ginas
      private $nProdutosPorPagina;
      private $nTotalProdutos;
      private $nTotalPaginas;
      
      //armazena o n�mero das p�ginas - link's
      private $sPgLnk1;
      private $sPgLnk2;
      private $sPgLnk3;
      private $sPgLnk4;
      private $sPgLnk5;


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();
        $this->MontarSQLPesquisarTotalProdutos();
        $this->PesquisarTotalProdutos();
        $this->CalcularTotalPaginas();
        $this->MontarLinksNavegacao();
        $this->RetornarRegistroJSON();
      }
      
      
      //inclui o cabe�alho da p�gina para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }
      
      
      //solicita arquivos necess�rios desta p�gina
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
	  }


      //inicia a sess�o que armazena os dados do $sql
      private function IniciarSession(){
        session_start("dados_sql");
      }


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        
        $this->sTipoProduto = $_SESSION["sTipoProduto"];
        $this->nSubGrupo = $_SESSION["nSubGrupo"];
        $this->sFiltroPesquisa = $_SESSION["sFiltroPesquisa"];
        $this->nPgSelecionada = $_SESSION["nPgSelecionada"];
        
        $this->nProdutosPorPagina = 9;
        $this->nTotalProdutos = 0;
        $this->nTotalPaginas = 0;
        
        $this->sPgLnk1 = "";
        $this->sPgLnk2 = "";
        $this->sPgLnk3 = "";
        $this->sPgLnk4 = "";
        $this->sPgLnk5 = "";
      } //fim - InicializarVariaveis()


      //monta o SQL de pesquisa de total de produtos, com base nos filtros armazenados na session 'dados_sql'
      private function MontarSQLPesquisarTotalProdutos(){
        $this->sSql = "SELECT COUNT(DISTINCT(cam.cdCamiseta)) AS 'total'";
        $this->sSql .= " FROM camiseta cam";
        $this->sSql .= " LEFT JOIN imagem_camiseta img_cam ON cam.cdCamiseta = img_cam.cdFkCamiseta";
        $this->sSql .= " JOIN sub_grupo sub_gru ON cam.cdFkSubGrupo = sub_gru.cdSubGrupo";
        $this->sSql .= " JOIN grupo gru ON sub_gru.cdFkGrupo = gru.cdGrupo";
        $this->sSql .= " WHERE cam.flAtivo = 'S'";

        //sub-grupo
        if($this->nSubGrupo != 0){
          $this->sSql .= " AND sub_gru.cdSubGrupo = '" .$this->nSubGrupo. "'";
        }

        //filtro de pesquisa
        if($this->sFiltroPesquisa != ""){
          $this->sSql .= " AND (cam.nome LIKE '%" .$this->sFiltroPesquisa. "%' OR cam.descricao LIKE '%";
          $this->sSql .= $this->sFiltroPesquisa. "%' OR sub_gru.nome LIKE '%" .$this->sFiltroPesquisa;
          $this->sSql .= "%' OR gru.nome LIKE '%" .$this->sFiltroPesquisa. "%')";
        }
      } //fim - MontarSQLPesquisarTotalProdutos()
      
      
      //pesquisa pelos link's de navega��o
      private function PesquisarTotalProdutos(){
        $oDadosPesquisa = $this->oBd->PesquisarSQL($this->sSql);
        if($oDadosPesquisa){
          $this->nTotalProdutos = $oDadosPesquisa[0]->total;
        }
      } //fim - PesquisarTotalProdutos()


      //calcula o total de p�ginas com base no total de produtos
      private function CalcularTotalPaginas(){
        $this->nTotalPaginas = $this->nTotalProdutos/$this->nProdutosPorPagina; //calcula total de p�ginas
        if(! is_int($this->nTotalPaginas)){
          $this->nTotalPaginas++;
          $this->nTotalPaginas = floor($this->nTotalPaginas);
        }
      } //fim - CalcularTotalPaginas()
      

      //monta os link's de navega��o, calculando o n�mero das p�ginas, com base no total de p�ginas
      private function MontarLinksNavegacao(){
        //se n�o existe uma p�gina
        if($this->nTotalPaginas == 1){
          //mas existe algum produto
          if($this->nTotalProdutos > 0){
            $this->sPgLnk1 = 1;
          }
        }
        //se existem duas p�ginas
        elseif($this->nTotalPaginas == 2){
          $this->sPgLnk1 = 1;
          $this->sPgLnk2 = 2;
        }
        //se existem tr�s p�ginas
        elseif($this->nTotalPaginas == 3){
          $this->sPgLnk1 = 1;
          $this->sPgLnk2 = 2;
          $this->sPgLnk3 = 3;
        }
        //se existem quatro p�ginas
        elseif($this->nTotalPaginas == 4){
          $this->sPgLnk1 = 1;
          $this->sPgLnk2 = 2;
          $this->sPgLnk3 = 3;
          $this->sPgLnk4 = 4;
        }
        //se existem cinco p�ginas
        elseif($this->nTotalPaginas == 5){
          $this->sPgLnk1 = 1;
          $this->sPgLnk2 = 2;
          $this->sPgLnk3 = 3;
          $this->sPgLnk4 = 4;
          $this->sPgLnk5 = 5;
        }
        //se existem mais que 5 p�ginas
        elseif($this->nTotalPaginas > 5){
          //se a p�gina selecionada � a 1�, 2� ou 3�
          if($this->nPgSelecionada <= 3){
            $this->sPgLnk1 = 1;
            $this->sPgLnk2 = 2;
            $this->sPgLnk3 = 3;
            $this->sPgLnk4 = 4;
            $this->sPgLnk5 = $this->nTotalPaginas;
          }
          //se a p�gina selecionada � antepen�ltima, pen�ltima ou �ltima
          elseif($this->nTotalPaginas-2 <= $this->sPgSelecionada){
            $this->sPgLnk1 = 1;
            $this->sPgLnk2 = $this->nTotalPaginas-3;
            $this->sPgLnk3 = $this->nTotalPaginas-2;
            $this->sPgLnk4 = $this->nTotalPaginas-1;
            $this->sPgLnk5 = $this->nTotalPaginas;
          }
          //se a p�gina selecionada � outra - p�ginas do 'meio'
          else{
            $this->sPgLnk1 = 1;
            $this->sPgLnk2 = $this->sPgSelecionada-1;
            $this->sPgLnk3 = $this->sPgSelecionada;
            $this->sPgLnk4 = $this->sPgSelecionada+1;
            $this->sPgLnk5 = $this->nTotalPaginas;
          }
        }
      } //fim - MontarLinksNavegacao();

      
      //retorno AJAX em formato JSON
      private function RetornarRegistroJSON(){
        $oRegistro = "{'registro':[{";
        $oRegistro .= "'lnkNavega1':'" .$this->sPgLnk1. "'";
        $oRegistro .= ",'lnkNavega2':'" .$this->sPgLnk2. "'";
        $oRegistro .= ",'lnkNavega3':'" .$this->sPgLnk3. "'";
        $oRegistro .= ",'lnkNavega4':'" .$this->sPgLnk4. "'";
        $oRegistro .= ",'lnkNavega5':'" .$this->sPgLnk5. "'";
        $oRegistro .= "}]}";
        echo $oRegistro;
      } //fim - RetornarRegistroJSON()
      
    } //fim - class SelecionarLinksNavegacao()
?>
