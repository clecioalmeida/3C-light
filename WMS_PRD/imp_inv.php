<?php
session_start();
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

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

//$id_rec = $_POST["id_rec_sap"];

$diretorio = "sap/";
$tab = "\t";
if (!is_dir($diretorio)) {
	echo "Pasta $diretorio nao existe";
} else {
	$arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++) {

		$destino = $diretorio . "/" . $arquivo['name'][$controle];
		if (move_uploaded_file($arquivo['tmp_name'][$controle], $destino)) {

			echo "Upload realizado com sucesso<br>";

			$nome = $arquivo['name'][$controle];

			$origem = $diretorio . $arquivo['name'][$controle];
			echo $origem . "<br>";

			$arquivo2 = fopen($origem, 'r');
			//echo $origem;
			while (!feof($arquivo2)) {
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha, $tab);

				if ($dados[0] != 'LP' && !empty($linha)) {

					$ds_lp 				= $dados[0];
					$ds_serial 			= $dados[1];

					//echo $ds_lp."-".$ds_serial."</br>";

					$sql = "select cod_estoque, produto, ds_lp, n_serie, ds_prateleira, ds_coluna, ds_altura, ds_galpao, id_endereco 
					from tb_posicao_pallet 
					where (ds_lp = '$ds_lp' or n_serie = '$ds_lp') and ds_lp is not null and fl_status = 'A'";
					$res = mysqli_query($link, $sql) or die(mysqli_error($link));

					if (mysqli_num_rows($res) > 0) {

						$dados = mysqli_fetch_assoc($res);

						echo "cod_estoque '" . $dados['cod_estoque'] . "' e produto '" . $dados['produto'] . "', ds_lp '" . $dados['ds_lp'] . "', ds_serial '" . $dados['n_serie'] . "'.<br>";
						
						/*$sql_dest = "insert into tb_inv_tarefa (
							id_inv, id_estoque,id_produto, id_galpao, id_rua, id_coluna, id_altura, fl_status,
							user_create, dt_create
							) values (
								'99','" . $dados['cod_estoque'] . "', '" . $dados['produto'] . "','" . $dados['ds_galpao'] . "',
								'" . $dados['ds_prateleira'] . "','" . $dados['ds_coluna'] . "','" . $dados['ds_altura'] . "',
								'A','" . $id . "','" . $date . "')";
						$res_dest = mysqli_query($link1, $sql_dest);

						if (mysqli_affected_rows($link1) > 0) {

							$id_tar = mysqli_insert_id($link1);

							$sql_conf = "insert into tb_inv_conf (
								id_tar, cont_1, cont_2, cont_3, conf_1, user_create, dt_create
								) values (
									'$id_tar','1','1','1', '99','$id','$date'
									)";
							$res_conf = mysqli_query($link1, $sql_conf);

							$ins_upd = "update tb_posicao_pallet set 
							nr_qtde = '0', fl_status = 'E', id_tar = '" . $id_tar . "', user_update = '99', dt_update = '" . $date . "' 
							where cod_estoque = '" . $dados['cod_estoque'] . "'";
							$res_upd = mysqli_query($link1, $ins_upd);

							if (mysqli_affected_rows($link1) > 0) {

								echo "<h3 style='float:center;color:green'><strong>Tarefa gravada com sucesso - produto: " . $dados['produto'] . "</strong></h3><hr>";
							} else {

								echo "<h3 style='float:center;color:red'><strong>Erro na gravação da tarefa.</strong></h3><hr>";
							}
						} else {

							echo "<h3 style='float:center;color:red'><strong>Erro na gravação da tarefa.</strong></h3><hr>";
						}*/
					} else {

						echo "ds_lp '$ds_lp' não encontrado.<br>";
					}
				}
			}

			fclose($arquivo2);

			$importado = 'sap/importados/' . $nome;
			copy($origem, $importado);
			unlink($origem);
		} else {

			echo "Erro ao realizar upload";
		}
	}
}

$link->close();
$link1->close();
$link2->close();
?>