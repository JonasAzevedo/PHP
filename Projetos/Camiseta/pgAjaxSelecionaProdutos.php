<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxSelecionaProdutos.php
  Função: página que retorna seleção de produtos - usa Ajax
  Data de Criação: 09/02/2011 - 11:42
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: http://localhost/VENDA_CAMISETA/pgAjaxSelecionaProdutos.php?chamou=inicio&tipo_prod=camiseta&sub_grupo=0
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  InicializarVariaveis()
  MontarSQLPesquisarProdutos() //monta o SQL de pesquisa
  PesquisarProdutos() //pesquisa por produtos, e monta retorno AJAX em formato JSON
  OrganizarDados() //organiza os dados do retorno do sql em um array
  RetornarIndice($nMax) //função para retornar o índice do array $this->oDadosOrganizados[], para povoar o retorno
  RetornarRegistroJSON() //retorno AJAX em formato JSON
*/

    $selecionarProdutos = new SelecionarProdutos();

    class SelecionarProdutos{
      //bd
      private $oBd;
      private $sSql;
      
      //parâmetros recebidos
      private $sChamou;
      private $sTipoProduto;
      private $nSubGrupo;
      private $sFiltroPesquisa;
      private $nPgSelecionada;
      
      private $nIniLimit;
      
      private $oDadosPesquisa; //dados retorno do sql
      private $nTotal; //total de registros que o sql retornou
      private $oDadosOrganizados; //igual a $oDadosPesquisa, mas com os dados organizados. Com as 3 figuras no mesmo 'registro'.
      private $aryRetornou; //array para controlar quais registros já foram inseridos no retorno
      

      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();
        if(($this->sChamou == "inicio")or($this->sChamou == "pesquisando")or($this->sChamou == "navegando")
        or($this->sChamou == "link")){
          if($this->sTipoProduto == "camiseta"){
            $this->MontarSQLPesquisarProdutos();
            $this->PesquisarProdutos();
            if($this->nTotal > 0){
              $this->OrganizarDados();
              $this->RetornarRegistroJSON();
            }
            else{
              echo "";
            }
          }
          else{
            echo "";
          }
        }
        else{
          echo "";
        }
      }

      
      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }
      
      
      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
	  }


      //inicia a sessão que armazenará os dados do $sql
      private function IniciarSession(){
        session_start("dados_sql");
      }


      //grava variáveis da session
      private function GravarSession(){
        $_SESSION["sTipoProduto"] = $this->sTipoProduto;
        $_SESSION["nSubGrupo"] = $this->nSubGrupo;
        $_SESSION["sFiltroPesquisa"] = $this->sFiltroPesquisa;
        $_SESSION["nPgSelecionada"] = $this->nPgSelecionada;
      }
      

      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";

        //armazena parâmetros recebidos via GET
        if(isset($_GET['chamou'])){
          $this->sChamou = $_GET['chamou'];
        }
        else{
          $this->sChamou = "";
        }
        
        if($this->sChamou == "inicio"){
          if(isset($_GET['tipo_prod'])){
            $this->sTipoProduto = $_GET['tipo_prod'];
          }
          else{
            $this->sTipoProduto = "";
          }

          if(isset($_GET['sub_grupo'])){
            $this->nSubGrupo = $_GET['sub_grupo'];
          }
          else{
            $this->nSubGrupo = "";
          }
          
          $this->sFiltroPesquisa = "";
          $this->nPgSelecionada = 0;

          $this->nIniLimit = 0;
        } //fim - sChamou == "inicio"

        else if($this->sChamou == "pesquisando"){
          if(isset($_GET['tipo_prod'])){
            $this->sTipoProduto = $_GET['tipo_prod'];
          }
          else{
            $this->sTipoProduto = "";
          }

          if(isset($_GET['filtroPesquisa'])){
            $this->sFiltroPesquisa = $_GET['filtroPesquisa'];
          }
          else{
            $this->sFiltroPesquisa = "";
          }
          
          $this->nSubGrupo = 0;
          $this->nPgSelecionada = 0;

          $this->nIniLimit = 0;
        } //fim - sChamou == "pesquisando"

        if($this->sChamou == "navegando"){
          if(isset($_GET['tipo_prod'])){
            $this->sTipoProduto = $_GET['tipo_prod'];
          }
          else{
            $this->sTipoProduto = "";
          }

          if(isset($_GET['sub_grupo'])){
            $this->nSubGrupo = $_GET['sub_grupo'];
          }
          else{
            $this->nSubGrupo = "";
          }

          $this->sFiltroPesquisa = "";
          $this->nPgSelecionada = 0;

          $this->nIniLimit = 0;
        } //fim - sChamou == "navegando"

        if($this->sChamou == "link"){
          $this->sTipoProduto = $_SESSION["sTipoProduto"];
          $this->nSubGrupo = $_SESSION["nSubGrupo"];
          $this->sFiltroPesquisa = $_SESSION["sFiltroPesquisa"];
          
          if(isset($_GET['pagina'])){
            $this->nPgSelecionada = $_GET['pagina'];
          }
          else{
            $this->nPgSelecionada = 0;
          }
          
          if($this->nPgSelecionada > 0){
            $this->nIniLimit = ($this->nPgSelecionada-1) * 27; ////diminui 1 pois o iniLimit inicia em zero, multiplica por 27. Exemplo: (1-1) * 27 = 0 - 1ª página foi a selecionada
          }
          else{
            $this->nIniLimit = 0;
          }
        } //fim - sChamou == "link"
        
        $this->oDadosPesquisa = null;
        $this->nTotal = 0;
        $this->oDadosOrganizados = null;
        $this->aryRetornou = null;
      } //fim - InicializarVariaveis()


      //monta o SQL de pesquisa
      private function MontarSQLPesquisarProdutos(){
        $this->sSql = "";
        $this->sSql = "SELECT cam.cdCamiseta,cam.nome,cam.valor,cam.desconto,cam.flAtivo,cam.descricao,";
        $this->sSql .= " img_cam.cdImagemCamiseta, img_cam.is_principal,"; //////
        $this->sSql .= " CASE WHEN img_cam.imagem IS NOT NULL THEN img_cam.imagem ELSE 'default' END AS figura";
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
        
        $this->sSql .= " ORDER BY cam.cdCamiseta, is_principal DESC "; /////Q
        $this->sSql .= " LIMIT " .$this->nIniLimit. ",27"; //máximo que os 9 produtos irão retornar. (9 produtos * 3 imagens por produto)
        
        $this->GravarSession(); //grava dados da pesquisa
      } //fim -  MontarSQLPesquisarProdutos()


      //pesquisa por produtos, e monta retorno AJAX em formato JSON
      private function PesquisarProdutos(){
        $oRegistro = "";
        $this->oDadosPesquisa = $this->oBd->PesquisarSQL($this->sSql);
        
        if($this->oDadosPesquisa){
          $this->nTotal = count($this->oDadosPesquisa);
        }
      } //fim -  PesquisarProdutos()
      
      
      //organiza os dados do retorno do sql em um array
      private function OrganizarDados(){
        $this->oDadosOrganizados = array();
        $i = 0;
        $x = 0;
        $nCdCamiseta = 0;

        //SELECT traz 3 figuras por produto, mesmo este não tendo 3 figuras
        //imagem_camiseta.imagem = 'complemento'
        while($i < $this->nTotal){
          $nCdCamiseta = $this->oDadosPesquisa[$i]->cdCamiseta;
          $this->oDadosOrganizados[$x]->cdCamiseta = $this->oDadosPesquisa[$i]->cdCamiseta;
          $this->oDadosOrganizados[$x]->nome = $this->oDadosPesquisa[$i]->nome;
          $this->oDadosOrganizados[$x]->valor = $this->oDadosPesquisa[$i]->valor;
          $this->oDadosOrganizados[$x]->desconto = $this->oDadosPesquisa[$i]->desconto;
          $this->oDadosOrganizados[$x]->flAtivo = $this->oDadosPesquisa[$i]->flAtivo;
          $this->oDadosOrganizados[$x]->descricao = $this->oDadosPesquisa[$i]->descricao;
          
          $this->oDadosOrganizados[$x]->cdImagemCamiseta1 = $this->oDadosPesquisa[$i]->cdImagemCamiseta;
          $this->oDadosOrganizados[$x]->figura1 = $this->oDadosPesquisa[$i]->figura;
          $i++;
          if($nCdCamiseta == $this->oDadosPesquisa[$i]->cdCamiseta){
            $this->oDadosOrganizados[$x]->cdImagemCamiseta2 = $this->oDadosPesquisa[$i]->cdImagemCamiseta;
            $this->oDadosOrganizados[$x]->figura2 = $this->oDadosPesquisa[$i]->figura;
            $i++;
            if($nCdCamiseta == $this->oDadosPesquisa[$i]->cdCamiseta){
              $this->oDadosOrganizados[$x]->cdImagemCamiseta3 = $this->oDadosPesquisa[$i]->cdImagemCamiseta;
              $this->oDadosOrganizados[$x]->figura3 = $this->oDadosPesquisa[$i]->figura;
              $i++;
            }
            else{
              $this->oDadosOrganizados[$x]->cdImagemCamiseta3 = 0;
              $this->oDadosOrganizados[$x]->figura3 = "";
            }
          }
          else{
            $this->oDadosOrganizados[$x]->cdImagemCamiseta2 = 0;
            $this->oDadosOrganizados[$x]->figura2 = "";
            $this->oDadosOrganizados[$x]->cdImagemCamiseta3 = 0;
            $this->oDadosOrganizados[$x]->figura3 = "";
          }
          $x++;
        } //fim - while
      } //fim - OrganizarDados()
      
      
      //função para retornar o índice do array $this->oDadosOrganizados[], para povoar o retorno
      function RetornarIndice($nMax){
        $bAchou = False;
        $n = -1;
        while($bAchou == False){
          $n = rand(0,$nMax);
          if($this->aryRetornou[$n] == 0){
            $bAchou = True;
            $this->aryRetornou[$n] = 1; //achou
          }
        }
        return $n;
      } //fim - RetornarIndice($nMax)
      
        
      //retorno AJAX em formato JSON
      private function RetornarRegistroJSON(){
        $nTotRegistros = count($this->oDadosOrganizados);
        //array para controlar quais registros já foram inseridos no retorno
        $this->aryRetornou = array();
        for($i = 0; $i < $nTotRegistros; $i++){
          $this->aryRetornou[$i] = 0; //0 = não retornou
        }


        $x = 0; //controla laço
        $oRegistro = "{'registro':[";
        while($x < $nTotRegistros){
          $i = $this->RetornarIndice($nTotRegistros-1);

          if($x>0){
            $oRegistro .= ",";
          }
          $oRegistro .= "{'cdCamiseta':'" .$this->oDadosOrganizados[$i]->cdCamiseta. "'";
          $oRegistro .= ",'nome':'" .$this->oDadosOrganizados[$i]->nome. "'";
          $oRegistro .= ",'valor':'" .$this->oDadosOrganizados[$i]->valor. "'";
          $oRegistro .= ",'desconto':'" .$this->oDadosOrganizados[$i]->desconto. "'";
          $oRegistro .= ",'flAtivo':'" .$this->oDadosOrganizados[$i]->flAtivo. "'";
          $oRegistro .= ",'descricao':'" .$this->oDadosOrganizados[$i]->descricao. "'";
          $oRegistro .= ",'cdImagemCamiseta1':'" .$this->oDadosOrganizados[$i]->cdImagemCamiseta1. "'";
          $oRegistro .= ",'figura1':'" .$this->oDadosOrganizados[$i]->figura1. "'";
          $oRegistro .= ",'cdImagemCamiseta2':'" .$this->oDadosOrganizados[$i]->cdImagemCamiseta2. "'";
          $oRegistro .= ",'figura2':'" .$this->oDadosOrganizados[$i]->figura2. "'";
          $oRegistro .= ",'cdImagemCamiseta3':'" .$this->oDadosOrganizados[$i]->cdImagemCamiseta3. "'";
          $oRegistro .= ",'figura3':'" .$this->oDadosOrganizados[$i]->figura3. "'";
          $oRegistro .= "}";
          $x++;
        } //fim - while
        
        $oRegistro .= "]}";
        
        echo $oRegistro;
      } //fim - RetornarRegistroJSON()

    } //fim - class SelecionarProdutos()
?>
