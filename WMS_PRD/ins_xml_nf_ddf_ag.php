<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];

	echo $cod_cli;
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
$link3 = $objDb->conecta_mysql();

$id_rec = $_POST["id_rec"];
$arquivo = $_POST['caminho'];

$origem = 'xml/'.$arquivo;

$Arrxml = simplexml_load_file('xml/' . $arquivo);
foreach ($Arrxml->NFe as $key => $xml) {
	$nr_nf_formulario 	= $xml->infNFe->ide->nNF;
	$nr_serie 			= $xml->infNFe->ide->serie;
	$nr_cfop 			= $xml->infNFe->det->prod->CFOP;
	$dt_emissao 		= $xml->infNFe->ide->dhEmi;
	$ds_nat_op 			= $xml->infNFe->ide->natOp;
	$nm_cliente 		= $xml->infNFe->emit->xNome;
	$nm_fantasia 		= $xml->infNFe->emit->xFant;
	$nr_cnpj 			= $xml->infNFe->emit->CNPJ;
	$nr_ie 				= $xml->infNFe->emit->IE;
	$ds_endereco 		= $xml->infNFe->emit->enderEmit->xLgr;
	$numero 			= $xml->infNFe->emit->enderEmit->nro;
	if($numero > 0){

		$nr_numero = $numero;

	}else{

		$nr_numero = 0;

	}
	$ds_bairro 			= $xml->infNFe->emit->enderEmit->xBairro;
	$ds_cidade 			= $xml->infNFe->emit->enderEmit->xMun;
	$ds_uf 				= $xml->infNFe->emit->enderEmit->UF;
	$nr_telefone 		= $xml->infNFe->emit->enderEmit->fone;
	$ds_cep 			= $xml->infNFe->emit->enderEmit->CEP;
	$cod_mun_org 		= $xml->infNFe->emit->enderEmit->cMun;
	$nm_destinatario 	= $xml->infNFe->dest->xNome;
	$nr_cnpj_dest 		= $xml->infNFe->dest->CNPJ;
	$nr_ie_dest 		= $xml->infNFe->dest->IE;
	$ds_endereco_dest 	= $xml->infNFe->dest->enderDest->xLgr;
	$numero_dest 		= $xml->infNFe->dest->enderDest->nro;
	if($numero_dest > 0){

		$nr_numero_dest = $numero_dest;

	}else{

		$nr_numero_dest = 0;

	}
	$ds_bairro_dest 	= $xml->infNFe->dest->enderDest->xBairro;
	$ds_cidade_dest 	= $xml->infNFe->dest->enderDest->xMun;
	$ds_uf_dest 		= $xml->infNFe->dest->enderDest->UF;
	$ds_cep_dest 		= $xml->infNFe->dest->enderDest->CEP;
	$cod_mun_dest 		= $xml->infNFe->dest->enderDest->cMun;
	$nr_telefone_dest 	= $xml->infNFe->dest->enderDest->fone;
	$nr_peso 			= $xml->infNFe->transp->vol->pesoB;
	$vl_mercadoria 		= $xml->infNFe->total->ICMSTot->vNF;
	$nr_volume 			= $xml->infNFe->transp->vol->qVol;
	$tp_vol 			= $xml->infNFe->transp->vol->esp;
	$item 				= $xml->infNFe->det ->prod->cProd;

	/* GRAVA CHAVE DA NOTA FISCAL */

	foreach ($Arrxml->protNFe as $key => $chave) {
		$nfe_chave = $chave->infProt->chNFe;
	}

	/* VALIDAÇÃO DO REMENTE DA NOTA*/

	$sql_rem = "select cod_cliente, nm_cliente from tb_cliente where nr_cnpj_cpf = '$nr_cnpj'";
	$res_rem = mysqli_query($link, $sql_rem) or die(mysqli_error($link));
	while ($rem=mysqli_fetch_assoc($res_rem)) {
		$nm_cliente=$rem['nm_cliente'];
		$cod_rem=$rem['cod_cliente'];
	}
	if(mysqli_num_rows($res_rem) > 0){

		echo '<hr>';
		echo 'Remetente '.$nm_cliente.' já existe.<br>';

	}else{

		$sql_rem = "insert into tb_cliente (nm_cliente, nr_cnpj_cpf, ds_ie_rg, ds_endereco, nr_numero, ds_bairro, ds_cidade, cod_mun, ds_cep, ds_uf, nr_telefone, nm_fantasia, fl_tipo, fl_status) values ('$nm_cliente', '$nr_cnpj', '$nr_ie', '$ds_endereco', '$nr_numero', '$ds_bairro', '$ds_cidade', '$cod_mun_org', '$ds_cep', '$ds_uf', '$nr_telefone', '$nm_fantasia', 'E', 'A')";
		$res_rem = mysqli_query($link2, $sql_rem);
		$cod_rem = mysqli_insert_id($link2);

		if(mysqli_affected_rows($link2) > 0){

			echo 'Remetente '.$nm_cliente.' cadastrado.<br>';

		}else{
			echo 'Erro no cadastro do remetente.<br>';
		}

	}

	/* VALIDAÇÃO DO DESTINATÁRIO DA NOTA*/

	$sql_dest = "select cod_cliente, nm_cliente from tb_cliente where nr_cnpj_cpf = '$nr_cnpj_dest'";
	$res_dest = mysqli_query($link, $sql_dest) or die(mysqli_error($link));
	while ($dest=mysqli_fetch_assoc($res_dest)) {
		$nm_destinatario_cad=$dest['nm_cliente'];
		$cod_dst=$dest['cod_cliente'];
	}
	if(mysqli_num_rows($res_dest) > 0){

		echo '<hr>';
		echo 'Destinatário '.$nm_destinatario_cad.' já existe.<br>';

	}else{

		$sql_dest = "insert into tb_cliente (nm_cliente, nr_cnpj_cpf, ds_ie_rg, ds_endereco, nr_numero, ds_bairro, ds_cidade, cod_mun, ds_cep, ds_uf, nr_telefone, fl_tipo, fl_status) values ('$nm_destinatario', '$nr_cnpj_dest', '$nr_ie_dest', '$ds_endereco_dest', '$nr_numero_dest', '$ds_bairro_dest', '$ds_cidade_dest', '$cod_mun_dest', '$ds_cep_dest', '$ds_uf_dest', '$nr_telefone_dest', 'D', 'A')";
		$res_dest = mysqli_query($link3, $sql_dest);
		$cod_dst = mysqli_insert_id($link3);

		if(mysqli_affected_rows($link3) > 0){

			echo 'Destinatário '.$nm_destinatario.' cadastrado.<br>';

		}else{
			echo 'Erro no cadastro do destinatário.<br>';
		}

	}

	/* VERIFICA SE A NOTA FISCAL JÁ EXISTE, SE NÃO EXITIR FAZ O CADASTRO DA NOTA*/

	$sql_nf = "select cod_nf_entrada, nr_fisc_ent from tb_nf_entrada where id_rem = '$cod_rem' and nr_fisc_ent = '$nr_nf_formulario' and fl_empresa = '$cod_cli'";
	$res_nf = mysqli_query($link, $sql_nf) or die(mysqli_error($link));
	while ($nf = mysqli_fetch_assoc($res_nf)) {
		$n_fiscal 	= $nf['nr_fisc_ent'];
	}
	if(mysqli_num_rows($res_nf) > 0){

		echo '<hr>';
		echo 'Nota fiscal '.$n_fiscal.' já foi importada anteriormente, ';

	}else{

		$sql = "insert into tb_nf_entrada (nr_fisc_ent, id_rem, id_dest, dt_emis_ent, chavenfe, nr_peso_ent, vl_tot_nf_ent, qtd_vol_ent, tp_vol_ent, fl_status, fl_empresa, cod_rec, usr_create, dt_create) values ('$nr_nf_formulario', '$cod_rem', '$cod_dst', '$dt_emissao', '$nfe_chave', '$nr_peso', '$vl_mercadoria', '$nr_volume', '$tp_vol', 'A', '$cod_cli', '$id_rec', '$id', '$date')";
		$result_id = mysqli_query($link1, $sql) or die(mysqli_error($link1));
		$nova_nf = mysqli_insert_id($link1);

		/* VERIFICA SE A NOTA FISCAL FOI CADASTRADA, SE SIM, CADASTRA OS ITENS DA NOTA */

		if (mysqli_affected_rows($link1) > 0) {

			$semResultado = 0;
			for ($i=0; $i <=1000 ; $i++) { 

				if(!empty($xml->infNFe->det[$i]->prod->cProd)){

					$produto = $xml->infNFe->det[$i]->prod->cProd;
					$nm_produto = $xml->infNFe->det[$i]->prod->xProd;
					$nr_qtde = $xml->infNFe->det[$i]->prod->qCom;
					$nr_valor = $xml->infNFe->det[$i]->prod->vProd;
					$unidade = $xml->infNFe->det[$i]->prod->uCom;
					$nr_ean = $xml->infNFe->det[$i]->prod->cEANTrib;
					$semResultado = 0;

					if($unidade == "KG"){

						$sql_prd = "insert into tb_nf_entrada_item (cod_nf_entrada, produto, nm_produto, nr_peso_unit, vl_unit, ds_unid, nr_ean) values ('$nova_nf', '$produto', '$nm_produto', '$nr_qtde', '$nr_valor', '$unidade', '$nr_ean')";
						$res_prd = mysqli_query($link, $sql_prd);



					}else{

						$sql_prd = "insert into tb_nf_entrada_item (cod_nf_entrada, produto, nm_produto, nr_qtde, vl_unit, ds_unid, nr_ean) values ('$nova_nf', '$produto', '$nm_produto', '$nr_qtde', '$nr_valor', '$unidade', '$nr_ean')";
						$res_prd = mysqli_query($link, $sql_prd);



					}

				} else {
					$semResultado ++;
				}
				if($semResultado >= 1000){
					break;
				}
			} 

			/* VERIFICA SE A NOTA FISCAL VEIO COM PESO E VOLUME. SE NÃO, SOMA OS ITENS DA NOTA E ATUALIZA A NOTA COM O TOTAL NO PESO E VOLUME */

			$sql_peso = "select nr_peso_ent, qtd_vol_ent from tb_nf_entrada where cod_nf_entrada = '$nova_nf'";
			$res_peso = mysqli_query($link, $sql_peso) or die(mysqli_error($link));
			while ($peso = mysqli_fetch_assoc($res_peso)) {
				$nr_peso 		= $peso['nr_peso_ent'];
				$nr_volume 		= $peso['qtd_vol_ent'];
			}

			if($nr_peso == 0 && $nr_volume == 0){

				$sum_peso = "select sum(nr_peso_unit) as total from tb_nf_entrada_item where cod_nf_entrada = '$nova_nf'";
				$res_sum = mysqli_query($link, $sum_peso) or die(mysqli_error($link));
				while ($sum = mysqli_fetch_assoc($res_sum)) {
					$novo_peso 		= $sum['total'];
				}

				$upd_peso = "update tb_nf_entrada set nr_peso_ent = '$novo_peso', qtd_vol_ent = '$novo_peso' where cod_nf_entrada = '$nova_nf'";
				$res_upd = mysqli_query($link, $upd_peso);

			}

			echo '<hr>';
			echo 'Nota fiscal importada com sucesso.';
			echo '<hr>';
			echo '<strong>NF:</strong> ' . $xml->infNFe->ide->nNF . '<br>';
			echo '<strong>Serie:</strong> ' . $xml->infNFe->ide->serie . '<br>';
			echo '<strong>Cfop:</strong> ' . $xml->infNFe->det->prod->CFOP . '<br>';
			echo '<strong>dtEmissão:</strong> ' . $xml->infNFe->ide->dhEmi . '<br>';
			echo '<strong>natOp:</strong> ' . $xml->infNFe->ide->natOp . '<br>';
			echo '<strong>Emitente:</strong> ' . $xml->infNFe->emit->xNome . '<br>';
			echo '<strong>Cnpj:</strong> ' . $xml->infNFe->emit->CNPJ . '<br>';
			echo '<strong>IE:</strong> ' . $xml->infNFe->emit->IE . '<br>';
			echo '<strong>Endereço:</strong> ' . $xml->infNFe->emit->enderEmit->xLgr . '<br>';
			echo '<strong>Numero:</strong> ' . $xml->infNFe->emit->enderEmit->nro . '<br>';
			echo '<strong>Bairro:</strong> ' . $xml->infNFe->emit->enderEmit->xBairro . '<br>';
			echo '<strong>Cidade:</strong> ' . $xml->infNFe->emit->enderEmit->xMun . '<br>';
			echo '<strong>UF:</strong> ' . $xml->infNFe->emit->enderEmit->UF . '<br>';
			echo '<strong>Código Município de origem:</strong> ' . $xml->infNFe->emit->enderEmit->cMun . '<br>';
			echo '<strong>CEP:</strong> ' . $xml->infNFe->emit->enderEmit->CEP . '<br>';
			echo '<strong>Destinatário:</strong> ' . $xml->infNFe->dest->xNome. '<br>';
			echo '<strong>Cnpj:</strong> ' . $xml->infNFe->dest->CNPJ. '<br>';
			echo '<strong>IE:</strong> ' . $xml->infNFe->dest->IE. '<br>';
			echo '<strong>Endereço:</strong> ' . $xml->infNFe->dest->enderDest->xLgr . '<br>';
			echo '<strong>Numero:</strong> ' . $xml->infNFe->dest->enderDest->nro. '<br>';
			echo '<strong>Bairro:</strong> ' . $xml->infNFe->dest->enderDest->xBairro. '<br>';
			echo '<strong>Cidade:</strong> ' . $xml->infNFe->dest->enderDest->xMun. '<br>';
			echo '<strong>UF:</strong> ' . $xml->infNFe->dest->enderDest->UF. '<br>';
			echo '<strong>Código Município de destino:</strong> ' . $xml->infNFe->dest->enderDest->cMun. '<br>';
			echo '<strong>CEP:</strong> ' . $xml->infNFe->dest->enderDest->CEP. '<br>';
			echo '<strong>Peso:</strong> ' . $xml->infNFe->transp->vol->pesoB . '<br>';
			echo '<strong>Vmercadoria:</strong> ' . $xml->infNFe->total->ICMSTot->vNF . '<br>';
			echo '<strong>Volumes:</strong> ' . $xml->infNFe->transp->vol->qVol . '<br>';
			echo '<strong>Chave:</strong> ' . $nfe_chave . '<br>';


		} else {

			echo 'Erro na inclusão de notas fiscais.';
		}

		$destino = 'xml/importados/'.$arquivo;
		copy($origem, $destino);
		unlink($origem);

	}		

}

$link->close();
$link1->close();
$link2->close();
$link3->close();
?>