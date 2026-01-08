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

 require_once 'bd_class.php';
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $nr_nf 		= $_POST['nr_nf'];
 $ds_div 		= $_POST['ds_div'];
 $ds_resp_div 	= $_POST['ds_resp_div'];
 $dt_limite_div = $_POST['dt_limite_div'];
 $dt_sol_div 	= $_POST['dt_sol_div'];
 $ds_sol_div 	= $_POST['ds_sol_div'];
 $nr_ped_sap 	= $_POST['nr_ped_sap'];

 $sql = "update tb_nf_entrada set fl_status = 'S', ds_div = '$ds_div', ds_resp_div = '$ds_resp_div', dt_limite_div = '$dt_limite_div', dt_sol_div = '$dt_sol_div', ds_sol_div = '$ds_sol_div', nr_ped_sap = '$nr_ped_sap',  usr_update = '$id', dt_update = '$date' WHERE cod_nf_entrada = '$nr_nf'";
 $resultado_id = mysqli_query($link, $sql);

 if(mysqli_affected_rows($link) > 0){ 

 	echo "Nota fiscal alterada!";

 }else{ 


 	echo "Erro no cadastro!";

 } 

 $link->close();
 ?>