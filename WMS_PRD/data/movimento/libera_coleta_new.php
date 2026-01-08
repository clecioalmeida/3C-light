<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

if (isset($_POST["nr_ped"])) {

	$id_sep = $_POST["id_sep"];

	foreach ($_POST["nr_ped"] as $nr_pedido) {

		$sql = "update tb_pedido_coleta set fl_status = 'M', usr_init_col = '$id_sep', dt_init_col = '$date' WHERE nr_pedido = '$nr_pedido'" or die(mysqli_error($sql));
		$resultado_id = mysqli_query($link, $sql);

		$sql_prd = "update tb_pedido_coleta_produto set fl_status = 'M' WHERE nr_pedido =  '$nr_pedido'" or die(mysqli_error($sql));
		$res_prd = mysqli_query($link1, $sql_prd);

		if(mysqli_affected_rows($link) > 0){ 


			echo "Coleta iniciada!";


		}else{ 


			echo "Erro!";

		} 

	}
}

//$nr_pedido =implode("','",(array)$_POST['onda']);
//echo $nr_pedido;

//foreach($nr_pedido as $value){
//$pedido=implode(',',$nr_pedido);
//	echo "Pedido:".$value;
//}

//if (isset($_POST['onda'])) {

//	$i = 0;
//	foreach ($_POST as $val) {
//	    $pedido = $_POST['onda'][$i];
//$age = $_POST['age'][$i];
//	    echo "Pedido:".$pedido;
//mysql_query("INSERT INTO users (name, age) VALUES ('$name', '$age')");
//	    $i++;
//	}
//}

/*
$sql_status="select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
$resultado_status = mysqli_query($link1, $sql_status);
while ($dados_upd=mysqli_fetch_assoc($resultado_status)) {
$fl_status=$dados_upd['fl_status'];

}

if($fl_status == 'C'){

$sql = "CALL prc_coleta('$nr_pedido', '$id')";
$res_prc = mysqli_query($link, $sql);
$res_col=mysqli_num_rows($res_prc);

if($res_col > 0){

$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col = now(), fl_status = 'M' where nr_pedido = '$nr_pedido'";
$result_upd = mysqli_query($link1, $upd_col);

$upd_prd = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nr_pedido'";
$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

//$upd_ped = "update tb_coleta_pedido fl_status = 'M' where nr_pedido = '$nr_pedido'";
//$result_ped = mysqli_query($link1, $upd_ped);

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
 */
$link->close();
?>