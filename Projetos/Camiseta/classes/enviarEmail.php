<?php
/*******************************************************************
********************************************************************
  Nome: enviarEmail.php
  Função: classe para envio de email's
  Data de Criação: 24/02/2011 - 10:52
  Data de Atualização: -
  Desenvolvido por: Jonas
  Acessando página: -
********************************************************************
*******************************************************************/

/*
//function's:
  DefinirDadosEnvioEmail($pnCdUsuario,$psEmailDestinatario,$psNomeDestinatario) //define os dados para o envio do email
  ChamarFuncoesEnviarEmail() //chama as funções para envio de email
  EnviouEmail() //retorna se o email foi enviado
  SolicitarArquivos()
  InicializarVariaveis()
  SetProduto($psTipoProduto,$pnCdProduto) //seta o produto a ser usado no envio de email
  DefinirDadosAssuntoMensagemAnexo() //define os dados do assunto, mensagem e anexo do email, com base na variável '$this->sTipoEnvio'
  IniciarConfiguracoesEnvioEmail() //inicia as configurações para envio de email
  IniciarConfiguracoesServidorTipoConexao() //define os dados do servidor e tipo de conexão
  IniciarConfiguracoesRemetente() //define os dados do remetente
  InciarConfiguracoesDestinatario() //define os dados do(s) destinatário(s)
  IniciarConfiguracoesMensagem() //define os dados da mensagem
  AcrescentarAnexos() //acrescenta no email os anexos - (opcional)
  EnviarEmail() //envia email
  GravarRegistroEnvioEmail() //grava registro do envio do email
  Retornar() //retorno se conseguiu enviar email
*/

    class EnviarEmail{
      private $bd;
      //tipo do envio do email
      private $sTipoEnvio; //valores possíveis: cadastro_usuario, recuperar_senha, indicar_produto
      //servidor de conexão, para envio do email
      private $sHost;
      private $nPort;
      private $sUsername;
      private $sPassword;
      //dados do remetente
      private $sFrom;
      private $sFromName;
      //dados do(s) destinatário(s)
      private $nCdUsuario; //caso for enviado um email para um cadastrado na tabela 'usuario'
      private $sEmailDestinatario;
      private $sNomeDestinatario;
      private $sEmailDestinatarioCC;
      private $sNomeDestinatarioCC;
      private $sEmailDestinatarioCCO;
      private $sNomeDestinatarioCCO;
      //dados da mensagem
      private $sAssunto;
      private $bHTML;
      private $sBody;
      //dados de anexo
      private $sAnexo;
      //instância do PHPMailer()
      private $oEmail;
      //enviou email?
      private $bEnviado;
      
      //produto a ser usado no envio de email
      private $sTipoProduto;
      private $nCdProduto;
    
      function __construct($psTipoEnvio){
        $this->sTipoEnvio = $psTipoEnvio;
        if(($this->sTipoEnvio == "cadastro_usuario")or($this->sTipoEnvio == "recuperar_senha")
          or($this->sTipoEnvio == "indicar_produto")){
          $this->SolicitarArquivos();
          $this->InicializarVariaveis();
          $this->DefinirDadosAssuntoMensagemAnexo();
        }
      }
      

      //define os dados para o envio do email
      //parâmetros:
      //$pnCdUsuario = cdUsuario para o qual o email será enviado
      //$psEmailDestinatario = email de destino
      //$psNomeDestinatario = nome do destinatário
      public function DefinirDadosEnvioEmail($pnCdUsuario,$psEmailDestinatario,$psNomeDestinatario){
        $this->nCdUsuario = $pnCdUsuario;
        $this->sEmailDestinatario = $psEmailDestinatario;
        $this->sNomeDestinatario = $psNomeDestinatario;
        $this->DefinirDadosAssuntoMensagemAnexo();
      } //fim - DefinirDadosEnvioEmail()


      //chama as funções para envio de email
      public function ChamarFuncoesEnviarEmail(){
        $this->IniciarConfiguracoesEnvioEmail();
        $this->IniciarConfiguracoesServidorTipoConexao();
        $this->IniciarConfiguracoesRemetente();
        $this->InciarConfiguracoesDestinatario();
        $this->IniciarConfiguracoesMensagem();
        $this->AcrescentarAnexos();
        $this->EnviarEmail();
        $this->GravarRegistroEnvioEmail();
        $this->Retornar();
      } //fim - ChamarFuncoesEnviarEmail()
      
      
      //retorna se o email foi enviado
      public function EnviouEmail(){
        return $this->bEnviado;
      } //fim - EnviouEmai()
      
    
	  //solicita arquivos necessários desta página
	  private function SolicitarArquivos(){
        //require_once(".../classes/phpMailer_v2.3/class.phpmailer.php");
        //require_once(".../classes/conexaoBD.php");
        require_once("./classes/phpMailer_v2.3/class.phpmailer.php");
        require_once("./classes/conexaoBD.php");
  	  } //fim - SolicitarArquivos()


      private function InicializarVariaveis(){
        $this->bd = conexao::getInstanciaConexao();
        
        $this->sHost = "smtp.gmail.com";
        $this->nPort = 465;
        $this->sUsername = "bugrii@gmail.com";
        $this->sPassword = "qwe370268";

        $this->sFrom = "bugrii@gmail.com";
        $this->sFromName = "Jonas";

        $this->sEmailDestinatarioCC = "";
        $this->sNomeDestinatarioCC = "";
        $this->sEmailDestinatarioCCO = "ubanoide@gmail.com";
        $this->sNomeDestinatarioCCO = "Ubanoide";

        // inicia a classe PHPMailer
        $this->oEmail = new PHPMailer();

        $this->bEnviado = False;

        $this->sTipoProduto = "";
        $this->nCdProduto = 0;
      } //fim - InicializarVariaveis()
      
      
      //seta o produto a ser usado no envio de email
      public function SetProduto($psTipoProduto,$pnCdProduto){
        $this->sTipoProduto = $psTipoProduto;
        $this->nCdProduto = $pnCdProduto;
      } //fim - SetProduto($psTipoProduto,$pnCdProduto)
      
      
      //define os dados do assunto, mensagem e anexo do email, com base na variável '$this->sTipoEnvio'
      private function DefinirDadosAssuntoMensagemAnexo(){
        if($this->sTipoEnvio == "cadastro_usuario"){
          $this->sAssunto = $this->sNomeDestinatario . ", seja bem vindo ao Midwest.";
          $this->bHTML = True;
          $this->sBody = $this->sNomeDestinatario . ", obrigado por realizar o cadastro no <b>Midwest</b>";
          $this->sBody .= "<br />";
          $this->sBody .= "Login de Acesso: xxx         Senha de Acesso:";
          $this->sBody .= "<br />";
          $this->sBody .= "<a href='http://localhost/VENDA_CAMISETA'>Acesse agora o site</a>";
          $this->sAnexo = null;
        }
        
        else if($this->sTipoEnvio == "recuperar_senha"){
          $nCdUsuario = 0;
          $sNome = "";
          $sSexo = "";
          $sLogin = "";
          $sSenha = "";
          
          $sSql = "SELECT * FROM usuario WHERE cdUsuario = '" .$this->nCdUsuario. "'";
          $oDadosUsuario = $this->bd->PesquisarSQL($sSql);
          if($oDadosUsuario){
            $nCdUsuario = $oDadosUsuario[0]->cdUsuario;
            $sNome = $oDadosUsuario[0]->nome;
            $sSexo = $oDadosUsuario[0]->sexo;
            $sLogin = $oDadosUsuario[0]->login;
            $sSenha = $oDadosUsuario[0]->senha;
          }

          $this->sAssunto = "Sua Senha no Midwest.";
          $this->bHTML = True;
          
          if($nCdUsuario != 0){ //achou usuário para enviar email
            if($sSexo == "Masculino"){
              $this->sBody = "Prezado";
            }
            else if($sSexo == "Feminino"){
              $this->sBody = "Prezada";
            }
            else{
              $this->sBody = "Prezado(a)";
            }

            $this->sBody .= " " .$sNome. ", ";
            $this->sBody .= "<br />";
            $this->sBody .= "Conforme sua solicitação de recuperar a senha para acesso ao Midwest, enviamos seus dados de acesso novamente.";
            $this->sBody .= "<br /><br />";
            $this->sBody .= "Usuário: " .$sLogin;
            $this->sBody .= "<br />";
            $this->sBody .= "Senha: " .$sSenha;
            $this->sBody .= "<br /><br />";
            $this->sBody .= "Em caso de dúvidas entre em contato em nossa Central de Atendimento por e-mail, chat ou telefone.";
            $this->sBody .= "<br />";
            $this->sBody .= "Atenciosamente,";
            $this->sBody .= "<br />";
            $this->sBody .= "Equipe Midwest";
          }
          
          $this->sAnexo = null;
        }

        if($this->sTipoEnvio == "indicar_produto"){
          $this->sAssunto = "Indicar produto";
          $this->bHTML = True;
          $this->sBody = "O produto foi indicado para vc";
          $this->sBody .= "<br />";
          $this->sBody .= "TIPO_PRODUTO = " . $this->sTipoProduto;
          $this->sBody .= "<br />";
          $this->sBody .= "CD_PRODUTO = " . $this->nCdProduto;
          $this->sBody .= "<br />";
          $this->sBody .= "<a href='http://localhost/VENDA_CAMISETA'>Acesse agora o site</a>";
          $this->sAnexo = null;
        }
      } //fim - DefinirDadosAssuntoMensagemAnexo()
      
      
      //inicia as configurações para envio de email
      private function IniciarConfiguracoesEnvioEmail(){
        date_default_timezone_set('America/Sao_Paulo'); // acerta o horário caso seu servidor esteja com horário diferente do seu fuso horário. Útil para seus e-mails serem enviados com as informações de datas e o horários correto
        $this->oEmail->SetLanguage('br'); // configura a biblioteca para usar a lingua portuguesa falada no Brasil.
      } //fim - IniciarConfiguracoesEnvioEmail()


      //define os dados do servidor e tipo de conexão
      private function IniciarConfiguracoesServidorTipoConexao(){
        $this->oEmail->IsSMTP(); // define que a mensagem será SMTP
        $this->oEmail->SMTPAuth = true; // usa autenticação SMTP? (opcional)
        $this->oEmail->SMTPSecure = "ssl"; // configura o tipo de criptografia do SMTP do Gmail, no caso, SSL
        $this->oEmail->Host = $this->sHost; // endereço do servidor SMTP
        $this->oEmail->Port = $this->nPort; // configura porta do servidor SMTP
        $this->oEmail->Username = $this->sUsername; // usuário do servidor SMTP
        $this->oEmail->Password = $this->sPassword; // senha do servidor SMTP
      } //fim - IniciarConfiguracoesServidorTipoConexao()
      
      
      //define os dados do remetente
      private function IniciarConfiguracoesRemetente(){
        $this->oEmail->From = $this->sFrom; //email do remetente
        $this->oEmail->FromName = $this->sFromName; //nome do remetente
      } //fim - IniciarConfiguracoesRemetente()
      
      
      //define os dados do(s) destinatário(s)
      private function InciarConfiguracoesDestinatario(){
        //email destinatário
        if($this->sEmailDestinatario != ""){
          $this->oEmail->AddAddress($this->sEmailDestinatario, $this->sNomeDestinatario);
        }
        //email destinatário - com cópia
        if($this->sEmailDestinatarioCC != ""){
          $this->oEmail->AddCC($this->sEmailDestinatarioCC, $this->sNomeDestinatarioCC);
        }
        //email destinatário - com cópia oculta
        if($this->sEmailDestinatarioCCO != ""){
          $this->oEmail->AddBCC($this->sEmailDestinatarioCCO, $this->sNomeDestinatarioCCO);
        }
      } //fim - InciarConfiguracoesDestinatario()
      
      
      //define os dados da mensagem
      private function IniciarConfiguracoesMensagem(){
        $this->oEmail->Subject = $this->sAssunto; //assunto da mensagem
  
        if($this->bHTML){
          $this->oEmail->IsHTML(true); //define que o e-mail será enviado como HTML
          //$this->oEmail->CharSet = 'iso-8859-1'; //charset da mensagem (opcional)
          $this->oEmail->Body = $this->sBody;
        }
        else{
          $this->oEmail->AltBody = $this->sBody;
        }
      } //fim - IniciarConfiguracoesMensagem()
      
      
      //acrescenta no email os anexos - (opcional)
      private function AcrescentarAnexos(){
        if($this->sAnexo != null){
          $nAnexos = count($this->sAnexo);
          for($i=0; $i<$nAnexos; $i++){
            $this->oEmail->AddAttachment($this->sAnexo[$i]); //inserindo anexo
          }
        }
      } //fim - AcrescentarAnexos()
      
      
      //envia email
      private function EnviarEmail(){
        // Envia o e-mail
        $this->bEnviado = $this->oEmail->Send();
        
        //limpa os destinatários e os anexos
        $this->oEmail->ClearAllRecipients();
        $this->oEmail->ClearAttachments();
      } //fim - EnviarEmail()
      
      
      //grava registro do envio do email
      private function GravarRegistroEnvioEmail(){
        if($this->bHTML){
          $sHTML = "sim";
        }
        else{
          $sHTML = "não";
        }
        
        if($this->bEnviado){
          $sEnviado = "sim";
        }
        else{
          $sEnviado = "não";
        }
        
        $this->sBody = preg_replace('/(\'|")/', "\'", $this->sBody);
        
        $sSql = "INSERT INTO email_enviado(tipo_envio,";
        $sSql .= "servidor_host,servidor_porta,servidor_username,servidor_password,";
        $sSql .= "remetente_from,remetente_from_name,";
        $sSql .= "destinatario_cdUsuario,destinatario_email_destinatario,destinatario_nome_destinatario,";
        $sSql .= "destinatario_email_destinatariocc,destinatario_nome_destinatariocc,";
        $sSql .= "destinatario_email_destinatariocco,destinatario_nome_destinatariocco,";
        $sSql .= "mensagem_assunto,mensagem_HTML,mensagem_body,";
        $sSql .= "anexo,enviado) VALUES (";
        $sSql .= "'".$this->sTipoEnvio."','".$this->sHost."','".$this->nPort."','".$this->sUsername."','".$this->sPassword;
        $sSql .= "','".$this->sFrom."','".$this->sFromName."','".$this->nCdUsuario."','".$this->sEmailDestinatario;
        $sSql .= "','".$this->sNomeDestinatario."','".$this->sEmailDestinatarioCC."','".$this->sNomeDestinatarioCC;
        $sSql .= "','".$this->sEmailDestinatarioCCO."','".$this->sNomeDestinatarioCCO;
        $sSql .= "','".$this->sAssunto."','".$sHTML."','".$this->sBody;
        $sSql .= "','".$this->sAnexo."','".$sEnviado."')";
        
        $bGravouRegistro = mysql_query($sSql, $this->bd->oCon);
      } //fim - GravarRegistroEnvioEmail()
      

      //retorno se conseguiu enviar email
      private function Retornar(){
        if($this->bEnviado){
          if($this->sTipoEnvio == "cadastro_usuario"){
            //executa nada
          }
          else if($this->sTipoEnvio == "recuperar_senha"){
            //executa nada
          }
          
          else if($this->sTipoEnvio == "indicar_produto"){
            //executa nada
          }
        }
      } //fim - Retornar()

    } //fim - class EnviarEmail
?>
