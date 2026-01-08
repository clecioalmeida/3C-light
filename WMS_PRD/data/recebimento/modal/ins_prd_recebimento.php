<?php
session_start();

	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	$cod_produto = $_POST['cod_prod_cliente'];
	$cod_nf_entrada = $_POST['cod_nf_entrada'];
	$nr_qtde = $_POST['nr_qtde'];
	$vl_unit = $_POST['vl_unit'];
	$nr_peso_ent = $_POST['nr_peso_ent'];
	$estado_produto = $_POST['estado_produto'];

	if(!isset($_POST['cod_prod_cliente'])){
		$cod_produto = $_POST['cod_produto'];
	}else{

		$query_prod="select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente'";
		$res_prod = mysqli_query($link, $query_prod);

		while ($produto=mysqli_fetch_array($res_prod)) {
			$cod_produto=$produto['cod_produto'];
		}
	}


	$_SESSION['cod_nf_entrada']=$cod_nf_entrada;

	$query_nf="select t1.cod_nf_entrada_item, t4.nr_fisc_ent, t1.nr_qtde, t1.vl_unit, t1.nr_peso_unit, t2.cod_produto, t2.nm_produto, t3.estado 
	  from tb_nf_entrada_item t1
	  left join tb_produto t2 on t1.produto = t2.cod_produto
	  left join tb_estado_produto t3 on t1.estado_produto = t3.id
	  left join tb_nf_entrada t4 on t1.cod_nf_entrada = t4.cod_nf_entrada
	  where t1.cod_nf_entrada = '$cod_nf_entrada'and t1.fl_status <> 'E'";
	$res_nf = mysqli_query($link, $query_nf);
	
	if($res_nf){

		while ($dados=mysqli_fetch_array($res_nf)) {
			$nr_qtde_nf = $dados['nr_qtde'];
			$total = $dados['total'];
			$fl_status = $dados['fl_status'];
		}

	}

	if($total <= ($nr_qtde+$nr_qtde_nf) || $fl_status =! 'A'){
		$sql_prd = " insert into tb_nf_entrada_item (cod_nf_entrada, produto, nr_qtde,  vl_unit, nr_peso_unit, estado_produto) values ('$cod_nf_entrada', '$cod_produto', '$nr_qtde', '$vl_unit', '$nr_peso_ent', '$estado_produto') ";
		$res_prd = mysqli_query($link, $sql_prd);

	}else{

		echo"<script>alert('Quantidade digitada não confere com o total desse produto na nota ou a OR não está com status ABERTA.');</script>";

	}

	
	$link->close();	
	
?>