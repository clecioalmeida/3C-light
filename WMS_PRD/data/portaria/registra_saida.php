<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:../../index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_prt = $_REQUEST['id'];
	$nr_minuta = $_REQUEST['nr_minuta'];
	
	$query_status="select fl_status from tb_portaria where id = '$id_prt'";
	$res_status = mysqli_query($link, $query_status);
	while ($dados=mysqli_fetch_assoc($res_status)) {
		$fl_status = $dados['fl_status'];
	}

	if($fl_status == 'L'){
		$upd_prt = "update tb_portaria set fl_status = 'S', usr_saida = '$id', nr_minuta = '$nr_minuta', dt_saida = now() where id = '$id_prt'";
		$res_upd = mysqli_query($link, $upd_prt);
		
		if($res_upd){

			$retorno[] = array(
				'info'	=> "1",
			);
		}
	}else{

		$retorno[] = array(
				'info'	=> "0",
			);

	}	

	
		

	echo(json_encode($retorno));
$link->close();
?>