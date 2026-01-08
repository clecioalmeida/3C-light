<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
        //$usuario=$_SESSION['usuario'];
    }
?>
<?php
	require_once("bd_class_dsv.php");
	
	//$cod_cli = $_POST['cod_cli'];
	$nm_produto = $_POST['nm_produto'];
	$cod_prod_cliente = $_POST['cod_prod_cliente'];
	//$tp_separacao = $_POST['tp_separacao'];
	$codncm = $_POST['codncm'];
	$ean = $_POST['ean'];
	//$fl_lote = $_POST['fl_lote'];
	$peso = $_POST['peso'];
	$ds_produto = $_POST['ds_produto'];
	$peso_bruto = $_POST['peso_bruto'];
	$detalhe_produto = $_POST['detalhe_produto'];
	$nr_estoque_min = $_POST['nr_estoque_min'];
	$unid = $_POST['unid'];
	$volume = $_POST['volume'];
	$unid_controle = $_POST['unid_controle'];
	$altura = $_POST['altura'];
	$cod_grupo = $_POST['cod_grupo'];
	$cod_sub_grupo = $_POST['cod_sub_grupo'];
	$compr = $_POST['compr'];
	$largura = $_POST['largura'];
	$cod_identificacao = $_POST['cod_identificacao'];
	$multiplo = $_POST['multiplo'];
	$id_armazem = $_POST['id_armazem'];
	//$aloc_aut = $_POST['aloc_aut'];


	$objDb = new db();
	$link = $objDb->conecta_mysql();

	//$search="select cod_prod_cliente from tb_produto where cod_prod_cliente = '$cod_prod_cliente'";

    $sql = "insert into tb_produto (nm_produto, cod_prod_cliente, codncm, ean, peso, ds_produto, peso_bruto, detalhe_produto, nr_estoque_min, unid, volume, unid_controle, altura, cod_grupo, cod_sub_grupo, compr, largura, cod_identificacao, multiplo, id_armazem, fl_status, fl_tipo, user_create, dt_create) values ('$nm_produto',  '$cod_prod_cliente', '$codncm', '$ean', '$peso', '$ds_produto', '$peso_bruto', '$detalhe_produto', '$nr_estoque_min', '$unid', '$volume', '$unid_controle', '$altura', '$cod_grupo', '$cod_sub_grupo', '$compr', '$largura', '$cod_identificacao', '$multiplo', '$id_armazem', 'A', 'I', '$id', now())";

           $resultado_id = mysqli_query($link, $sql);

            if($resultado_id){

                echo 'Dados cadastrados com sucesso';

            } else {
                echo 'Dados não cadastrados';
            }
    
$link->close();
?>