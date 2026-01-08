<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_dem    		= $_POST['nr_dem'];
$vlr_dem     	= str_replace(",",".",str_replace(".","",$_POST['vlr_dem']));
$nr_pedido    	= $_POST['nr_ped'];

$sql = "update tb_pedido_coleta set nr_dem = '$nr_dem',vlr_dem = '$vlr_dem' WHERE nr_pedido = '$nr_pedido'";

$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

    echo "Pedido alterado!";

}else{

    echo "Pedido não pode alterado.";

} 


$link->close();
?>