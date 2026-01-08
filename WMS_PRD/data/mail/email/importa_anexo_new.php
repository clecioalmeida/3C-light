<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

//Verifica número do pedido
$Query1="select max(nr_pedido)+1 as novo_pedido from tb_pedido_coleta";
$res1 = mysqli_query($link,$Query1);
while ($dados=mysqli_fetch_assoc($res1)) {
	$novo_pedido=$dados['novo_pedido'];	
}
	//Abre coenxão IMAP
date_default_timezone_set('America/Sao_Paulo');

$mbox = imap_open("{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert}INBOX", "teste@growupsti.com.br", "teste2017");

for($i = 1;$i <= imap_num_msg($mbox);$i++) {

	$headers    = imap_header($mbox, $i);
	$uid 	 	= imap_uid($mbox,$i);
	$dados 		= imap_base64(imap_fetchbody($mbox, $i,2));

	if($dados != ''){

		$ins_pedido = "insert into tb_pedido_coleta (nr_pedido, id_remetente, nm_usuario, dt_pedido, fl_status, fl_tipo) values ('$novo_pedido', 110, 2, now(), 'A', 'A')";
		$res_pedido = mysqli_query($link1, $ins_pedido) or die(mysqli_error($link1));

		if(mysqli_affected_rows($link1) > 0){

			$estrutura = imap_fetchstructure($mbox, $i);

			//Da estrutura, pega o nome do anexo. Dê um print_r na $estrutura quem mais detalhes
			$nomeAnexo = $estrutura->parts[1]->parameters[0]->value;

			//Da mensagem, pega o conteúdo do anexo
			$caminho = 'anexos/';
				//Cria um arquivo com o nome do anexo
			$arq = fopen($caminho.$nomeAnexo,"w");

			//Grava o conteúdo do anexo no novo arquivo. (Não seria mais facil um SaveAs???
			fwrite($arq, $dados);

			$arquivo = new DomDocument();
			$arquivo->load($caminho.$nomeAnexo);

			$linhas = $arquivo->getElementsByTagName("Row");

			$primeira_linha = true;

			foreach($linhas as $linha){

				if($primeira_linha == false){

					$cod_prod_cliente 	= $linha->getElementsByTagName("Data")->item(0)->nodeValue;
					$nr_qtde 			= $linha->getElementsByTagName("Data")->item(1)->nodeValue;
					$ds_endereco 		= $linha->getElementsByTagName("Data")->item(3)->nodeValue;
					$ds_galpao 			= $ds_endereco[0].$ds_endereco[1].$ds_endereco[2];
					$ds_prateleira 		= $ds_endereco[3].$ds_endereco[4].$ds_endereco[5];
					$letraGalpao		= $ds_endereco[0];
					$dt_pedido 			= $linha->getElementsByTagName("Data")->item(4)->nodeValue;

					if($ds_endereco[0] == "P"){

						$ds_coluna		= $ds_endereco[7].$ds_endereco[8];

						$ds_altura		= "A";

					}else{

						$ds_coluna		= $ds_endereco[7].$ds_endereco[8].$ds_endereco[9];

						$ds_altura		= $ds_endereco[6];

					}

					//Procura o id do galpão
					$sql_galpao = "select id, ds_apelido from tb_armazem where ds_apelido = '$ds_galpao'";
					$res_galpao = mysqli_query($link, $sql_galpao) or die(mysqli_error($link));
					while ($galpao=mysqli_fetch_assoc($res_galpao)) {
						$id=$galpao['id'];
					}

					//Procura o código do produto
					$sql_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente' and fl_status = 'A'";
					$res_prod = mysqli_query($link, $sql_prod) or die(mysqli_error($link));
					while ($produto=mysqli_fetch_assoc($res_prod)) {
						$cod_produto=$produto['cod_produto'];
					}

					$sql_estoq = "select cod_estoque from tb_posicao_pallet where ds_galpao = '$ds_galpao' and ds_prateleira = '$ds_prateleira' and ds_coluna = '$ds_coluna' and ds_altura = '$ds_altura' and produto = '$cod_produto' and nr_qtde >= '$nr_qtde'";
					$res_estoq = mysqli_query($link, $sql_estoq) or die(mysqli_error($link));
					while ($estoque=mysqli_fetch_assoc($res_estoq)) {
						$cod_estoque=$galpao['cod_estoque'];
					}

					if(mysqli_num_rows($res_prod) > 0){

						$ins_item = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, fl_status, usr_create, dt_create) values ('$novo_pedido', '$cod_produto', '$nr_qtde', 'A', 2, now())";
						$res_item = mysqli_query($link2, $ins_item);

						if(mysqli_affected_rows($link2) > 0){

							$ins_log = "insert into tb_log_imp_sap (ds_arquivo, nr_pedido, cod_produto, ds_msg, dt_import) values ('$nomeAnexo', '$novo_pedido', '$cod_produto', 'Produto importado com sucesso', now())";
							$res_log = mysqli_query($link, $ins_log) or die(mysqli_error($link));

							$ins_conf = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$novo_pedido', '$cod_produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$nr_qtde', '$id', now(), 'M', '$cod_estoque')";
							$res_conf = mysqli_query($link, $ins_conf) or die(mysqli_error($link));

							if(isset($res_conf)){

								$sql_atualiza = "select nr_qtde from tb_posicao_pallet where cod_estoque = '$cod_estoque'";
								$res_atualiza = mysqli_query($link, $sql_atualiza) or die(mysqli_error($link));
								while ($atualiza=mysqli_fetch_assoc($res_atualiza)) {
									$qtde=$atualiza['nr_qtde'];
								}

								$sql_saldo = "update tb_posicao_pallet set nr_qtde = '$nr_qtde', nr_qtde_ant = '$qtde', nr_pedido_ant = '$novo_pedido', user_update = '$id', dt_update = now() where cod_estoque = '$cod_estoque'";
								$saldo = mysqli_query($link1, $sql_saldo);

							}			

						}
					}
				}

				$primeira_linha = false;

			}

			//Fecha o novo arquivo
			fclose($arq);

			//Copia para diretório importados
			$destino = 'importados/'.$nomeAnexo;
			$origem  = 'anexos/'.$nomeAnexo;
			copy($origem, $destino);
			unlink($origem);

		}

	}

	imap_delete($mbox, $uid, FT_UID);
}

imap_expunge($mbox);

imap_close($mbox);

if(isset($res_log)){

	$retorno[] = array(
		'info'	=> "0",
		'novo_pedido' => $novo_pedido,
	);

	echo(json_encode($retorno));

}else{

	$retorno[] = array(
		'info'	=> "1",
	);

	echo(json_encode($retorno));
}

$link->close();
$link1->close();
$link2->close();
?>