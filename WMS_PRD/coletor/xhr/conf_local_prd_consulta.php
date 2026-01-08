<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$produto = $_POST['barcodeConsLocPrd'];

$query_conf = "SELECT t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, round(COALESCE(t1.nr_qtde, 0),'3') as nr_qtde, 
t2.nome, t3.nm_produto, date_format(t1.dt_create,'%d/%m/%Y') as dt_create, COALESCE(t1.ds_lp, 0) as ds_lp, t3.unid
    from tb_posicao_pallet t1
    left join tb_armazem t2 on t1.ds_galpao = t2.id
    left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
    where t1.produto = '$produto' and t1.nr_qtde > 0 and t1.fl_empresa = '$cod_cli' and t2.fl_situacao = 'A' and t1.fl_status = 'A'
    group by t1.cod_estoque";
$res_conf = mysqli_query($link, $query_conf);

if (mysqli_num_rows($res_conf) > 0) {

    while ($conf = mysqli_fetch_assoc($res_conf)) {

        if ($conf['unid'] == "KG" && strlen($conf['nr_qtde']) <= 7) {

            $nr_qtde =  str_replace(".", ",", $conf['nr_qtde']) . " kg";
        } else if ($conf['unid'] == "KG" && strlen($conf['nr_qtde']) > 7) {

            $nr_qtde = $conf['nr_qtde'] / 1000 . " t";
        } else {

            $nr_qtde = number_format($conf['nr_qtde'], 0) . " " . $conf['unid'];
        }

        $retorno[] = array(
            'retorno' => "<p><strong>Código</strong>: " . $conf['produto'] . " <strong>Produto</strong>: " . $conf['nm_produto'] . " <strong>Qtde</strong>: " . $nr_qtde . "</p><p>Rua: " . $conf['ds_prateleira'] . " - Coluna: " . $conf['ds_coluna'] . " - Altura: " . $conf['ds_altura'] . " - Data: " . $conf['dt_create'] . " <strong>LP</strong>: " . $conf['ds_lp'] . "</p><hr>",
        );
    }

    echo (json_encode($retorno));
} else {

    $retorno[] = array(
        'retorno' => 'Produto não encontrado.',
    );
    echo (json_encode($retorno));
}

$link->close();
$link1->close();
?>