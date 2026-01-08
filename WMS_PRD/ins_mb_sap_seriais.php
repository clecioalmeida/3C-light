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
$hoje = date("Y-m-d");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$dt_entrega = $_POST["dt_entrega"];
$dt_entrega = $_POST["dt_entrega"];

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

				if ($dados[0] != 'COD. CLIENTE' && !empty($linha)) {

					$cod_cliente = $dados[0];
					$fornecedor  = $dados[1];
					$dt          = $dados[2];
					$cod_sap     = $dados[3];
					$nr_coleta   = $dados[4];
					$nr_serie    = $dados[5];
					$status      = $dados[6];

					echo  'Fornecedor: ' . (!empty($fornecedor) ? $fornecedor : 'Sem fornecedor' ) . " - Nr Coleta: " . $nr_coleta . " - Nr Série: " . $nr_serie . " - Status: " . $status .  "<br>";

					$x = ($status == 'VALIDADO') ? "X" : "Y";

					$sql = "SELECT n_serie FROM tb_nserie WHERE n_serie = '$nr_coleta'";
					$res = mysqli_query($link1, $sql);

					if(mysqli_num_rows($res) > 0) {

						$sql_upd = "UPDATE tb_nserie SET fl_status = '$x', n_serie = '$nr_coleta', dt_upd_sap = '$dt_entrega', usr_update = '$id' WHERE n_serie = '$nr_coleta'";
						$res_upd = mysqli_query($link1, $sql_upd);

						if (mysqli_affected_rows($link1) > 0) {

							$ret_op = 'Nr Série ' . $dados[4] . ' alterado com sucesso.<br>';

						} else {

							$ret_op = 'Nr Série ' . $dados[4] . ' não alterado.<br>';

						}

						echo $ret_op;

						
					} else {
						
						$ret_op = 'Nr Série ' . $dados[4] . ' não encontrado.<br>';

						echo $ret_op;
						
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