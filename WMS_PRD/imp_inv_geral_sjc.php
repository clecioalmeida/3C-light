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

$diretorio = "sap/";
$tab = ";";
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

				if($dados[0] != 'material' && !empty($linha)){

					$produto 			= $dados[0];
					$nr_qtde 			= str_replace(",",".", $dados[1]);
					$nr_qtde2			= str_replace(",",".",$nr_qtde);

					$ds_galpao = "1";

					echo $nr_qtde." - ".$produto."<br>";

					/*$sql_prd = "select cod_produto from tb_produto where cod_prod_cliente = '".$produto."'";
					$res_prd = mysqli_query($link1, $sql_prd);

					if(mysqli_num_rows($res_prd) > 0){
						$prd = mysqli_fetch_assoc($res_prd);
						$cod_produto = $prd['cod_produto'];

						$sql_dest = "insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_volume, nr_qtde, fl_status, fl_tipo, fl_empresa, usr_create, dt_create) values ('".$produto."', '".$cod_produto."', '".$ds_galpao."', 'L', '1', '1', '1', '".$nr_qtde."', 'A',  'I',  '".$cod_cli."',  '".$id."', '".$date."')";
						$res_dest = mysqli_query($link1, $sql_dest);

					}*/
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