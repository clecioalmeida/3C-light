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
$data = date("Y-m-d");

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

					$id_produto 		= $dados[0];
					$n_serie 			= $dados[1];
					$ds_centro 			= $dados[2];
					$ds_deposito		= $dados[3];
					$status_sap			= $dados[4];
					$status_usr			= $dados[5];
					$dt_create_sap		= $dados[6];
					$dt_install			= $dados[7];
					$ds_descricao		= $dados[8];
					$ds_grp_reg			= $dados[9];

					if($dados[10] > "0")

						$dt_sap 			= explode('/', $dados[10]);
					$dia_sap  			= $dt_sap[0];
					$mes_sap  			= $dt_sap[1];
					$ano_sap  			= $dt_sap[2];

					$dt_upd_sap			= $ano_sap."-".$mes_sap."-".$dia_sap;

				}else{

					$dt_upd_sap			= "0000-00-00";

				}

				if($dados[11] > "0"){

					$dt_vld 			= explode('/', $dados[11]);
					$dia_vld  			= $dt_vld[0];
					$mes_vld  			= $dt_vld[1];
					$ano_vld  			= $dt_vld[2];
					$dt_upd_vld			= $ano_vld."-".$mes_vld."-".$dia_vld;


				}else{

					$dt_upd_vld			= "0000-00-00";

				}

				if($dados[12] > "0"){

					$dt_vld2 			= explode('/', $dados[12]);
					$dia_vld2 			= $dt_vld2[0];
					$mes_vld2  			= $dt_vld2[1];
					$ano_vld2  			= $dt_vld2[2];
					$dt_upd_vld2		= $ano_vld2."-".$mes_vld2."-".$dia_vld2;


				}else{

					$dt_upd_vld2			= "0000-00-00";

				}

				$ds_usr_upd			= $dados[13];
				$ds_usr_ins			= $dados[14];
				$ds_usr_upd2		= $dados[15];

				if($dados[16] > "0"){

					$dt_usr 			= explode('/', $dados[16]);
					$dia_usr 			= $dt_usr[0];
					$mes_usr  			= $dt_usr[1];
					$ano_usr  			= $ano_usr[2];
					$dt_upd_usr			= $ano_vld2."-".$mes_usr."-".$dia_usr;


				}else{

					$dt_upd_usr			= "0000-00-00";

				}

				$ds_fabr				= $dados[17];
				$ns_fabr				= $dados[18];

				$sql = "select n_serie from tb_nserie where n_serie = '".$n_serie."' and fl_status = 'A'";
				$res = mysqli_query($link, $sql) or die(mysqli_error($link));

				if(mysqli_num_rows($res) > 0){

					$sql_dest = "update tb_nserie set ds_centro ='".$ds_centro."', ds_deposito ='".$ds_deposito."', status_sap ='".$status_sap."', dt_upd_sap ='".$dt_upd_sap."', status_usr ='".$status_usr."', dt_create_sap ='".$dt_create_sap."', dt_install ='".$dt_install."', ds_descricao ='".$ds_descricao."', ds_grp_reg ='".$ds_grp_reg."', dt_upd_vld ='".$dt_upd_vld."', dt_upd_vld2 ='".$dt_upd_vld2."', ds_usr_upd ='".$ds_usr_upd."', ds_usr_ins='".$ds_usr_ins."',ds_usr_upd2='".$ds_usr_upd2."',ds_fabr ='".$ds_fabr."', ns_fabr ='".$ns_fabr."', usr_update = '$id', dt_update = '$date' where n_serie = '".$n_serie."'";
					$res_dest = mysqli_query($link1, $sql_dest);

				}else{

					$sql_dest = "insert into tb_nserie (
					id_produto, 
					n_serie, 
					ds_centro, 
					ds_deposito, 
					status_sap, 
					dt_upd_sap, 
					status_usr, 
					dt_create_sap, 
					dt_install, 
					ds_descricao, 
					ds_grp_reg,
					dt_upd_vld, 
					dt_upd_vld2, 
					ds_usr_upd, 
					ds_usr_ins, 
					ds_usr_upd2, 
					ds_fabr, 
					ns_fabr, 
					fl_status, 
					fl_empresa, 
					usr_create, 
					dt_create
					) values (
					'".$id_produto."', 
					'".$n_serie."', 
					'".$ds_centro."', 
					'".$ds_deposito."', 
					'".$status_sap."',
					'".$dt_upd_sap."',
					'".$status_usr."', 
					'".$dt_create_sap."', 
					'".$dt_install."', 
					'".$ds_descricao."', 
					'".$ds_grp_reg."', 
					'".$dt_upd_vld."', 
					'".$dt_upd_vld2."', 
					'".$ds_usr_upd."', 
					'".$ds_usr_ins."', 
					'".$ds_usr_upd2."', 
					'".$ds_fabr."', 
					'".$ns_fabr."', 
					'A', 
					'".$cod_cli."',
					'".$id."', 
					'".$date."'
					)";
					$res_dest = mysqli_query($link1, $sql_dest);
				}
			}

			$sql_tot = "select coalesce(count(n_serie),0) as total from tb_nserie where (date(dt_create) = '".$data."' or date(dt_update) = '".$data."')";
			$res_tot = mysqli_query($link, $sql_tot);

			$total = mysqli_fetch_assoc($res_tot);
			$count = $total['total'];

			if($count > 0){

				$sql_log = "insert into tb_log_iq09 (nr_total_reg, fl_empresa, usr_create, dt_create) values ('".$count."', '".$cod_cli."', '".$id."', '".$date."')";
				$res_log = mysqli_query($link, $sql_log) or die(mysqli_error($link));

				echo "Foram atualizados ".$count." registros.";


			}else{

				echo "Houve um erro na atualização. Total: ".$count;

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