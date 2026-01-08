<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
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

$diretorio = "inventario/";
$tab = "\t";
if(!is_dir($diretorio)){ 
	echo "Pasta $diretorio nao existe";
}else{
	$arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++){
		
		$destino = $diretorio."/".$arquivo['name'][$controle];
		if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){

			echo "<h3 style='float:center;color:green'><strong>Upload realizado com sucesso!</strong></h3><hr><br>";

			$nome = $arquivo['name'][$controle];

			$origem =$diretorio.$arquivo['name'][$controle];
			echo $origem."<br>";

			$arquivo2 = fopen($origem, 'r');
			
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'Código' && !empty($linha)){

					$cod_estoque		= $dados[0];
					$id_inv				= $_POST['id_inv_prg'];
					$cod_etq 			= $dados[1];
					$id_galpao 			= $dados[3];
					$id_rua 			= $dados[4];
					$id_coluna 			= $dados[5];
					$id_altura 			= $dados[6];
					$id_produto 		= $dados[7];
					$nr_qtde1 			= $dados[9];
					$nr_qtde2 			= $dados[10];
					$nr_qtde3			= $dados[11];
					$dt_validade		= $dados[12];
					$nr_ca 				= $dados[13];
					$dt_ca 				= $dados[14];
					$nr_laudo 			= $dados[15];
					$dt_laudo 			= $dados[16];
					$dt_inv 			= $dados[17];
					$usr_inv 			= $dados[18];

					if(){



					}else{


						
					}

					$sql_tar = "select id_estoque, id_etq
					from tb_inv_tarefa
					where id_inv = '$id_inv' and id_estoque = '$cod_estoque' and id_etq = '$cod_etq'";
					$res_tar = mysqli_query($link1, $sql_tar);

					if(mysqli_num_rows($res_tar) > 0){

						echo "<h3 style='float:center;color:red'><strong>Volume já inventariado.</strong></h3><hr>";

					}else{

						$sql_dest = "insert into tb_inv_tarefa (id_inv, id_estoque, id_etq, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_ca, dt_ca, nr_laudo, dt_laudo, dt_val, fl_status, fl_empresa, user_create, dt_create) values ('$id_inv'),'$cod_estoque','$cod_etq','$id_produto','$id_galpao','$id_rua','$id_coluna','$id_altura','$nr_ca','$dt_ca','$nr_laudo','$dt_laudo','$dt_validade','A','$cod_cli', '$id','$date')";
						$res_dest = mysqli_query($link1, $sql_dest);

						if(mysqli_affected_rows($link1) > 0){

							$id_tar = mysqli_insert_id($link1);

							$sql_conf = "insert into tb_inv_conf (id_tar, cont_1, cont_2, cont_3, conf_1, user_create, dt_create) values ('$id_tar','$nr_qtde1','$nr_qtde2','$nr_qtde3', '$usr_inv','$id','$date')";
							$res_conf = mysqli_query($link1, $sql_conf);

							if(mysqli_affected_rows($link1) > 0){

								echo "<h3 style='float:center;color:green'><strong>Tarefa gravada com sucesso - produto: ".$id_produto."</strong></h3><hr>";

							}else{

								echo "<h3 style='float:center;color:red'><strong>Erro na gravação da tarefa.</strong></h3><hr>";

							}

						}else{

							echo "<h3 style='float:center;color:red'><strong>Erro na gravação da tarefa.</strong></h3><hr>";

						}

					}
				}
			}

			fclose($arquivo2);

			$importado = 'inventario/importados/'.$nome;
			copy($origem, $importado);
			unlink($origem);

		}else{

			echo "<h3 style='float:center;color:red'><strong>Erro ao realizar upload</strong></h3><hr>";

		}

	}
}

$link->close();
$link1->close();
$link2->close();
?>