<?php

date_default_timezone_set('America/Sao_Paulo');

$mbox = imap_open("{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert/readonly}INBOX", "teste@growupsti.com.br", "teste2017");

$nlidas = imap_num_recent($mbox);

//$folders = imap_listmailbox($mbox, "{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert}", "*");

$array_oper[] = array(
	'nlidas' => $nlidas,
);
echo(json_encode($array_oper));

imap_close($mbox);
?>