<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$last_pedido = "select coalesce(max(nr_pedido),0) + 1 as pedido from tb_pedido_coleta";
$res_last_pedido = mysqli_query($link, $last_pedido);
$n_pedido = mysqli_fetch_assoc($res_last_pedido);
$pedido_novo = $n_pedido['pedido'];

$diretorio = "sap/";

if(!is_dir($diretorio)){ 
	echo "Pasta $diretorio nao existe";
}else{
	$arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++){
		
		$destino = $diretorio."/".$arquivo['name'][$controle];
		if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){

			echo "<h3 style='background-color:#98FB98'>Upload realizado com sucesso</h3><br>";

			$nome = $arquivo['name'][$controle];

			$origem = $diretorio.$arquivo['name'][$controle];
			
			$fp = fopen($origem,'r');

			$prd = array();

			while( !feof($fp) ){
				$line = trim(fgets($fp));

				$codigo = substr($line,0,2);
				if($codigo == '00'){
					$cod 			= substr($line,0,2);
					$data_ped 		= substr($line,5,6);
					$ano 			= substr($data_ped,0,2);
					$mes 			= substr($data_ped,2,2);
					$dia 			= substr($data_ped,4,2);
					$data 			=  "20".$ano."-".$mes."-".$dia;
					$cod_ped_sap 	= substr($line,14,10);
				}

				if($codigo == '10'){
					$prd[] = array(
						'cod_sap' 	=> substr($line,11,8),
						'Qtde' 		=> preg_replace("@0+@","",substr($line,39,13))
					);
					continue;;
				}
			}

			fclose($fp);

			$sql_ped = "select nr_ped_sap from tb_pedido_coleta where nr_ped_sap = '$cod_ped_sap'";
			$res_ped = mysqli_query($link, $sql_ped);

			if(mysqli_num_rows($res_ped) > 0){

				echo "<h3 style='background-color:#F4A460'>Pedido já importado anteriormente!</h3>";

			}else{

				$ins_pedido = "insert into tb_pedido_coleta (nr_pedido, nr_ped_sap, dt_pedido, fl_status, usr_create, dt_create) values ('$pedido_novo', '$cod_ped_sap', '$data', 'A', '$id', '$date')";
				$res_ins_pedido = mysqli_query($link1, $ins_pedido);
				$novoPed = mysqli_insert_id($link1);

				foreach ($prd as $row)
				{
					echo '<div><h3 style="background-color:#98FB98">'.$cod_ped_sap." ".$novoPed." ". $row['cod_sap']." ".$row['Qtde'].'</h3></div>';

					$ins_prd = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, fl_status, usr_create, dt_create) values ('".$novoPed."', '".$row['cod_sap']."', '".$row['Qtde']."', 'A', '".$id."', '".$date."')";
					$res_prd = mysqli_query($link, $ins_prd);
				}

			}

		}else{

			echo "<h3 style='background-color:#F4A460'>Erro ao realizar upload!</h3>";

		}

	}
}

$link->close();
?>