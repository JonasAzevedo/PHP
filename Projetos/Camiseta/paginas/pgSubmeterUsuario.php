<!------------------------------------------------------------------
--------------------------------------------------------------------
  Nome: pgSubmeterUsuario.php
  Função: página chamado ao ser submitido um formulário de cadastro de usuário
  Data de Criação: 12/02/2011 - 19:44
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
--------------------------------------------------------------------
------------------------------------------------------------------->

<!--
//function's:
  FormatarData($psData)  //retorna a data formatada no formato ano/mês/dia
  SolicitarArquivos()
  IniciarHTML()
  IniciarBody()
  CriarMascaraPagina() //cria a máscara para cobrir a página
  InicializarVariaveis()
  PegarVariaveisGET()  //pega as variáveis recebidas via GET
  PegarVariaveisPOST()  //pega as variáveis recebidas via POST
  FormatarValoresVariaveis()  //formata os valores das variáveis
  ExecutarAcao()  //executa a ação desejada
  FecharBody()
  FecharHTML()
  PegarCdUsuarioInserido() //pega o cdUsuario do último INSERT realizado
  EnviarEmailUsuarioCadastrado() //envia email que o usuário foi cadastrado com sucesso
  RedirecionarPagina()  //redireciona a página após executar os procedimentos nesta página
-->

