<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$sql = "select cod_almox, ds_destino, nr_qtde as saldo, dt_lancto from tb_mb51e where nr_pedido is null and fl_empresa = '$cod_cli' and nr_qtde > 0 group by cod_almox order by cod_almox";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {
	echo "cod_almox: ".$dados_nf['cod_almox']."<br>";

	$last_pedido = "select coalesce(max(nr_pedido),0) + 1 as pedido from tb_pedido_coleta";
	$res_last_pedido = mysqli_query($link, $last_pedido);
	$n_pedido = mysqli_fetch_assoc($res_last_pedido);
	$pedido_novo = $n_pedido['pedido'];

	$ins_nf = "insert into tb_pedido_coleta (nr_pedido, cod_almox, ds_destino, dt_pedido, fl_status, fl_empresa, usr_create, dt_create) values ('".$pedido_novo."', '".$dados_nf['cod_almox']."', '".$dados_nf['ds_destino']."', '".$dados_nf['dt_lancto']."', 'A', '".$cod_cli."', '".$id."', '".$date."')";
	$res_nf = mysqli_query($link1, $ins_nf);
	$nNf = mysqli_insert_id($link1);

	if(mysqli_affected_rows($link1) > 0){

		$sql_prd = "select nr_pedido_sap, sum(nr_qtde) as nr_qtde, cod_prod_cliente, nm_produto, dt_lancto, tp_unid, vl_unit from tb_mb51e where fl_empresa = '$cod_cli' and cod_almox = '".$dados_nf['cod_almox']."' and nr_qtde > 0 and nr_pedido is null group by cod_almox, cod_prod_cliente";
		$res_prd = mysqli_query($link, $sql_prd) or die(mysqli_error($link));
		while ($dados_pr=mysqli_fetch_assoc($res_prd)) {

			echo 'Pedido: '.$nNf.' cod_prod_cliente: '.$dados_pr['cod_prod_cliente'].' nr_qtde: '.$dados_pr['nr_qtde'].' cadastrado com sucesso.<br>';

			$ins_prd = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nm_produto, nr_pedido_sap, fl_status, fl_empresa, nr_qtde, vl_unit, ds_unid, usr_create, dt_create) values ('".$pedido_novo."', '".$dados_pr['cod_prod_cliente']."', '".$dados_pr['nm_produto']."', '".$dados_pr['nr_pedido_sap']."', 'A', '".$cod_cli."', '".$dados_pr['nr_qtde']."', '".$dados_pr['vl_unit']."','".$dados_pr['tp_unid']."', '".$id."', '".$date."')";
			$res_ins = mysqli_query($link2, $ins_prd);

			if(mysqli_affected_rows($link2) > 0){
				$ret_op = 'Produto '.$dados_pr['cod_prod_cliente'].' cadastrado com sucesso.<br>';

				echo $ret_op;

			}else{

				$ret_op = 'Produto '.$dados_pr['cod_prod_cliente'].' não cadastrado.<br>';

				echo $ret_op;
			}

		}

		$upd_mb = "update tb_mb51e set nr_pedido = '".$pedido_novo."' where cod_almox '".$dados_nf['cod_almox']."'";
		$res_upd = mysqli_query($link, $upd_mb);

	}else{

		echo "Erro no cadastro.";

	}
	

}

$link->close();
$link1->close();
$link2->close();
?>