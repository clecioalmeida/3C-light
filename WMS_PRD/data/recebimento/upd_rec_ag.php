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
 $link1 = $objDb->conecta_mysql();

 $cod_recebimento 	= $_POST['upd_rec'];
 $ds_motivo 		= $_POST['ds_motivo'];

 $sql = "update tb_recebimento_ag set fl_status = 'R',ds_motivo = '$ds_motivo', usr_update = '$id', dt_update = '$date' WHERE cod_recebimento = '$cod_recebimento'";
 $resultado_id = mysqli_query($link, $sql);

 if(mysqli_affected_rows($link) > 0){ 

 	$sql_jan = "update tb_janela set fl_status = 'A', cod_rec = 'NULL', usr_update = '$id', dt_update = '$date' WHERE cod_rec = '$cod_recebimento'";
 	$res_jan = mysqli_query($link1, $sql_jan);

 	if(mysqli_affected_rows($link1) > 0){

 		echo "Ordem de recebimento alterada e janela liberada!";

 	}else{


 		echo "Erro no cadastro!";

 	}

 }else{ 


 	echo "Erro no cadastro!";

 } 

 $link->close();
 ?>