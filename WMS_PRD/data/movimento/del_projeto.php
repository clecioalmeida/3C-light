<?php 
  require_once('bd_class_dsv.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $cod_estoque = mysqli_real_escape_string($link, $_POST["cod_estoque_proj"]);

    $upd_proj = "update tb_posicao_pallet set ds_projeto = NULL where cod_estoque = '$cod_estoque'";
    $res_proj = mysqli_query($link,$upd_proj);

    if(mysqli_affected_rows($link)){

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
$link->close();
?>