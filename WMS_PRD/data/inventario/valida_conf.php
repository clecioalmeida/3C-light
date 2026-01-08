<?php
require_once('bd_class_dsv.php');
$id_tar = $_GET['id_tar'];
$id_conf = $_GET['id_conf'];
$cod_estoque = $_GET['cod_estoque'];
$id_inv = $_GET['id_inv'];

$objDb = new db();
$link = $objDb->conecta_mysql();

$query_conf="select t1.nr_qtde, t2.cont_1, t2.cont_2, t2.cont_3 
			from tb_inv_tarefa t1 
			left join tb_inv_conf t2 on t1.id = t2.id_tar 
			where t2.id = '$id_conf'";
 $res_conf=mysqli_query($link, $query_conf);

 while ($dados_conf = mysqli_fetch_assoc($res_conf)) {
 	$nr_qtde=$dados_conf['nr_qtde'];
 	$cont_1=$dados_conf['cont_1'];
 	$cont_2=$dados_conf['cont_2'];
 	$cont_3=$dados_conf['cont_3'];

 }

 $cont1 = ($cont_1 + $cont_2 + $cont_3) / 3;
 $cont2 = ($cont_1 + $cont_2) / 2;

 if($nr_qtde == $cont2){

 	$updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
 	$res_updt=mysqli_query($link, $updt_conf);

 	if(mysqli_affected_rows($link) > 0){

 		include"sucess_updt.php";

 	}else{

 		include"err_updt.php";

 	}

 }elseif($nr_qtde == $cont1){

 	$updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
 	$res_updt=mysqli_query($link, $updt_conf);

 	if(mysqli_affected_rows($link) > 0){

 		include"sucess_updt.php";

 	}else{

 		include"err_updt.php";

 	}

 }elseif($nr_qtde != $cont1 && $cont1 == $cont2){

 	include"err_qtde.php";

 }elseif($cont_1 != $cont_3 && $cont_1 != $cont_2 && $cont_2 != $cont_3){

 	include"err_cont.php";

 }

$link->close();
?>