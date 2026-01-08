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

	$codEstoque = $_REQUEST['codEstoque'];
	$nr_qtde_nc = $_REQUEST['nr_qtde_nc'];
	$codProduto = $_REQUEST['codProduto'];
	$nr_qtde_old = $_REQUEST['nr_qtde_old'];
	$idGalpaoNew = $_REQUEST['idGalpaoNew'];
	$idRuaNew = $_REQUEST['idRuaNew'];
	$idColunaNew = $_REQUEST['idColunaNew'];
	$idAlturaNew = $_REQUEST['idAlturaNew'];
	$motivoNc = $_REQUEST['motivoNc'];

	$saldo=$nr_qtde_old-$nr_qtde_nc;

	//echo $saldo." - ".$nr_qtde_nc." - ".$nr_qtde_old;

	$sql_nc = "insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde, nm_user_mov, dt_user_mov, nr_posicao_temp, fl_status) values ('$codProduto', '$idGalpaoNew', '$idRuaNew', '$idColunaNew', '$idAlturaNew', '$nr_qtde_nc','$id', now(), '$codEstoque', 'Z')";
	$res_local = mysqli_query($link, $sql_nc);

	if($res_local){

		$sql_upd="update tb_posicao_pallet set nr_qtde = '$saldo' where cod_estoque = '$codEstoque'";
		$res_upd = mysqli_query($link, $sql_upd);

		$ins_ocor="insert into tb_ocorrencias (nm_ocorrencia, tipo, fl_resp_cli, finalizadora, criticidade, dt_abertura, fl_status, cod_origem, user_create, dt_create, ds_obs) values ('Não-conformidade identificada no estoque', 'A', 'N', 'N', 'M', now(), 'A', '$codEstoque', '$id', now(), '$motivoNc')";
        $res_ocor=mysqli_query($link, $ins_ocor);

        if($res_ocor){

        	$retorno[] = array(
			'info' => "0",
			);

			echo(json_encode($retorno));

        }else{

        	$retorno[] = array(
			'info' => "3",
			);

			echo(json_encode($retorno));

        }

	}else{

		$retorno[] = array(
			'info' => "1",
		);

		echo(json_encode($retorno));

	}
$link->close();
?>