<?php
    $pgSubmeterUsuarios = new PgSubmeterUsuarios();

    class PgSubmeterUsuarios{
      private $bd;
      private $sSql;
      //ação a ser executada
      private $sAcao;
      private $bExecutou;
      
      //campos da tabela usuario. Recebidos via $_POST
      private $nCodigo;
      private $sNome;
      private $sNomeChamado; //apelido
      private $sEmail;
      private $sTelefone;
      private $sDataNascimento;
      private $sSexo;
      private $sEnderecoUF;
      private $sEnderecoCidade;
      private $sEnderecoCEP;
      private $sEnderecoBairro;
      private $sEnderecoRua;
      private $sEnderecoNumero;
      private $sEnderecoComplemento;
      private $sLogin;
      private $sSenha;
      
      private $oEnvioEmail;
      
    
      function __construct(){
        $this->SolicitarArquivos();
        $this->IniciarHTML();
        $this->IniciarBody();
        $this->CriarMascaraPagina();
        $this->InicializarVariaveis();
        $this->PegarVariaveisGET();
        $this->PegarVariaveisPOST();
        $this->FormatarValoresVariaveis();
        $this->ExecutarAcao();
        $this->FecharBody();
        $this->FecharHTML();
        $this->RedirecionarPagina();
      }
      
      
      //retorna a data formatada no formato ano/mês/dia
      private function FormatarData($psData){
        $sDataExp = explode("/", $psData);
        $sData = $sDataExp[2] . "/" . $sDataExp[1] . "/" . $sDataExp[0];
        return $sData;
      }

      
      //solicita arquivos necessários desta página
	  function SolicitarArquivos(){
        require_once("../classes/conexaoBD.php");
        require_once("../classes/enviarEmail.php");
	  }
	  

      //inicia HTML
      function IniciarHTML(){
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	    echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
	    echo "<head>";
	      echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />";
          echo "<link rel='stylesheet' href='../css/cPgSubmeterUsuario.css' type='text/css' />";
          echo "<script type='text/javascript' src='../js/jPgSubmeterUsuario.js'></script>";
          echo "<script type='text/javascript' src='../jQuery/js/jquery-1.4.4.min.js'></script>";
          echo "<script type='text/javascript' src='../js/jQryPgSubmeterUsuario.js'></script>";
        echo "</head>";
      }
      
      //iniciar a tag body
      function IniciarBody(){
        echo "<body>";
      }
      
      
      //cria a máscara para cobrir a página
      private function CriarMascaraPagina(){
        echo "<div id='divMaskSubmeterUsuario'>";
          echo "<img class='imgProcessando' name='imgProcessando' id='imgProcessando' src='../figuras/processando/loader1.gif' />";
          echo "<span class='spnProcessando' name='spnProcessando' id='spnProcessando'>" ."Aguarde. Realizando cadastro do usuário...". "</span>";
          echo "<span class='spnMsgSucesso' name='spnMsgSucesso' id='spnMsgSucesso'>" ."Usuário cadastrado com sucesso. Você será redirecionado em ". "</span>";
          echo "<span class='spnMsgSucessoCont' name='spnMsgSucessoCont' id='spnMsgSucessoCont'>" ."". "</span>";
        echo "</div>";
      }
      
      
      function InicializarVariaveis(){
        $this->bd = conexao::getInstanciaConexao();
        $this->sSql = "";
        $this->bExecutou = False;
      
        $this->nCodigo = 0;
        $this->sNome = "";
        $this->sNomeChamado = "";
        $this->sEmail = "";
        $this->sTelefone = "";
        $this->sDataNascimento = "";
        $this->sSexo = "";
        $this->sEnderecoUF = "";
        $this->sEnderecoCidade = "";
        $this->sEnderecoCEP = "";
        $this->sEnderecoBairro = "";
        $this->sEnderecoRua = "";
        $this->sEnderecoNumero = "";
        $this->sEnderecoComplemento = "";
        $this->sLogin = "";
        $this->sSenha = "";
        
        $this->oEnvioEmail = null;
      }
      

      //pega as variáveis recebidas via GET
      function PegarVariaveisGET(){
        $this->sAcao = $_GET['acao'];
      }
      
      
      //pega as variáveis recebidas via POST
      function PegarVariaveisPOST(){
        $this->sNome = trim($_POST['txtValorCadUsuarioNome']);
        $this->sNomeChamado = trim($_POST['txtValorCadUsuarioApelido']);
        $this->sEmail = trim($_POST['txtValorCadUsuarioEmail']);
        $this->sTelefone = trim($_POST['txtValorCadUsuarioTelefone']);
        $this->sDataNascimento = trim($_POST['txtValorCadUsuarioDataNascimento']);
        $this->sSexo = trim($_POST['rdGrupoSexo']);
        $this->sEnderecoUF = trim($_POST['txtValorCadUsuarioEnderecoUF']);
        $this->sEnderecoCidade = trim($_POST['txtValorCadUsuarioEnderecoCidade']);
        $this->sEnderecoCEP = trim($_POST['txtValorCadUsuarioEnderecoCEP']);
        $this->sEnderecoBairro = trim($_POST['txtValorCadUsuarioEnderecoBairro']);
        $this->sEnderecoRua = trim($_POST['txtValorCadUsuarioEnderecoRua']);
        $this->sEnderecoNumero = trim($_POST['txtValorCadUsuarioEnderecoNumero']);
        $this->sEnderecoComplemento = trim($_POST['txtAreaValorCadUsuarioEnderecoComplemento']);
        $this->sLogin = trim($_POST['txtValorCadUsuarioLogin']);
        $this->sSenha = trim($_POST['txtValorCadUsuarioSenha1']);
      }
      
      
      //formata os valores das variáveis
      function FormatarValoresVariaveis(){
        //possui a quantidade de caracteres de uma data válida. dd/mm/yyyy
        if(strlen($this->sDataNascimento) == 10){
          $this->sDataNascimento = $this->FormatarData($this->sDataNascimento);
        }
        else{
          $this->sDataNascimento = 0;
        }
      }
      
      
      //executa a ação desejada
      function ExecutarAcao(){
        $bPodeContinuar = true;
        if($this->sAcao == "novo"){
          $this->sSql = "INSERT INTO usuario(nome,data_nascimento,sexo,email,telefone,";
          $this->sSql .= "endereco_uf,endereco_cidade,endereco_cep,endereco_bairro,";
          $this->sSql .= "endereco_rua,endereco_numero,endereco_complemento,login,senha,";
          $this->sSql .= "nome_chamado,data_cadastro) VALUES (";
          $this->sSql .= "'".$this->sNome."','".$this->sDataNascimento."','".$this->sSexo;
          $this->sSql .= "','".$this->sEmail."','".$this->sTelefone."','".$this->sEnderecoUF;
          $this->sSql .= "','".$this->sEnderecoCidade."','".$this->sEnderecoCEP;
          $this->sSql .= "','".$this->sEnderecoBairro."','".$this->sEnderecoRua;
          $this->sSql .= "','".$this->sEnderecoNumero."','".$this->sEnderecoComplemento;
          $this->sSql .= "','".$this->sLogin."','".$this->sSenha;
          $this->sSql .= "','".$this->sNomeChamado."', CURRENT_TIMESTAMP)";
          
          $this->bExecutou = mysql_query($this->sSql, $this->bd->oCon);
          if($this->bExecutou){
            $this->EnviarEmailUsuarioCadastrado();
          }
        }
      }

      
      //pega o cdUsuario do último INSERT realizado
      private function PegarCdUsuarioInserido(){
        $sSql = "SELECT last_insert_id() AS id";
		$oDadosId = mysql_query($sSql, $this->bd->oCon);
        if($oDadosId){
		  while($oLinha = mysql_fetch_object($oDadosId)){
		    $oDadosRegistro[]=$oLinha;
		  }
		  return $oDadosRegistro[0]->id;
        }
        else{
          return 0;
        }
      } //fim - PegarCdUsuarioInserido()
      

      //envia email que o usuário foi cadastrado com sucesso
      private function EnviarEmailUsuarioCadastrado(){
        $nCdUsuario = $this->PegarCdUsuarioInserido();
        $this->oEnvioEmail = new EnviarEmail("cadastro_usuario");
        //$oAnexos = array(); //$oAnexos[0] = "C:\wamp\www\arq.txt"; //$oAnexos[1] = "C:\wamp\www\senha wordpress.txt";
        //$this->oEnvioEmail->DefinirDadosEnvioEmail($this->sEmail,$this->sNome,"assunto para usuario cadastrado","true","usuario cadastrado <B> com sucesso",$oAnexos);
        $this->oEnvioEmail->DefinirDadosEnvioEmail($nCdUsuario,$this->sEmail,$this->sNome);
        $this->oEnvioEmail->ChamarFuncoesEnviarEmail();
      } //fim - EnviarEmailUsuarioCadastrado()
      

      //redireciona a página após executar os procedimentos nesta página
      function RedirecionarPagina(){
        if($this->bExecutou){
          ?>
            <script language='JavaScript'>
              MostrarMensagemUsuarioCadastrado();
            </script>
          <?php
          //echo "<meta http-equiv='refresh' content='1;url=../index.php'>";
        }
      }
      
      
      //finaliza a tag body
      function FecharBody(){
        echo "</body>";
      }

      //finaliza HTML
      function FecharHTML(){
        echo "</html>";
      }
  
    } //fim - class PgSubmeterUsuarios
?>
