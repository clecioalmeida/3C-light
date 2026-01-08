<?php
require_once('data/movimento/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$res = array('erro' => false);

$action='consulta';

if(isset($_GET['action'])){
	$action=$_GET['action'];


}

if($action == 'consulta'){

	$sql_torre = "select * from tb_tipo_torre";
	$res_torre = mysqli_query($link, $sql_torre);
	$tipo_torre=array();

	while ($torre=mysqli_fetch_assoc($res_torre)) {

		array_push($tipo_torre, $torre);
	}

	$res['tipo_torre'] = $tipo_torre;
}

 $link->close();

 header("Content-type: application/json");
 echo json_encode($res);
 die();
?>