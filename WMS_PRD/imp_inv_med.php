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

$diretorio = "imp/";
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
			//echo $origem;
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'POSIÇÃO' && !empty($linha)){

					$ds_end 			= explode('-',$dados[0]);
					$id_rua				= $ds_end[0];
					if($ds_end[0]){$id_rua = $ds_end[0];}else{$id_rua = "1";}
					if($ds_end[1]){$id_col = $ds_end[1];}else{$id_col = "1";}
					if($ds_end[2]){$id_alt = $ds_end[2];}else{$id_alt = "1";}
					$cod_prod 			= $dados[1];
					$ds_kva 			= $dados[2];
					$ds_lp 				= $dados[3];
					$nserie 			= $dados[4];
					$ds_fabr 			= $dados[5];
					$ds_ano 			= $dados[6];
					$ds_enr 			= $dados[7];
					$ds_insp 			= $dados[8];
					/*$data_teste 		=$dados[9];
					$dateAloca 			= explode('/',$dados[9]);
					$ano_aloca 			= $dateAloca[2];
					$mes_aloca 			= $dateAloca[1];
					$dia_aloca 			= $dateAloca[0];*/
					$dt_aloca 			= "2025-04-14";//$ano_aloca."-".$mes_aloca."-".$dia_aloca;
					$nm_prod 			= "";
					$nr_qtde 			= "1";
					$nr_volume 			= "1";

					$ret_op = "- rua ".$id_rua."- col ".$id_col."- alt ".$id_alt."- qtde ".$nr_qtde."- galpão ".$id_glp."</br>";

					echo $dt_aloca."-".$cod_prod."- rua ".$id_rua."- col ".$id_col."- alt".$id_alt."- qtde ".$nr_qtde."-".$id_glp."-".$ds_lp."-".$ds_fabr."-".$ds_ano."</br>";

					/*$sql_mt = "select ds_lp, cod_estoque 
					from tb_posicao_pallet
					 where ds_lp = '$ds_lp' and ds_galpao = '$id_glp' and ds_prateleira = '$id_rua' and ds_coluna = '$id_col' 
					 and ds_altura = '$id_alt'";
					$res_mt = mysqli_query($link, $sql_mt);

					if(mysqli_num_rows($res_mt) > 0){

						$dados = mysqli_fetch_assoc($res_mt);
						$cod_estoque = $dados['cod_estoque'];

						$ins_upd = "update tb_posicao_pallet set produto = '$cod_prod',
						n_serie = '$nserie', ds_kva = '$ds_kva',  ds_fabr = '$ds_fabr', ds_ano = '$ds_ano', id_tar = '180325', fl_status = 'A' 
						where cod_estoque = '$cod_estoque'";
						$res_upd = mysqli_query($link1, $ins_upd);

						if(mysqli_affected_rows($link) > 0){

							$ret_op = 'LP Alterado.<br>';

						}else{

							$ret_op = 'LP Não alterado.<br>';


						}

						
					}else{*/


						$sql_dest = "insert into tb_posicao_pallet 
						(produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_volume,nr_qtde,n_serie,ds_lp,ds_kva,ds_fabr,ds_ano,ds_insp, 
						ds_enr,fl_status,fl_tipo,fl_empresa,fl_bloq,id_tar,dt_aloca,usr_create,dt_create) 
						values 
						('$cod_prod','21','$id_rua','$id_col','$id_alt','$nr_volume','$nr_qtde','$nserie','$ds_lp','$ds_kva',
						'$ds_fabr','$ds_ano','$ds_insp','$ds_enr','A','I','$cod_cli','N','180325','$dt_aloca','$id','$date')";
						$res_dest = mysqli_query($link1, $sql_dest);
	
						if(mysqli_affected_rows($link1) > 0){
	
							$ret_op = $cod_prod."-".$id_rua."-".$id_col."-".$id_alt."-".$nr_volume."-".$nr_qtde."</br>";
	
							$sql_prod = "select cod_prod_cliente from tb_produto where cod_prod_cliente = '$cod_prod'";
							$res_prod = mysqli_query($link1, $sql_prod);
	
							if(mysqli_num_rows($res_prod) > 0){
	
								echo "Produto já existe.";
	
							}else{
	
								$ins_prd = "insert into tb_produto (cod_prod_cliente, nm_produto, fl_status, fl_empresa, user_create,dt_create
								) values ('$cod_prod', '$nm_prod', 'A', '$cod_cli', '$id', '$date')";
								$res_ins = mysqli_query($link1, $ins_prd);
	
								if(mysqli_affected_rows($link1) > 0){
	
									echo "Produto cadastrado.";
	
								}else{
	
									echo "Produto não cadastrado.";
	
								}
	
							}
	
						}else{
	
							$ret_op = 'não cadastrado.<br>';
						}

					//}

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