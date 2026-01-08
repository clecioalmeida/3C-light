<?php
	require_once('bd_class_dsv.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$ds_local=$_POST['ds_local'];

	$big_select="set sql_big_selects=1";
	$res_select = mysqli_query($link,$big_select);

	$SQL = "select t1.*, t2.ds_apelido, t2.nome
	from tb_portaria t1
	left join tb_armazem t2 on t1.ds_galpao = t2.id
	 where t1.ds_galpao = '$ds_local'";
	$res = mysqli_query($link,$SQL);

	while ($local=mysqli_fetch_assoc($res)) {
		$array_local[] = array(
			'ds_doca' => $local['ds_doca'],
			'ds_apelido' => $local['ds_apelido'],
			'nome' => $local['nome'],
			'fl_status' => $local['fl_status'],
			'id' => $local['id'],
		);
	}
	
	echo(json_encode($array_local));
	
	$link->close();
?>