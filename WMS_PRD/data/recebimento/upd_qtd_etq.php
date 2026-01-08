<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_qt    = $_POST['nr_qt'];
$id_etq   = $_POST['id_item'];

$sql = "update tb_etiqueta set nr_qtde = '$nr_qt' WHERE id = '$id_etq'";
$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

    echo "Etiqueta alterada com sucesso.";

}else{

    echo "Ocorreu um erro.";

} 


$link->close();
?>