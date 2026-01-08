<?php
session_start();
ini_set('default_charset','UTF-8');
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id_usr = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Campo_Grande');
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

				if($dados[0] != 'DATA' && !empty($linha)){

					$cod_prd 			= $dados[0];
					$vlr_med 			= str_replace(",",".",$dados[1]);

					echo "Código: ".$cod_prd." Valor: ".$vlr_med."<br>";

					$ins_pedido = "insert into tb_vlr_est (dt_log, cod_prd, nr_or_ut, vlr_ut, vlr_med, usr_create, dt_create) values ('".$date."', '".$cod_prd."', '99999', '".$vlr_med."','".$vlr_med."', '".$id_usr."','".$date."')";
					$res_ped = mysqli_query($link2, $ins_pedido);

					if(mysqli_affected_rows($link2) > 0){

						echo "Cadastrado.";

						
					}else{

						echo "Não cadastrada.<br>";
					}
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
$link2->close();
?>