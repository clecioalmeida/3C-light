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

				if($dados[0] != 'RUA' && !empty($linha)){

					$rua 			= $dados[0];
					$col 			= $dados[1];
					$alt 			= $dados[8];

					if($alt != ''){

						echo  $rua."-".$col."-".$alt."<br>";

						$sql_dest = "select * from tb_posicao_pallet where fl_empresa = '$cod_cli' and ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt' and nr_qtde > 0";
						$res_dest = mysqli_query($link1, $sql_dest);
						while ($dados = mysqli_fetch_assoc($res_dest)) {

							echo 'Posição: '.$dados['cod_estoque'].' - '.$dados['produto'].' - '.$dados['nr_qtde'].' - '.$dados['ds_prateleira'].' - '.$dados['ds_coluna'].' - '.$dados['ds_altura'].'<br>';

							$upd_pos = "update tb_posicao_pallet set fl_status = 'E', id_tar = '9999', ds_obs = 'POSIÇÃO EXCLUÍDA POR PLANILHA', user_update = '$id', dt_update = '$date' where cod_estoque = '".$dados['cod_estoque']."'";
							$res_upd = mysqli_query($link1, $upd_pos);

							if(mysqli_affected_rows($link1) > 0){

								$ret_op = 'Posicao '.$dados['cod_estoque'].' zerada.<br>';

							}else{

								$ret_op = 'doc_material '.$dados['cod_estoque'].' não zerada.<br>';
							}

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