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

$cod_rec = mysqli_real_escape_string($link,$_POST['cod_rec']);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);
    
    $query_status="select count(id) as total from tb_nf_entrada_conf where cod_rec = '$cod_rec' and fl_status = 'A'";
    $res_status=mysqli_query($link, $query_status);
    while ($status=mysqli_fetch_assoc($res_status)) {
        $status_conf=$status['total'];
    }

    $query_nrqte="select sum(t1.nr_qtde) as nr_qtde
    from tb_nf_entrada_item t1
    left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
    where t2.cod_rec = '$cod_rec' and t1.fl_status <> 'E'";
    $res_nrqtde=mysqli_query($link, $query_nrqte);
    while ($nrqtde=mysqli_fetch_assoc($res_nrqtde)) {
        $qtde=$nrqtde['nr_qtde'];
    }

    $query_init="select count(t1.barcode) as total
    from tb_nf_entrada_conf t1
    left join tb_nf_entrada_item t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
    left join tb_nf_entrada t3 on t1.cod_rec = t3.cod_rec
    where t1.cod_rec = '$cod_rec' and t1.fl_status <> 'E'";
    $res_init=mysqli_query($link, $query_init);
    while ($init=mysqli_fetch_assoc($res_init)) {
        $count=$init['total'];
    }

    if($count = $qtde && $status_conf > 0){

        $upd_nf = "update tb_nf_entrada_conf set fl_status = 'M' where cod_rec = '$cod_rec' and fl_status = 'A'";
        $res_upd_nf = mysqli_query($link,$upd_nf);

        $upd_nf_ent="update tb_nf_entrada set fl_status = 'M' where cod_rec = '$cod_rec' and fl_status = 'A'";
        $res_nf_ent = mysqli_query($link,$upd_nf_ent);

        $upd_or = "update tb_recebimento set fl_status = 'M' where cod_recebimento = '$cod_rec' and fl_status = 'A'";
        $res_upd_or = mysqli_query($link,$upd_or);

        $array_estoque[] = array(
            'fin_conf'    => "Conferência finalizada com sucesso!",
        );

        echo(json_encode($array_estoque));


    }else{

        $array_estoque[] = array(
            'fin_conf'    => "Ainda existem produtos a conferir!",
        );

        echo(json_encode($array_estoque));

    
$link->close();
?>