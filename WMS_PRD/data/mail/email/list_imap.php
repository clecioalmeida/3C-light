<?php

date_default_timezone_set('America/Sao_Paulo');

$mbox = imap_open("{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert/readonly}INBOX", "teste@growupsti.com.br", "teste2017");

$nlidas = imap_num_recent($mbox);

$folders = imap_listmailbox($mbox, "{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert/readonly}", "*");

if ($folders == false) {
	$erro = "Falha na listagem de pastas";
} else {

	for($i = 1;$i <= imap_num_msg($mbox);$i++) {

		$headers            = imap_header($mbox, $i);
		//$headerinfo 		= imap_headerinfo($mbox, $i);
		//$recent				= $headerinfo->Recent
		$lida				= $headers->Unseen;
		$nova				= $headers->Recent;
		$assunto            = $headers->subject;
		$message_id         = $headers->message_id;
		$toaddress          = $headers->toaddress;
		$to                 = $headers->to;		
		$fromaddress        = $headers->fromaddress;
		$email_remetente    = $to[0]->mailbox;
		$servidor_remetente = $to[0]->host;
		$data               = $headers->date;
		$data               = strtotime($data);
		$data               = date("d/m/Y H:i:s", $data);		
		$remetente          =  $email_remetente."@".$servidor_remetente;
		$uid=imap_uid($mbox,$i);

		//echo "Assunto = $assunto - Remetente = $email_remetente@$servidor_remetente Data = $data <a href=\"imap.php?id=$i\">Ler Mensagem</a><br>";

		$array_oper[] = array(
			'remetente' => $remetente,
			'assunto' => $assunto,
			'data_mail' => $data,
			'msg_id' => $message_id,
			'fromaddress' => $fromaddress,
			'uid' => $uid,
			'lida' => $lida,
			'nova' => $nova,
		);
	} 
}

echo(json_encode($array_oper));

imap_close($mbox);
?>