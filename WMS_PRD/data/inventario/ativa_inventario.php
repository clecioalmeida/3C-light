<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id = $_SESSION["id"];
}
?>
<?php

require_once('bd_class.php');

$cod_inv = $_POST['cod_inv'];

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

/*$sql1="select t1.*, t2.cod_estoque
from tb_inv_prog t1
left join tb_posicao_pallet t2 on t2.ds_galpao = t1.id_galpao and t2.ds_prateleira >= t1.id_rua_inicio
and t2.ds_prateleira <= t1.id_rua_fim and t2.ds_coluna >= t1.id_coluna_inicio and t2.ds_coluna <= t1.id_coluna_fim
where t1.id = '$cod_inv'";
$res_ped = mysqli_query($link, $sql1);
while ($dados=mysqli_fetch_assoc($res_ped)) {

    $id_inv         = $dados['id'];
    $cod_estoque    = $dados['cod_estoque'];

    if($cod_estoque != ''){

        $sql3="update tb_posicao_pallet set fl_bloq = 'S'
        where cod_estoque = '$cod_estoque'";
        $res_upd = mysqli_query($link1, $sql3);

    }

}*/

$sql3 = "update tb_inv_prog set fl_status = 'P'
where id = '$cod_inv'";
$res_upd = mysqli_query($link, $sql3);

if(mysqli_affected_rows($link) > 0){

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


$link->close();
?>