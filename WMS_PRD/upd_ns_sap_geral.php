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

				if($dados[0] != 'Material' && !empty($linha)){

					$id_produto 		= $dados[0];
					$n_serie 			= $dados[1];
					$status_sap			= $dados[4];

					if($dados[10] > "0"){

						/*$dt_sap 			= explode('.', $dados[10]);
						$dia_sap  			= $dt_sap[0];
						$mes_sap  			= $dt_sap[1];
						$ano_sap  			= $dt_sap[2];

						$dt_upd_sap			= $ano_sap."-".$mes_sap."-".$dia_sap;*/

						$dt_upd_sap			= $dados[10];

					}else{

						$dt_upd_sap			= "0000-00-00";

					}

					if($dados[11] > "0"){

						/*$dt_usr 			= explode('.', $dados[11]);
						$dia_usr  			= $dt_usr[0];
						$mes_usr  			= $dt_usr[1];
						$ano_usr  			= $dt_usr[2];
						$dt_upd_usr			= $ano_usr."-".$mes_usr."-".$dia_usr;*/

						$dt_upd_usr			= $dados[11];


					}else{

						$dt_upd_usr			= "0000-00-00";

					}

					$status_usr			= $dados[5];

					/*$sql = "select n_serie from tb_nserie where n_serie = '".$n_serie."'";
					$res = mysqli_query($link, $sql) or die(mysqli_error($link));

					if(mysqli_num_rows($res) > 0){

						echo "Número de série: '".$n_serie."' já existe.<br>";

					}else{*/

						$sql_dest = "insert into tb_nserie (id_produto, n_serie, status_sap, dt_upd_sap, status_usr, dt_upd_usr, fl_status, fl_empresa, usr_create, dt_create) values ('".$id_produto."', '".$n_serie."', '".$status_sap."','".$dt_upd_sap."','".$status_usr."','".$dt_upd_usr."', 'A', '".$cod_cli."','".$id."', '".$date."')";
						$res_dest = mysqli_query($link1, $sql_dest);

						if(mysqli_affected_rows($link1) > 0){

							$ret_op = 'n_serie '.$dados[1].' cadastrado com sucesso.<br>';

						}else{

							$ret_op = 'n_serie '.$dados[1].' não cadastrado.<br>';
						}

						echo $ret_op;
					//}

					echo "status_sap: ".$status_sap."status_usr: ".$status_usr."Produto: ".$id_produto."N_serie: ".$n_serie." Data1: ".$dt_upd_sap." Data2: ".$dt_upd_usr."<br>"; 

					/*$retorno[] = array(
					'info' 	=> "0",
					'id_produto' 	=> $id_produto,
					'n_serie' 		=> $n_serie,
					'status_sap' 	=> $status_sap,
					'dt_upd_sap' 	=> $dt_upd_sap,
					'status_usr' 	=> $status_usr,
					'dt_upd_usr' 	=> $dt_upd_usr,
					);

					echo $retorno;*/
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