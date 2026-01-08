<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_nf_item = mysqli_real_escape_string($link,$_POST['cod_nf_item']);
$cod_nf = mysqli_real_escape_string($link,$_POST['cod_nf']);
$cod_rec = mysqli_real_escape_string($link,$_POST['cod_rec']);
$cod_produto = mysqli_real_escape_string($link,$_POST['cod_produto']);
$barcode = mysqli_real_escape_string($link,$_POST['barcode']);
$nr_qtde = mysqli_real_escape_string($link,number_format($_POST['nr_qtde'],0,",",""));

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_prod="select t1.produto
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
where t2.cod_rec = '$cod_rec' and t1.produto = '$barcode'";
$res_prod=mysqli_query($link, $query_prod);
$tr_prod = mysqli_num_rows($res_prod);

if($tr_prod > 0){

    $query_init="select count(id) as total
    from tb_nf_entrada_conf
    where cod_rec = '$cod_rec'";
    $res_init=mysqli_query($link, $query_init);
    while ($init=mysqli_fetch_assoc($res_init)) {
        $count=$init['total'];
    }

    if($count < $nr_qtde){

        $insert_barcode = " insert into tb_nf_entrada_conf (cod_nf_entrada_item, cod_nf_entrada, cod_rec, barcode, usr_create, dt_create) values ('$cod_nf', '$cod_nf_item', '$cod_rec', '$barcode', '$id', now())";
        $res_barcode = mysqli_query($link,$insert_barcode);

    }else{

        $array_estoque[] = array(
            'total_conf'    => "Todos os itens foram conferidos!",
        );

        echo(json_encode($array_estoque));

        //echo "Todos os itens foram conferidos";
        exit();

    }

}else{

    $array_estoque[] = array(
        'total_conf'    => "Produto não faz parte da OR!",
    );

    //echo "Produto não faz parte da OR!";
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

?>