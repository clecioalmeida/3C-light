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

				if($dados[0] != 'MATERIAL' && !empty($linha)){

					$cod_prod_cliente 	= $dados[0];
					$tipo 				= $dados[2];

					echo $cod_prod_cliente."-".$dados[1]."-".$tipo."</br>";

					$sql_dest = "update tb_produto set cod_identificacao = '".$tipo."' where cod_prod_cliente = '".$cod_prod_cliente."' and fl_empresa = '".$cod_cli."'";
					$res_dest = mysqli_query($link1, $sql_dest);

					if(mysqli_affected_rows($link1) > 0){

						$ret_op = 'Produto '.$cod_prod_cliente.' atualizado com sucesso.<br>';

					}else{

						$ret_op = 'Produto '.$cod_prod_cliente.' não atualizado.<br>';
					}

					echo $ret_op;
				}
			}

			fclose($arquivo2);

			$importado = 'sap/importados/'.$nome;
			copy($origem, $importado);
			unlink($origem);

		}else{

			echo "Erro ao realizar upload";

		}

	}
}

$link->close();
$link1->close();
$link2->close();
?>