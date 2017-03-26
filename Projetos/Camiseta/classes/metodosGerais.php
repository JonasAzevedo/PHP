<?php
/*******************************************************************
********************************************************************
  Nome: metodosGerais.php
  Função: página com métodos gerais para dar suporte a outras páginas
  Data de Criação: 02/03/2011 - 16:38
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  SolicitarArquivos()
  GetInstanciaMetodosGerais() //recuperar instância
  FormatarValorMonetario($pdValor) //formata parâmetro '$pdValor' para valor monetário
  GetPost($psKey) //verifica se possui um parâmetro _POST com o nome '$psKey'
  GetSession($psKey) //verifica se possui um parâmetro _SESSION com o nome '$psKey'
  ExibirTamanhos($psClasse) //imprime no select com a classe='$psClasse' os tamanhos das camisetas
  GetCEP_Origem() //retorna o CEP de origem - (de onde será enviado os produtos)
  DiferencaEntreDatas()
*/

  class MetodosGerais{
    //propriedade estática referenciando um tipo da mesma classe
    private static $oMetGer = false;
    
    private $Fbd;


	//solicita arquivos necessários desta página
	private function SolicitarArquivos(){
      require_once("ConexaoBD.php");
	}
	

    private function __construct() {
      $this->SolicitarArquivos();
      $this->Fbd = Conexao::GetInstanciaConexao();
    } //fim - __construct();


    //método para recuperar instância
    public static function GetInstanciaMetodosGerais(){
      if (MetodosGerais::$oMetGer === false){
        MetodosGerais::$oMetGer = new MetodosGerais();//chamando construtor
      }
      return MetodosGerais::$oMetGer;
    }
    
    
    //formata parâmetro '$pdValor' para valor monetário
    function FormatarValorMonetario($pdValor){
      //$sValor = str_replace(array(".", ","), "", $pdValor);
      $sValor = str_replace(array(","), "", $pdValor);
      $dNumFormatado = number_format($sValor,2,',','.');
      return $dNumFormatado;
    } //fim - FormatarValorMonetario()
    

    //verifica se possui um parâmetro _POST com o nome '$psKey'
    function GetPost($psKey){
      return isset($_POST[$psKey]) ? $_POST[$psKey] : null;
    } //fim - GetPost($psKey)
    
    
    //verifica se possui um parâmetro _SESSION com o nome '$psKey'
    function GetSession($psKey){
      return isset($_SESSION[$psKey]) ? $_SESSION[$psKey] : null;
    } //fim - GetSession($psKey)

    
    //imprime no select com a classe='$psClasse' os tamanhos das camisetas
    function ExibirTamanhos($psClasse){
      $oDadosCamiseta;
      $sSql = "SELECT * FROM tamanho_camiseta";
      $oDadosCamiseta = $this->Fbd->PesquisarSQL($sSql);
      
      foreach($oDadosCamiseta as $oRegistro){
        echo "<option value='".$oRegistro->sigla."' class='".$psClasse."'>".$oRegistro->nome."</option>";
      }
    } //fim - ExibirTamanhos($psClasse)
    

    //retorna o CEP de origem - (de onde será enviado os produtos)
    function GetCEP_Origem(){
      $sCEP = "";
      $sSql = "SELECT cep_origem FROM configuracoes_sistema";
      $oDados = $this->Fbd->PesquisarSQL($sSql);
      if($oDados){
        $sCEP = $oDados[0]->cep_origem;
        $sCEP = str_replace("-","",$sCEP);
      }
      return $sCEP;
    } //fim - GetCEP_Origem()
    
    
    //formato das datas = "08/11/2011 22:00:44";
    //psTipo:
    // -> D = dias exatos
    // -> d = dias arredondados
    // -> H = horas exatas
    // -> h = horas arredondadas
    // -> m = minutos
    function DiferencaEntreDatas($pdData1,$pdData2="",$psTipo=""){
      if($pdData2 == ""){
        $pdData2 = date('d/m/Y H:i:s');
      }
      if($psTipo == ""){
        $psTipo = "h";
      }

      for($i=1;$i<=2;$i++){
        ${"dia".$i} = substr(${"pdData".$i},0,2);
        ${"mes".$i} = substr(${"pdData".$i},3,2);
        ${"ano".$i} = substr(${"pdData".$i},6,4);
        ${"horas".$i} = substr(${"pdData".$i},11,2);
        ${"minutos".$i} = substr(${"pdData".$i},14,2);
      }

      $segundos = mktime($horas2,$minutos2,0,$mes2,$dia2,$ano2)-mktime($horas1,$minutos1,0,$mes1,$dia1,$ano1);
      switch($psTipo){
        case "m":
          $dif = $segundos/60;
          break;
        case "H":
          $dif = $segundos/3600;
          break;
        case "h":
          $dif = round($segundos/3600);
          break;
        case "D":
          $dif = $segundos/86400;
          break;
        case "d":
          $dif = round($segundos/86400);
          break;
        }
        return $dif;
    } //fim - DiferencaEntreDatas()
    
  } //fim - class MetodosGerais
  ?>
