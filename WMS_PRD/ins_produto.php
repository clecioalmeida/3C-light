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

					$cod_prod_cliente 			= $dados[0];
					$nm_produto 				= $dados[1];
					$unid 						= $dados[2];

					echo $dados[0]." | ".$dados[1]." | ".$dados[2]."<br>";

					$sql_prd = "select cod_prod_cliente from tb_produto where cod_prod_cliente = '".$dados[0]."' and fl_empresa = '$cod_cli'";
					$res_prd = mysqli_query($link, $sql_prd);

					if(mysqli_num_rows($res_prd) > 0){

						$sql_dest = "update tb_produto set unid = '$unid' where cod_prod_cliente = '$cod_prod_cliente'";
						$res_dest = mysqli_query($link, $sql_dest);

						if(mysqli_affected_rows($link) > 0){

							$ret_op = 'Código de produto '.$dados[0].' alterado com sucesso.<br>';


						}else{

							$ret_op = 'Código de produto '.$dados[0].' não alterado.<br>';
						}

					}else{

						$sql_dest = "insert into tb_produto (cod_prod_cliente, nm_produto, fl_empresa, fl_status, user_create, dt_create) values ('".$dados[0]."', '".$dados[1]."', '".$cod_cli."',  'A', '".$id."', '".$date."')";
						$res_dest = mysqli_query($link, $sql_dest);

						if(mysqli_affected_rows($link) > 0){

							$ret_op = 'Código de produto '.$dados[0].' cadastrado com sucesso.<br>';


						}else{

							$ret_op = 'Código de produto '.$dados[0].' não cadastrado.<br>';
						}

					}

					echo $ret_op;

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