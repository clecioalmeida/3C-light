<?php
    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $cod_inv = $_REQUEST['cod_inv'];
    
    $sql = "select fl_status from tb_inv_prog where id = '$cod_inv'";
    $res = mysqli_query($link,$sql);
    while ($parte=mysqli_fetch_assoc($res)) {
    	$fl_status = $parte['fl_status'];
	    if($fl_status != 'A'){

	    	$retorno[] = array(
				'info' => "1",
			);

    		echo(json_encode($retorno));

    		exit();
	    }else{

	    	$retorno[] = array(
				'info' => "0",
			);

			echo(json_encode($retorno));
	    }
    }	
$link->close();
?>