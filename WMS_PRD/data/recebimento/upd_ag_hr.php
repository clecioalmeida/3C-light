 <?php
 session_start();
 ?>
 <?php

 if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

 	header("Location:../../index.php");
 	exit;

 } else {

 	$id         = $_SESSION["id"];
 	$cod_cli    = $_SESSION['cod_cli'];
 }
 ?>
 <?php
 date_default_timezone_set('America/Sao_Paulo');
 $date = date("Y-m-d H:i:s");
 $dt_upd = date("Y-m-d");

 require_once 'bd_class.php';
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $cod_rec 			= $_POST['cod_rec'];
 $hr_chegada 		= $_POST['dt_chegada']." ".$_POST['hr_chegada'];
 $init_descarga 	= $_POST['dt_chegada']." ".$_POST['init_descarga'];
 $fim_descarga 		= $_POST['dt_chegada']." ".$_POST['fim_descarga'];
 $t_descarregamento = $_POST['t_descarregamento'];
 $t_permanece 		= $_POST['t_permanece'];
 $fl_status 		= $_POST['fl_status'];

 $sql = "update tb_recebimento_ag set fl_status = '$fl_status', hr_chegada = '$hr_chegada',init_descarga = '$init_descarga',fim_descarga = '$fim_descarga',t_descarregamento = '$t_descarregamento',t_permanece = '$t_permanece', usr_update = '$id', dt_update = '$date' WHERE cod_recebimento = '$cod_rec'";
 $resultado_id = mysqli_query($link, $sql);

 if(mysqli_affected_rows($link) > 0){ 

 		echo "Ordem de recebimento alterada!".$hr_chegada;

 }else{ 


 	echo "Erro no cadastro!";

 } 

 $link->close();
 ?>