<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_item    = $_POST['id_item'];
$nr_vol     = $_POST['nr_vol'];

$sql = "update tb_nf_entrada_item set nr_volume = '$nr_vol' WHERE cod_nf_entrada_item = '$id_item'";

$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

    echo "Volume alterado!";

}else{

    echo "Volume não pode alterado.";

} 


$link->close();
?>