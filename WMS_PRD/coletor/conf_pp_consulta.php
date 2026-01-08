<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();


$id = $_POST['barcodeConsPP'];
$end = explode("-", $id);

$id_end = $end[0];
$rua = $end[1];
$col = $end[2];
$alt = $end[3];

$query_conf = "SELECT t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde, t2.nome, t3.nm_produto, t3.cod_prod_cliente
from tb_posicao_pallet t1
left join tb_armazem t2 on t1.ds_galpao = t2.id
left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
where t1.ds_prateleira = '$rua' and t1.ds_coluna = '$col' and t1.ds_altura = '$alt' and t1.fl_empresa = '$cod_cli' and t1.fl_status = 'A'";
$res_conf=mysqli_query($link, $query_conf);

if(mysqli_num_rows($res_conf) > 0){

    while ($conf=mysqli_fetch_assoc($res_conf)) {
        $retorno[] = array(
            'saldo' => $conf['nr_qtde'],
            'nm_produto' => $conf['nm_produto'],
            'cod_prod_cliente' => $conf['cod_prod_cliente'],
            'info' => "1",
        );
    }

    echo(json_encode($retorno));

}else{

    $retorno[] = array(
        'info' => "2",
    );

    echo(json_encode($retorno));

}   

$link->close();
?>