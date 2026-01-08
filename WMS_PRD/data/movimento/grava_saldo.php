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

	$nr_pedido = $_POST['start_col'];

	$sql_status="select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
    $resultado_status = mysqli_query($link, $sql_status);
    while ($dados_upd=mysqli_fetch_assoc($resultado_status)) {
        $fl_status=$dados_upd['fl_status'];

    }

    if($fl_status == 'C'){

    	$sql_prd="select distinct c.produto, c.nr_qtde
			from tb_pedido_coleta_produto c
			left join tb_nserie n on c.nr_pedido = n.cod_pedido and c.produto = n.id_produto
			where nr_pedido = '$nr_pedido'";
    	$res_prd = mysqli_query($link, $sql_prd);

    	while ($dados_prd=mysqli_fetch_assoc($res_prd)) {
	        $array_parte[] = array(
				'produto' => $dados_prd['produto'],
				'nr_qtde' => $dados_prd['nr_qtde'],
			);

			echo(json_encode($array_parte));

	    }
/*
	
		$sql = "CALL prc_coleta('$nr_pedido', '$id')";
		$res_prc = mysqli_query($link, $sql);	
		$res_col=mysqli_num_rows($res_prc);
		
		if($res_col > 0){

			$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col = now(), fl_status = 'M' where nr_pedido = '$nr_pedido'";
			$result_upd = mysqli_query($link1, $upd_col);

			$upd_prd = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nr_pedido'";
			$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

			//$upd_ped = "update tb_coleta_pedido fl_status = 'M' where nr_pedido = '$nr_pedido'";
			//$result_ped = mysqli_query($link1, $upd_ped);

			$retorno[] = array(
			'info' => "0",
			);

			echo(json_encode($retorno));

		}else{

			$retorno[] = array(
			'info' => "1",
			);

			echo(json_encode($retorno));

		}

*/
	}else{

		$retorno[] = array(
			'info' => "3",
			);

			echo(json_encode($retorno));
	}

$link->close();
?>