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
			
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'r_social' && !empty($linha)){

					$nm_fornecedor 	= $dados[0];
					$nr_cnpj_cpf 	= $dados[1];
					$cod_sap 		= $dados[2];
					$ds_email 		= $dados[3];
					$ds_endereco 	= $dados[5];
					$ds_numero 		= $dados[6];
					$ds_cep 		= $dados[7];
					$ds_bairro 		= $dados[8];
					$ds_cidade 		= $dados[9];
					$ds_uf 			= $dados[10];
					$ds_ie_rg 		= $dados[12];
					echo $dados[0]." | ".$dados[1]." | ".$dados[2]." | ".$dados[3]." | ".$dados[5]." | ".$dados[6]." | ".$dados[7]." | ".$dados[8]." | ".$dados[9]." | ".$dados[10]." | ".$dados[12]."<br>";

					$sql_dest = "insert into tb_cliente (cod_sap, nm_cliente, nr_cnpj_cpf, ds_ie_rg, ds_endereco, nr_numero, ds_bairro, ds_cidade, ds_uf, ds_cep, ds_email, fl_status, fl_tipo, usr_create, dt_create) values ('".$cod_sap."', '".$nm_fornecedor."', '".$nr_cnpj_cpf."', '".$ds_ie_rg."', '".$ds_endereco."', '".$ds_numero."', '".$ds_bairro."', '".$ds_cidade."', '".$ds_uf."', '".$ds_cep."', '".$ds_email."', 'A', 'F', '".$id."', '".$date."')";
					$res_dest = mysqli_query($link, $sql_dest);

					if(mysqli_affected_rows($link) > 0){

						$ret_op = 'Código de produto '.$nm_fornecedor.' cadastrado com sucesso.<br>';


					}else{

						$ret_op = 'Código de produto '.$nm_fornecedor.' não cadastrado.<br>';
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