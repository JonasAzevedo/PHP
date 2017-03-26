<?php
  /* Conexao com o banco de dados
  Jonas da Silva Azevedo
  Criado: 20/01/2010 - 13:47
*/
  class conexao {
    private $ins;
    private $executou = true;
    private $insercoes;
    public $id;
    
    function conexao($servidor="", $usuario="", $senha="", $nomebd=""){
      $this->id = mysql_connect("$servidor", "$usuario", "$senha")
        or die ("Problemas ao conectar com o banco de dados!");
      mysql_select_db("$nomebd")
        or die ("Problemas ao selecionar o banco de dados!");
      return $this->id;
    }
    
    function getExectou(){
      return $this->executou;
    }
    
    function setInsercoes(){
      $this->insercoes = 0;
    }
    function getInsercoes(){
      return $this->insercoes;
    }
    
    private function formataData($dataFormatar){
      $dataExp = explode("/", $dataFormatar);
      $data = $dataExp[2] . "/" . $dataExp[1] . "/" . $dataExp[0];
      return $data;
    }

    function insereBD($dados){
      $SQLprocuraID = "SELECT * FROM os_encerrada WHERE id_da_ordem='" . $dados[3] . "'";
      if($this->pegaRegistros($SQLprocuraID)==0){
        $data = $this->formataData($dados[65]);
        $SQL = $SQL . "INSERT INTO os_encerrada(nome_do_cliente,nome_do_consultor,numero_da_os_crm,id_da_ordem,numero_do_terminal,";
        $SQL = $SQL . "produto,modalidade,tipo_da_os,tipo,estado,status_do_processo,multifilial,filial_planta_interna_1,";
        $SQL = $SQL . "filial_planta_interna_2,velocidade_do_circuito,nome_do_cliente_na_ponta_a,numero_circuito_ponta_a,";
        $SQL = $SQL . "filial_da_ponta_a,sigla_estacao_a,sigla_localidade_a,uf_ponta_a,endereco_da_ponta_a,tipo_de_acesso_ponta_a,";
        $SQL = $SQL . "velocidade_de_acesso_a,nome_do_cliente_na_ponta_b,numero_circuito_ponta_b,filial_da_ponta_b,sigla_estacao_b,";
        $SQL = $SQL . "sigla_localidade_b,uf_ponta_b,endereco_da_ponta_b,tipo_de_acesso_ponta_b,velocidade_de_acesso_b,";
        $SQL = $SQL . "codigo_da_pendencia,observacao_pendencia,numero_circuito_dialnet,data_da_solicitacao,data_de_criacao_da_ordem,";
        $SQL = $SQL . "data_promessa,data_aprazamento,data_esperada_para_finalizacao_da_ordem,agrupador_da_os,data_de_fechamento_da_os,";
        $SQL = $SQL . "numero_do_circuito_cvp,numero_da_vpn,nome_da_vpn,numero_de_acesso,modalidade_dados_originais,observacao_crm,";
        $SQL = $SQL . "cpf_cgc,data_cadastro,data_atualizacao,tempo_cnbrt,tempo_comercial,tempo_projeto,tempo_ti,tempo_filial,";
        $SQL = $SQL . "tempo_outros,tempo_total,tempo_total2,tempo_pendencia,aprovNoPrazo,segmento,prd,mesAbertura,diaEncerramento,";
        $SQL = $SQL . "computar,mesCompet,tempo_cnbrt_c,velocidade,subgrupo,linha,compTempMedio,metrored,arranjoFilial,passou_por_tx,";
        $SQL = $SQL . "ajusteProduto,gerencia,segNovo,dataImportacaoBD,cod_usuario)";
        $SQL = $SQL . "VALUES(";
        $SQL = $SQL . "'" . $dados[0] . "','" . $dados[1] . "','" . $dados[2] . "','" . $dados[3] . "','" . $dados[4] . "','";
        $SQL = $SQL . $dados[5] . "','" . $dados[6] . "','" . $dados[7] . "','" . $dados[8] . "','" . $dados[9] . "','";
        $SQL = $SQL . $dados[10] . "','" . $dados[11] . "','" . $dados[12] . "','" . $dados[13] . "','" . $dados[14] . "','";
        $SQL = $SQL . $dados[15] . "','" . $dados[16] . "','" . $dados[17] . "','" . $dados[18] . "','" . $dados[19] . "','";
        $SQL = $SQL . $dados[20] . "','" . $dados[21] . "','" . $dados[22] . "','" . $dados[23] . "','" . $dados[24] . "','";
        $SQL = $SQL . $dados[25] . "','" . $dados[26] . "','" . $dados[27] . "','" . $dados[28] . "','" . $dados[29] . "','";
        $SQL = $SQL . $dados[30] . "','" . $dados[31] . "','" . $dados[32] . "','" . $dados[33] . "','" . $dados[34] . "','";
        $SQL = $SQL . $dados[35] . "','" . $dados[36] . "','" . $dados[37] . "','" . $dados[38] . "','" . $dados[39] . "','";
        $SQL = $SQL . $dados[40] . "','" . $dados[41] . "','" . $dados[42] . "','" . $dados[43] . "','" . $dados[44] . "','";
        $SQL = $SQL . $dados[45] . "','" . $dados[46] . "','" . $dados[47] . "','" . $dados[48] . "','" . $dados[49] . "','";
        $SQL = $SQL . $dados[50] . "','" . $dados[51] . "','" . $dados[52] . "','" . $dados[53] . "','" . $dados[54] . "','";
        $SQL = $SQL . $dados[55] . "','" . $dados[56] . "','" . $dados[57] . "','" . $dados[58] . "','" . $dados[59] . "','";
        $SQL = $SQL . $dados[60] . "','" . $dados[61] . "','" . $dados[62] . "','" . $dados[63] . "','" . $dados[64] . "','";
        $SQL = $SQL . $data . "','" . $dados[66] . "','" . $dados[67] . "','" . $dados[68] . "','" . $dados[69] . "','";
        $SQL = $SQL . $dados[70] . "','" . $dados[71] . "','" . $dados[72] . "','" . $dados[73] . "','" . $dados[74] . "','";
        $SQL = $SQL . $dados[75] . "','" . $dados[76] . "','" . $dados[77] . "','" . $dados[78] . "',CURRENT_TIMESTAMP,0)";// . $codUsu . ")";
        $this->ins = mysql_query($SQL,$this->id);
        if(! $this->ins) {
          echo "Problema na inserção do ID: " . $dados[3] . "<br>";
          $this->executou = false;
        }
        else {
          $this->insercoes ++;
        }
      }
    }
    
    function executaSQL($sql){
      $this->executou = true;
      $this->ins = mysql_query($sql,$this->id);
      if(! $this->ins) {
        $this->executou = false;
      }
      return $this->executou;
    }
    
    function selecionaDados($sql){
      $resultado = mysql_query($sql,$this->id);
      while($linha = mysql_fetch_object($resultado)){
        $dados[]=$linha;
      }
      return $dados;
    }
    
    function pegaRegistros($sql){
      $resultado = mysql_query($sql,$this->id);
      while($linha = mysql_fetch_object($resultado)){
        $dados=$linha;
      }
      $total = count($dados);
      return $total;
    }
  }
?>
