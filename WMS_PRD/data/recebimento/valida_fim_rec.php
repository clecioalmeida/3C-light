<?php
session_start();  
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

if($cod_cli == "5"){

	$ds_galpao = "7";

}else if($cod_cli == "6"){

	$ds_galpao = "18";

}else if($cod_cli == "7"){

	$ds_galpao = "27";

}else if($cod_cli == "8"){

	$ds_galpao = "33";

}

$cod_rec = $_POST['cod_rec'];

$sql = "select t1.id as id_etq, t1.cod_item, t1.nr_qtde, t2.produto, t1.nr_qtde, t2.dt_validade, t2.nr_ca, t2.dt_ca, t2.nr_laudo, t2.dt_laudo, t3.id as cod_ca, t4.id as cod_laudo, t1.cod_rec
from tb_etiqueta t1
left join tb_nf_entrada_item t2 on t1.cod_rec = t2.cod_rec and t1.cod_item = t2.cod_nf_entrada_item
left join tb_ca t3 on t2.nr_ca = t3.nr_docto
left join tb_ca t4 on t2.nr_laudo = t4.nr_docto
where t1.cod_rec = '$cod_rec'
group by t1.id
order by t1.id";
$res_sql = mysqli_query($link, $sql);

if(mysqli_num_rows($res_sql) > 0){

	while ($dados=mysqli_fetch_assoc($res_sql)) {

		$ins_rec="insert into tb_posicao_pallet (produto,ds_galpao, nr_volume, nr_qtde, fl_status, fl_empresa, nr_or, dt_validade, cod_ca, cod_laudo, cod_etq, usr_create, dt_create) values ('".$dados['produto']."', '".$ds_galpao."', '1', '".$dados['nr_qtde']."', 'A', '".$cod_cli."', '".$dados['cod_rec']."', '".$dados['dt_validade']."', '".$dados['cod_ca']."', '".$dados['cod_laudo']."', '".$dados['id_etq']."', '".$id."', '".$date."')";
		$res_ins = mysqli_query($link, $ins_rec);

		if(mysqli_affected_rows($link) > 0){

			$cod_estoque = mysqli_insert_id($link);

			$upd_etq = "update tb_etiqueta set cod_estoque = '$cod_estoque' where cod_item = '".$dados['cod_item']."'";
			$res_etq = mysqli_query($link, $upd_etq);

			$ins_lg = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, ds_obs, usr_create, dt_create) values ('".$dados['cod_item']."', 'COD ESTOQUE', '".$cod_estoque."', 'RECEBIMENTO', 'RECEBIMENTO FINALIZADO', '$id', '$date')";
			$res_LG = mysqli_query($link,$ins_lg);

		}else{

			$retorno[] = array(
				'info' => "2",
			);

			echo(json_encode($retorno));

		}

	}

	$upd_or="update tb_recebimento set fl_status = 'L', usr_confere = '$id', dt_confere = '$date' where cod_recebimento = '$cod_rec'";
	$res_upd = mysqli_query($link, $upd_or);

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

}else{

	$retorno[] = array(
		'info' => "3",
	);

	echo(json_encode($retorno));

}
$link->close();
?>