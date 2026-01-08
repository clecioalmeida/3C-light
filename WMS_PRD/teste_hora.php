<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
$data_atual = (new DateTime($date))->format('H:i');

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

//$ds_janela 		= substr("08:00 - Doca 1",0,5);
$ds_janela 		= "09:00";

$tolerancia = date("H:i",strtotime("$ds_janela + 15 minutes"));

/*list($h1,$m1) = explode(':',$data_atual);
list($h2,$m2) = explode(':',$tolerancia);

$dateTimeOne = new DateTime();
$dateTimeOne->setTime($h1, $m1);

$dateTimeTwo = new DateTime();
$dateTimeTwo->setTime($h2, $m2);

$interval = $dateTimeOne->diff($dateTimeTwo);
//echo $interval->format('%H horas %i minutos e %s segundos');
$atraso = $interval->format('%H:%i'). "<br>";*/

$hora1 = explode(":",$tolerancia);
$hora2 = explode(":",$data_atual);
print_r($hora1);
print_r($hora2);
$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60);
$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60);
$resultado = $acumulador2 - $acumulador1;
$hora_ponto = floor($resultado / 3600);
//$resultado = $resultado - ($hora_ponto * 3600);
$min_ponto = floor($resultado / 60);
$resultado2 = $resultado - ($min_ponto * 60);
echo $acumulador2." - ".$acumulador1."<br>";
echo "resultado ".$resultado."<br>";
echo "resultado2 ".$resultado2."<br>";
echo "hora_ponto ".$hora_ponto."<br>";
echo "min_ponto ".$min_ponto."<br>";
$tempo = $hora_ponto.":".$min_ponto;
echo "<br>".$data_atual." - ".$ds_janela." - ".$tolerancia." - ".$tempo."<br>";
/*
if($hora_ponto > 0){

	$ins_oc="insert into tb_ocorrencias (criticidade, tipo, cod_origem, nm_ocorrencia, ds_responsavel, nm_depto, dt_final, ds_obs, fl_status, dt_abertura, user_create, dt_create) values ('B', 'G', '', 'FORNECEDOR ATRASOU A CHEGADA', '', 'RECEBIMENTO', '', '', 'A', '$date','', '$date')";
	$res_oc = mysqli_query($link,$ins_oc);

}else{

	if($min_ponto > 15){

		$ins_oc="insert into tb_ocorrencias (criticidade, tipo, cod_origem, nm_ocorrencia, ds_responsavel, nm_depto, dt_final, ds_obs, fl_status, dt_abertura, user_create, dt_create) values ('B', 'G', '', 'FORNECEDOR ATRASOU A CHEGADA', '', 'RECEBIMENTO', '', '', 'A', '$date','', '$date')";
		$res_oc = mysqli_query($link,$ins_oc);

	}

}
*/
$link->close();
?>