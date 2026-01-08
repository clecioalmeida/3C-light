<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_est = $_POST['cod_estoque'];

$query_qtde="select DISTINCT t1.id
from tb_etiqueta t1
left join tb_nf_entrada_item t2 on t1.cod_item = t2.cod_nf_entrada_item
left join tb_nf_entrada t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente and t4.fl_empresa = '$cod_cli'
left join tb_posicao_pallet t5 on t3.cod_rec = t5.nr_or
where t1.id = '$cod_est'
group by t1.id";
$qtde = mysqli_query($link,$query_qtde);
while ($dados=mysqli_fetch_assoc($qtde)) {

	$upd_etq="update tb_etiqueta set fl_status = 'L' where id = '".$dados['id']."'";
	$res_etq = mysqli_query($link1,$upd_etq);
	
}

$upd_aloc="update tb_aloca set fl_status = 'L' where id = '$cod_est'";
$res_aloc = mysqli_query($link1,$upd_aloc);
$tr=mysqli_affected_rows($link1);

if(mysqli_affected_rows($link1)>0){
	$retorno[] = array(
		'info'	=> "0",
	);

}else{

	$retorno[] = array(
		'info'	=> "1",
	);

}

echo(json_encode($retorno));
$link->close();
$link1->close();
?>