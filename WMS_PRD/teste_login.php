<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id     	= $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
  $cnpj     = $_SESSION["nr_cnpj"];
  $ds_oper 	= $_SESSION['ds_oper'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

//require_once("bd_class_site.php");
//$objDb = new db();
//$link = $objDb->conecta_mysql(); 

echo "id: ".$id."<br>";
echo "cod_cli: ".$cod_cli."<br>";
echo "cnpj: ".$cnpj."<br>";
echo "ds_oper: ".$ds_oper."<br>";

/*
$ds_nome 			= $_POST['ds_nome'];
$ds_usuario 		= $_POST['ds_usuario'];
$id_emitente 		= $_POST['id_emitente'];
$dados_cli 			= explode("-", $_POST['id_emitente']);
$id_cli				= $dados_cli[0];
$id_oper			= $dados_cli[1];
$ds_senha 			= password_hash($_POST['ds_senha'], PASSWORD_DEFAULT);
$nr_cnpj_transp 	= $cnpj;

$sql = "INSERT INTO tb_acesso (ds_nome, ds_usuario, nr_cnpj_transp, nr_cnpj_cliente, ds_senha, id_oper, fl_status, usr_create, dt_create) VALUES ('$ds_nome', '$ds_usuario', '$cod_emp', '$id_cli', '$ds_senha', '$id_oper', 'A','$id', '$date')";

$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {

	$array_parte[] = array(
		'info' => "0",
	);

} else {

	$array_parte[] = array(
		'info' => "1",
	);
}

echo (json_encode($array_parte));

$link->close();
*/
?>