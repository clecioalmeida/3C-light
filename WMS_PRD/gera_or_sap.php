<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
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

$id_rec = $_POST["id_rec_sap"];

$sql = "select cod_forn_sap, doc_material, nr_nf, dt_emis_nf, sum(nr_qtde) as saldo, cod_forn_sap from tb_mb51 where cod_rec = '$id_rec' group by cod_forn_sap, nr_nf order by cod_forn_sap, nr_nf";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {
	echo "CodForSap: ".$dados_nf['cod_forn_sap']." - NF: ".$dados_nf['nr_nf']." - saldo: ".$dados_nf['saldo']."<br>";

	$sql_mat = "select nr_fisc_ent, cod_fornecedor
	from tb_nf_entrada
	where fl_status <> 'E' and nr_fisc_ent = '".$dados_nf['nr_nf']."' and cod_fornecedor = '".$dados_nf['cod_forn_sap']."' group by cod_fornecedor, nr_fisc_ent";
	$res_mat = mysqli_query($link1, $sql_mat);

	if(mysqli_num_rows($res_mat) > 0){

		echo $dados_nf['doc_material']." Ja existe!<br>";		

	}else{

		if($dados_nf['saldo'] > 0 && $dados_nf['saldo'] != ''){

			$ins_nf = "insert into tb_nf_entrada (nr_fisc_ent, cod_mat_sap, dt_emis_ent, cod_fornecedor, fl_status, fl_empresa, cod_rec, usr_create, dt_create) values ('".$dados_nf['nr_nf']."', '".$dados_nf['doc_material']."', '".$dados_nf['dt_emis_nf']."', '".$dados_nf['cod_forn_sap']."', 'A', '".$cod_cli."', '".$id_rec."', '', '".$date."')";
			$res_nf = mysqli_query($link1, $ins_nf);

			$nNf = mysqli_insert_id($link1);

			$sql_prd = "select cod_forn_sap, doc_material, nr_nf, dt_emis_nf, sum(nr_qtde) as saldo, cod_forn_sap, cod_prod_cliente, tp_unid, vl_unit from tb_mb51 where nr_nf = '".$dados_nf['nr_nf']."' and cod_forn_sap = '".$dados_nf['cod_forn_sap']."' and cod_rec = '".$id_rec."' group by cod_forn_sap, nr_nf, cod_prod_cliente";
			$res_prd = mysqli_query($link, $sql_prd) or die(mysqli_error($link));

			while ($dados_pr=mysqli_fetch_assoc($res_prd)) {

				/*echo "<br>".$nNf."<br>";
				echo $dados_pr['cod_forn_sap']."<br>";
				echo $dados_pr['doc_material']."<br>";
				echo $dados_pr['cod_prod_cliente']."<br>";
				echo $dados_pr['saldo']."<br>";
				echo $dados_pr['vl_unit']."<br>";
				echo $dados_pr['tp_unid']."<br>";*/

				$ins_prd = "insert into tb_nf_entrada_item (cod_nf_entrada, cod_mat_sap, produto, fl_status, nr_qtde, vl_unit, ds_unid) values ('".$nNf."', '".$dados_pr['doc_material']."', '".$dados_pr['cod_prod_cliente']."', 'A', '".$dados_pr['saldo']."', '".$dados_pr['vl_unit']."','".$dados_pr['tp_unid']."')";
				$res_ins = mysqli_query($link2, $ins_prd);

				if(mysqli_affected_rows($link2) > 0){

					$ret_op = 'nova nf:'.$nNf.'cod_forn_sap:'.$dados_pr['cod_forn_sap'].' nr_nf:'.$dados_pr['nr_nf'].' cod_prod_cliente:'.$dados_pr['cod_prod_cliente'].' nr_qtde:'.$dados_pr['saldo'].' cadastrado com sucesso.<br>';

				}else{

					$ret_op = 'Produto '.$dados_pr['cod_prod_cliente'].' não cadastrado.<br>';
				}

				echo $ret_op;

			}

		}else{

			echo "Material invalido!<br>";						

		}

	}
}

$link->close();
$link1->close();
$link2->close();
?>