<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['local'])){
	
	$id = trim($_POST['local']);

	$end = explode("-", $id);

	if(isset($end[0]) && isset($end[1]) && isset($end[2]) && isset($end[3])){

		$id_end = $end[0];
		$rua = strtoupper($end[1]);
		$col = $end[2];
		$alt = $end[3];

		$query_conf="select cod_estoque
		from tb_posicao_pallet
		where ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt' and fl_empresa = '$cod_cli' AND fl_status = 'A'";
		$res_conf=mysqli_query($link, $query_conf);

		if(mysqli_num_rows($res_conf) > 0){

			$retorno[] = array(
				'info' => "0",
			);

			echo(json_encode($retorno));

		}else{

			$retorno[] = array(
				'info' => "Endereço inválido.",
			);

			echo(json_encode($retorno));

		}

	}else{

		$retorno[] = array(
			'info' => "Endereço inválido.",
		);

		echo(json_encode($retorno));

	}  


}else{

	$retorno[] = array(
		'info' => "Endereço inválido.",
	);

	echo(json_encode($retorno));

} 

$link->close();
?>