<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<?php 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $nr_pedido = $_POST["nr_pedido"];
    
    $sql = "select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
    $res = mysqli_query($link,$sql);
    while ($parte=mysqli_fetch_assoc($res)) {
    	$fl_status = $parte['fl_status'];
	    if($fl_status != 'P'){

	    	$retorno[] = array(
				'info' => "1",
			);

    		echo(json_encode($retorno));

    		exit();
	    }else{

	    	$sql_ped = "update tb_pedido_coleta set fl_status = 'X' where nr_pedido = '$nr_pedido'";
			$ped = mysqli_query($link,$sql_ped);

			$sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '$id', dt_lib_exp = now(), fl_status = 'X' where nr_pedido = '$nr_pedido'";
			$prd = mysqli_query($link,$sql_prd);

			$sql_col = "update tb_coleta_pedido set fl_status = 'X' where nr_pedido = '$nr_pedido'";
			$col = mysqli_query($link,$sql_col);

			if($sql_ped){
				$retorno[] = array(
				'info' => "0",
				);

				echo(json_encode($retorno));
			}
	    }

    }
	
$link->close();
?>