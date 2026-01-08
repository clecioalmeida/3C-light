<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$workdays = array();

$type = CAL_GREGORIAN;

$sql_dt = "select max(dt_janela) as dt_janela from tb_janela" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);
$dados=mysqli_fetch_assoc($res_dt);
$next_jan=$dados['dt_janela'];

echo $next_jan;

$pieces = explode("-", $next_jan);
$month = $pieces[1]+1;

if($pieces[1] == '12'){

	$year = $pieces[0]+1;

}else{

	$year = $pieces[0];

}

$day_count = cal_days_in_month($type, $month, $year);

for ($i = 1; $i <= $day_count; $i++) {

	$date = $year.'/'.$month.'/'.$i;
	$get_name = date('l', strtotime($date));
	$day_name = substr($get_name, 0, 3);

	if($day_name != 'Sun' && $day_name != 'Sat'){
		$workdays[] = $year.'-'.$month.'-'.$i;
	}

}

$janela = array("08:00", "10:00", "13:00", "15:00");
$fl_empresa = array("3", "4");
$ds_doca = array("Doca 1", "Doca 2");
foreach ($workdays as $key=>$value) {

	$dt_agenda = date('Y-m-d', strtotime($value));

	foreach ($janela as $key1 => $value1) {

		foreach ($ds_doca as $key2 => $value2) {

			foreach ($fl_empresa as $key3 => $value3) {

				$sql = "insert into tb_janela (dt_janela, ds_janela, ds_doca, fl_status, fl_tipo, fl_empresa, usr_create, dt_create) values ('$value', '$value1', '$value2', 'A', 'N', '$value3', '1', '$data')";
				$resultado_id = mysqli_query($link, $sql);
				$nRec = mysqli_insert_id($link);

				//echo $nRec." - ".$dt_agenda." - ".$value1." - ".$value2." - ".$value3."<br>";*/
				//echo $dt_agenda." - ".$value1." - ".$value2." - ".$value3."<br>";
			}

		}

	}
}
$link->close();
?>