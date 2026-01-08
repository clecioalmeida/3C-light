<?php
date_default_timezone_set('America/Sao_Paulo');
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$xml 	= $_POST['xml'];
$chave 	= $_POST['chave'];

$caminho = "../../xml/";

$xmlDownload = $xml;
$fp = fopen($caminho . $chave . '-nfe.xml', 'w+');
fwrite($fp, $xmlDownload);
fclose($fp);

$arquivo = $caminho . $chave . '-nfe.xml';

if (file_exists($arquivo)) {

	$array_cte = array(
		'info' => "0",
		'caminho'	=> $chave . '-nfe.xml',
	);

} else {

	$array_cte = array(
		'info' 		=> "1",
	);

}

echo json_encode($array_cte);

$link->close();
?>