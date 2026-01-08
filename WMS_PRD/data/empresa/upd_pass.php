<?php
	require_once('bd_class.php');
	
	$cod_cliente = $_POST['cod_cliente'];
    $ds_senha1 = $_POST['ds_senha1'];
    $ds_senha2 = $_POST['ds_senha2'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	if($ds_senha1 == $ds_senha2){

		$sql = "update tb_cliente set ds_senha ='$ds_senha2' WHERE cod_cliente = '$cod_cliente'" or die(mysqli_error($sql));
	
		$resultado_id = mysqli_query($link, $sql);

		if($resultado_id){

			 include 'modal/sucess_upd_pass.php';

		} else {

			echo "<script>alert('Falha no cadastro!')</script>";

		}

	} else {

		echo "<script>alert('As senhas digitadas devem ser iguais!')</script>";
	}


$link->close();

?>