<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$workdays = array();

$type = CAL_GREGORIAN;

$month = '02';
$year = date('Y')+1;
$day_count = cal_days_in_month($type, $month, $year);

for ($i = 1; $i <= $day_count; $i++) {

	$date = $year.'/'.$month.'/'.$i;
	$get_name = date('l', strtotime($date));
	$day_name = substr($get_name, 0, 3);

	if($day_name != 'Sun' && $day_name != 'Sat'){
		$workdays[] = $year.'-'.$month.'-'.$i;
	}

}

$janela = array("08:00", "09:00", "10:00", "11:00", "13:00", "14:00", "15:00", "16:00");

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

				echo $nRec." - ".$dt_agenda." - ".$value1." - ".$value2." - ".$value3."<br>";
			}

		}

	}
}
?>