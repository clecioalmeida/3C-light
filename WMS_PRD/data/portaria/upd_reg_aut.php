<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../../index.php");
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

$cod_recebimento = $_POST['cod_rec'];

$sql = "update tb_recebimento set fl_status = 'AT', usr_autoriza = '$id', dt_autoriza = '$date' WHERE cod_recebimento = '$cod_recebimento'";
$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){ 

	echo "Entrada autorizada!";

}else{ 


	echo "Erro no cadastro!";

}

$link->close();
?>