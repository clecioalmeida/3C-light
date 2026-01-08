<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$cod_rec = $_REQUEST['cod_rec'];

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, coalesce(t1.dt_chegada, '0000-00-00') as dt_chegada, ";
$sql .= "coalesce(t1.dt_recebimento_previsto,'0000-00-00') as dt_recebimento_previsto, t1.dt_create, t1.nr_insumo, ";
$sql .= "t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.ds_email_sol, ";
$sql .= "t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, ";
$sql .= "t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, t1.dt_autoriza, t1.fl_status, t5.id as id_janela, t5.dt_janela, t5.ds_janela, ";
$sql .= "t6.descricao, round((t1.nr_peso_previsto/t6.cap_kg)*100,0) as cap_veic, t6.codigo, t1.fl_status, t1.ds_tipo_vol ";
$sql .= "FROM tb_recebimento_ag t1 ";
$sql .= "left join tb_janela t5 on t1.cod_recebimento = t5.cod_rec ";
$sql .= "left join tb_tipo_veiculo t6 on t1.tp_veiculo = t6.codigo ";
$sql .= "WHERE t1.cod_recebimento = ? ";
$sql .= "order by t1.cod_recebimento desc limit 3 ";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $cod_rec);
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {
	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

		$status = ($row['fl_status'] == "AG") ? "<span class='center-block padding-5 label label-success'>CONFIRMADO</span>" 
		: (($row['fl_status'] == "S") ? "<span class='center-block padding-5 label label-warning'>AGUARDANDO CONFIRMAÇÃO</span>" 
		: "<span class='center-block padding-5 label label-danger'>RECUSADO</span>");

		$progress = ($row['cap_veic'] >= "70") ? "red" : (($row['cap_veic'] < "70" && $row['cap_veic'] >= "30") ? "yellow" : "green");

		$retorno = array(
			"name" 			=> $row['nm_fornecedor'],
			"cap_veic" 		=> "<td><div class='progress progress-xs' data-progressbar-value=' " . $row['cap_veic'] . "'><div style='width: " . $row['cap_veic'] . "%;background-color: " . $progress . "' class='progress-bar'></div></div></td>",
			"status" 		=> $status,
			"peso" 			=> $row['nr_peso_previsto'],
			"volume" 		=> $row['nr_volume_previsto'],
			"tp_veiculo" 	=> $row['descricao'],
			"id_veiculo" 	=> $row['codigo'],
			"placa" 		=> $row['nm_placa'],
			"transportador" => $row['nm_transportadora'],
			"motorista" 	=> $row['nm_motorista'],
			"dt_create"		=> $row['dt_create'],
			"dt_chegada" 	=> $row['dt_chegada'],
			"dt_entrada" 	=> "0000-00-00",
			"ini_car" 		=> "0000-00-00",
			"fim_car" 		=> "0000-00-00",
			"dt_janela" 	=> $row['dt_janela'],
			"ds_janela" 	=> $row['ds_janela'],
			"id_janela" 	=> $row['id_janela'],
			"ds_obs" 		=> $row['ds_obs'],
			"nr_insumo" 	=> $row['nr_insumo'],
			"ds_mail" 	    => $row['ds_email_sol'],
			"ds_tipo_vol" 	=> $row['ds_tipo_vol'],
			"cod_rec" 		=> $row['cod_recebimento']
		);
	}
} else {

	$retorno = array(
		
		"name" 			=> "<td colspan='18'>Não há dados para mostrar.</td>"

	);
}

if (!empty($retorno)) {

	echo json_encode($retorno);
} else {

	$retorno[] = array('info' => '1');
	echo json_encode($retorno);
}
