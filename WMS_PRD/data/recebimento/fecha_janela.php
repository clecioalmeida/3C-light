<?php
require_once("bd_class.php");

$objDb = new db();
$link = $objDb->conecta_mysql();

$ins_jn = $_POST['ins_jn'];

$sql = "update tb_janela set fl_status = 'B' WHERE id = '$ins_jn'";

$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

    echo "Janela fechada.";

}else{

    echo "Ocorreu um erro, por favor entre em contato com o suporte.";

} 

$link->close();
?>