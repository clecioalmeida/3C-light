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
$cod_almox 	= $_POST["cod_almox"];

$last_pedido = "select coalesce(max(nr_pedido),0) + 1 as pedido from tb_pedido_coleta";
$res_last_pedido = mysqli_query($link, $last_pedido);
$n_pedido = mysqli_fetch_assoc($res_last_pedido);
$pedido_novo = $n_pedido['pedido'];

//INCLUSÃO DE PEDIDO E PRODUTOS DO PEDIDO

$ins_nf = "insert into tb_pedido_coleta (nr_pedido,cod_almox, dt_pedido, dt_limite, ds_prd, fl_status, fl_empresa, usr_create, dt_create) values ('".$pedido_novo."', '".$cod_almox."','".$date."', '".$dt_entrega."', 'S', 'A', '".$cod_cli."', '".$id."', '".$date."')";
$res_nf = mysqli_query($link1, $ins_nf);
$nNf = mysqli_insert_id($link1);

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

				if($dados[0] != 'Pedido' && !empty($linha)){

					$nr_pedido_sap 		= $dados[0];
					$cod_prod_cliente 	= $dados[2];
					$nm_produto 		= $dados[3];
					//$cod_almox 		= $dados[5];
					//$nr_qtde 			= str_replace(",",".",str_replace(".","",$dados[6]));
					$nr_qtde 			= intval($dados[6]);

					$sql_prd = "select produto, nr_pedido_sap 
					from tb_pedido_coleta_produto
					where produto = '".$cod_prod_cliente."' and nr_pedido_sap = '".$nr_pedido_sap."'";
					$res_prd = mysqli_query($link, $sql_prd);

					if(mysqli_affected_rows($link) > 0){

						$ret_op = 'Produto '.$cod_prod_cliente.' e pedido '.$nr_pedido_sap.' Já existem.<br>';

					}else{

						$ins_prd = "insert into tb_pedido_coleta_produto (nr_pedido, nr_pedido_sap, produto, nm_produto, fl_status, fl_empresa, nr_qtde, usr_create, dt_create) values ('".$pedido_novo."', '".$nr_pedido_sap."', '".$cod_prod_cliente."', '".$nm_produto."', 'A', '".$cod_cli."', '".$nr_qtde."', '".$id."', '".$date."')";
						$res_ins = mysqli_query($link2, $ins_prd);

						if(mysqli_affected_rows($link2) > 0){

							$ret_op = 'Produto '.$cod_prod_cliente.' cadastrado com sucesso.<br>';

							echo 'Pedido: '.$pedido_novo.' cod_prod_cliente: '.$cod_prod_cliente.' nm_produto: '.$nm_produto.' nr_qtde: '.$nr_qtde.' cadastrado com sucesso.<br>';

							echo $ret_op;

						}else{

							$ret_op = 'Produto '.$cod_prod_cliente.' não cadastrado.<br>';

							echo $ret_op;
						}

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