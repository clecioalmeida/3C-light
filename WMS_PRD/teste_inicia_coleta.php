<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

//$nr_pedido = $_POST['start_col'];

/*if($cod_cli == '5'){

    $rec = '7';

}else if($cod_cli == '6'){

    $rec = '18';

}else if($cod_cli == '7'){

    $rec = '27';

}else if($cod_cli == '8'){

    $rec = '33';

}else{

    $rec = "0";

}*/

//$sql_status = "select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
//$resultado_status = mysqli_query($link, $sql_status);
//while ($dados_upd = mysqli_fetch_assoc($resultado_status)) {
	//$fl_status = "A";
//}

//if ($fl_status == "A") {

/*	$sql_prd = "select distinct c.produto, c.nr_qtde
from tb_pedido_coleta_produto c
where nr_pedido = '$nr_pedido' and fl_status <> 'E' and fl_empresa = '$cod_cli'
order by c.produto";
	$res_prd = mysqli_query($link, $sql_prd);
	while ($dados_prd = mysqli_fetch_array($res_prd)) {*/

		$produto = '4309';
		$nr_qtde = '50';

		$sql_pp = "SELECT data,  cod_estoque, produto, nr_qtde, ds_galpao, ds_prateleira, ds_coluna, ds_altura, dt_validade, dt_ca, dt_laudo, data, cod_etq, fl_status,COALESCE(LEAST(dt_validade, dt_ca, dt_laudo),'0000-00-00') as result
	FROM
	(
	SELECT COALESCE(dt_validade,'0000-00-00') as data, a.cod_estoque, a.produto, a.nr_qtde, ds_galpao, ds_prateleira, ds_coluna, ds_altura, dt_validade, c.dt_docto as dt_ca, d.dt_docto as dt_laudo, e.id as cod_etq, coalesce(a.fl_bloq,'N') as fl_bloq, a.fl_empresa, a.fl_status
	FROM tb_posicao_pallet a
	left join tb_ca c on c.id = a.cod_ca
	left join tb_ca d on d.id = a.cod_laudo
	left join tb_etiqueta e on a.cod_estoque = e.cod_estoque
	UNION
	SELECT COALESCE(f.dt_docto,'0000-00-00') as data, e.cod_estoque, e.produto, e.nr_qtde, ds_galpao, ds_prateleira, ds_coluna, ds_altura, dt_validade, f.dt_docto as dt_ca, g.dt_docto as dt_laudo, c.id as cod_etq, coalesce(e.fl_bloq,'N') as fl_bloq, e.fl_empresa, e.fl_status
	FROM tb_posicao_pallet e
	left join tb_ca f on f.id = e.cod_ca
	left join tb_ca g on g.id = e.cod_laudo
	left join tb_etiqueta c on c.cod_estoque = e.cod_estoque
	UNION
	SELECT COALESCE(j.dt_docto,'0000-00-00') as data, h.cod_estoque, h.produto, h.nr_qtde, ds_galpao, ds_prateleira, ds_coluna, ds_altura, dt_validade, i.dt_docto as dt_ca, j.dt_docto as dt_laudo, e.id as cod_etq, coalesce(h.fl_bloq,'N') as fl_bloq, h.fl_empresa, h.fl_status
	FROM tb_posicao_pallet h
	left join tb_ca i on i.id = h.cod_ca
	left join tb_ca j on j.id = h.cod_laudo
	left join tb_etiqueta e on h.cod_estoque = e.cod_estoque
	) s
	where produto = '4309' and nr_qtde > 0 and ds_galpao <> '7' and fl_bloq = 'N' and fl_empresa = '5' and fl_status <> 'E'
	group by cod_estoque, data
	order by cod_estoque, data asc";
		$res_pp = mysqli_query($link, $sql_pp);

		if(mysqli_num_rows($res_pp) > 0){

			while ($dados_qtd = mysqli_fetch_array($res_pp)) {
				$cod_estoque 		= $dados_qtd['cod_estoque'];
				$nr_qtde_pp 		= $dados_qtd['nr_qtde'];
				$ds_galpao 			= $dados_qtd['ds_galpao'];
				$ds_prateleira 	= $dados_qtd['ds_prateleira'];
				$ds_coluna 			= $dados_qtd['ds_coluna'];
				$ds_altura 			= $dados_qtd['ds_altura'];
				$dt_validade 		= $dados_qtd['dt_validade'];
				$dt_ca 				= $dados_qtd['dt_ca'];
				$dt_laudo 			= $dados_qtd['dt_laudo'];
				$cod_etq 			= $dados_qtd['cod_etq'];
				$array 			= array($cod_estoque,array($dados_qtd['data']));

				 //echo json_encode($array);

				foreach ($array as $value => $key) {

					echo $key."<br>";

					/*if($value > $date){

						echo "dt_docto - ".$value." cod_estoque - ".$cod_estoque." produto - ".$produto." - "."Qtde pedido - ".$nr_qtde."-"."Qtde parcial - ".$qtde_parcial."-"."Produto - ".$produto."-"."Qtde posicao - ".$nr_qtde_pp."<br>";


					}else{

						echo "Vencido ".$value."<br>";

					}*/
				}

				$sql_res = "select COALESCE(sum(c.nr_qtde_col),0) as qtde_res
				from tb_coleta_pedido c
				where cod_estoque = '$cod_estoque' and fl_status <> 'E' and fl_status <> 'F'";
				$res_res = mysqli_query($link, $sql_res);
				$reserva = mysqli_fetch_assoc($res_res);
				$qtde_res = $reserva['qtde_res'];

				$nr_qtde_pp = $nr_qtde_pp-$qtde_res;

				$dt_docto = array($dt_validade,$dt_ca,$dt_laudo);
				sort($dt_docto);
				//var_dump($dt_docto);
				$data_prd = $dt_docto[0];

				//echo "Qtde pedido - ".$nr_qtde."-".$produto."- nr_qtde_pp ".$nr_qtde_pp."<br>";

				if ($nr_qtde >= $nr_qtde_pp) {

					$qtde_parcial = $nr_qtde_pp;

				} else {

					$qtde_parcial = $nr_qtde;

				}

				/*if ($qtde_parcial > 0) {
					$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', now(), 'M', '$cod_estoque')";
					$res_ins = mysqli_query($link, $ins_prd);
					//$tr_ins=mysqli_num_rows($res_ins);

					$nr_qtde = $nr_qtde - $qtde_parcial;

					//echo "saldo - ".$nr_qtde."<br /><br />";

					$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col = '$date', fl_status = 'M' where nr_pedido = '$nr_pedido' and produto = '$produto'";
					$result_upd = mysqli_query($link1, $upd_col);

					$upd_prd = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nr_pedido'";
					$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

				}*/
			}

		}

	//}

	/*if ($result_prd) {

		$retorno = array(
			'info' => "0",
		);

		echo (json_encode($retorno));
		echo "Funciona";
	}*/

//} else {

	/*$retorno = array(
		'info' => "3",
	);

	echo (json_encode($retorno));*/

	//echo "Coleta já liberada";
//}

/*$sql_conf = "select count(fl_status) as status from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido' and fl_status = 'A'";
$res_conf = mysqli_query($link, $sql_conf);
$count = mysqli_fetch_assoc($res_conf);

if($count['status'] > 0){

	echo "Alguns produtos não foram liberados para coleta. Consulte no detalhe do pedido.";

}else{

	echo "Coleta liberada para separação.";

}*/

$link->close();
?>