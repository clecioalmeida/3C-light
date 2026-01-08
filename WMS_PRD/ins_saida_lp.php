<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;
} else {

	$id_user    = $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
$hoje = date("Y-m-d");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$dt_entrega = $_POST["dt_entrega"];
$nm_for 	= $_POST["nm_for"];

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

			while (!feof($arquivo2)) {
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha, $tab);

				if ($dados[0] != 'DATA RECEBIMENTO' && !empty($linha)) {

					$ds_prestadora 	= $dados[1];
					$nr_lote 		= $dados[2];
					$ds_kva 		= $dados[3];
					$ds_lp 			= $dados[4];
					$n_serial		= $dados[5];
					$ds_fab 		= $dados[6];
					$ds_ano 		= $dados[7];
					$ds_enr 		= $dados[8];

					$dt_chegada = explode('/',$dados[0]);

					$dia_ch = $dt_chegada[0];
					$mes_ch = $dt_chegada[1];
					$ano_ch = $dt_chegada[2];

					$dt_ch = $ano_ch."-".$mes_ch."-".$dia_ch;

					echo  'ds_lp -' . $ds_lp . "- ds_kva " . $ds_kva . "- n_serial " . $n_serial . "<br>";

					$sql_dest = "insert into tb_mb51e (
							ds_destino, dt_entrega, ds_kva, ds_lp, ds_serial, ds_fabr, ds_ano, ds_enr, 
							dt_rec, ds_prest, nr_qtde, fl_empresa, usr_create, dt_create
							) values (
								'" . $nm_for . "', '" . $dt_entrega . "', '" . $ds_kva . "', 
								'" . $ds_lp . "', '" . $n_serial . "', 
								'" . $ds_fab . "', '" . $ds_ano . "', '" . $ds_enr . "', '" . $dt_ch . "', '" . $ds_prestadora . "', '1',
								'" . $cod_cli . "', '" . $id_user . "', '" . $date . "')";
					$res_dest = mysqli_query($link1, $sql_dest);

					if (mysqli_affected_rows($link1) > 0) {

						$ret_op = 'Produto ' . $dados[0] . ' cadastrado com sucesso.<br>';
					} else {

						$ret_op = 'Produto ' . $dados[0] . ' não cadastrado.<br>';
					}

					echo $ret_op;
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