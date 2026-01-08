<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$hoje = date('Y-m-d');
$limite = date('Y-m-d', strtotime('+15 days'));
$inicio = new DateTime($hoje);
$fim = new DateTime($limite);

$periodo = new DatePeriod($inicio, new DateInterval('P1D'), $fim);
$validos = [];
foreach($periodo as $item){

	$sql_tipo2 = "select id,date_format(ds_janela, '%H:%i') as ds_janela, ds_doca from tb_recebimento_jn";
	$res_tipo2 = mysqli_query($link, $sql_tipo2);
	while ($janela=mysqli_fetch_assoc($res_tipo2)) {
		$ds_janela =  $janela['ds_janela'];
		$ds_doca =  $janela['ds_doca'];
		$id =  $janela['id'];

		if(substr($item->format("D"), 0, 1) != 'S'){
			$validos[] = $item->format('Y-m-d')."-".$id;
		}
	}
}

foreach($validos as $dias){

	$sql = "select t1.dt_agenda, t2.id, date_format(t2.ds_janela, '%H:%i') as ds_janela, t2.ds_doca 
	from tb_recebimento_ag t1
	left join tb_recebimento_jn t2 on t1.nr_janela = t2.id
	where concat(t1.dt_agenda,'-',t2.id = '$dias' and t1.fl_status <> 'E'" or die(mysqli_error($sql));
	$select_cliente = mysqli_query($link, $sql);
	while ($datas=mysqli_fetch_assoc($select_cliente)) {
		$ocupados[] =  $datas['dt_agenda'].'-'.$datas['ds_janela'].'-'.$datas['ds_doca'];
	}
}

$disponiveis = array_merge(array_diff($validos, $ocupados) , array_diff($ocupados, $validos));

/*foreach($disponiveis as $agendar){

	$sql_ag = "SELECT e.id, concat(a.dt_agenda,'-',date_format(e.ds_janela, '%H:%i'), '-', e.ds_doca) as janela FROM tb_recebimento_jn e
	left join tb_recebimento_ag a on e.id = a.nr_janela
	WHERE e.id NOT IN (SELECT nr_janela FROM tb_recebimento_ag where dt_agenda = '$agendar')" or die(mysqli_error($sql_ag));
	$res_ag = mysqli_query($link, $sql_ag);
	while ($agenda=mysqli_fetch_assoc($res_ag)) {
		$agendado[] =  $agenda['id']." - ".$agenda['janela'];
	}
}*/

echo "<pre>";
print_r($validos);
print_r($ocupados);
print_r($disponiveis);
$link->close();
?>