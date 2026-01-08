<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_vol    = $_POST['nr_vol'];
$cod_est   = $_POST['cod_est'];

$sql = "update tb_posicao_pallet set nr_volume = '$nr_vol' WHERE cod_estoque = '$cod_est'";
$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

    echo "Locação alterada com sucesso.";

}else{

    echo "Ocorreu um erro.";

} 


$link->close();
?>