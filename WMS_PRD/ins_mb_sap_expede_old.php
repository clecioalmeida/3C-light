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

				if($dados[0] != 'Material' && !empty($linha)){

					$doc_material 		= $dados[3];
					$nm_produto 		= $dados[1];
					$tp_movimento 		= $dados[4];
					$cod_prod_cliente 	= $dados[0];
					$ds_galpao			= $dados[6];
					//$data_emis 			= $dados[7];
					//$dt_lan 			= $dados[8];
					$tp_unid 			= $dados[9];
					$nr_qtde 			= str_replace(",",".",str_replace(".","",$dados[2]))*-1;
					$vl_unit 			= str_replace(",",".",str_replace(".","",$dados[10]))*-1;
					$ds_obs 			= $dados[11];
					$cod_almox 			= substr($ds_obs, 5, 4);
					$ds_destino 		= substr($ds_obs, 10, 100);
					$nr_pedido_sap 		= $dados[12];

					//$date2 = explode(".", $data_emis);
					//$date3 = explode(".", $dt_lan);

					//$dt_emis_nf = $date2[2]."-".$date2[1]."-".$date2[0];
					//$dt_lancto = $date3[2]."-".$date3[1]."-".$date3[0];

					echo  $ds_destino." - ".$cod_almox." - ".$doc_material." - ".$cod_prod_cliente."<br>";

					$sql_dest = "insert into tb_mb51e (doc_material, tp_movimento, cod_prod_cliente, nm_produto, ds_galpao, cod_almox, ds_destino, dt_lancto, tp_unid, nr_qtde, nr_pedido_sap, vl_unit, ds_obs, fl_empresa, usr_create, dt_create) values ('".$doc_material."', '".$tp_movimento."', '".$cod_prod_cliente."', '".$nm_produto."', '".$ds_galpao."', '".$cod_almox."', '".$ds_destino."', '".$hoje."', '".$tp_unid."', '".$nr_qtde."', '".$nr_pedido_sap."', '".$vl_unit."',  '".$ds_obs."', '".$cod_cli."', '".$id."', '".$date."')";
					$res_dest = mysqli_query($link1, $sql_dest);

					if(mysqli_affected_rows($link1) > 0){

						$ret_op = 'doc_material '.$dados[3].' cadastrado com sucesso.<br>';

						echo $ret_op;

					}else{

						$ret_op = 'doc_material '.$dados[3].' não cadastrado.<br>';

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