<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

date_default_timezone_set('America/Sao_Paulo');

$mbox = imap_open("{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert}INBOX", "teste@growupsti.com.br", "teste2017");

for($i = 1;$i <= imap_num_msg($mbox);$i++) {

	$headers    = imap_header($mbox, $i);
	$uid 	 	= imap_uid($mbox,$i);
	$dados 		= imap_base64(imap_fetchbody($mbox, $i,2));

	if($dados != ''){

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
					$id_galpao=$galpao['id'];
				}

				$sql_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente' and fl_status = 'A'";
				$res_prod = mysqli_query($link, $sql_prod) or die(mysqli_error($link));
				while ($produto=mysqli_fetch_assoc($res_prod)) {
					$cod_produto=$produto['cod_produto'];

					if($cod_produto != ''){

						$sql_estoq = "select cod_estoque from tb_posicao_pallet where ds_galpao = '$id_galpao' and ds_prateleira = '$ds_prateleira' and ds_coluna = '$ds_coluna' and ds_altura = '$ds_altura' and produto = '$cod_produto' and nr_qtde >= '$nr_qtde'";
						$res_estoq = mysqli_query($link, $sql_estoq) or die(mysqli_error($link));
						while ($estoque=mysqli_fetch_assoc($res_estoq)) {
							$cod_estoque=$estoque['cod_estoque'];
						}

						if($res_estoq){

							$retorno[] = array(
								'info'				=> "0",
								'cod_prod_cliente'	=> $cod_prod_cliente,
								'nr_qtde'			=> $nr_qtde,
								'ds_galpao'			=> $ds_galpao,
								'ds_prateleira'		=> $ds_prateleira,
								'dt_pedido'			=> $dt_pedido,
								'ds_coluna'			=> $ds_coluna,
								'ds_altura'			=> $ds_altura,
								'id_galpao'			=> $id_galpao,
								'cod_produto'		=> $cod_produto,
								'cod_estoque'		=> $cod_estoque,

							);

							echo(json_encode($retorno));

						}else{

							$retorno[] = array(
								'info'	=> "1",

							);
							echo(json_encode($retorno));
						}

					}else{

						$retorno[] = array(
							'info'	=> "2",

						);
						echo(json_encode($retorno));

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

	//imap_delete($mbox, $uid, FT_UID);
}

//imap_expunge($mbox);

imap_close($mbox);

$link->close();
?>