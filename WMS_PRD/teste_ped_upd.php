<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

//$nr_pedido = '1290';

$sql = "select nr_pedido, produto, nr_qtde from tb_pedido_coleta_produto where nr_pedido = '1310'";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {
	$nr_qtde = $dados_nf['nr_qtde'];
	$produto = $dados_nf['produto'];
	$nr_pedido = $dados_nf['nr_pedido'];
	$nova_qtde = $nr_qtde/2;

	$ins_nf = "update tb_pedido_coleta_produto set nr_qtde = '$nova_qtde', fl_status = 'A' where nr_pedido = '$nr_pedido' and produto = '$produto'";
	$res_nf = mysqli_query($link1, $ins_nf);
	$nNf = mysqli_insert_id($link1);

	$upd = "update tb_pedido_coleta set fl_status = 'A' where nr_pedido = '$nr_pedido'";
	$res_upd = mysqli_query($link, $upd);

	$del = "delete from tb_coleta_pedido where nr_pedido = '$nr_pedido'";
	$res_del = mysqli_query($link, $del);

	if(mysqli_affected_rows($link1) > 0){

	echo "nr_pedido: ".$nr_pedido." - produto: ".$produto." - qtde: ".$nr_qtde." - nova_qtde: ".$nova_qtde."<br>";
		

			//echo "nr_pedido: ".$nr_pedido." - produto: ".$produto." - nova_qtde: ".$nova_qtde."<br>";

		
	}else{

		echo "Erro no cadastro.";

	}
	

}

$link->close();
$link1->close();
$link2->close();
?>