<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
$data = explode("-", $date);
$mes  = $data[1];

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_2 = "select round(avg(vl_unit),2) as vlr_med, produto
from tb_nf_entrada_item
where month(dt_rec) = '$mes'
group by produto" or die(mysqli_error($sql_2));
$res_2 = mysqli_query($link, $sql_2);
while ($dados = mysqli_fetch_assoc($res_2)) {

	$sql_4 = "insert into tb_vlr_est (dt_log, cod_prd, vlr_med, usr_create, dt_create) values ('".$date."', '".$dados['produto']."', '".$dados['vlr_med']."', '99','".$date."')" or die(mysqli_error($sql_4));
	$res_4 = mysqli_query($link, $sql_4);

	if(mysqli_affected_rows($link) > 0){

		echo "Valor cadastrado.<br>";

	}else{

		echo "Valor não cadastrado.<br>";

	}

}

$link->close();
?>