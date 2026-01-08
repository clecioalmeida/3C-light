<?php
if($_REQUEST['app'] == 'wms_prd'){

	require_once 'bd_class_prd.php';

}else{

	require_once 'bd_class_prd.php';

}
$objDb = new db();
$link = $objDb->conecta_mysql();

$user = $_REQUEST['user'];
$pass = $_REQUEST['pass'];

$sql_cod = "select id, id_op from tb_usuario where nm_login = '$user' and ds_senha = '$pass'";
$res_cod = mysqli_query($link, $sql_cod);

if(mysqli_num_rows($res_cod) > 0){

	while ($cod = mysqli_fetch_assoc($res_cod)) {

		$cod_cli = $cod['id_op'];

		$sql_parte = "select cod_empresa, nr_cnpj, nm_empresa, id_oper, ds_oper
		from tb_empresa
		where fl_status = 'A' and FIND_IN_SET(cod_empresa, '$cod_cli')";
		$res_parte = mysqli_query($link, $sql_parte);

		if(mysqli_num_rows($res_parte) > 0){

			while ($parte = mysqli_fetch_assoc($res_parte)) {
				$array_parte[] = array(
					'info'			=>	"0",
					'cod_empresa' 	=> $parte['cod_empresa'],
					'nm_empresa' 	=> $parte['nm_empresa'],
					'id_oper' 		=> $parte['id_oper'],
					'ds_oper' 		=> $parte['ds_oper'],
				);
			}

		}else{

			$array_parte[] = array(
				'info'	=>	"1",
			);

		}

	}


}else{

	$array_parte[] = array(
		'info'	=>	"2",
		'app'	=>	$_REQUEST['app'],
		'user'	=>	$user,
		'pass'	=>	$pass,
	);

}

echo (json_encode($array_parte));
$link->close();
?>