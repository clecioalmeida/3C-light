<?php
	require_once('bd_class.php');
	
	$id_wms = $_POST['id_wms'];
	$cod_rec = $_POST['cod_rec'];
	$id_produto = $_POST['id_produto'];
	$id_nf = $_POST['id_nf'];
	$n_serie = $_POST['n_serie'];
 
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql_nserie = " insert into tb_nserie (id_wms, cod_rec, id_produto, id_nf, n_serie) values ('$id_wms', '$cod_rec', '$id_produto', '$id_nf', '$n_serie') ";

	$res_nserie = mysqli_query($link, $sql_nserie);

	if($res_nserie){

                echo 'Dados cadastrados com sucesso';


            } else {
                echo 'Dados não cadastrados';
            }
  
	$link->close();	
	
?>
