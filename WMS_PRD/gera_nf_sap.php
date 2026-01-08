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
	echo $dados_nf['cod_forn_sap']." - ".$dados_nf['nr_nf']." - ".$dados_nf['saldo']."<br>";

	/*$sql_mat = "select nr_fisc_ent, cod_fornecedor
	from tb_nf_entrada
	where nr_fisc_ent = '".$dados_nf['nr_nf']."' and cod_fornecedor = '".$dados_nf['cod_forn_sap']."' group by cod_fornecedor, nr_fisc_ent";
	$res_mat = mysqli_query($link1, $sql_mat);

	if(mysqli_num_rows($res_mat) > 0){

		echo $dados_nf['doc_material']." Ja existe!<br>";		

	}else{

		if($dados_nf['saldo'] > 0 && $dados_nf['saldo'] != ''){

			$ins_nf = "insert into tb_nf_entrada (nr_fisc_ent, cod_mat_sap, dt_emis_ent, cod_fornecedor, fl_status, cod_rec, usr_create, dt_create) values ('".$dados_nf['nr_nf']."', '".$dados_nf['doc_material']."', '".$dados_nf['dt_emis_nf']."', '".$dados_nf['cod_forn_sap']."', 'A', '".$id_rec."', '', '".$date."')";
			$res_nf = mysqli_query($link1, $ins_nf);

			$nNf = mysqli_insert_id($link1);

			if(mysqli_affected_rows($link1) > 0){

				$array_sap = array(
					'info' => "0",
				);

			}else{

				$array_sap = array(
					'info' => "1",
				);

			}

		}else{

			echo "Material invalido!<br>";						

		}

	}*/
}

$link->close();
$link1->close();
$link2->close();
?>