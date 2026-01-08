<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_almox 		= $_POST["nr_matricula"];
$ds_custo 		= $_POST["ds_custo"];
$nr_ped_sap 	= $_POST["nr_ped_sap"];
$ds_tipo 		= $_POST["ds_tipo"];
$ds_frete 		= $_POST["ds_frete"];
$ds_prd			= $_POST["ds_prd"];
$dt_pedido 		= $_POST["dt_pedido"];
$dt_separa 		= $_POST["dt_separa"];
$dt_limite 		= $_POST["dt_limite"];
$hr_limite 		= $_POST["hr_limite"];
$ds_obs 		= $_POST["ds_obs"];

$sql_doc = "select nr_ped_sap from tb_pedido_coleta where nr_ped_sap = '$nr_ped_sap'";
$res_doc = mysqli_query($link, $sql_doc);

if(mysqli_num_rows($res_doc) > 0){

	echo "Já existe requisição com o numero ".$nr_ped_sap;

}else{

	$last_pedido = "select coalesce(max(nr_pedido),0) + 1 as pedido from tb_pedido_coleta";
	$res_last_pedido = mysqli_query($link, $last_pedido);
	$n_pedido = mysqli_fetch_assoc($res_last_pedido);
	$pedido_novo = $n_pedido['pedido'];

	if ($pedido_novo > 0) {

		$ins_pedido = "insert into tb_pedido_coleta (nr_pedido, cod_almox, ds_custo, nr_ped_sap, ds_tipo, ds_frete, ds_prd, dt_pedido, dt_separa, dt_limite, hr_limite, ds_obs, fl_status, fl_empresa, usr_create, dt_create) values ('$pedido_novo', '$cod_almox', '$ds_custo', '$nr_ped_sap', '$ds_tipo', '$ds_frete', '$ds_prd', '$dt_pedido', '$dt_separa', '$dt_limite',  '$hr_limite', '$ds_obs', 'A', '$cod_cli', '$id', '$date')";
		$res_ins_pedido = mysqli_query($link1, $ins_pedido);

		if (mysqli_affected_rows($link1) > 0) {

			$sel_prod = "select nr_pedido from tb_pedido_coleta where nr_pedido = '$pedido_novo'";
			$res = mysqli_query($link, $sel_prod);
			while ($dados = mysqli_fetch_assoc($res)) {
				$novo_pedido = $dados['nr_pedido'];
			}

			echo "Pedido número ".$novo_pedido." criado com sucesso!";

		} else {

			echo "Ocorreu um erro na gravação do pedido!";

		}

	} else {

		echo "Não foi possível gerar um novo pedido!";

	}

}

$link->close();
?>