<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:../../index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido = mysqli_real_escape_string($link,$_POST['pedido']);

$query_init="select sum(nr_qtde_conf) as total_qtde, sum(nr_qtde_col) as total_conf
from tb_coleta_pedido
where nr_pedido = '$pedido'";
$res_init=mysqli_query($link, $query_init);

while ($init=mysqli_fetch_assoc($res_init)) {
    $total=$init['total_conf'];
    $qtde=$init['total_qtde'];
}

if($total == $qtde){
	$upd_col="update tb_coleta_pedido set fl_status = 'F' where nr_pedido = '$pedido'";
	$res_upd_col=mysqli_query($link, $upd_col);

	$upd_prd="update tb_pedido_coleta_produto set fl_status = 'F', usr_fim_coleta = '$id', dt_fim_coleta = now() where nr_pedido = '$pedido'";
	$res_upd_prd=mysqli_query($link, $upd_prd);

	$upd_ped="update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$pedido'";
	$res_upd_ped=mysqli_query($link, $upd_ped);

	$retorno[] = array(
        'info' => 1,
    );

    echo(json_encode($retorno));

}else{

	$retorno[] = array(
	    'info' => "Ainda existem produtos a coletar.",
	);

    echo(json_encode($retorno));

}
$link->close();
?>