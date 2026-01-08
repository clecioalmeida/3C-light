<?php
session_start();

$id_oper = $_SESSION['id_oper'];

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT t1.id, date_format(t1.dt_janela,'%d/%m/%Y') as dt_janela_conf, t1.ds_janela, t1.fl_status, t1.fl_tipo, ";
$sql .= "CASE t1.fl_status WHEN 'A' THEN 'ABERTA' WHEN 'S' THEN 'SOLICITADA' WHEN 'C' THEN 'CONFIRMADA' WHEN 'B' THEN 'FECHADA' END as janela, ";
$sql .= "t2.cod_recebimento, t2.nm_fornecedor, t2.nr_peso_previsto, t2.nr_volume_previsto ";
$sql .= "FROM tb_janela t1 ";
$sql .= "left join tb_recebimento_ag t2 on t1.cod_rec = t2.cod_recebimento ";
$sql .= "where t1.fl_empresa = ? and t1.dt_janela >= CURRENT_DATE ";
$sql .= "order by t1.dt_janela, t1.ds_janela asc";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $id_oper);
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {
	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

		$status = ($row['fl_status'] == "A") ? "<span class='center-block padding-5 label label-success'>ABERTA</span>" 
		: (($row['fl_status'] == "S")  ? "<span class='center-block padding-5 label label-warning'>SOLICITADA</span>" 
		: (($row['fl_status'] == "C")  ? "<span class='center-block padding-5 label label-info'>CONFIRMADA</span>" 
		: (($row['fl_status'] == "B")  ? "<span class='center-block padding-5 label label-success'>FECHADA</span>" 
		: "<span class='center-block padding-5 label label-danger'>RECUSADO</span>")));

		if ($row['fl_status'] == "A") {

			$btn = '<button type="submit" id="btnBlqJan" class="btn btn-danger btn-xs" value="' . $row['id'] . '">FECHAR JANELA</button>';
		} else if ($row['fl_status'] == "B") {

			$btn = '<button type="submit" id="btnReabJan" class="btn btn-primary btn-xs" value="' . $row['id'] . '">REABRIR JANELA</button>';
		} else {

			$btn = '<button type="submit" id="btnBlqJan" class="btn btn-danger btn-xs" value="' . $row['id'] . '" disabled>FECHAR JANELA</button>';
		}

		$retorno[] = array(
			"dt_janela_conf" 	 => $row['dt_janela_conf'],
			"ds_janela" 		 => $row['ds_janela'],
			"fl_status"          => $row['fl_status'],
			"cod_recebimento"    => $row['cod_recebimento'],
			"nm_fornecedor"	     => $row['nm_fornecedor'],
			"nr_peso_previsto" 	 => $row['nr_peso_previsto'],
			"nr_volume_previsto" => $row['nr_volume_previsto'],
			"acoes"              => $btn,
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
