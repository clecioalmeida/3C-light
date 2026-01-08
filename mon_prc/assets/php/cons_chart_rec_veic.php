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
$sql = "select date_format(dt_recebimento_real, '%m/%Y') as mes_rec, count(nm_placa) as total_veic ";
$sql .= "FROM tb_recebimento_ag ";
$sql .= "WHERE fl_status <> ? ";
$sql .= "group by year(dt_recebimento_real), month(dt_recebimento_real) ";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, 'E');
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {

    $tb_veic = "";

	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

		$tb_veic .= "<tr>";
        $tb_veic .= "<td>".$row['mes_rec']."</td>";
        $tb_veic .= "<td>".$row['total_veic']."</td>";
        $tb_veic .= "</tr>";
	}

} else {

	$retorno[] = array(
		
		"mes_rec" 			=> "<h4>Não há dados para mostrar.</h4>"

	);
}

if (!empty($tb_veic)) {

	//echo json_encode($retorno);

	echo $tb_veic;

} else {

	$retorno[] = array('info' => '1');
	echo json_encode($retorno);

}
