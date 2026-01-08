<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_nf_item = 1;//$_POST['cod_nf_item'];
$cod_nf = 1;//$_POST['cod_nf'];
$cod_rec = 1;//$_POST['cod_rec'];
$barcode = '10000017-2';//$_POST['barcode'];
$nr_qtde = number_format('194.000',0,",","");
$array = explode('-', $barcode);
$codigo =  $array[0];
$id_etq = $array[1];

//echo "Codigo: ".$codigo." Etq: ".$id_etq."<br>";

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_prod="select t1.produto
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
where t2.cod_rec = '$cod_rec' and t1.produto = '$codigo'";
$res_prod=mysqli_query($link, $query_prod);
$tr_prod = mysqli_num_rows($res_prod);

if($tr_prod > 0){

    $query_nrqte="select t1.nr_qtde
    from tb_nf_entrada_item t1
    left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
    where t2.cod_rec = '$cod_rec' and t1.produto = '$codigo'";
    $res_nrqtde=mysqli_query($link, $query_nrqte);
    while ($nrqtde=mysqli_fetch_assoc($res_nrqtde)) {
        $qtde=$nrqtde['nr_qtde'];
    }

    $query_init="select count(barcode) as total from tb_nf_entrada_conf 
    where cod_rec = '$cod_rec' and barcode = '$codigo' and fl_status <> 'E'";
    $res_init=mysqli_query($link, $query_init);
    while ($init=mysqli_fetch_assoc($res_init)) {
        $count=$init['total'];
    }
    //echo "Conf: ".$count." Qtde: ".$qtde."<br>";
    if($count < $qtde){

        $insert_barcode = " insert into tb_nf_entrada_conf (cod_nf_entrada_item, cod_nf_entrada, cod_rec, barcode, id_etq, fl_status, usr_create, dt_create) values ('$cod_nf', '$cod_nf_item', '$cod_rec', '$codigo', '$id_etq', 'A', '1', now())";
        $res_barcode = mysqli_query($link,$insert_barcode);

    }else{

        $array_estoque[] = array(
            'total_conf'    => "Todos os itens desse produto foram conferidos!",
        );

        echo(json_encode($array_estoque));

        exit();

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