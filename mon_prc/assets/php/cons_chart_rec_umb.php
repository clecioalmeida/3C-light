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
$sql = "SELECT date_format(r.dt_recebimento_real, '%m/%Y') as mes_rec, GROUP_CONCAT(m.total_umb) as total_umb, GROUP_CONCAT(m.unid) as unid ";
$sql .= "FROM tb_recebimento_ag r ";
$sql .= "LEFT JOIN (";
$sql .= "SELECT r.cod_recebimento, sum(r.cod_recebimento) as total_umb,  ";
$sql .= "COALESCE(p.unid,'S/ INFO') as unid ";
$sql .= "FROM tb_recebimento_ag r ";
$sql .= "LEFT JOIN tb_produto p on r.cod_produto = p.cod_prod_cliente ";
$sql .= "WHERE r.fl_status <> ? and p.unid is not null ";
$sql .= "GROUP BY year(r.dt_recebimento_real), month(r.dt_recebimento_real), p.unid) m on m.cod_recebimento = r.cod_recebimento ";
$sql .= "GROUP BY date_format(r.dt_recebimento_real, '%m/%Y')";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, 'E');
$stm->execute();

$count = $stm->rowCount();

if ($count > 0) {

    $tb_umb = "";
    $ln_umb = "";

    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

        $total_umb = explode(',', $row['total_umb']);
        $unid[] = explode(',', $row['unid']);

        $tb_umb .= "<tr>";
        $tb_umb .= "<td>" . $row['mes_rec'] . "</td>";

        foreach ($total_umb as $e) {

            $tb_umb .= "<td class='' style='text-align:right'>" . $e . "</td>";
        }

        $tb_umb .= "</tr>";
    }

    $ln_umb .= "<tr>";
    $ln_umb .= "<th>Mês</th>";

    foreach ($unid[0] as $f) {

        $ln_umb .= "<th>" . $f . "</th>";
    }

    $ln_umb .= "</tr>";
} else {

    $retorno[] = array(

        "mes_rec"             => "<h4>Não há dados para mostrar.</h4>"

    );
}

if (!empty($tb_umb)) {

    $retorno = array(

        "tb_umb"            => $tb_umb,
        "ln_umb"            => $ln_umb

    );
    echo json_encode($retorno);

} else {

    $retorno[] = array('info' => '1');
    echo json_encode($retorno);
}
