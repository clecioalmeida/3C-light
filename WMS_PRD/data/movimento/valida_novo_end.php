<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$nr_pedido = $_REQUEST['nr_pedido'];
	$cod_produto = $_REQUEST['cod_produto'];
	$ds_galpao = $_REQUEST['ds_galpao'];
	$ds_prateleira = $_REQUEST['ds_prateleira'];
	$ds_coluna = $_REQUEST['ds_coluna'];
	$ds_altura = $_REQUEST['ds_altura'];
	$nr_qtde = $_REQUEST['nr_qtde'];
	
	$select_dest = "select t1.cod_produto, t1.nm_produto, t2.produto, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.nr_qtde as saldo, t3.nr_qtde as reservado, t4.cod_col
            from tb_produto t1
            left join tb_posicao_pallet t2 on t1.cod_produto = t2.produto
            left join tb_pedido_coleta_produto t3 on t1.cod_produto = t3.produto
            left join tb_coleta_pedido t4 on t3.nr_pedido = t4.nr_pedido
            where t4.produto = '$cod_produto' and t4.ds_galpao = '$ds_galpao' and t4.ds_prateleira = '$ds_prateleira' and t4.ds_coluna = '$ds_coluna' and t4.ds_altura = '$ds_altura'
            group by t4.produto";
	$res_dest = mysqli_query($link,$select_dest);
	$exp = mysqli_num_rows($res_dest);

	if($exp > 0){

		while ($dest=mysqli_fetch_assoc($res_dest)) {
			$array_dest[] = array(
				'saldo'	=> $dest['saldo'],
				'reservado' => $dest['reservado'],
				'produto' => $dest['produto'],
				'ds_galpao' => $dest['ds_galpao'],
				'ds_prateleira' => $dest['ds_prateleira'],
				'ds_coluna' => $dest['ds_coluna'],
				'ds_altura' => $dest['ds_altura'],
				'cod_col' => $dest['cod_col'],
			);
		echo(json_encode($array_dest));
		}

	}else{

		$array_info[] = array(
			'info'	=> "Produto não encontrado no endereço",
		);
		echo(json_encode($array_info));
	}


$link->close();
?>