<?php
session_start();  
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_item    = $_POST['id_item'];
$nr_vol     = $_POST['nr_vol'];
$dt_val     = $_POST['dt_val'];
$nr_ca     	= $_POST['nr_ca'];
$dt_ca     	= $_POST['dt_ca'];
$nr_laudo   = $_POST['nr_laudo'];
$dt_laudo   = $_POST['dt_laudo'];
$nr_qtde   	= $_POST['nr_qtde'];

$sql_ca = "select id, nr_docto, fl_tipo from tb_ca where nr_docto = '$nr_ca' and fl_tipo = 'C'";
$res_ca = mysqli_query($link, $sql_ca);

if(mysqli_num_rows($res_ca) > 0){

	$ca = mysqli_fetch_assoc($res_ca);
	$cod_ca = $ca['id'];

}else{

	$ins_ca = "insert into tb_ca (nr_docto, dt_docto, fl_tipo, fl_status, usr_create, dt_create) values ('$nr_ca','$dt_ca','C','A','$id','$date')";
	$res_ins_ca = mysqli_query($link, $ins_ca);

	$cod_ca = mysqli_insert_id($link);

}

$sql_ld = "select id, nr_docto, fl_tipo from tb_ca where nr_docto = '$nr_laudo' and fl_tipo = 'L'";
$res_ld = mysqli_query($link, $sql_ld);

if(mysqli_num_rows($res_ld) > 0){

	$ld = mysqli_fetch_assoc($res_ld);
	$cod_laudo = $ld['id'];

}else{

	$ins_ld = "insert into tb_ca (nr_docto, dt_docto, fl_tipo, fl_status, usr_create, dt_create) values ('$nr_laudo','$dt_laudo','L','A','$id','$date')";
	$res_ins_ld = mysqli_query($link, $ins_ld);

	$cod_laudo = mysqli_insert_id($link);

}

$sql = "update tb_nf_entrada_item set nr_qtde = '$nr_qtde', nr_volume = '$nr_vol', dt_validade = '$dt_val', nr_ca = '$nr_ca', dt_ca = '$dt_ca', nr_laudo = '$nr_laudo', dt_laudo = '$dt_laudo' WHERE cod_nf_entrada_item = '$id_item'";

$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

    echo "Produto alterado: ".$id_item;

}else{

    echo "Produto não pode alterado.";

} 


$link->close();
?>