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

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);


if(isset($_POST['id_tar'])){

    $produto = mysqli_real_escape_string($link,$_POST['produto']);
    $cod_estoque = mysqli_real_escape_string($link,$_POST['cod_estoque']);
    $id_tar = mysqli_real_escape_string($link,$_POST['id_tar']);

    $query_init="select t1.nr_qtde, coalesce(t2.cont_1,0) as cont_1 from tb_inv_tarefa t1
    left join tb_inv_conf t2 on t1.id = t2.id_tar
    where t1.id = '$id_tar'";
    $res_init=mysqli_query($link, $query_init);
    while ($init=mysqli_fetch_assoc($res_init)) {
        $cont_1=$init['cont_1'];
        $nr_qtde=$init['nr_qtde'];
    }

    if($cont_1 > 0){

        $query_conf="update tb_inv_conf set cont_1 = '$cont_1'+1, dt_conf_1 = now(), conf_1 = '$id', user_update = '$id', dt_update = now()";
        $res_conf=mysqli_query($link, $query_conf);

        if($res_conf){

            $query_init="select coalesce(cont_1,0) as cont_1 from tb_inv_conf
            where id_tar = '$id_tar'";
            $res_init=mysqli_query($link, $query_init);
            while ($init=mysqli_fetch_assoc($res_init)) {
                $cont_1=$init['cont_1'];
            }

            $array_estoque[] = array(
                'info'    => $cont_1,

            );

        }else{

            $array_estoque[] = array(
                'info'    => "Erro.",
            );

        }

    }else if($cont_1 == 0){

        $query_conf="insert into tb_inv_conf (id_tar, cont_1, dt_conf_1, conf_1, user_create, dt_create) values ('$id_tar', '$cont_1'+1, now(), '$id', '$id', now())";
        $res_conf=mysqli_query($link, $query_conf);

        if($res_conf){

            $query_init="select coalesce(cont_1,0) as cont_1 from tb_inv_conf
            where id_tar = '$id_tar'";
            $res_init=mysqli_query($link, $query_init);
            while ($init=mysqli_fetch_assoc($res_init)) {
                $cont_1=$init['cont_1'];
            }

            $array_estoque[] = array(
                'info'    => $cont_1,
            );

        }else{

            $array_estoque[] = array(
                'info'    => "Erro.",
            );

        }

    }
}
$link->close();
    ?>