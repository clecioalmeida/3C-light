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
			
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'Material' && !empty($linha)){

					$cod_sap 	= $dados[0];
					$qtde 		= $dados[2]*-1;
					$dt_ped 	= explode("/",$dados[7]);
					$dia 		= $dt_ped[0];
					$mes 		= $dt_ped[1];
					$ano 		= $dt_ped[2];

					$dt_pedido  = $ano."-".$mes."-".$dia." 00:00:00";

					echo $cod_sap."-".$qtde."-".$dt_pedido."<br>";

					$sql_frn = "select nr_pedido from tb_pedido_coleta where date(dt_pedido) = '".$dt_pedido."' and fl_status = 'F'";
					$res_frn = mysqli_query($link, $sql_frn) or die(mysqli_error($link));

					if(mysqli_num_rows($res_frn) > 0){

						echo "nr_pedido '".$dt_pedido."' já existe.<br>";
						$dados_frn = mysqli_fetch_assoc($res_frn);
						$nr_pedido = $dados_frn['nr_pedido'];

						$ins_frn = "insert into tb_pedido_coleta_produto (
							nr_pedido, produto, nr_qtde, nr_qtde_conf, nr_qtde_exp, fl_status, usr_create, dt_create
							) values (
								'".$nr_pedido."', '".$cod_sap."', '".$qtde."','".$qtde."','".$qtde."',
								'F', '99', '".$date."'
								)";
						$res_ins = mysqli_query($link1, $ins_frn);

					}else{

						$last_pedido = "select coalesce(max(nr_pedido),0) + 1 as pedido from tb_pedido_coleta";
						$res_last_pedido = mysqli_query($link, $last_pedido);
						$n_pedido = mysqli_fetch_assoc($res_last_pedido);
						$pedido_novo = $n_pedido['pedido'];

						$ins_ped = "insert into tb_pedido_coleta (nr_pedido, dt_pedido, fl_status, usr_create, dt_create
						) values (
							'".$pedido_novo."', '".$dt_pedido."',  'F', '99', '".$date."'
							)";
						$res_ped = mysqli_query($link1, $ins_ped);

						if(mysqli_affected_rows($link1) > 0){

							$ins_frn = "insert into tb_pedido_coleta_produto (
								nr_pedido, produto, nr_qtde, nr_qtde_conf, nr_qtde_exp, fl_status, usr_create, dt_create
								) values (
									'".$pedido_novo."', '".$cod_sap."', '".$qtde."','".$qtde."','".$qtde."',
									'A', '99', '".$date."'
									)";
							$res_ins = mysqli_query($link1, $ins_frn);

							echo "nr_pedido ".$pedido_novo.", código ".$cod_sap." cadastrada.<br>";

						}else{

							echo "nr_pedido ".$pedido_novo." não cadastrada.<br>";

						}

					}


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