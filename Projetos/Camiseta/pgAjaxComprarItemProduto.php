<?php
/*******************************************************************
********************************************************************
  Nome: pgAjaxComprarItemProduto.php
  Função: página que realiza a compra do item do produto
  Data de Criação: 25/03/2011 - 16:14
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  IncluirCabecalho() //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
  SolicitarArquivos()
  IniciarSession()
  InicializarVariaveis()
  CriarPedidoCompra() //cria um pedido de compra
  PegarValoresItemPedidoCompra() //pega os valores do item pedido de compra, para realizar o seu cadastro
  CadastrarItemPedidoCompra() //realiza o cadastro do item do pedido da compra
  RetornoProcessamentoAJAX() //retorna o processamento da página AJAX
*/

    $comprarItemProduto = new ComprarItemProduto();

    class ComprarItemProduto{
      //bd
      private $oBd;
      private $sSql;
      
      //métodos gerais
      private $FMetGer;

      //parâmetros recebidos
      private $sTipoProduto;
      private $nCdProduto;
      private $nQtde;
      private $sTamanhoCamiseta;

      private $nCdPedidoCompra; //código do pedido da compra
      private $nCdUsuario; //código do usuário

      private $dProdutoValorUnitario; //valor unitário do produto que está comprando
      private $dProdutoValorTotal; //valor total = quantidade de produtos * valor unitário do produto

      private $sRetorno; //retorno AJAX


      function __construct(){
        $this->IncluirCabecalho();
        $this->SolicitarArquivos();
        $this->IniciarSession();
        $this->InicializarVariaveis();

        //pode fazer compras sem usuário logado
        //if($this->nCdUsuario == 0){
        //}

        if(($this->nCdPedidoCompra == null)or($this->nCdPedidoCompra == 0)){
          $this->CriarPedidoCompra();
        }
        $this->PegarValoresItemPedidoCompra();
        $this->CadastrarItemPedidoCompra();
        $this->RetornoProcessamentoAJAX();
      }
      

      //inclui o cabeçalho da página para definir o formato do retorno dos caracteres
      private function IncluirCabecalho(){
        header("Content-Type: text/html; charset=iso-8859-1");
      }


      //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        require_once("./classes/conexaoBD.php");
        require_once("./classes/metodosGerais.php");
	  }


      //inicia a sessão que armazenará os dados do usuário logado
      private function IniciarSession(){
        session_start("dados_usuario_logado");
      } //fim -  IniciarSession()


      private function InicializarVariaveis(){
        //bd
        $this->oBd = Conexao::GetInstanciaConexao();
        $this->sSql = "";
        //métodos gerais
        $this->FMetGer = MetodosGerais::GetInstanciaMetodosGerais();

        if($_SERVER['REQUEST_METHOD']=='POST'){
          $this->sTipoProduto = trim($this->FMetGer->GetPost('edTipoProduto'));
          $this->nCdProduto = trim($this->FMetGer->GetPost('edCdProduto'));
          $this->nQtde = trim($this->FMetGer->GetPost('txtCompProdQtde'));
          $this->sTamanhoCamiseta = trim($this->FMetGer->GetPost('sctTamanho'));
        }

        $this->nCdPedidoCompra = trim($this->FMetGer->GetSession('nIdCompra')); //pedido_compra
        $this->nCdUsuario = trim($this->FMetGer->GetSession('nCodigo')); //código do usuário
        
        $this->dProdutoValorUnitario = 0;
        $this->dProdutoValorTotal = 0;

        $this->sRetorno = "produto não pode ser comprado.";
      } //fim - InicializarVariaveis()


      //cria um pedido de compra
      private function CriarPedidoCompra(){
        $this->sSql = "INSERT INTO pedido_compra(cdFkUsuario,data_hora_inicio,status)";
        $this->sSql .= " VALUES ('" .$this->nCdUsuario. "',CURRENT_TIMESTAMP,'aberto')";
        $bInseriuPedidoCompra = mysql_query($this->sSql, $this->oBd->oCon);
        if($bInseriuPedidoCompra){
          $this->sSql = "SELECT last_insert_id() AS id";
          $oDadosId = $this->oBd->PesquisarSQL($this->sSql);
          if($oDadosId){
            $this->nCdPedidoCompra = $oDadosId[0]->id;
            $_SESSION["nIdCompra"] = $this->nCdPedidoCompra;
          }
          else{
            $this->nCdPedidoCompra = 0;
          }
        }
      } //fim - CriarPedidoCompra()


      //pega os valores do item pedido de compra, para realizar o seu cadastro
      private function PegarValoresItemPedidoCompra(){
        if($this->sTipoProduto == "camiseta"){
          $this->sSql = "SELECT * FROM camiseta WHERE cdCamiseta = '".$this->nCdProduto."'";
          $oDadosCamiseta = $this->oBd->PesquisarSQL($this->sSql);
          if($oDadosCamiseta){
            $this->dProdutoValorUnitario = $oDadosCamiseta[0]->valor - $oDadosCamiseta[0]->desconto;
          }
        } //fim - ($this->sTipoProduto == "camiseta")
        $this->dProdutoValorTotal = $this->dProdutoValorUnitario * $this->nQtde;
      } //fim - PegarValoresItemPedidoCompra()


      //realiza o cadastro do item do pedido da compra
      private function CadastrarItemPedidoCompra(){
        $this->sSql = "INSERT INTO item_pedido_compra ";
        $this->sSql .= " (cdFkPedidoCompra,tipo_produto,cdFkProduto,quantidade,valor_unitario,valor_total,status,tamanho_camiseta)";
        $this->sSql .= " VALUES('".$this->nCdPedidoCompra."','".$this->sTipoProduto."','".$this->nCdProduto."','";
        $this->sSql .= $this->nQtde."','".$this->dProdutoValorUnitario."','".$this->dProdutoValorTotal."','aberto','".$this->sTamanhoCamiseta."')";

        $bInseriuItemPedidoCompra = mysql_query($this->sSql, $this->oBd->oCon);
        if($bInseriuItemPedidoCompra){
          $this->sRetorno = "produto inserido no carrinho de compras.";
        }
        else{
          $this->sRetorno = "produto não pode ser inserido no carrinho de compras.";
        }
      } //fim - CadastrarItemPedidoCompra()


      //retorna o processamento da página AJAX
      private function RetornoProcessamentoAJAX(){
        echo $this->sRetorno;
      } //fim - RetornoProcessamentoAJAX()

    } //fim - class ComprarItemProduto();
?>
