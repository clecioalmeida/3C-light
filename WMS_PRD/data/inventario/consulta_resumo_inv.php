<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_POST['id_inv'];

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$sql_parte = "SELECT t1.id, t2.nr_qtde as qtde_pos, COALESCE(t3.nr_qtde_ant,0) as qtde_ant
FROM tb_inv_tarefa AS t1
LEFT JOIN (SELECT cod_estoque, nr_qtde, fl_status, id_tar FROM tb_posicao_pallet) AS t2 ON t2.id_tar = t1.id 
LEFT JOIN (SELECT nr_posicao_temp, sum(nr_qtde) as nr_qtde_ant FROM tb_posicao_pallet group by nr_posicao_temp) AS t3 ON t3.nr_posicao_temp = t2.cod_estoque
where t1.id_inv = '$id_inv' and t1.fl_status = 'X' and t2.fl_status = 'A'
group by t1.id";
$res_parte = mysqli_query($link, $sql_parte);
$total = mysqli_num_rows($res_parte);


if (mysqli_num_rows($res_parte) > 0) {

	$confere = 0;

	while ($parte = mysqli_fetch_assoc($res_parte)) {


		if($parte['qtde_ant'] == $parte['qtde_pos']){

			$confere ++;

		}
	}

	$acur = number_format(($confere / $total), 2) * 100;
	
	$array_parte = array(
		'info' => 0,
		'acuracidade' => $acur,
	);
	
	echo (json_encode($array_parte));

} else {

	$array_parte[] = array(
		'info' => 1,
	);

	echo (json_encode($array_parte));
}

$link->close();
?>