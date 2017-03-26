<?php
  // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
  require("./phpMailer_v2.3/class.phpmailer.php");

  date_default_timezone_set('America/Sao_Paulo'); // Acerta o horário caso seu servidor caso esteja com horário diferente do seu fuso horário. Útil para seus e-mails serem enviados com as informações de datas e o horários correto

  // Inicia a classe PHPMailer
  $mail = new PHPMailer();
  $mail->SetLanguage('br'); // Configura a biblioteca para usar a lingua portuguesa falada no Brasil. Para outras linguas veja a pasta languages da biblioteca

  // Define os dados do servidor e tipo de conexão
  $mail->IsSMTP(); // Define que a mensagem será SMTP
  $mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
  $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
  
  $mail->SMTPSecure = "ssl"; // Configura o tipo de criptografia do SMTP do Gmail, no caso, SSL
  $mail->Host = "smtp.gmail.com"; // Configura servidor SMTP do Gmail
  $mail->Port = 465; // Configura porta do servidor SMTP do Gmail

  $mail->Username = "bugrii@gmail.com"; // Usuário do servidor SMTP
  $mail->Password = "qwe370268"; // Senha do servidor SMTP
  

  

  // Define o remetente
  $mail->From = "bugrii@gmail.com"; // Seu e-mail
  $mail->FromName = "Jonas"; // Seu nome

  // Define os destinatário(s)
  //$mail->AddAddress('fulano@dominio.com.br', 'Fulano da Silva');
  $mail->AddAddress("jonassazevedo@hotmail.com");
  //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
  //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

  // Define os dados técnicos da Mensagem
  $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
  //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

  // Define a mensagem (Texto e Assunto)
  $mail->Subject  = "Mensagem Teste"; // Assunto da mensagem
  //$mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>! <br /> <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
  //$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
  $mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>";
//  $mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano!";
  

  // Define os anexos (opcional)
  //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

  // Envia o e-mail
  $enviado = $mail->Send();

  // Limpa os destinatários e os anexos
  $mail->ClearAllRecipients();
  $mail->ClearAttachments();

  // Exibe uma mensagem de resultado
  if ($enviado) {
     echo "E-mail enviado com sucesso!";
  } else {
    echo "Não foi possível enviar o e-mail.<br /><br />";
    echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
  }
?>
