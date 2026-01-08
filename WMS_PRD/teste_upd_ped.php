<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

/*$sql = "select nr_pedido, produto, nr_qtde from tb_pedido_coleta_produto where date(dt_create) < '2020-01-08' and fl_status = 'X'";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {
	$nova_qtde = $dados_nf['nr_qtde'];
	$produto = $dados_nf['produto'];
	$nr_pedido = $dados_nf['nr_pedido'];

	$ins_nf = "update tb_pedido_coleta_produto set nr_qtde_conf = '$nova_qtde' where nr_pedido = '$nr_pedido' and produto = '$produto'";
	$res_nf = mysqli_query($link1, $ins_nf);
	$nNf = mysqli_insert_id($link1);

	if(mysqli_affected_rows($link1) > 0){
		

			echo "nr_pedido: ".$nr_pedido." - produto: ".$produto." - nova_qtde: ".$nova_qtde."<br>";

		
	}else{

		echo "Erro no cadastro.";

	}
	

}*/

$sql = "select t1.nr_pedido, t1.fl_status, t2.nr_pedido, t2.usr_lib_exp from tb_pedido_coleta t1 left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
where date(t1.dt_create) >= '2020-02-17' and t2.usr_lib_exp is not null and t1.fl_status <> 'F'
group by t1.nr_pedido";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {
	$nr_pedido = $dados_nf['nr_pedido'];
	$fl_status = $dados_nf['fl_status'];

	//$ins_nf = "insert into tb_pedido_coleta_produto (cod_col, nr_pedido, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde) values ('$cod_col', '$nr_pedido', '$produto', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$nova_qtde')";
	//$res_nf = mysqli_query($link1, $ins_nf);

	$ins_nf = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$nr_pedido'";
	$res_nf = mysqli_query($link1, $ins_nf);

	if(mysqli_affected_rows($link1) > 0){

		//echo "cod_col: ".$cod_col." - ds_prateleira: ".$ds_prateleira." - ds_coluna: ".$ds_coluna." - ds_altura: ".$ds_altura." - nr_pedido: ".$nr_pedido." - produto: ".$produto." - nova_qtde: ".$nova_qtde."<br>";

		echo"nr_pedido: ".$nr_pedido." - fl_status: ".$fl_status."<br>";
		
	}else{

		echo "Erro no cadastro.<br>";

	}
	

}

$link->close();
$link1->close();
$link2->close();
?>