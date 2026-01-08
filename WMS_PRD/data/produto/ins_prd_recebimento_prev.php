<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../../index.php");
	exit;

} else {

	$id_user 	= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$id_item 	= $_POST['id_item'];
$id_rec 	= $_POST['id_rec'];

foreach ($id_item as $a) {

	$query_vol = "select distinct id_reposicao from tb_reposicao_item WHERE id = '" . $a . "'";
	$res_vol = mysqli_query($link, $query_vol);

	while($dados = mysqli_fetch_array($res_vol)) {

		$sql_nf = "insert into tb_nf_entrada (cod_rec, nr_fisc_ent, fl_status, usr_create, dt_create) values ('$id_rec', '".$dados['id_reposicao']."', 'A', '$id_user', '$date')";
		$res_nf = mysqli_query($link, $sql_nf);

		$nrNf = mysqli_insert_id($link);

		if(mysqli_affected_rows($link) > 0){

			$sql_item = "select cod_produto, nr_qtde, id_fornecedor, dt_previsto from tb_reposicao_item WHERE id_reposicao = '".$dados['id_reposicao']."'";
			$res_item = mysqli_query($link, $sql_item);

			while($dados_item = mysqli_fetch_array($res_item)) {
				
				// ESSE BLOCO NÃO ESTÁ GRAVANDO //

				$ins_item = "insert into tb_nf_entrada_item (cod_nf_entrada, fl_status, produto, estado_produto, nr_qtde, user_rec, dt_rec) values ('$nrNf', 'A', '".$dados_item['cod_produto']."', '1', '".$dados_item['nr_qtde']."', '$id_user', '$date'";
				$res_nf_item = mysqli_query($link, $ins_item);

				if(mysqli_affected_rows($link) > 0){

					$retorno = array(

						'nrNf' => $nrNf,
						'info' => "0",
					);

				}else{

					$retorno = array(

						'nrNf' => $nrNf,
						'info' => "1.1",
					);

				}

			}

		}else{

			$retorno = array(
				'info' => "1",
			);

		}

	}


}

echo (json_encode($retorno));

$link->close();
?>