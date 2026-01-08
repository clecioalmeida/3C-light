<?php
session_start();
ini_set('default_charset','UTF-8');
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

$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
	'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
	'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
	'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

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

					$data 				= $dados[0];
					$produto 			= $dados[3];
					$galpao 			= $dados[1];
					$ende 				= explode("-", $dados[2]);

					if($galpao == 1 || $galpao == 2 || $galpao == 5){

						$ds_prateleira 	= $ende[0];
						$ds_coluna 		= $ende[1];
						$ds_altura 		= $ende[2];

					}else if($galpao == 3|| $galpao == 4){

						$ds_prateleira 	= $ende[0];
						$ds_coluna 		= $ende[1];
						$ds_altura 		= "1";

					}

					$nr_volume 		= "1";
					$nr_qtde 		= trim($dados[5]);
					$dt_validade 	= trim($dados[14]);
					$nr_ca 			= trim($dados[15]);
					$dt_ca 			= trim($dados[16]);
					$nr_laudo 		= trim($dados[17]);
					$dt_laudo 		= trim($dados[18]);

					$dt_rec 		= explode("/", $data);
					$rec_ano 		= $dt_rec[2];
					$rec_mes 		= $dt_rec[1];
					$rec_dia 		= $dt_rec[0];

					$dt_create 		= $rec_ano."-".$rec_mes."-".$rec_dia;

					$val_ca 		= explode("/", $dt_ca);
					$ca_ano 		= $val_ca[2];
					$ca_mes 		= $val_ca[1];
					$ca_dia 		= $val_ca[0];

					$data_ca 		= $ca_ano."-".$ca_mes."-".$ca_dia;

					$val_ld 		= explode("/", $dt_laudo);
					$ld_ano 		= $val_ld[2];
					$ld_mes 		= $val_ld[1];
					$ld_dia 		= $val_ld[0];

					$data_ld 		= $ld_ano."-".$ld_mes."-".$ld_dia;


					if($nr_ca > 0){

						$sql_ca ="select id, nr_docto, fl_tipo from tb_ca where nr_docto = '".$nr_ca."' and fl_tipo = 'C'";
						$res_ca = mysqli_query($link1, $sql_ca);

						if(mysqli_num_rows($res_ca) > 0){

							$dados_ca = mysqli_fetch_assoc($res_ca);
							$cod_ca = $dados_ca['id'];

						}else{

							$ins_ca = "insert into tb_ca (nr_docto, fl_tipo, dt_docto, fl_status, usr_create, dt_create) values ('".$nr_ca."','C', '".$data_ca."', 'A', '".$id."', '".$date."')";
							$res_ins_ca = mysqli_query($link, $ins_ca);

							if(mysqli_affected_rows($link) > 0){

								$cod_ca = mysqli_insert_id($link);

							}else{

								exit();
							}

						}

					}else{

						$cod_ca = "";

					}

					if($nr_laudo > 0){

						$sql_ld ="select id, nr_docto, fl_tipo from tb_ca where nr_docto = '".$nr_laudo."' and fl_tipo = 'L'";
						$res_ld = mysqli_query($link1, $sql_ld);

						if(mysqli_num_rows($res_ld) > 0){

							$dados_ld = mysqli_fetch_assoc($res_ld);
							$cod_ld = $dados_ld['id'];

						}else{

							$ins_ld = "insert into tb_ca (nr_docto, fl_tipo, dt_docto, fl_status, usr_create, dt_create) values ('".$nr_laudo."','L', '".$data_ld."', 'A', '".$id."', '".$date."')";
							$res_ins_ld = mysqli_query($link2, $ins_ld);

							if(mysqli_affected_rows($link2) > 0){

								$cod_ld = mysqli_insert_id($link2);

							}else{

								exit();
							}

						}

					}else{

						$cod_ld = "";

					}


					$sql_dest = "insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde, nr_volume, fl_status, fl_bloq, fl_tipo, dt_validade, cod_laudo, cod_ca, usr_create, dt_create) values ('".$produto."','".$galpao."', '".$ds_prateleira."', '".$ds_coluna."', '".$ds_altura."', '".$nr_qtde."', '".$nr_volume."', 'A', 'N', 'I', '".$dt_validade."', '".$cod_ld."', '".$cod_ca."', '".$id."', '".$date."')";
					$res_dest = mysqli_query($link2, $sql_dest);

					$cod_estoque = mysqli_insert_id($link);

					if(mysqli_affected_rows($link2) > 0){

						$ret_op = 'produto de produto '.$produto.' cadastrado com sucesso.<br>';

					}else{

						$ret_op = 'produto de produto '.$produto.' não cadastrado.<br>';
					}

					echo "produto ".$produto." cod_estoque ".$cod_estoque." nr_qtde ".$nr_qtde."<br>";

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