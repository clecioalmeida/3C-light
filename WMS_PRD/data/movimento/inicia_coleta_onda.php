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
$link1 = $objDb->conecta_mysql();

if (isset($_POST["onda"])) {

	$ins_onda = "insert into tb_onda (dt_create, usr_create, dt_inicio, usr_inicio, dt_fim, usr_fim) values (now(), '$id', NULL, NULL, NULL, NULL)";
	$res_onda = mysqli_query($link, $ins_onda);
	$onda = mysqli_insert_id($link);

	foreach ($_POST["onda"] as $nr_pedido) {

		$sql_status = "select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
		$resultado_status = mysqli_query($link1, $sql_status);
		while ($dados_upd = mysqli_fetch_assoc($resultado_status)) {
			$fl_status = $dados_upd['fl_status'];
		}

		if ($fl_status == 'C') {

			$sql_prd = "select distinct c.produto, c.nr_qtde
					from tb_pedido_coleta_produto c
					left join tb_nserie n on c.nr_pedido = n.cod_pedido and c.produto = n.id_produto
					where nr_pedido = '$nr_pedido'";
			$res_prd = mysqli_query($link, $sql_prd);

			while ($dados_prd = mysqli_fetch_array($res_prd)) {

				$produto = $dados_prd['produto'];
				$nr_qtde = $dados_prd['nr_qtde'];

				$sql_pp = "SELECT distinct p.cod_estoque, p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura, p.nr_qtde, p.nr_lote, p.nr_nf_entrada
						FROM tb_posicao_pallet p left join tb_pedido_coleta_produto l on p.produto = l.produto
			  			left join tb_armazem g on p.ds_galpao = g.id
			  			left join tb_produto a on a.cod_produto = p.produto
						WHERE p.produto = '$produto' and g.fl_situacao = 1
						order by p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura";
				$res_pp = mysqli_query($link, $sql_pp);

				while ($dados_qtd = mysqli_fetch_array($res_pp)) {
					$cod_estoque = $dados_qtd['cod_estoque'];
					$nr_qtde_pp = $dados_qtd['nr_qtde'];
					$ds_galpao = $dados_qtd['ds_galpao'];
					$ds_prateleira = $dados_qtd['ds_prateleira'];
					$ds_coluna = $dados_qtd['ds_coluna'];
					$ds_altura = $dados_qtd['ds_altura'];

					if ($nr_qtde >= $nr_qtde_pp) {
						$qtde_parcial = $nr_qtde_pp;

					} else {
						$qtde_parcial = $nr_qtde;

					}

					if ($qtde_parcial > 0) {
						$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque,nr_onda) values('$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', now(), 'M', '$cod_estoque', '$onda')";
						$res_ins = mysqli_query($link, $ins_prd);

						$nr_qtde = $nr_qtde - $qtde_parcial;

						$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col = now(), fl_status = 'M' where nr_pedido = '$nr_pedido'";
						$result_upd = mysqli_query($link1, $upd_col);

						$upd_prd = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nr_pedido'";
						$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

					}
				}

			}

			if ($result_prd) {

				$retorno[] = array(
					'info' => "0",
				);

				echo (json_encode($retorno));

			}

		} else {

			$retorno[] = array(
				'info' => "3",
			);

			echo (json_encode($retorno));
		}
		echo "Pedido:" . $nr_pedido;

	}
}

//$nr_pedido =implode("','",(array)$_POST['onda']);
//echo $nr_pedido;

//foreach($nr_pedido as $value){
//$pedido=implode(',',$nr_pedido);
//	echo "Pedido:".$value;
//}

//if (isset($_POST['onda'])) {

//	$i = 0;
//	foreach ($_POST as $val) {
//	    $pedido = $_POST['onda'][$i];
//$age = $_POST['age'][$i];
//	    echo "Pedido:".$pedido;
//mysql_query("INSERT INTO users (name, age) VALUES ('$name', '$age')");
//	    $i++;
//	}
//}

/*
$sql_status="select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
$resultado_status = mysqli_query($link1, $sql_status);
while ($dados_upd=mysqli_fetch_assoc($resultado_status)) {
$fl_status=$dados_upd['fl_status'];

}

if($fl_status == 'C'){

$sql = "CALL prc_coleta('$nr_pedido', '$id')";
$res_prc = mysqli_query($link, $sql);
$res_col=mysqli_num_rows($res_prc);

if($res_col > 0){

$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col = now(), fl_status = 'M' where nr_pedido = '$nr_pedido'";
$result_upd = mysqli_query($link1, $upd_col);

$upd_prd = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nr_pedido'";
$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

//$upd_ped = "update tb_coleta_pedido fl_status = 'M' where nr_pedido = '$nr_pedido'";
//$result_ped = mysqli_query($link1, $upd_ped);

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

}else{

$retorno[] = array(
'info' => "3",
);

echo(json_encode($retorno));
}
 */
$link->close();
?>