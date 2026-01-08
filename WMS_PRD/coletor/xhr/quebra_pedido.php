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

$pedido = mysqli_real_escape_string($link,$_POST['pedido']);

$query_init="select sum(nr_qtde_conf) as total_qtde, sum(nr_qtde_col) as total_conf
from tb_coleta_pedido
where nr_pedido = '$pedido'";
$res_init=mysqli_query($link, $query_init);

while ($init=mysqli_fetch_assoc($res_init)) {
    $total=$init['total_conf'];
    $qtde=$init['total_qtde'];
}

if($total != $qtde){

	$upd_col="update tb_coleta_pedido set fl_status = 'F' where nr_pedido = '$pedido'";
	$res_upd_col=mysqli_query($link, $upd_col);

	$upd_prd="update tb_pedido_coleta_produto set fl_status = 'F', usr_fim_coleta = '$id', dt_fim_coleta = now() where nr_pedido = '$pedido'";
	$res_upd_prd=mysqli_query($link, $upd_prd);

	$upd_ped="update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$pedido'";
	$res_upd_ped=mysqli_query($link, $upd_ped);

    $ins="insert into tb_ocorrencias (nm_ocorrencia, tipo, fl_resp_cli, finalizadora, criticidade, finalizadora, dt_abertura, fl_status, cod_origem, nm_depto, user_create, dt_create) values ('Divergência de estoque apurada durante o picking', 'A', 'N', 'A', 'N', now(), 'A', '$pedido', 'Conferência', '$id', now()";
    $res_ins=mysqli_query($link, $ins);

	$retorno[] = array(
        'info' => 1,
    );

    echo(json_encode($retorno));

}else{

	$retorno[] = array(
	    'info' => "Não foi possível registrar quebra de estoque.",
	);

    echo(json_encode($retorno));

}
$link->close();
?>