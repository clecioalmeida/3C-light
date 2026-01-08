<?php
require_once('modal/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_img=$_POST['id_img'];

$delete = "delete from tb_img_ocor where id = '$id_img'";
$result = mysqli_query($link,$delete);
$tr = mysqli_affected_rows($link);

if($tr > 0){

	echo "Imagem excluída com sucesso.";

}else{

	echo "Ocorreu um erro.";

}

$link->close();
?>