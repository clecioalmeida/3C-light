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
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$cod_estoque = mysqli_real_escape_string($link,$_POST['cod_estoque']);
$nr_new_qtde = mysqli_real_escape_string($link,$_POST['nr_new_qtde']);
$cod_col = mysqli_real_escape_string($link,$_POST['cod_col']);
$pedido = mysqli_real_escape_string($link,$_POST['id_pedido']);
$cod_produto = mysqli_real_escape_string($link,$_POST['cod_prod']);

$upd_prd="update tb_pedido_coleta_produto set nr_qtde = '$nr_new_qtde' where nr_pedido = '$pedido' and produto = '$cod_produto'";
$res_upd=mysqli_query($link, $upd_prd);

$upd_col="update tb_coleta_pedido set nr_qtde_col = '$nr_new_qtde' where cod_estoque = '$cod_estoque'";
$res_col=mysqli_query($link1, $upd_col);

$upd_pos="update tb_posicao_pallet set fl_status = 'Q' where cod_estoque = '$cod_estoque'";
$res_pos=mysqli_query($link1, $upd_pos);

$ins="insert into tb_ocorrencias (nm_ocorrencia, tipo, fl_resp_cli, finalizadora, criticidade, dt_abertura, fl_status, cod_origem, nm_depto, user_create, dt_create) values ('Divergência de estoque apurada durante o picking, informado codigo do estoque', 'A', 'N', 'N', 'A', now(), 'A', '$cod_estoque', 'Conferência', '$id', now())";
$res_ins=mysqli_query($link2, $ins);

if($res_col && $res_upd && $res_ins && $res_pos){

    $retorno[] = array(
        'info' => 0,
    );

    echo(json_encode($retorno));

}else{

    $retorno[] = array(
        'info' => 1,
    );

    echo(json_encode($retorno));

}

$link->close();
?>