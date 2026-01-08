<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$nr_placa = $_REQUEST['nr_placa'];

	$big_select="set sql_big_selects=1";
	$res_select = mysqli_query($link,$big_select);
	
	$sql_veic = "select * from tb_portaria where (fl_status = 'L' or fl_status = 'A') and id = '$nr_placa'";
	$res_veic = mysqli_query($link, $sql_veic);

	if(mysqli_num_rows($res_veic) == '0'){
			$array_veic[] = array(
				'erro' => "Veículo não se encontra na empresa!",
			);
		echo(json_encode($array_veic));

	} else {

		while ($veic=mysqli_fetch_assoc($res_veic)) {
			$array_veic[] = array(
				'ds_veiculo' => $veic['ds_veiculo'],
				'ds_empresa' => $veic['ds_empresa'],
				'ds_nome' => $veic['ds_nome'],
				'id' => $veic['id'],
				'dt_entrada' => $veic['dt_entrada'],
			);
		}
		echo(json_encode($array_veic));

	}

$link->close();
?>