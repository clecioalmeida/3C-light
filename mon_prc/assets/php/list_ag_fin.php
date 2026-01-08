<?php
session_start();

$fl_nivel = $_SESSION['fl_nivel'];

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, coalesce(date_format(t1.dt_chegada, '%d/%m/%Y %H:%i:%s'), '0000-00-00') as dt_chegada, ";
$sql .= "coalesce(date_format(t1.dt_recebimento_previsto, '%d/%m/%Y %H:%i:%s'),'0000-00-00') as dt_recebimento_previsto, t1.dt_create, ";
$sql .= "t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, ";
$sql .= "t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, ";
$sql .= "t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, COALESCE(date_format(t1.dt_autoriza, '%d/%m/%Y %H:%i:%s'),'0000-00-00') as dt_autoriza, t1.fl_status, t5.dt_janela, t5.ds_janela, ";
$sql .= "t6.descricao, round((t1.nr_peso_previsto/t6.cap_kg)*100,0) as cap_veic, t1.fl_status ";
$sql .= "FROM tb_recebimento_ag t1 ";
$sql .= "left join tb_janela t5 on t1.cod_recebimento = t5.cod_rec ";
$sql .= "left join tb_tipo_veiculo t6 on t1.tp_veiculo = t6.codigo ";
$sql .= $_SESSION['fl_nivel'] == "1" ? "WHERE (t1.fl_status =  'F' or t1.fl_status = 'R') and t1.usr_create = ? "
	: "WHERE (t1.fl_status =  'F' or t1.fl_status = 'R') ";
$sql .= "order by t1.cod_recebimento desc limit 10 ";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, 'S');
$stm->bindValue(2, 'AG');
$stm->bindValue(3, 'CR');
$stm->bindValue(4, 'AT');
$stm->bindValue(5, 'R');
if ($_SESSION['fl_nivel'] == "1") {
	$stm->bindValue(3, $_SESSION['id_user']);
}
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {
	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

		$status = ($row['fl_status'] == "AG") ? "<span class='center-block padding-5 label label-success'>CONFIRMADO</span>" 
		: (($row['fl_status'] == "S")  ? "<span class='center-block padding-5 label label-warning'>AGUARDANDO CONFIRMAÇÃO</span>" 
		: (($row['fl_status'] == "CR")  ? "<span class='center-block padding-5 label label-info'>AGUARDANDO AUTORIZAÇÃO</span>" 
		: (($row['fl_status'] == "AT")  ? "<span class='center-block padding-5 label label-success'>ENTRADA AUTORIZADA</span>" 
		: "<span class='center-block padding-5 label label-danger'>RECUSADO</span>")));

		$progress = ($row['cap_veic'] >= "70") ? "red" : (($row['cap_veic'] < "70" && $row['cap_veic'] >= "30") ? "yellow" : "green");

		$retorno[] = array(
			"name" 			=> $row['nm_fornecedor'],
			"cap_veic" 		=> "<td style='width:200px;'><div class='progress progress-xs' data-progressbar-value=' " . $row['cap_veic'] . "'><div style='width: " . $row['cap_veic'] . "%;background-color: " . $progress . "' class='progress-bar'></div></div></td>",
			"status" 		=> $status,
			"peso" 			=> "<strong>" . $row['nr_peso_previsto'] . "</strong>",
			"volume" 		=> "<strong>" . $row['nr_volume_previsto'] . "</strong>",
			"tp_veiculo" 	=> "<strong>" . $row['descricao'] . "</strong>",
			"placa" 		=> $row['nm_placa'],
			"transportador" => $row['nm_transportadora'],
			"motorista" 	=> $row['nm_motorista'],
			"dt_create"		=> $row['dt_create'],
			"dt_chegada" 	=> $row['dt_chegada'],
			"dt_entrada" 	=> $row['dt_autoriza'],
			"ini_car" 		=> "0000-00-00",
			"fim_car" 		=> "0000-00-00",
			"dt_rec" 		=> "<strong>" . $row['dt_janela'] ." ".$row['ds_janela']. "</strong>",
			"ds_obs" 		=> $row['ds_obs'],
			"cod_rec" 		=> $row['cod_recebimento'],
			"fl_status" 	=> $row['fl_status'],
			"fl_nivel" 		=> $fl_nivel
		);
	}
} else {

	$retorno[] = array(
		
		"name" 			=> "<td colspan='18'>Não há dados para mostrar.</td>"

	);
}

if (!empty($retorno)) {

	echo json_encode($retorno);
} else {

	$retorno[] = array('info' => '1');
	echo json_encode($retorno);
}
