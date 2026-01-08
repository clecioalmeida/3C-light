<?php
	require_once("bd_class.php");
	
	$cod_sub_grupo = $_POST['cod_sub_grupo'];
    $nm_grupo = $_POST['nm_sub_grupo'];
    $cod_grupo = $_POST['cod_grupo'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "update tb_grupo set nm_grupo ='$nm_grupo', cod_grupo = '$cod_grupo' WHERE cod_sub_grupo = '$cod_sub_grupo'" or die(mysqli_error($sql));
	
	$resultado_id = mysqli_query($link, $sql);
 
if($resultado_id){
 
    echo 'Dados cadastrados com sucesso';
 
} else {
    echo 'Dados não cadastrados';

}
$link->close();

?>