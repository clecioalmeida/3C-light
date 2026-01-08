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

					$doc_material 		= $dados[8];
					$item_doc 			= $dados[12];
					$nm_produto 		= $dados[1];
					$cod_prod_cliente 	= $dados[0];
					$nr_qtde 			= str_replace(",",".",str_replace(".","",$dados[4]));
					$cod_almox 			= "";//$dados[4];
					$ds_kva 			= "";//$dados[2];
					$ds_lp 				= "";//$dados[3];
					$nr_serial 			= "";//$dados[4];
					$ds_fabricante 		= "";//$dados[5];
					$ds_ano 			= "";//$dados[6];
					$ds_enr 			= "";//$dados[7];
					$data 				= explode('/',$dados[6]);
					$dia = $data[0];
					$mes = $data[1];
					$ano = $data[2];
					$dt_mov = $ano."-".$mes."-".$dia;

					$sql_dest = "insert into tb_mb51e (
						doc_material, item_doc, cod_prod_cliente, nm_produto, cod_almox, dt_lancto, nr_qtde,
						ds_kva, ds_lp, ds_serial, ds_ano, ds_fabr, ds_enr, fl_empresa, usr_create, dt_create
						) values (
							'".$doc_material."','".$item_doc."', '".$cod_prod_cliente."', '".$nm_produto."', '".$cod_almox."', '".$dt_mov."', 
							'".$nr_qtde."', '".$ds_kva."', '".$ds_lp."', '".$nr_serial."', '".$ds_ano."', '".$ds_fabricante."', '".$ds_enr."', 
							'".$cod_cli."', '".$id."', '".$date."'
							)";
					$res_dest = mysqli_query($link1, $sql_dest);

					if(mysqli_affected_rows($link1) > 0){

						$ret_op = 'doc_material '.$dados[1].' cadastrado com sucesso.<br>';

					}else{

						$ret_op = 'doc_material '.$dados[1].' não cadastrado.<br>';
					}

					echo $ret_op;
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