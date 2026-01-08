<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST['pedido'];
$cod_produto = $_POST['prd'];
$rua = $_POST['rua'];
$col = $_POST['col'];
$alt = $_POST['alt'];
$qtd = $_POST['qtd'];
$galpao = $_POST['galpao'];
$barcode = $_POST['barcode'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$query_init = "select count(produto) as total
    from tb_pedido_conferencia
    where nr_pedido = '$nr_pedido' and produto = '$barcode' and ds_galpao = '$galpao' and ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt'";
$res_init = mysqli_query($link, $query_init);
while ($init = mysqli_fetch_assoc($res_init)) {
	$count = $init['total'];
}

if ($count < $qtd) {

	$insert_barcode = "insert into tb_pedido_conferencia (nr_pedido, produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, usr_create, dt_create) values ('$nr_pedido', '$barcode', '$galpao', '$rua', '$col', '$alt', '$id', now())";
	$res_barcode = mysqli_query($link, $insert_barcode);

	$query_count = "select count(produto) as total
        from tb_pedido_conferencia
        where nr_pedido = '$nr_pedido' and produto = '$barcode' and ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt'";
	$res_count = mysqli_query($link, $query_count);
	while ($count = mysqli_fetch_assoc($res_count)) {
		$count_upd = $count['total'];
	}

	$upd_conf = "update tb_pedido_coleta_produto set nr_qtde_conf = '$count_upd' where nr_pedido = '$nr_pedido' and produto = '$barcode'";
	$res_upd = mysqli_query($link, $upd_conf);

	$upd_col = "update tb_coleta_pedido set nr_qtde_conf = '$count_upd' where nr_pedido = '$nr_pedido' and produto = '$barcode' and ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt'";
	$res_col = mysqli_query($link, $upd_col);

	if ($res_barcode) {

		$query_conf = "select count(produto) as total_conf
            from tb_pedido_conferencia
            where nr_pedido = '$nr_pedido' and produto = '$barcode' and ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt'";
		$res_conf = mysqli_query($link, $query_conf);
		$tr_conf = mysqli_num_rows($res_conf);

		while ($conf = mysqli_fetch_assoc($res_conf)) {
			$array_estoque = array(
				'info' => "0",
				'total' => $conf['total_conf'],
			);
		}

		echo (json_encode($array_estoque));
	}

} else {

	$array_estoque = array(

		'info' => "Todos os itens desse produto foram conferidos!",
	);

	echo (json_encode($array_estoque));

	exit();

}

$link->close();
?>