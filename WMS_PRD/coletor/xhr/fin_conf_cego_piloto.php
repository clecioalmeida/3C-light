<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id         = $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido     = $_POST['pedido'];

// PESQUISA QUANTIDADE DO PEDIDO E QUANTIDADE SEPARADA //

$query_ped = "select round(sum(t1.nr_qtde),0) as total_ped
from tb_pedido_coleta_produto t1
where t1.nr_pedido = '$pedido'";
$res_ped=mysqli_query($link, $query_ped);
$ped = mysqli_fetch_assoc($res_ped);
$qtde_ped = $ped['total_ped'];

$query_sep = "select sum(t2.nr_qtde) as total_conf
from tb_pedido_conferencia t2
where t2.nr_pedido = '$pedido' and coalesce(fl_status,'A') <> 'E'";
$res_sep=mysqli_query($link, $query_sep);
$sep = mysqli_fetch_assoc($res_sep);
$qtde_cnf = $sep['total_conf'];

// COMPARA QUANTIDADES ENCONTRADAS //

if($qtde_ped > $qtde_cnf){

    // PEDIDO PARCIAL //

	$retorno[] = array(
		'info' => "Quantidade não confere.",
	);

}else if($qtde_ped == $qtde_cnf){

    // QUANTIDADES CONFEREM  - CRIA ARRAY COM TOTAL SEPARADO POR PRODUTO //

	$select_dest = "SELECT produto, sum(nr_qtde) as qtde_conf FROM tb_pedido_conferencia WHERE nr_pedido = '$pedido' group by produto";
	$res_dest = mysqli_query($link,$select_dest);

	while ($dest=mysqli_fetch_assoc($res_dest)) {

		$qtde_conf  = $dest['qtde_conf'];
		$produto    = $dest['produto'];

        // GRAVA SEPARAÇÃO NA TABELA COM PRODUTOS DO PEDIDO //

		$sql_prd = "update tb_pedido_coleta_produto set fl_status = 'X', nr_qtde_conf = '$qtde_conf', usr_fim_coleta = '$id', dt_fim_coleta = '$date' where produto = '$produto' and nr_pedido = '$pedido'";
		$res_prd = mysqli_query($link, $sql_prd);

	}

    //ATUALIZA AS TABELAS DE PEDIDO E DE COLETA //

	$upd_col="update tb_coleta_pedido set fl_status = 'X', usr_col = '$id', dt_col = '$date' where nr_pedido = '$pedido'";
	$res_upd_col=mysqli_query($link, $upd_col);

	$upd_ped="update tb_pedido_coleta set fl_status = 'X' where nr_pedido = '$pedido'";
	$res_upd_ped=mysqli_query($link, $upd_ped);

    // VALIDA SE A TABELA FOI ALTERADA //

	if(mysqli_affected_rows($link) > 0){

		$retorno = array(
			'info' => 1,
		);

	}else{

		$retorno = array(
			'info' => 2,
		);

	}

}else{

	$retorno = array(
		'info' => 2,
	);
}

echo(json_encode($retorno));

$link->close();
?>