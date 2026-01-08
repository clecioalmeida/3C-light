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
			
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'Centro' && !empty($linha)){

					$centro 			= $dados[0];
					$deposito 			= $dados[1];
					$destino 			= $dados[2];

					echo  $centro."-".$deposito."-".$destino."<br>";

					$sql_dest = "insert into tb_almox (cod_almox, ds_almox, fl_empresa, fl_status, usr_create, dt_create) values ('".$deposito."', '".$destino."', '".$cod_cli."', 'A', '".$id."', '".$date."')";
					$res_dest = mysqli_query($link1, $sql_dest);

					if(mysqli_affected_rows($link1) > 0){

						$ret_op = 'doc_material '.$dados[1].' cadastrado com sucesso.<br>';

					}else{

						$ret_op = 'doc_material '.$dados[1].' não cadastrado.<br>';
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