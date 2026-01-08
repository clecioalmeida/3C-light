<?php
require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$cod_estoque=$_GET['cod_estoque'];
$cont1=$_GET['cont1'];
$id_inv=$_GET['id_inv'];
$id_tar=$_GET['id_tar'];

$updt_estoque="update tb_posicao_pallet set nr_qtde = '$cont1' where cod_estoque = '$cod_estoque'";
$res_updt_pp=mysqli_query($link, $updt_estoque);

if(mysqli_affected_rows($link) > 0){

	$updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
	$res_updt=mysqli_query($link1, $updt_conf);

	if(mysqli_affected_rows($link1) > 0){

		$ins_ocorrencia="insert into tb_ocorrencias (nm_ocorrencia, tipo, fl_resp_cli, finalizadora, criticidade, prazo, fl_status, cod_origem) values ('Divergência de estoque apurada em inventário', 'A', 'N', 'N', 'M', '10', 'A', '$id_tar')";
		$res_ins=mysqli_query($link2, $ins_ocorrencia);
		$ocorrencia = mysqli_insert_id($link2);

		include "sucess_updt_pp.php";

	}else{

		include "err_updt.php";

	}


}else{

	include "err_updt.php";

}

$link->close();
?>