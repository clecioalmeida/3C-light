<?php
	require_once('bd_class.php');
	
	$cod_dpto = $_POST['cod_dpto'];
    $nm_dpto = $_POST['nm_dpto'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

     $sql = "update tb_dpto set nm_dpto ='$nm_dpto' WHERE cod_dpto = '$cod_dpto'" or die(mysqli_error($sql));
	
	$resultado_id = mysqli_query($link, $sql);
 
if($resultado_id){
 
    echo 'Dados cadastrados com sucesso';
 
} else {
    echo 'Dados não cadastrados';
}
$link->close();

?>