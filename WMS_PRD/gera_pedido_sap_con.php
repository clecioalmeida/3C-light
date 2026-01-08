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
$link3 = $objDb->conecta_mysql();

/*$translate = array(
	0 => "Sun",
	1 => "Mon",
	2 => "Tue",
	3 => "Wed",
	4 => "Thu",
	5 => "Fri",
	6 => "Sat",
);*/

$sql_prd = "select distinct t2.cod_prod_cliente, coalesce(t2.cod_produto,0) as cod_produto, t1.nm_produto 
from tb_mb51e t1 
left join tb_produto t2 on t1.cod_prod_cliente = t2.cod_prod_cliente 
where t1.nr_pedido is null and t1.fl_empresa = '$cod_cli' 
group by t2.cod_prod_cliente";
$res_prd = mysqli_query($link, $sql_prd) or die(mysqli_error($link));
while ($dados_prd=mysqli_fetch_assoc($res_prd)) {

	if($dados_prd['cod_produto'] == 0){

		$ins_prd = "insert into tb_produto (
			cod_prod_cliente, nm_produto, fl_status
			) values (
				'".$dados_prd['cod_prod_cliente']."','".$dados_prd['nm_produto']."', 'A'
				)";
		$res_ins = mysqli_query($link, $ins_prd) or die(mysqli_error($link));

		if(mysqli_affected_rows($link) > 0){

			echo "Produto cadastrado.<br>";

		}else{

			echo "Erro no cadastro.<br>";

		}

	}else{

		echo "Cadastro já existe.<br>";

	}

}

$sql = "select t1.cod_almox, t1.nr_qtde as saldo, t1.dt_lancto, t1.doc_material 
from tb_mb51e t1
where t1.nr_pedido is null and t1.fl_empresa = '$cod_cli' 
group by t1.doc_material order by t1.doc_material";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {
	echo "doc_material: ".$dados_nf['doc_material']."-".$dados_nf['cod_almox']."<br>";

	$last_pedido = "select coalesce(max(nr_pedido),0) + 1 as pedido from tb_pedido_coleta";
	$res_last_pedido = mysqli_query($link, $last_pedido);
	$n_pedido = mysqli_fetch_assoc($res_last_pedido);
	$pedido_novo = $n_pedido['pedido'];

	//INCLUSÃO DE PEDIDO E PRODUTOS DO PEDIDO

	$ins_nf = "insert into tb_pedido_coleta (
		nr_pedido, doc_material, cod_almox, dt_pedido, fl_status, fl_empresa, usr_create, dt_create
		) values (
			'".$pedido_novo."', '".$dados_nf['doc_material']."', '".$dados_nf['cod_almox']."',
			'".$dados_nf['dt_lancto']."','A', '".$cod_cli."', '".$id."', '".$date."'
			)";
	$res_nf = mysqli_query($link1, $ins_nf);
	$nNf = mysqli_insert_id($link1);

	if(mysqli_affected_rows($link1) > 0){

		$sql_prd = "select doc_material, nr_pedido_sap, (sum(nr_qtde)*-1) as nr_qtde, cod_prod_cliente, nm_produto, dt_lancto,
		ds_kva, ds_lp, ds_fabr, ds_enr, ds_ano, ds_serial  
		from tb_mb51e 
		where fl_empresa = '$cod_cli' and doc_material = '".$dados_nf['doc_material']."' and nr_pedido is null 
		group by cod_prod_cliente";
		$res_prd = mysqli_query($link, $sql_prd) or die(mysqli_error($link));
		while ($dados_pr=mysqli_fetch_assoc($res_prd)) {

			echo 'Pedido: '.$pedido_novo.' doc_material: '.$dados_pr['doc_material'].' cod_prod_cliente: '.$dados_pr['cod_prod_cliente'].' nr_qtde: '.$dados_pr['nr_qtde'].' cadastrado com sucesso.<br>';

			$ins_prd = "insert into tb_pedido_coleta_produto (
				nr_pedido, produto, nm_produto, fl_status, fl_empresa, nr_qtde, ds_kva, ds_lp, ds_serial, ds_fabr, ds_ano, 
				ds_enr, usr_create, dt_create
				) values (
					'".$pedido_novo."', '".$dados_pr['cod_prod_cliente']."', '".$dados_pr['nm_produto']."', 'A', 
					'".$cod_cli."', '".$dados_pr['nr_qtde']."', '".$dados_pr['ds_kva']."', '".$dados_pr['ds_lp']."', '".$dados_pr['ds_serial']."',
					'".$dados_pr['ds_fabr']."', '".$dados_pr['ds_ano']."', '".$dados_pr['ds_enr']."', '".$id."', '".$date."'
					)";
			$res_ins = mysqli_query($link2, $ins_prd);

			if(mysqli_affected_rows($link2) > 0){
				$ret_op = 'Produto '.$dados_pr['cod_prod_cliente'].' cadastrado com sucesso.<br>';

				echo $ret_op;

			}else{

				$ret_op = 'Produto '.$dados_pr['cod_prod_cliente'].' não cadastrado.<br>';

				echo $ret_op;
			}

		}

	}

	$upd_mb = "update tb_mb51e set 
	nr_pedido = '".$pedido_novo."' 
	where doc_material = '".$dados_nf['doc_material']."' and fl_empresa = '$cod_cli'";
	$res_upd = mysqli_query($link3, $upd_mb);

	if(mysqli_affected_rows($link3) > 0){

		echo "Alterado".$dados_nf['cod_almox']." - ".$pedido_novo.'<br>';

	}else{

		echo "Nao Alterado".$dados_nf['cod_almox']." - ".$pedido_novo.'<br>';

	}

	// FIM DA INCLUSÃO DE PEDIDOS E PRODUTOS DO PEDIDO

}

$link->close();
$link1->close();
$link2->close();
$link3->close();
?>