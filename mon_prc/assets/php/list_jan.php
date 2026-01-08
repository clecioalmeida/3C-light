<?php
session_start();

if (!isset($_SESSION["id_user"]) || !isset($_SESSION["id_oper"])) {

    header("Location:../../index.php");
    exit;

} else {

    $id_user    = $_SESSION["id_user"];
    $cod_cli    = $_SESSION['id_oper'];
    $fl_nivel = $_SESSION['fl_nivel'];

}


date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT t1.id, date_format(t1.dt_janela,'%d/%m/%Y') as dt_janela_conf, t1.ds_janela, t1.fl_status, t1.fl_tipo,  ";
$sql .= "CASE t1.fl_status WHEN 'A' THEN 'ABERTA' WHEN 'S' THEN 'SOLICITADA' WHEN 'C' THEN 'CONFIRMADA' WHEN 'B' THEN 'FECHADA' END as janela, ";
$sql .= "t2.cod_recebimento, t2.nm_fornecedor, t2.nr_peso_previsto, t2.nr_volume_previsto ";
$sql .= "FROM tb_janela t1 ";
$sql .= "left join tb_recebimento_ag t2 on t1.cod_rec = t2.cod_recebimento ";
$sql .= "left join tb_tipo_veiculo t6 on t1.tp_veiculo = t6.codigo ";
$sql .= "WHERE t1.fl_empresa = ? and t1.dt_janela >= CURRENT_DATE ";
$sql .= "order by t1.dt_janela, t1.ds_janela asc";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $id_user);
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
