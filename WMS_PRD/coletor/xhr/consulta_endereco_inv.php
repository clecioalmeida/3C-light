<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_glp = $_REQUEST['id_glp'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_parte = "SELECT a.id, a.nome, e.id, e.rua, e.coluna, e.altura 
from tb_armazem a 
left join tb_endereco e on a.id = e.galpao
where a.id = '$id_glp' and a.fl_tipo = 'P'";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) > 0){
	
	$parte=mysqli_fetch_assoc($res_parte);

	$retorno = array(
		'end'	=> $parte['id']."-".$parte['rua']."-".$parte['coluna']."-".$parte['altura'],
	);

}else{

	$retorno = array(
		'end'	=> "",
	);

}

echo(json_encode($retorno));


$link->close();
?>