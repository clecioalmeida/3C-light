<?php
session_start();

$fl_nivel = $_SESSION['fl_nivel'];

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/con_wms.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT r.cod_recebimento, DATE_FORMAT(r.dt_recebimento_real, '%d/%m/%Y') AS dt_recebimento, r.fl_empresa, r.fl_status, ";
$sql .= "r.nm_placa, r.nm_fornecedor, r.nm_motorista, SUM(r.nr_qtde) as nr_qtde, r.id_end, r.ds_galpao, r.ds_rua, r.ds_coluna, ";
$sql .= "r.ds_altura, r.ds_kva, r.ds_lp, r.ds_ano, r.ds_enr, r.ds_fabr, r.cod_produto, r.nr_serial, r.ds_obs, ";
$sql .= "COALESCE(p.unid,'S/INFO') as unid ";
$sql .= "FROM tb_recebimento_ag r ";
$sql .= "left join tb_produto p on r.cod_produto = p.cod_prod_cliente ";
$sql .= "WHERE r.fl_status = ? ";
$sql .= "GROUP BY r.cod_recebimento ORDER BY r.dt_recebimento_real desc ";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, 'A');
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {
	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

		if ($row['unid'] == "KG" && strlen($row['nr_qtde']) <= 7) {

			$qtde_rec = str_replace(".", ",", $row['nr_qtde']) . " kg";
		} else if ($row['unid'] == "KG" && strlen($row['nr_qtde']) > 7) {

			$qtde_rec = $row['nr_qtde'] / 1000 . " t";
		} else {

			$qtde_rec = number_format($row['nr_qtde'], 0) . " " . $row['unid'];
		}

		$fl_situacao = $row['fl_status'] == "A" ? "<span style='background-color:#E9967A;color:white;text-align:center'>ENDEREÇAMENTO PENDENTE</span>" 
		: "<span style='background-color:#FF6347;color:white;text-align:center'>PRODUTO ENDEREÇADO</span>";

		$retorno[] = array(
			"fl_status" 		=> $row['fl_status'],
			"cod_recebimento" 	=> $row['cod_recebimento'],
			"dt_recebimento" 	=> $row['dt_recebimento'],
			"nm_placa" 			=> $row['nm_placa'],
			"nm_motorista"		=> $row['nm_motorista'],
			"nm_fornecedor" 	=> $row['nm_fornecedor'],
			"cod_produto" 		=> $row['cod_produto'],
			"qtde_rec" 			=> $qtde_rec,
			"ds_lp" 			=> $row['ds_lp'],
			"ds_kva" 			=> $row['ds_kva'],
			"nr_serial"    		=> $row['nr_serial'],
			"ds_fabr"    		=> $row['ds_fabr'],
			"ds_ano"    		=> $row['ds_ano'],
			"ds_enr"    		=> $row['ds_enr'],
			"ds_obs"    		=> $row['ds_obs'],
			"situacao"    		=> $fl_situacao,
		);
	}

} else {

	$retorno[] = array(
		
		"fl_status" 			=> "",
			"cod_recebimento" 	=> "",
			"dt_recebimento" 	=> "",
			"nm_placa" 			=> "",
			"nm_motorista"		=> "",
			"nm_fornecedor" 	=> "",
			"cod_produto" 		=> "",
			"qtde_rec" 			=> "",
			"ds_lp" 			=> "",
			"ds_kva" 			=> "",
			"nr_serial"    		=> "",
			"ds_fabr"    		=> "",
			"ds_ano"    		=> "",
			"ds_enr"    		=> "",
			"ds_obs"    		=> "",
			"situacao"    		=> "",

	);
}

if (!empty($retorno)) {

	echo json_encode($retorno);
} else {

	$retorno[] = array('info' => '1');
	echo json_encode($retorno);
}
