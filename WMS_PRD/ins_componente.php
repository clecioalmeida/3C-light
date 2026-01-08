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

if($cod_cli == '3'){

	$ds_centro    = '1300';
	$ds_deposito  = '1310';

}else if($cod_cli == '4'){

	$ds_centro    = '5500';
	$ds_deposito  = '5510';

}

$cod_prod_comp = $_POST["cod_prod_comp"];

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

				if($dados[0] != 'material' && !empty($linha)){

					$n_serie_p 	= $dados[0];
					$n_serie_s 	= $dados[15];

					$sql ="select id_produto, n_serie from tb_nserie where n_serie = '".$n_serie_p."'";
					$res = mysqli_query($link1, $sql);

					if(mysqli_num_rows($res) > 0){

						$ret_op = "Número de série: '".$n_serie_p."' já existe.<br>";

						echo $ret_op;

						$sql_S = "insert into tb_nserie (id_produto, ds_centro, ds_deposito, n_serie, fl_tipo, n_serie_comp, status_sap, status_usr, fl_status, fl_empresa, usr_create, dt_create) values ('".$cod_prod_comp."', '".$ds_centro."', '".$ds_deposito."', '".$n_serie_s."', 'I','".$n_serie_p."', 'DEPS', 'DEPS', 'A', '".$cod_cli."','".$id."', '".$date."')";
						$res_S = mysqli_query($link2, $sql_S);

						if(mysqli_affected_rows($link2) > 0){

							$ret_op = "Número de série: '".$n_serie_p."' e número de série '".$n_serie_s."' cadastrados.<br>";

							echo $ret_op;


						}else{

							$ret_op = "Número de série: '".$n_serie_s."' não cadastrados3.<br>";

							echo $ret_op;

						}

					}else{

						$sql_dest = "insert into tb_nserie (id_produto, ds_centro, ds_deposito, n_serie, fl_tipo, status_sap, status_usr, fl_status, fl_empresa, usr_create, dt_create) values ('".$cod_prod_comp."', '".$ds_centro."', '".$ds_deposito."', '".$n_serie_p."', 'C', 'DEPS', 'DEPS', 'A', '".$cod_cli."','".$id."', '".$date."')";
						$res_dest = mysqli_query($link1, $sql_dest);

						if(mysqli_affected_rows($link1) > 0){

							$sql_S = "insert into tb_nserie (id_produto, ds_centro, ds_deposito, n_serie, fl_tipo, n_serie_comp, status_sap, status_usr, fl_status, fl_empresa, usr_create, dt_create) values ('".$cod_prod_comp."', '".$ds_centro."', '".$ds_deposito."', '".$n_serie_s."', 'I','".$n_serie_p."', 'DEPS', 'DEPS', 'A', '".$cod_cli."','".$id."', '".$date."')";
							$res_S = mysqli_query($link2, $sql_S);

							if(mysqli_affected_rows($link2) > 0){

								$ret_op = "Número de série: '".$n_serie_p."' e número de série '".$n_serie_s."' cadastrados.<br>";

								echo $ret_op;


							}else{

								$ret_op = "Número de série: '".$n_serie_s."' não cadastrados1.<br>";

								echo $ret_op;

							}

						}else{

							$ret_op = "Número de série: '".$n_serie_p."' não cadastrados2.<br>";

							echo $ret_op;
						}

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