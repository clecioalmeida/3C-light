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
$sql = "select date_format(dt_create, '%m/%Y') as mes_col, count(n_serie) as total_ns ";
$sql .= "FROM tb_nserie ";
$sql .= "WHERE fl_status <> ? ";
$sql .= "group by year(dt_create), month(dt_create) ";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, 'E');
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {

    $tb_ns = "";

	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

		$tb_ns .= "<tr>";
        $tb_ns .= "<td>".$row['mes_col']."</td>";
        $tb_ns .= "<td>".$row['total_ns']."</td>";
        $tb_ns .= "</tr>";
	}

} else {

	$retorno[] = array(
		
		"mes_col" 			=> "<h4>Não há dados para mostrar.</h4>"

	);
}

if (!empty($tb_ns)) {

	//echo json_encode($retorno);

	echo $tb_ns;

} else {

	$retorno[] = array('info' => '1');
	echo json_encode($retorno);

}
