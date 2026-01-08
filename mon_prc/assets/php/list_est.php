<?php
session_start();

$fl_nivel = $_SESSION['fl_nivel'];

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/con_wms.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

if (!empty($_REQUEST['cod_prd'])) {

    $cod_prd    = trim(strip_tags($_REQUEST['cod_prd']));
    $fl_sts     = "A";
    $qtde       = "0";

    // Consulta tarefas abertas e pendentes por atendente
    $sql = "SELECT t1.id, t1.nome, t2.cod_estoque, t2.ds_galpao, t2.produto, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, ";
    $sql .= "t2.nr_qtde as nr_qtde, t3.cod_prod_cliente, t3.nm_produto, t2.nr_or, ";
    $sql .= "date_format(t4.dt_create,'%d/%m/%Y') as dt_recebimento, t2.id_tar, date_format(t5.dt_create,'%d/%m/%Y') as dt_tarefa, ";
    $sql .= "t2.n_serie, t4.nr_serial, t4.ds_lp, t4.ds_ano, t4.ds_fabr, t4.ds_kva, t4.ds_enr, t9.nome, t3.unid ";
    $sql .= "FROM tb_armazem t1 ";
    $sql .= "left join tb_posicao_pallet t2 on t1.id = t2.ds_galpao ";
    $sql .= "left join tb_produto t3 on t2.produto = t3.cod_prod_cliente ";
    $sql .= "left join tb_recebimento_ag t4 on t2.nr_or = t4.cod_recebimento ";
    $sql .= "left join tb_inv_tarefa t5 on t2.id_tar = t5.id ";
    $sql .= "left join tb_etiqueta t8 on t2.cod_estoque = t8.cod_estoque ";
    $sql .= "left join tb_armazem t9 on t2.ds_galpao = t9.id ";
    $sql .= "WHERE t2.fl_status = ? and t2.produto = ? and t2.nr_qtde > ? ";
    $sql .= "GROUP BY t2.cod_estoque ORDER BY t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto";
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $fl_sts);
    $stm->bindValue(2, $cod_prd);
    $stm->bindValue(3, $qtde);
    $stm->execute();

    $count = $stm->rowCount();

    if ($count > 0) {
        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

            if ($row['unid'] == "KG" && strlen($row['nr_qtde']) <= 7) {

                $qtde_est = str_replace(".", ",", $row['nr_qtde']) . " kg";
            } else if ($row['unid'] == "KG" && strlen($row['nr_qtde']) > 7) {

                $qtde_est = $row['nr_qtde'] / 1000 . " t";
            } else {

                $qtde_est = number_format($row['nr_qtde'], 0) . " " . $row['unid'];
            }

            $retorno[] = array(
                "cod_estoque"         => $row['cod_estoque'],
                "ds_prateleira"     => $row['ds_prateleira'],
                "ds_coluna"         => $row['ds_coluna'],
                "ds_altura"         => $row['ds_altura'],
                "produto"            => $row['produto'],
                "nr_serial"            => $row['nr_serial'],
                "nm_produto"         => $row['nm_produto'],
                "qtde_est"             => $qtde_est,
                "ds_kva"            => $row['ds_kva'],
                "ds_ano"             => $row['ds_ano'],
                "ds_lp"             => $row['ds_lp'],
                "ds_fabr"            => $row['ds_fabr'],
                "ds_enr"            => $row['ds_enr'],
                "dt_recebimento"    => $row['dt_recebimento'],
            );
        }
    } else {

        $retorno[] = array(

            "cod_estoque"         => "",
            "ds_prateleira"     => "",
            "ds_coluna"         => "",
            "ds_altura"         => "",
            "produto"            => "",
            "nr_serial"         => "",
            "nm_produto"         => "",
            "qtde_est"             => "",
            "ds_kva"             => "",
            "ds_ano"             => "",
            "ds_lp"                => "",
            "ds_fabr"            => "",
            "ds_enr"            => "",
            "dt_recebimento"    => "",

        );
    }

    if (!empty($retorno)) {

        echo json_encode($retorno);
    } else {

        $retorno[] = array('info' => '1');
        echo json_encode($retorno);
    }
}
