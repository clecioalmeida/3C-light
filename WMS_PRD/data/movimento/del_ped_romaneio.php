<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_ped = $_POST["nr_ped"];

$upd_rom = "update tb_pedido_coleta set nr_minuta = NULL where nr_pedido = '$nr_ped'";
$res_rom = mysqli_query($link,$upd_rom);

if(mysqli_affected_rows($link)){

  echo "Pedido excluído do romaneio";

}else{

    echo "Erro na exclusão do pedido do romaneio";

}

$link->close();
?>