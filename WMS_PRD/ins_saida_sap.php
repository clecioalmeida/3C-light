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
$nm_for 	= $_POST["nm_for"];
$ds_frete 	= $_POST["ds_frete"];

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

				if ($dados[0] != 'MATERIAL' && !empty($linha)) {

					$cod_prd 		= $dados[0];
					$nm_material 	= $dados[1];
					$ds_centro 		= $dados[2];
					$ds_dep 		= $dados[3];
					$qtde 			= $dados[4];
					$nr_qtde 		= explode('-',$qtde);
					$nr_qtde 		= str_replace('.','',$nr_qtde[0]);
					$ds_unid 		= $dados[5];
					$dt_lancto 		= $dados[6];
					$doc_material 	= $dados[7];
					$item_doc 		= $dados[8];
					$nm_user_sap 	= $dados[9];
					$nr_tmv 		= $dados[10];
					$nr_ordem 		= $dados[11];

					echo  'cod_prd -' . $cod_prd . "- nr_qtde " . $nr_qtde . "<br>";

					$sql_dest = "insert into tb_mb51e (
					cod_prod_cliente,nm_produto, doc_material, item_doc,dt_entrega, tp_modal, nr_qtde, cod_user_sap, nr_tmv, 
					nr_ordem,tp_unid, fl_empresa, usr_create, dt_create
					) values (
					'$cod_prd','$nm_material','$doc_material','$item_doc','$dt_entrega','$ds_frete','$nr_qtde','$nm_user_sap', 
					'$nr_tmv','$nr_ordem','$ds_unid','$cod_cli','$id','$date')";
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