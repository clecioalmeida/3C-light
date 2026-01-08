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
    
    $sql = "select distinct fl_status from tb_pedido_coleta where fl_status = 'M'";
    $res = mysqli_query($link,$sql);
    while ($parte=mysqli_fetch_assoc($res)) {
    	//$fl_status = $parte['fl_status'];

	    	$retorno[] = array(
				'fl_status' => $parte['fl_status'],
			);

    		

    }
	echo(json_encode($retorno));
$link->close();
?>