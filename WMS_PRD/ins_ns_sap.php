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

$id_rec = $_POST["id_ns_sap"];

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

				if($dados[0] != 'Equipamento' && !empty($linha)){

					$id_produto 		= $dados[1];
					$n_serie 			= $dados[2];
					$status_sap			= $dados[3];
					$cod_for_sap 		= $dados[12];
					$id_nf				= $dados[13];
					$cod_pedido 		= $dados[14];

					$sql = "select n_serie from tb_nserie where n_serie = '".$n_serie."'";
					$res = mysqli_query($link, $sql) or die(mysqli_error($link));

					if(mysqli_num_rows($res) > 0){

						echo "Número de série: '".$nr_nf."' já existem.<br>";

					}else{

						$sql_dest = "insert into tb_nserie (id_produto, n_serie, status_sap, cod_for_sap, id_nf, cod_pedido, fl_status, cod_rec, usr_create, dt_create) values ('".$id_produto."', '".$n_serie."', '".$status_sap."', '".$cod_for_sap."', '".$id_nf."', '".$cod_pedido."', 'A', '".$id_rec."','".$id."', '".$date."')";
						$res_dest = mysqli_query($link1, $sql_dest);

						if(mysqli_affected_rows($link1) > 0){

							$ret_op = 'doc_material '.$dados[0].' cadastrado com sucesso.<br>';

						}else{

							$ret_op = 'doc_material '.$dados[0].' não cadastrado.<br>';
						}

						echo $ret_op;
					}
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