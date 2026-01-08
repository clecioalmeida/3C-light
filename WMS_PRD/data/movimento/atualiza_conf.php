<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_conf 	= $_POST['cod_conf'];
$cod_col 	= $_POST['cod_col'];
$cod_prd 	= $_POST['cod_prd'];
$id_rua 	= strtoupper($_POST['id_rua']);
$id_col 	= strtoupper($_POST['id_col']);
$id_alt 	= $_POST['id_alt'];
$nr_ped 	= $_POST['nr_ped'];
$nr_qtde 	= $_POST['nr_qtde'];

if($cod_conf == ""){

	$upd_col = "insert into tb_pedido_conferencia (nr_pedido, cod_col, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, fl_conferido, fl_status, usr_create, dt_create) values ('$nr_ped', '$cod_col', '$cod_prd', '$id_rua', '$id_col', '$id_alt', '$nr_qtde', 'C', 'M', '$id', '$date')";
	$res_col = mysqli_query($link, $upd_col);

	if ($res_col) {

		$sql_prd = "update tb_pedido_coleta_produto set usr_fim_conf = '$id', dt_fim_conf = '$date' where produto = '$cod_prd' and nr_pedido = '$nr_ped'";
		$res_prd = mysqli_query($link, $sql_prd);

		if($res_prd){

			echo "Separação cadastrada!";

		}else{

			echo "Separação não pode ser cadastrada.";

		} 
	}


}else{

	$sql = "update tb_pedido_conferencia set nr_qtde = '$nr_qtde', ds_prateleira = '$id_rua', ds_coluna = '$id_col', ds_altura = '$id_alt' WHERE cod_conferencia = '$cod_conf'";
	$resultado_id = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link) > 0){

		echo "Separação alterada!";

	}else{

		echo "Separação não pode ser alterada.";

	} 

}

$link->close();
?>