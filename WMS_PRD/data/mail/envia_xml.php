<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date('c');

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_cte 		= $_POST['nr_cte'];
$caminho 		= $_POST['caminho'];
$caminho_xml 	= "../../".$_POST['caminho_xml'];

$sql = "select t1.cod_pagador,t2.nm_empresa,t2.email_fiscal, t3.nr_cnpj_cpf, t3.nm_cliente,t3.ds_email
from tb_conhecimento t1
left join tb_empresa t2 on t1.fl_empresa = t2.cod_empresa
left join tb_cliente t3 on t1.cod_pagador = t3.nr_cnpj_cpf
where t1.cod_conhecimento = '$nr_cte'";
$res = mysqli_query($link, $sql);
while ($dados = mysqli_fetch_assoc($res)) {
	$email_fiscal=$dados['email_fiscal'];
	$ds_email=$dados['ds_email'];
	$nm_empresa=$dados['nm_empresa'];
}

#
# Exemplo de envio de e-mail SMTP PHPMailer - www.secnet.com.br
#
# Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer

//require_once('PHPMailer-master\src\PHPMailer.php');
require 'PHPMailer-master\PHPMailerAutoload.php';
# Inicia a classe PHPMailer
$mail = new PHPMailer();

# Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "mx1.hostinger.com.br"; # Endereço do servidor SMTP
$mail->Port = 587; // Porta TCP para a conexão
$mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível
$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
$mail->Username = 'cte@growupsti.com.br'; # Usuário de e-mail
$mail->Password = 'cte2018#'; // # Senha do usuário de e-mail

# Define o remetente (você)
$mail->From = "cte@growupsti.com.br"; # Seu e-mail
$mail->FromName = "Argus TMS"; // Seu nome

# Define os destinatário(s)
$mail->AddAddress($ds_email, 'Teste de envio2'); # Os campos podem ser substituidos por variáveis
#$mail->AddAddress('webmaster@nomedoseudominio.com'); # Caso queira receber uma copia
$mail->AddCC($email_fiscal, 'Teste copia2'); # Copia
#$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); # Cópia Oculta

# Define os dados técnicos da Mensagem
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; # Charset da mensagem (opcional)

# Define a mensagem (Texto e Assunto)
$mail->Subject = "ARGUS TMS - Envio de arquivo XML de Conhecimento de transporte"; # Assunto da mensagem
$mail->Body = "Arquivo XML de conhecimento de transporte eletronico anexo emitido pela <b>".$nm_empresa."</b>!";
$mail->AltBody = "Este é o corpo da mensagem de teste, somente Texto! \r\n :)";

# Define os anexos (opcional)
$mail->AddAttachment($caminho_xml); # Insere um anexo

# Envia o e-mail
$enviado = $mail->Send();

# Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

# Exibe uma mensagem de resultado (opcional)
if ($enviado) {
 $array_parte = array(
		'info' 	=> "0",
	);
 echo json_encode($array_parte, JSON_PRETTY_PRINT);
 //echo "E-mail enviado com sucesso!<br />";
 //echo $date;
} else {
	$array_parte = array(
		'info' 	=> "1",
	);
	echo json_encode($array_parte, JSON_PRETTY_PRINT);
 //echo "Não foi possível enviar o e-mail.";
 //echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}
$link->close();
?>