<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../index.php");
    exit;

}else{

    $id=$_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido  = $_POST['nr_pedido'];
$codigo     = $_POST['barcode'];
$nr_qtde    = $_POST['nr_qtde'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_prod="select produto
from tb_pedido_coleta_produto
where nr_pedido = '$nr_pedido' and produto = '$codigo' and fl_status <> 'E'";
$res_prod=mysqli_query($link, $query_prod);
$tr_prod = mysqli_num_rows($res_prod);

if($tr_prod > 0){

    $query_nrqte="select SUM(t1.nr_qtde) as nr_qtde
    from tb_pedido_conferencia 
    where t1.nr_pedido = '$nr_pedido' and t1.produto = '$codigo'";
    $res_nrqtde=mysqli_query($link, $query_nrqte);
    while ($nrqtde=mysqli_fetch_assoc($res_nrqtde)) {
        $count=$nrqtde['nr_qtde'];
    }

    if($count == $nr_qtde){

        $insert_barcode = "insert into tb_nf_entrada_conf (cod_nf_entrada_item, cod_nf_entrada, cod_rec, barcode, id_etq, fl_status, usr_create, dt_create) values ('$cod_nf', '$cod_nf_item', '$cod_rec', '$codigo', '$id_etq', 'A', '$id', '$date')";
        $res_barcode = mysqli_query($link,$insert_barcode);

        $upd_etq = "update tb_etiqueta set fl_status = 'T', usr_conf = '$id', dt_conf = '$date' where id = '$id_etq'";
        $res_etq = mysqli_query($link,$upd_etq);

    }else{

        $array_estoque = array(
            'total_conf'    => "Todos os itens desse produto foram conferidos!",
        );

        echo(json_encode($array_estoque));

        exit();

    }

}else{

    $array_estoque = array(
        'total_conf'    => "Produto não faz parte da OR!",
    );

    echo(json_encode($array_estoque));
    exit();
}


$query_conf="select count(cod_nf_entrada_item) as total from tb_nf_entrada_conf where cod_rec = '$cod_rec'";
$res_conf=mysqli_query($link, $query_conf);
$tr_conf = mysqli_num_rows($res_conf);

while ($conf=mysqli_fetch_assoc($res_conf)) {
    $array_estoque = array(
        'total_conf'    => $conf['total'],
    );
}

echo(json_encode($array_estoque));
$link->close();
?>