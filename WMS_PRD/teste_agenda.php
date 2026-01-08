<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$workdays = array();

$type = CAL_GREGORIAN;

$month = '01';
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

$janela = array("08:00 - Doca 1", "08:00 - Doca 2", "10:00 - Doca 1", "10:00 - Doca 2", "13:00 - Doca 1", "13:00 - Doca 2", "17:00 - Doca 1", "17:00 - Doca 2");
foreach ($workdays as $key=>$value) {

	$dt_agenda = date('Y-m-d', strtotime($value));

	foreach ($janela as $key1 => $value1) {

		$sql = "insert into tb_janela (dt_janela, ds_janela, fl_status, usr_create, dt_create) values ('$value', '$value1', 'A', '1', '$data')";
		$resultado_id = mysqli_query($link, $sql);
		$nRec = mysqli_insert_id($link);

		echo $nRec." - ".$dt_agenda." - ".$value."<br>";
	}
}
?>