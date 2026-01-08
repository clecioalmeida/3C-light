<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$ds_tipo           = $_REQUEST['ds_tipo'];
    $dt_inicio          = $_REQUEST['dt_inicio'];
    $dt_fim             = $_REQUEST['dt_fim'];
    $id_galpao          = $_REQUEST['id_galpao'];
    $id_rua_inicio      = $_REQUEST['id_rua_inicio'];
    $id_rua_fim         = $_REQUEST['id_rua_fim'];
    $id_coluna_inicio   = $_REQUEST['id_coluna_inicio'];
    $id_coluna_fim      = $_REQUEST['id_coluna_fim'];
    $id_altura_inicio   = $_REQUEST['id_altura_inicio'];
    $id_altura_fim      = $_REQUEST['id_altura_fim'];
    $id_grupo           = $_REQUEST['id_grupo'];
    $id_sub_grupo       = $_REQUEST['id_sub_grupo'];
    $id_produto         = $_REQUEST['id_produto'];

    if($ds_tipo != '' && $dt_inicio != '' && $dt_fim != ''){

    	$sql_inv = "select id from tb_inv_prog where ds_tipo = '$ds_tipo' and dt_inicio = '$dt_inicio' and dt_fim = '$dt_fim' and id_galpao = '$id_galpao' and id_rua_inicio = '$id_rua_inicio' and id_coluna_inicio = '$id_coluna_inicio' and id_altura_inicio = '$id_altura_inicio' and id_rua_fim = '$id_rua_fim' and id_coluna_fim = '$id_coluna_fim' and id_altura_fim = '$id_altura_fim' and id_produto = '$id_produto' and (fl_status = 'A' or fl_status = 'P')";
		$res_inv = mysqli_query($link, $sql_inv);

		if(mysqli_num_rows($res_inv) > 0){

			$retorno[] = array(
              'info' => "1",
            );
            echo(json_encode($retorno));

		}else{

			$retorno[] = array(
              'info' => "0",
            );
            echo(json_encode($retorno));

		}

    }elseif($id_sub_grupo != '' && $id_grupo != '' && $id_produto != ''){

    	$sql_inv = "select id from tb_inv_prog where ds_tipo = '$ds_tipo' and dt_inicio = '$dt_inicio' and dt_fim = '$dt_fim' and id_galpao = '$id_galpao' and id_rua_inicio = '$id_rua_inicio' and id_coluna_inicio = '$id_coluna_inicio' and id_rua_fim = '$id_rua_fim' and id_coluna_fim = '$id_coluna_fim' and id_sub_grupo = '$id_sub_grupo' and id_grupo = '$id_grupo' and id_produto = '$id_produto' and (fl_status = 'A' or fl_status = 'P')";
		$res_inv = mysqli_query($link, $sql_inv);

		if(mysqli_num_rows($res_inv) > 0){

			$retorno[] = array(
              'info' => "1",
            );
            echo(json_encode($retorno));

		}else{

			$retorno[] = array(
              'info' => "0",
            );
            echo(json_encode($retorno));

		}
	}
$link->close();
?>