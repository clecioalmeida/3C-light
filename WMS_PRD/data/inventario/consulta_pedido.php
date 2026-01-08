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

$cod_inv = $_REQUEST['cod_inv'];

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql1="select t1.id, t2.cod_estoque
        from tb_inv_prog t1
        left join tb_posicao_pallet t2 on t2.ds_galpao = t1.id_galpao
        where t1.id = '$cod_inv' and (t2.ds_prateleira >= t1.id_rua_inicio and t2.ds_prateleira <= t1.id_rua_fim) and (t2.ds_coluna >= t1.id_coluna_inicio and t2.ds_coluna <= t1.id_coluna_fim) and (t2.ds_coluna >= t1.id_altura_inicio and t2.ds_coluna <= t1.id_altura_fim)";
$res_ped = mysqli_query($link, $sql1);

if(mysqli_num_rows($res_ped) > 0){
    while ($dados=mysqli_fetch_assoc($res_ped)) {
        $id=$dados['id'];
        $cod_estoque=$dados['cod_estoque'];

        $sql2="select distinct nr_pedido from tb_coleta_pedido where cod_estoque = '$cod_estoque' and fl_status <> 'E' and fl_status <> 'X'";
        $res_ped2 = mysqli_query($link, $sql2);

        if(mysqli_num_rows($res_ped2) > 0){

            $retorno[] = array(
                'info' => "0",
            );

            echo(json_encode($retorno));

        }else{

            $retorno[] = array(
                'info' => "1",
            );

            echo(json_encode($retorno));
        }
    }


}else{

    $retorno[] = array(
        'info' => "2",
    );

    echo(json_encode($retorno));

}

$link->close();
?>