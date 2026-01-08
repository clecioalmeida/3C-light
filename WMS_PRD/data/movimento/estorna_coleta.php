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
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();


if(isset($_POST['nr_pedido'])){


	$nr_pedido = $_POST['nr_pedido'];

	$sql_status = "select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
	$resultado_status = mysqli_query($link, $sql_status);
	while ($dados_upd = mysqli_fetch_assoc($resultado_status)) {
		$fl_status = $dados_upd['fl_status'];
	}

	if ($fl_status == "M") {


		$ins_prd = "delete from tb_coleta_pedido where nr_pedido = '$nr_pedido'";
		$res_ins = mysqli_query($link, $ins_prd);

		$upd_col = "update tb_pedido_coleta_produto set fl_status = 'A' where nr_pedido = '$nr_pedido'";
		$result_upd = mysqli_query($link1, $upd_col);

		$upd_prd = "update tb_pedido_coleta set fl_status = 'A' where nr_pedido = '$nr_pedido'";
		$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

		if ($result_prd) {

			echo "Coleta estornada.";


		}else{

			echo "Não foi possível estornar a coleta. Por favor entre em contato com o suporte.";

		}

	}else{

		echo "O pedido ainda não foi liberado para coleta ou a coleta já foi iniciada!";

	}

}else{

	echo "Não foi possível estornar a coleta. Por favor entre em contato com o suporte.";
	
}

$link->close();
?>