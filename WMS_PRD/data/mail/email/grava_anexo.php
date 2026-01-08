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

$nlidas = imap_num_recent($mbox);

$folders = imap_listmailbox($mbox, "{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert}", "*");

$result = imap_search($mbox, 'UNSEEN');

//echo $result;

//if ($nlidas == 0) {
//	$retorno[] = array(
//		'info'	=> "1",
		//'result'	=> $result,
//	);
//} else{

	//Inserir o pedido no BD
	$ins_pedido = "insert into tb_pedido_coleta (nr_pedido, cod_cliente, nm_usuario, dt_pedido, fl_status, fl_tipo) values ('$novo_pedido', 110, 2, now(), 'A', 'A')";
	$res_pedido = mysqli_query($link1, $ins_pedido) or die(mysqli_error($link1));

	if(mysqli_affected_rows($link1) > 0){

		for($i = 1;$i <= imap_num_msg($mbox);$i++) {

			$headers            = imap_header($mbox, $i);
			$uid 	 			= imap_uid($mbox,$i);
			$dados 				= imap_base64(imap_fetchbody($mbox, $i,2));
			$naolida			= $headers->Unseen;

			echo "Não lida: ".$naolida."<br>";

			

			if($result != false){

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
							$cod_prod_cliente 			= $linha->getElementsByTagName("Data")->item(0)->nodeValue;
							$nr_qtde 					= $linha->getElementsByTagName("Data")->item(1)->nodeValue;
							$ds_endereco 				= $linha->getElementsByTagName("Data")->item(3)->nodeValue;
							$ds_galpao 					= $ds_endereco[0].$ds_endereco[1].$ds_endereco[2];
							$ds_prateleira 				= $ds_endereco[3].$ds_endereco[4].$ds_endereco[5];
							$letraGalpao				= $ds_endereco[0];

							if($ds_endereco[0] == "P"){

								$ds_coluna				= $ds_endereco[7].$ds_endereco[8];

								$ds_altura				= "A";

							}else{

								$ds_coluna				= $ds_endereco[7].$ds_endereco[8].$ds_endereco[9];

								$ds_altura				= $ds_endereco[6];

							}

							$dt_pedido 					= $linha->getElementsByTagName("Data")->item(4)->nodeValue;

							echo "Endereço: $ds_endereco <br>";
							echo "Galpão: $ds_galpao <br>";
							echo "Rua: $ds_prateleira <br>";
							echo "Coluna: $ds_coluna <br>";
							echo "Altura: $ds_altura <br>";
/*
						$array_xml[] = array(
							'info'				=> '7',
							'pedido'			=> $novo_pedido,
							'cod_prod_cliente' 	=> $cod_prod_cliente,
							'nr_qtde' 			=> $nr_qtde,
							'ds_galpao' 		=> $ds_galpao,
							'ds_prateleira'		=> $ds_prateleira,
							'ds_coluna' 		=> $ds_coluna,
							'ds_altura' 		=> $ds_altura,
							'dt_pedido' 		=> $dt_pedido,
						);
*/
						//Verifica o id do galpão
						$sql_galpao = "select id, ds_apelido from tb_armazem where ds_apelido = '$ds_galpao'";
						$res_galpao = mysqli_query($link, $sql_galpao) or die(mysqli_error($link));
						while ($galpao=mysqli_fetch_assoc($res_galpao)) {
							$id=$galpao['id'];
						}

						//Verifica o código do produto
						$sql_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente'";
						$res_prod = mysqli_query($link, $sql_prod) or die(mysqli_error($link));
						while ($produto=mysqli_fetch_assoc($res_prod)) {
							$cod_produto=$produto['cod_produto'];
						}

						if(mysqli_num_rows($res_prod) > 0){

							$ins_item = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, fl_status, usr_create, dt_create) values ('$novo_pedido', '$cod_produto', '$nr_qtde', 'A', 2, now())";
							$res_item = mysqli_query($link2, $ins_item);

							if(mysqli_affected_rows($link2)){

								$retorno[] = array(
									'info'	=> "2",
								);

							}else{

								$retorno[] = array(
									'info'	=> "3",
								);

							}

						}else{

							$retorno[] = array(
								'info'	=> "4",
							);

						}
						

					}
					$primeira_linha = false;
					$retorno[] = array(
						'info'	=> "7",
					);
				}

				//Fecha o novo arquivo
				fclose($arq);

				//Copia para diretório importados
				$destino = 'importados/'.$nomeAnexo;
				$origem  = 'anexos/'.$nomeAnexo;
				copy($origem, $destino);
				unlink($origem);


			}else{

				$retorno[] = array(
					'info'	=> "5",
				);

			}
			//marca a mensagem como lida
			imap_setflag_full($mbox, $uid, "\\Seen", ST_UID);

		}else{

			$retorno[] = array(
				'info'	=> "8",
			);

		}

	}

//}else{

//	$retorno[] = array(
//		'info'	=> "6",
//	);

//}
echo(json_encode($retorno));

}
imap_close($mbox);
$link->close();
$link1->close();
$link2->close();