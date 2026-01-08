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

$dt_entrega = $_POST["dt_entrega"];
$ds_cat 	= $_POST["ds_cat"];
$ds_frete 	= $_POST["ds_frete"];

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

					if(strlen($dados[0]) != 8 || strlen($dados[3]) != 10 || strlen($dados[2]) == "" || strlen($dados[13]) != 10 || $dados[2] >= 0){

						echo "<h3>Lay-out não confere com o modelo de importação. Produto: ".$dados[0].", Doc material ".$dados[3].", Qtde ".$dados[2].", Pedido SAP ".$dados[13]."</h3><br>";

					}else{

						$doc_material 		= $dados[3];
						$nm_produto 		= $dados[1];
						$item_doc 			= $dados[4];
						$tp_movimento 		= $dados[5];
						$cod_prod_cliente 	= $dados[0];
						$ds_galpao			= $dados[7];
						$tp_unid 			= $dados[10];
						$nr_qtde 			= str_replace(",",".",str_replace(".","",$dados[2]))*-1;
						$vl_unit 			= str_replace(",",".",str_replace(".","",$dados[11]))*-1;
						$ds_obs 			= $dados[12];
						$cod_almox 			= substr($ds_obs, 0, 4);
						$ds_destino 		= substr($ds_obs, 10, 100);
						$nr_pedido_sap 		= $dados[13];

						echo  'Qtde -'.$nr_qtde."- produto ".$cod_prod_cliente."- doc material ".$doc_material."<br>";

						$sql ="select doc_material, item_doc from tb_mb51e where doc_material = '".$doc_material."' and item_doc = '".$item_doc."'";
						$res = mysqli_query($link1, $sql);
						if(mysqli_num_rows($res) > 0){

							$ret_op = 'doc_material '.$dados[3].' com item_doc '.$dados[4].' Já cadastrado.<br>';

							echo $ret_op;

						}else{

							$sql_dest = "insert into tb_mb51e (doc_material,item_doc, tp_movimento, cod_prod_cliente, nm_produto, ds_galpao, cod_almox, ds_destino, dt_lancto, tp_unid, nr_qtde, nr_pedido_sap, vl_unit, dt_entrega, ds_cat, tp_modal, ds_obs, fl_empresa, usr_create, dt_create) values ('".$doc_material."','".$item_doc."', '".$tp_movimento."', '".$cod_prod_cliente."', '".$nm_produto."', '".$ds_galpao."', '".$cod_almox."', '".$ds_destino."', '".$hoje."', '".$tp_unid."', '".$nr_qtde."', '".$nr_pedido_sap."', '".$vl_unit."', '".$dt_entrega."','".$ds_cat."','".$ds_frete."', '".$ds_obs."', '".$cod_cli."', '".$id."', '".$date."')";
							$res_dest = mysqli_query($link1, $sql_dest);

						if(mysqli_affected_rows($link1) > 0){

							$ret_op = 'doc_material '.$dados[3].' cadastrado com sucesso.<br>';

						}else{

							$ret_op = 'doc_material '.$dados[3].' não cadastrado.<br>';
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