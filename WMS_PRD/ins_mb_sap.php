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

$sql_rec = "insert into tb_recebimento (fl_status, fl_empresa, dt_recebimento_real, tp_recebimento, usr_create, dt_create) values ('A', '".$cod_cli."', '".$date."', 'N', '".$id."', '".$date."')";
$res_rec = mysqli_query($link, $sql_rec);

if(mysqli_affected_rows($link) > 0){

	$Nrec = mysqli_insert_id($link);

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

					if($dados[0] != 'Código do cliente/fornecedor' && !empty($linha)){

						$cod_forn_sap 	= $dados[0];
						$nm_fornecedor 	= $dados[1];
						$nr_nf 			= $dados[3];
						$cod_produto 	= $dados[6];
						$nm_produto 	= $dados[8];
						$centro_custo	= $dados[9];
						$nr_qtde 		= $dados[10];
						$vl_unit 		= str_replace("R$ ","",str_replace(",",".",str_replace(".","",$dados[11])));
						$vl_total_item 	= str_replace("R$ ","",str_replace(",",".",str_replace(".","",$dados[12])));

						// CONSULTA FORNECEDOR JÁ EXISTEM NA TABELA //

						$sql_frn = "select cod_fornecedor, cod_sap from tb_fornecedor where cod_sap = '".$cod_forn_sap."' and fl_status = 'A'";
						$res_frn = mysqli_query($link, $sql_frn) or die(mysqli_error($link));

						if(mysqli_num_rows($res_frn) > 0){

							echo "Fornecedor '".$cod_forn_sap."' já existe.<br>";
							$dados_frn = mysqli_fetch_assoc($res_frn);
							$cod_fornecedor = $dados_frn['cod_fornecedor'];

						}else{

							$ins_frn = "insert into tb_fornecedor (cod_sap, nm_fornecedor, fl_status, usr_create, dt_create) values ('".$cod_forn_sap."', '".$nm_fornecedor."',  'A', '".$id."', '".$date."')";
							$res_frn = mysqli_query($link1, $ins_frn);

							if(mysqli_affected_rows($link1) > 0){

								$cod_fornecedor = mysqli_insert_id($link1);
								echo "Fornecedor ".$cod_forn_sap.", código ".$cod_fornecedor." cadastrada.<br>";

							}else{

								echo "Fornecedor ".$cod_forn_sap." não cadastrada.<br>";

							}

						}

						// GRAVA NOME DO FORNECEDOR NA OR //

						$upd_or = "update tb_recebimento set nm_fornecedor = '$nm_fornecedor' where cod_recebimento = '$Nrec'";
						$res_upd = mysqli_query($link, $upd_or) or die(mysqli_error($link));

						// CONSULTA SE NOTA FISCAL E FORNECEDOR JÁ EXISTEM NA TABELA DE NOTAS DE ENTRADA COM OUTRO NÚMERO DE OR //

						$sql = "select cod_nf_entrada, cod_fornecedor, nr_fisc_ent from tb_nf_entrada where cod_fornecedor = '".$cod_forn_sap."' and nr_fisc_ent = '".$nr_nf."' and fl_status = 'A'";
						$res = mysqli_query($link, $sql) or die(mysqli_error($link));

						if(mysqli_num_rows($res) > 0){

							echo "Nota fiscal '".$nr_nf."' e fornecedor '".$cod_forn_sap."' já existem.<br>";
							$dados_nf = mysqli_fetch_assoc($res);
							$cod_nf_entrada = $dados_nf['cod_nf_entrada'];

						}else{

							$ins_nf = "insert into tb_nf_entrada (cod_fornecedor, nr_fisc_ent, cod_rec, nr_ccusto, fl_status, usr_create, dt_create) values ('".$cod_forn_sap."', '".$nr_nf."', '".$Nrec."', '".$centro_custo."', 'A', '".$id."', '".$date."')";
							$res_nf = mysqli_query($link1, $ins_nf);

							if(mysqli_affected_rows($link1) > 0){

								$cod_nf_entrada = mysqli_insert_id($link1);
								echo "Nota fiscal ".$nr_nf.", código ".$cod_nf_entrada." cadastrada.<br>";

							}else{

								echo "Nota fiscal ".$nr_nf." não cadastrada.<br>";

							}

						}

						// VERIFICA SE PRODUTO ESTÁ CADASTRADO, SE NÃO ESTIVER FAZ O CADASTRO  //

						$sql_prd = "select cod_produto from tb_produto where cod_prod_cliente = '".$cod_produto."' and fl_status = 'A'";
						$res_prd = mysqli_query($link, $sql_prd) or die(mysqli_error($link));

						if(mysqli_num_rows($res_prd) > 0){

							echo "Produto '".$cod_produto."' já existe.<br>";

						}else{

							$ins_prd = "insert into tb_produto (cod_prod_cliente, nm_produto, fl_status, user_create, dt_create) values ('".$cod_produto."', '".$nm_fornecedor."', 'A', '".$id."', '".$date."')";
							$res_ins = mysqli_query($link1, $ins_prd);

							if(mysqli_affected_rows($link1) > 0){

								echo "Produto ".$cod_produto." cadastrado.<br>";

							}else{

								echo "Produto ".$cod_produto." não cadastrado.<br>";

							}
						}

						//  VERIFICA SE ITEM DA NOTA ESTÁ CADASTRADO, SE NÃO ESTIVER FAZ O CADASTRO //

						$sql_itm = "select cod_nf_entrada, produto from tb_nf_entrada_item where cod_nf_entrada = '".$cod_nf_entrada."' and produto = '".$cod_produto."' and fl_status = 'A'";
						$res_itm = mysqli_query($link, $sql_itm) or die(mysqli_error($link));

						if(mysqli_num_rows($res_itm) > 0){

							echo "Item da nota '".$cod_produto."' já existe.<br>";

						}else{

							$ins_prd = "insert into tb_nf_entrada_item (cod_nf_entrada, produto, nr_qtde, vl_unit, vl_total, cod_rec, fl_status, usr_create, dt_create) values ('".$cod_nf_entrada."', '".$cod_produto."', '".$nr_qtde."', '".$vl_unit."', '".$vl_total_item."', '".$Nrec."', 'A', '".$id."', '".$date."')";
							$res_ins = mysqli_query($link2, $ins_prd);

							if(mysqli_affected_rows($link2) > 0){

								echo "Item da ".$cod_produto." cadastrado.<br>";

							}else{

								echo "Item da ".$cod_produto." não cadastrado.<br>";

							}
						}
					}
				}

				//  VERIFICA SE TODOS OS PRODUTOS FORAM INCLUÍDOS NA OR //

				$sql_cnf = "select count(distinct cod_nf_entrada) as total_nf, count(cod_nf_entrada_item) as total_item from tb_nf_entrada_item where cod_rec = '".$Nrec."' and  fl_status = 'A'";
				$res_cnf = mysqli_query($link, $sql_cnf) or die(mysqli_error($link));

				if(mysqli_num_rows($res_cnf) > 0){

					$dados_cnf = mysqli_fetch_assoc($res_cnf);

					echo "Foram incluídos ".$dados_cnf['total_item']." itens em ".$dados_cnf['total_nf']." notas fiscais.<br>";


				}else{

					echo "Ocorreu um erro, não foram incluídos itens na OR ".$Nrec.". Por favor verifique o lay-out da planilha usada na importação.<br>";

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


}else{

	echo "OR não cadastrada";

}

$link->close();
$link1->close();
$link2->close();
?>