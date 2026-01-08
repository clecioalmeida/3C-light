<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

//$nr_pedido = $_POST['start_col'];
$nr_pedido = 5635;
echo $nr_pedido."<br>";

$sql_status = "select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
$resultado_status = mysqli_query($link, $sql_status);
while ($dados_upd = mysqli_fetch_assoc($resultado_status)) {
	$fl_status = $dados_upd['fl_status'];
}

if ($fl_status != 'F') {

	$sql_prd = "select distinct c.produto, c.nr_qtde
	from tb_pedido_coleta_produto c
	where nr_pedido = '$nr_pedido'
	order by c.produto";
	$res_prd = mysqli_query($link, $sql_prd);

	init:
	while ($dados_prd = mysqli_fetch_array($res_prd)) {

		$produto = $dados_prd['produto'];
		$nr_qtde_ped = $dados_prd['nr_qtde'];

		$sql_pp = "SELECT distinct p.cod_estoque, p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura, p.nr_qtde,COALESCE(sum(c.nr_qtde_col),0) as reservado, g.nome
		FROM tb_posicao_pallet p
		left join tb_armazem g on p.ds_galpao = g.id
		left join tb_produto a on a.cod_prod_cliente = p.produto
		left join tb_coleta_pedido c on p.cod_estoque = c.cod_estoque and c.fl_status <> 'F' 
		WHERE p.produto = '$produto' and p.nr_qtde > 0   and p.fl_bloq <> 'S' and p.fl_empresa = '$cod_cli' and p.fl_status = 'A'
		group by p.cod_estoque
		order by date(p.dt_create), p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura";
		$res_pp = mysqli_query($link, $sql_pp);

		if(mysqli_num_rows($res_pp) > 0){

			while ($dados_qtd = mysqli_fetch_array($res_pp)) {

				$cod_estoque 	= $dados_qtd['cod_estoque'];
				$nr_qtde_pp 	= $dados_qtd['nr_qtde'];
				$qtd_disp 		= $dados_qtd['nr_qtde']-$dados_qtd['reservado'];
				$ds_galpao 		= $dados_qtd['ds_galpao'];
				$ds_prateleira 	= $dados_qtd['ds_prateleira'];
				$ds_coluna 		= $dados_qtd['ds_coluna'];
				$ds_altura 		= $dados_qtd['ds_altura'];

				if($qtd_disp > 0 && $nr_qtde_ped <= $qtd_disp){


					/*$sql_res = "select COALESCE(sum(t1.nr_qtde_col),0) as qtde_res
					from tb_coleta_pedido t1
					left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido
					where t1.cod_estoque = '$cod_estoque' and t2.fl_status <> 'F' and t2.fl_status <> 'X' and t2.fl_status <> 'E'";
					$res_res = mysqli_query($link, $sql_res);
					$dados_res = mysqli_fetch_assoc($res_res);

					$qtd_res = $dados_res['qtde_res'];
					$qtd_disp = $nr_qtde_pp - $qtd_res;*/

					echo "--------------------------<br>";
					echo "Primeiro if<br>";
					echo "cod_estoque: ".$cod_estoque."<br>";
					echo "produto: ".$produto."<br>";
					echo "nr_qtde_ped: ".$nr_qtde_ped."<br>";
					echo "nr_qtde_pp: ".$nr_qtde_pp."<br>";
					echo "nr_qtde_res: ".$dados_qtd['reservado']."<br>";
					echo "nr_qtde_disp: ".$qtd_disp."<br>";

					$qtde_parcial = $nr_qtde_ped;
						//echo "qtde_parcial 1 -".$qtde_parcial."<br>";
						/*$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', '$date', 'M', '$cod_estoque')";
						$res_ins = mysqli_query($link, $ins_prd);*/

						$nr_qtde_ped = $nr_qtde_ped - $qtde_parcial;
						//echo "qtde_parcial_1 -".$qtde_parcial."<br>";
						echo "nr_qtde_ped_at: ".$nr_qtde_ped."<br>";

						/*$upd_col = "update tb_pedido_coleta_produto set fl_status = 'C' where nr_pedido = '$nr_pedido'";
						$result_upd = mysqli_query($link1, $upd_col);

						$upd_prd = "update tb_pedido_coleta set fl_status = 'C', usr_lib_col = '$id', dt_lib_col = '$date' where nr_pedido = '$nr_pedido'";
						$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));*/


					if ($nr_qtde_ped == 0 ) goto init;


				} else {

					echo "--------------------------<br>";
					echo "Primeiro else.<br>";
					echo "cod_estoque: ".$cod_estoque."<br>";
					echo "produto: ".$produto."<br>";
					echo "nr_qtde_ped: ".$nr_qtde_ped."<br>";
					echo "nr_qtde_pp: ".$nr_qtde_pp."<br>";
					echo "nr_qtde_res: ".$dados_qtd['reservado']."<br>";
					echo "nr_qtde_disp: ".$qtd_disp."<br>";

						//$qtde_parcial = 0;
						//echo "qtde_parcial 2 -".$qtde_parcial."<br>";
						//echo "qtde_parcial 3 -".$qtde_parcial."<br>";

						/*$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '', '', '', '','$nr_qtde', '$id', '$date', 'D', '')";
						$res_ins = mysqli_query($link, $ins_prd);*/
						$nr_qtde_ped = $nr_qtde_ped - $nr_qtde_pp;
						//$nr_qtde_ped = $nr_qtde_ped - $qtde_parcial;
						//echo "qtde_parcial_2 -".$qtde_parcial."<br>";
						echo "nr_qtde_ped_at: ".$nr_qtde_ped."<br>";
						//goto init;
						//echo "nr_qtde_ped_at -".$nr_qtde_ped."<br>";

						/*$upd_prd = "update tb_pedido_coleta set fl_status = 'C' where nr_pedido = '$nr_pedido'";
						$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));*/

						if ($nr_qtde_ped == 0 ) goto init;

				}

				if ($nr_qtde_ped > 0 ) echo "Produto parcial: ".$nr_qtde_ped."<br>";//goto init;	

				//end:
				//echo 'goto funciona!<br>';
				//break;
			}	

				/*}else{

					echo "Segundo else<br>";*/

			/*$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '', '', '', '','$nr_qtde', '$id', '$date', 'D', '')";
			$res_ins = mysqli_query($link, $ins_prd);

			$upd_prd = "update tb_pedido_coleta set fl_status = 'C' where nr_pedido = '$nr_pedido'";
			$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));*/

		}else{

			echo "Produto nao encontrato: ".$produto."<br>";

		}

	}

	if ($result_prd) {

		echo "Coleta iniciada.<br>";
	}
}else{

	echo "Não foi possível iniciar a coleta. Por favor entre em contato com o suporte.<br>";

}

$link->close();
?>