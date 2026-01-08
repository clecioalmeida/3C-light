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

    $cod_rec = $_POST["cod_rec"];
    
    $sql = "select fl_status from tb_recebimento where cod_recebimento = '$cod_rec'";
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