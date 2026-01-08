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
$sql = "SELECT date_format(r.dt_recebimento_real, '%m/%Y') as mes_rec, GROUP_CONCAT(m.total_kva) as total_kva, GROUP_CONCAT(m.kva) as ds_kva ";
$sql .= "FROM tb_recebimento_ag r ";
$sql .= "LEFT JOIN (";
$sql .= "SELECT r.cod_recebimento, count(r.cod_recebimento) as total_kva, ";
$sql .= "coalesce(r.ds_kva,'0') as kva ";
$sql .= "FROM tb_recebimento_ag r ";
$sql .= "WHERE r.fl_status <> 'E' and r.ds_kva is not null and r.ds_kva > 0 ";
$sql .= "GROUP BY year(r.dt_recebimento_real), month(r.dt_recebimento_real), r.ds_kva) m on m.cod_recebimento = r.cod_recebimento ";
$sql .= "GROUP BY date_format(r.dt_recebimento_real, '%m/%Y')";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, 'E');
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {

    $tb_kva = "";
    $ln_kva = "";

	while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

        $total_kva = explode(',', $row['total_kva']);
        $ds_kva[] = explode(',', $row['ds_kva']);

        $tb_kva .= "<tr>";
        $tb_kva .= "<td>".$row['mes_rec']."</td>";

        foreach ($total_kva as $e) {

            $tb_kva .= "<td class='' style='text-align:right'>".$e."</td>";

          }

        $tb_kva .= "</tr>";
	}

    $ln_kva .= "<tr>";
    $ln_kva .= "<th>Mês</th>";

    foreach ($ds_kva[0] as $f) {

        $ln_kva .= "<th>".$f."</th>";

      }

    $ln_kva .= "</tr>";
    
} else {

	$retorno[] = array(
		
		"mes_rec" 			=> "<h4>Não há dados para mostrar.</h4>"

	);
}

if (!empty($tb_kva)) {

    $retorno = array(
		
		"tb_kva" 			=> $tb_kva,
        "ln_kva"            => $ln_kva

	);
	echo json_encode($retorno);

    //echo $tb_kva;
    //echo $ln_kva;

} else {

	$retorno[] = array('info' => '1');
	echo json_encode($retorno);
}
