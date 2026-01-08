<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
    $cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php

require_once 'bd_class_dsv.php';

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
if(isset($_POST['id_produto'])){

	$id_produto = $_POST['id_produto'];


}else{

	$id_produto = "";

}

$id_inv 		= $_POST['id_inv'];
$id_galpao_inv 	= $_POST['id_galpao_inv'];
$dt_tarefa		= $_POST['dt_tarefa'];
$id_rua 		= strtoupper($_POST['inv_rua']);
$id_coluna 		= $_POST['inv_mod'];
$id_altura 		= $_POST['inv_alt'];
$conf1 			= $_POST['conf1'];
$conf2 			= $_POST['conf2'];
$qtde1 			= $_POST['qtde1'];
$qtde2 			= $_POST['qtde2'];
$nr_vol 		= $_POST['nr_vol'];

if ($qtde1 == "" || $qtde2 == "" || $qtde1 != $qtde2 || $id_produto == '') {

	echo '<h3 style="background-color: #B22222;color:white">Preencha todas as informações.</h3>';

} else {

	$ins_tar = "insert into tb_inv_tarefa (id_inv, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_volume, fl_status, fl_empresa, fl_tipo, user_create, dt_create) values ('$id_inv', '$id_produto', '$id_galpao_inv',  '$id_rua', '$id_coluna', '$id_altura', '$nr_vol', 'A', '$cod_cli', 'N', '$id', '$dt_tarefa')";
	$res_ins_tar = mysqli_query($link, $ins_tar);
	$novatar = mysqli_insert_id($link);

	$ins_conf = "insert into tb_inv_conf (id_tar, cont_1, cont_2, dt_conf_1, dt_conf_2, conf_1, conf_2, user_create, dt_create) values ('$novatar', '$qtde1',  '$qtde2', now(), now(), '$conf1', '$conf2', '$id', '$dt_tarefa')";
	$res_ins_conf = mysqli_query($link1, $ins_conf);

	if(mysqli_affected_rows($link1) > 0){

		$sql_tar = "select t1.id, t1.id_produto, t1.id_galpao, t1.id_rua, t1.id_coluna, t1.id_altura
		from tb_inv_tarefa t1
		left join tb_produto t2 on t1.id_produto = t2.cod_produto
		where t1.id = '$novatar'";
		$res_tar = mysqli_query($link1, $sql_tar);
		$tar = mysqli_fetch_assoc($res_tar);
		$id_produto = $tar['id_produto'];
		$id_galpao = $tar['id_galpao'];
		$id_rua = $tar['id_rua'];
		$id_coluna = $tar['id_coluna'];
		$id_altura = $tar['id_altura'];

		echo '<h3 style="background-color: #009933;color:white">Tarefa: '.$id_produto.', local: Rua: '.$id_rua.' - Coluna: '.$id_coluna.' - Altura: '.$id_altura.'</h3>';

	}else{



	}
}


/*while ($tar = mysqli_fetch_assoc($res_tar)) {
	$array_tar[] = array(
		'id' => $tar['id'],
		'id_produto' => $tar['id_produto'],
		'id_galpao' => $tar['id_galpao'],
		'id_rua' => $tar['id_rua'],
		'id_coluna' => $tar['id_coluna'],
		'id_altura' => $tar['id_altura'],
	);
}

echo (json_encode($array_tar));*/

$link->close();
?>