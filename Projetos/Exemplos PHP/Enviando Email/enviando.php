<?php
  // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
  require("./phpMailer_v2.3/class.phpmailer.php");

  date_default_timezone_set('America/Sao_Paulo'); // Acerta o hor�rio caso seu servidor caso esteja com hor�rio diferente do seu fuso hor�rio. �til para seus e-mails serem enviados com as informa��es de datas e o hor�rios correto

  // Inicia a classe PHPMailer
  $mail = new PHPMailer();
  $mail->SetLanguage('br'); // Configura a biblioteca para usar a lingua portuguesa falada no Brasil. Para outras linguas veja a pasta languages da biblioteca

  // Define os dados do servidor e tipo de conex�o
  $mail->IsSMTP(); // Define que a mensagem ser� SMTP
  $mail->Host = "smtp.gmail.com"; // Endere�o do servidor SMTP
  $mail->SMTPAuth = true; // Usa autentica��o SMTP? (opcional)
  
  $mail->SMTPSecure = "ssl"; // Configura o tipo de criptografia do SMTP do Gmail, no caso, SSL
  $mail->Host = "smtp.gmail.com"; // Configura servidor SMTP do Gmail
  $mail->Port = 465; // Configura porta do servidor SMTP do Gmail

  $mail->Username = "bugrii@gmail.com"; // Usu�rio do servidor SMTP
  $mail->Password = "qwe370268"; // Senha do servidor SMTP
  

  

  // Define o remetente
  $mail->From = "bugrii@gmail.com"; // Seu e-mail
  $mail->FromName = "Jonas"; // Seu nome

  // Define os destinat�rio(s)
  //$mail->AddAddress('fulano@dominio.com.br', 'Fulano da Silva');
  $mail->AddAddress("jonassazevedo@hotmail.com");
  //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
  //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // C�pia Oculta

  // Define os dados t�cnicos da Mensagem
  $mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
  //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

  // Define a mensagem (Texto e Assunto)
  $mail->Subject  = "Mensagem Teste"; // Assunto da mensagem
  //$mail->Body = "Este � o corpo da mensagem de teste, em <b>HTML</b>! <br /> <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
  //$mail->AltBody = "Este � o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
  $mail->Body = "Este � o corpo da mensagem de teste, em <b>HTML</b>";
//  $mail->AltBody = "Este � o corpo da mensagem de teste, em Texto Plano!";
  

  // Define os anexos (opcional)
  //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

  // Envia o e-mail
  $enviado = $mail->Send();

  // Limpa os destinat�rios e os anexos
  $mail->ClearAllRecipients();
  $mail->ClearAttachments();

  // Exibe uma mensagem de resultado
  if ($enviado) {
     echo "E-mail enviado com sucesso!";
  } else {
    echo "N�o foi poss�vel enviar o e-mail.<br /><br />";
    echo "<b>Informa��es do erro:</b> <br />" . $mail->ErrorInfo;
  }
?>
