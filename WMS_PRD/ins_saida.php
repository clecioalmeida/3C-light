<?php
session_start();
ini_set('default_charset','UTF-8');
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
	'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
	'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
	'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$diretorio = "produtos/";
$tab = "\t";
if(!is_dir($diretorio)){ 
	echo "Pasta $diretorio nao existe";
}else{
	$arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++){
		
		$destino = $diretorio."/".$arquivo['name'][$controle];
		if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){

			echo "Upload realizado com sucesso<br>";

			$nome = $arquivo['name'][$controle];

			$origem =$diretorio.$arquivo['name'][$controle];
			echo $origem."<br>";

			$arquivo2 = fopen($origem, 'r');
			//echo $origem;
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'Material' && !empty($linha)){

					$data 				= $dados[0];
					$ds_custo 			= $dados[1];
					$produto 			= $dados[0];
					$desc 				= trim(strtr($dados[6], $unwanted_array));
					$sol 				= trim(strtr($dados[2], $unwanted_array));
					$galpao 			= $dados[3];
					$nr_ca 				= $dados[8];
					$nr_laudo 			= $dados[11];
					$ende 				= explode("-", $dados[4]);

					if($galpao == 1 || $galpao == 2 || $galpao == 5){

						$ds_prateleira 	= $ende[1];
						$ds_coluna 		= $ende[2];
						$ds_altura 		= $ende[3];

					}else if($galpao == 3|| $galpao == 4){

						$ds_prateleira 	= $ende[0];
						$ds_coluna 		= $ende[1];
						$ds_altura 		= "1";

					}
					$nr_qtde 		= trim($dados[7]);

					$dt_rec 		= explode("/", $data);
					$rec_ano 		= $dt_rec[2];
					$rec_mes 		= $dt_rec[1];
					$rec_dia 		= $dt_rec[0];

					$dt_create 		= $rec_ano."-".$rec_mes."-".$rec_dia;

					if($galpao > 0){

						$last_pedido = "select coalesce(max(nr_pedido),0) + 1 as pedido from tb_pedido_coleta";
						$res_last_pedido = mysqli_query($link, $last_pedido);
						$n_pedido = mysqli_fetch_assoc($res_last_pedido);
						$pedido_novo = $n_pedido['pedido'];

						$sql_dst = "select nr_matricula, ds_nome from tb_funcionario where ds_nome = '$sol'";
						$res_dst = mysqli_query($link, $sql_dst);

						if(mysqli_num_rows($res_dst) > 0){

							$nome = mysqli_fetch_assoc($res_dst);
							$ds_nome 		= $nome['ds_nome'];
							$nr_matricula 	= $nome['nr_matricula'];

						}else{

							$ds_nome 		= "";
							$nr_matricula 	= "";

						}

						if($nr_ca == ""){

							$cod_ca = "";

						}else{

							$sql_ca = "select id from tb_ca where nr_docto = '$nr_ca' and fl_status = 'C'";
							$res_ca = mysqli_query($link, $sql_ca);

							if(mysqli_num_rows($res_ca) > 0){

								$ca = mysqli_fetch_assoc($res_ca);
								$cod_ca = $ca['id'];

							}else{

								$cod_ca = "";

							}

						}

						if($nr_laudo == ""){

							$cod_ld = "";

						}else{

							$sql_ld = "select id from tb_ca where nr_docto = '$nr_laudo' and fl_status = 'L'";
							$res_ld = mysqli_query($link, $sql_ld);

							if(mysqli_num_rows($res_ld) > 0){

								$ld = mysqli_fetch_assoc($res_ld);
								$cod_ld = $ld['id'];

							}else{

								$cod_ld = "";

							}

						}

						$sql_prd = "select cod_prod_cliente from tb_produto where nm_produto = '$desc'";
						$res_prd = mysqli_query($link, $sql_prd);

						if(mysqli_num_rows($res_prd) == 0){

							$ins_prd = "insert into tb_produto (cod_prod_cliente, nm_produto, fl_status) values ('".$produto."','".$desc."', 'A')";
							$res_prd = mysqli_query($link2, $ins_prd);

							if(mysqli_affected_rows($link2) > 0){

								echo "Produto cadastrado ".$produto.".<br>";

							}else{

								echo "Produto não cadastrado ".$produto.".<br>";

							}


						}else{

							echo "Produto já existe.<br>";

						}
						

						$sql_end = "SELECT cod_estoque, produto, nr_qtde, ds_prateleira, ds_coluna, ds_altura
						from tb_posicao_pallet
						where produto = '".$produto."' and ds_prateleira = '".$ds_prateleira."' and ds_coluna = '".$ds_coluna."'and ds_altura = '".$ds_altura."' and cod_laudo = '".$cod_ld."' and cod_ca = '".$cod_ca."'";
						$res_end = mysqli_query($link, $sql_end);

						if(mysqli_num_rows($res_end) > 0){

							while ($endereco = mysqli_fetch_assoc($res_end)) {

								$cod_est = $endereco['cod_estoque'];

								echo "cod_estoque ".$endereco['cod_estoque']." destino ".$ds_nome." matricula ".$nr_matricula." produto ".$produto." galpao ".$galpao." ende ".$endereco['ds_prateleira']."-".$endereco['ds_coluna']."-".$endereco['ds_altura']." nr_qtde ".$nr_qtde."<br>";

							}


						}else{

							echo "Produto não encontrado produto ".$produto."<br>";

						}

						$ins_pedido = "insert into tb_pedido_coleta (nr_pedido, cod_almox, ds_destino, ds_custo, dt_pedido, fl_status, fl_tipo, fl_empresa, usr_create, dt_create) values ('".$pedido_novo."','".$nr_matricula."', '".$ds_nome."','".$ds_custo."', '".$dt_create."', 'X', 'N', '5', '99', '".$date."')";
						$res_ped = mysqli_query($link2, $ins_pedido);

						if(mysqli_affected_rows($link2) > 0){

							$ins_prd = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nm_produto, nr_qtde, fl_status, fl_empresa, usr_create, dt_create) values ('".$pedido_novo."','".$produto."', '".$desc."', '".$nr_qtde."', 'X', '5', '99', '".$date."')";
							$res_prd = mysqli_query($link1, $ins_prd);

							$ins_col = "insert into tb_coleta_pedido (nr_pedido, produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde_col, fl_status, cod_estoque, usr_create, dt_create) values ('".$pedido_novo."','".$produto."', '".$galpao."', '".$ds_prateleira."', '".$ds_coluna."', '".$ds_altura."', '".$nr_qtde."', 'X', '".$cod_est."', '99', '".$date."')";
							$res_col = mysqli_query($link2, $ins_col);

							if(mysqli_affected_rows($link2) > 0){

								$cod_col = mysqli_insert_id($link2);

								$ins_conf = "insert into tb_pedido_conferencia (nr_pedido, cod_col, produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde, fl_status, usr_create, dt_create) values ('".$pedido_novo."','".$cod_col."','".$produto."', '".$galpao."', '".$ds_prateleira."', '".$ds_coluna."', '".$ds_altura."', '".$nr_qtde."', 'X', '99', '".$date."')";
								$res_conf = mysqli_query($link1, $ins_conf);

							}else{

								echo "Coleta não cadastrada.<br>";

							}

							if(mysqli_affected_rows($link1) > 0){

								echo "Produto inserido no pedido.<br>";

							}else{

								echo "Produto não inserido no pedido.<br>";

							}

						}else{

							echo "Erro.<br>";
						}


						/*$sql_dest = "insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde, nr_volume, fl_status, fl_bloq, fl_tipo, dt_validade, cod_laudo, cod_ca, usr_create, dt_create) values ('".$produto."','".$galpao."', '".$ds_prateleira."', '".$ds_coluna."', '".$ds_altura."', '".$nr_qtde."', '".$nr_volume."', 'A', 'N', 'I', '".$dt_validade."', '".$cod_ld."', '".$cod_ca."', '".$id."', '".$date."')";
						$res_dest = mysqli_query($link2, $sql_dest);

						$cod_estoque = mysqli_insert_id($link);

						if(mysqli_affected_rows($link2) > 0){

							$ret_op = 'produto de produto '.$produto.' cadastrado com sucesso.<br>';

						}else{

							$ret_op = 'produto de produto '.$produto.' não cadastrado.<br>';
						}*/

						//echo "pedido_novo ".$pedido_novo." destino ".$ds_nome." matricula ".$nr_matricula." produto ".$produto." galpao ".$galpao." ende ".$ds_prateleira."-".$ds_coluna."-".$ds_altura." nr_qtde ".$dt_create."<br>";

					}

				}else{

					echo "Erro";

				}

			}

		}else{

			echo "Erro ao realizar upload";

		}

		fclose($arquivo2);

		$importado = 'produtos/importados/'.$nome;
		copy($origem, $importado);
		unlink($origem);
	}

}

$link->close();
$link1->close();
?>