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
$date1 = date("Y-m-d");
$date_str = explode('-', $date1);
$date_ano = $date_str[0];
$date_mes = $date_str[1];
$date_dia = $date_str[2];

$datestr = $date_ano."-".$date_mes."-".$date_dia;

$date2 = date('Y-m-d', strtotime('-1 days', strtotime($date)));

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

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

			$arquivo2 = fopen($origem, 'r');

			$result = "<table class='table table-bordered'>
			<thead>
			<th>PRODUTO</th>
			<th>VALOR</th>
			<th>SALDO MB</th>
			</thead>
			<tbody>";
			
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'Material' && !empty($linha)){

					$produto 		= $dados[0];
					$vlr_total 		= str_replace(",",".",str_replace(".","",$dados[4]));
					$nr_qtde 		= str_replace(",",".",str_replace(".","",$dados[6]));

					if($dados[6] > 0){

						$upd_sd = "insert into tb_fc_saldo_dia (dt_fechamento,cod_produto, nr_saldo_mb, vlr_mb, fl_tipo, fl_empresa, usr_create, dt_create) values ('".$datestr."','".$produto."','".$nr_qtde."','".$vlr_total."', 'M', '".$cod_cli."','".$id."','".$date."')";
						$res_upd = mysqli_query($link, $upd_sd);

						if(mysqli_affected_rows($link) > 0){

							$result .= "<tr>
							<td style='text-align:center'>".$produto."</td>
							<td style='text-align:right'>".$vlr_total."</td>
							<td style='text-align:right'>".$nr_qtde."</td>
							<td>VALOR CADASTRADO</td>
							</tr>";

						}else{

							$result .= "<tr>
							<td style='text-align:center'>".$produto."</td>
							<td style='text-align:right'>".$vlr_total."</td>
							<td style='text-align:right'>".$nr_qtde."</td>
							<td>NÃO CADASTRADO</td>
							</tr>";

						}

					}
				}
			}

			$result .= "</tbody>
			</table>";

			echo $result;

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
?>