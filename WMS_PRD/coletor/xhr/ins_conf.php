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

$cod_nf_item = $_POST['cod_nf_item'];
$cod_nf = $_POST['cod_nf'];
$cod_rec = $_POST['cod_rec'];
$barcode = $_POST['barcode'];
$nr_qtde = number_format($_POST['nr_qtde'],0,",","");
$array = explode('-', $barcode);
$codigo =  $array[0];
$id_etq = $array[1];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_prod="select t1.produto
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
where t2.cod_rec = '$cod_rec' and t1.produto = '$codigo'";
$res_prod=mysqli_query($link, $query_prod);
$tr_prod = mysqli_num_rows($res_prod);

if($tr_prod > 0){

    $sql_etq ="select id
    from tb_etiqueta
    where id = '$id_etq' and fl_status = 'T'";
    $res_id=mysqli_query($link, $sql_etq);

    if(mysqli_num_rows($res_id) > 0){

        $array_estoque[] = array(
            'total_conf'    => "Etiqueta já conferida!",
        );

        echo(json_encode($array_estoque));
        exit();

    }else{

        $query_nrqte="select SUM(t1.nr_volume) as nr_volume
        from tb_nf_entrada_item t1
        left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
        where t2.cod_rec = '$cod_rec' and t1.produto = '$codigo'";
        $res_nrqtde=mysqli_query($link, $query_nrqte);
        while ($nrqtde=mysqli_fetch_assoc($res_nrqtde)) {
            $qtde=$nrqtde['nr_volume'];
        }

        $query_init="select count(barcode) as total from tb_nf_entrada_conf 
        where cod_rec = '$cod_rec' and barcode = '$codigo' and fl_status <> 'E'";
        $res_init=mysqli_query($link, $query_init);
        while ($init=mysqli_fetch_assoc($res_init)) {
            $count=$init['total'];
        }

        if($count < $qtde){

            $insert_barcode = "insert into tb_nf_entrada_conf (cod_nf_entrada_item, cod_nf_entrada, cod_rec, barcode, id_etq, fl_status, usr_create, dt_create) values ('$cod_nf', '$cod_nf_item', '$cod_rec', '$codigo', '$id_etq', 'A', '$id', '$date')";
            $res_barcode = mysqli_query($link,$insert_barcode);

            $upd_etq = "update tb_etiqueta set fl_status = 'T', usr_conf = '$id', dt_conf = '$date' where id = '$id_etq'";
            $res_etq = mysqli_query($link,$upd_etq);

        }else{

            $array_estoque[] = array(
                'total_conf'    => "Todos os itens desse produto foram conferidos!",
            );

            echo(json_encode($array_estoque));

            exit();

        }

    }   

}else{

    $array_estoque[] = array(
        'total_conf'    => "Produto não faz parte da OR!",
    );

    echo(json_encode($array_estoque));
    exit();
}


$query_conf="select count(cod_nf_entrada_item) as total from tb_nf_entrada_conf where cod_rec = '$cod_rec'";
$res_conf=mysqli_query($link, $query_conf);
$tr_conf = mysqli_num_rows($res_conf);

while ($conf=mysqli_fetch_assoc($res_conf)) {
    $array_estoque[] = array(
        'total_conf'    => $conf['total'],
    );
}

echo(json_encode($array_estoque));
$link->close();
?>