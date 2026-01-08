<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];
$nr_qtde_emb = $_POST['nr_qtde_emb'];
$id_embalagem = $_POST['id_embalagem'];
$produto = $_POST['produto'];
$nr_qtde = $_POST['nr_qtde'];

$qtde_emb = $nr_qtde / $nr_qtde_emb;

echo ceil($qtde_emb);

$qtde = $nr_qtde;

while ($qtde > 0) {

	if ($qtde > $nr_qtde_emb) {

		$ins_man = "insert into tb_pedido_manuseio (nr_pedido, produto, qtd_vol_ant, qtd_vol, id_embalagem, fl_status, user_create, dt_create) values('$nr_pedido', '$produto', '$nr_qtde', '$nr_qtde_emb', '$id_embalagem', 'C', '$id', now())";
		$res_ins = mysqli_query($link, $ins_man);

		$qtde = $qtde - $nr_qtde_emb;

	} else {

		$ins_man = "insert into tb_pedido_manuseio (nr_pedido, produto, qtd_vol_ant, qtd_vol, id_embalagem, fl_status, user_create, dt_create) values('$nr_pedido', '$produto', '$nr_qtde', '$qtde', '$id_embalagem', 'C', '$id', now())";
		$res_ins = mysqli_query($link, $ins_man);

		$qtde = $qtde - $qtde;

	}

	$upd_ped = "update tb_pedido_coleta_produto set fl_status = 'I' where nr_pedido = '$nr_pedido'";
	$res_upd = mysqli_query($link, $upd_ped);

	$upd_prd = "update tb_pedido_coleta set fl_status = 'I' where nr_pedido = '$nr_pedido'";
	$res_prd = mysqli_query($link, $upd_prd);

}

$sql_parte = "SELECT t1.*, count(t1.nr_pedido) as total, t2.ds_tipo, t3.nr_qtde
	from  tb_pedido_manuseio t1
	left join tb_embalagem t2 on t1.id_embalagem = t2.id
    left join tb_pedido_coleta_produto t3 on t1.nr_pedido = t3.nr_pedido
	where t1.nr_pedido = '$nr_pedido' and t3.produto = '$produto'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'id' => $parte['id'],
		'nr_pedido' => $parte['nr_pedido'],
		'total' => $parte['total'],
		'ds_tipo' => $parte['ds_tipo'],
		'produto' => $parte['produto'],
		'qtd_vol' => $parte['qtd_vol'],
		'nr_qtde' => $parte['nr_qtde'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>