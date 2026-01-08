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

$date2 = date('Y-m-d', strtotime('-1 days', strtotime($date)));

if($cod_cli == '3'){

	$empresa = "SÃO JOSÉ DOS CAMPOS - SP";
	$email_conf = "atendimentosjc@3cservices.com.br";
	$copia_a 	= "sebastiao.silva@3cservices.com.br";
	$copia_b 	= "recebimentosjc@3cservices.com.br";
	$copia_c 	= "robson.ferreira@3cservices.com.br";
	$copia_d 	= "eduardomenocio@growupsti.com.br";
	$copia_e 	= "";

}else{

	$empresa = "VILA VELHA - ES";
	$email_conf = "atendimentoes@3cservices.com.br";
	$copia_a 	= "recebimentoes@3cservices.com.br";
	$copia_b 	= "gabriel.fernandes@3cservices.com.br";
	$copia_c 	= "christian.galvao@3cservices.com.br";
	$copia_d 	= "eduardomenocio@growupsti.com.br";
	$copia_e 	= "operacionales@3cservices.com.br";

}
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

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

			$arquivo2 = fopen($origem, 'r');

			$result = "<table class='table table-bordered'>
						<thead>
							<th>PRODUTO</th>
							<th>ESTOQUE</th>
							<th>SALDO MB</th>
							<th>STATUS</th>
						</thead>
						<tbody>";
			
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'Material' && !empty($linha)){

					$produto 		= $dados[0];
					$vlr_total 		= str_replace(",",".",str_replace(".","",$dados[4]));
					$nr_qtde 		= str_replace(",",".",str_replace(".","",$dados[6]));

					$sql_id = "select max(id) as id_saldo, coalesce(nr_saldo,0) as nr_saldo from tb_fc_saldo_dia where cod_produto = '".$produto."' and fl_empresa = '".$cod_cli."'";
					$res_id = mysqli_query($link, $sql_id);

					if(mysqli_num_rows($res_id) > 0){

						$last_id = mysqli_fetch_assoc($res_id);
						$id_saldo = $last_id['id_saldo'];
						$nr_saldo = $last_id['nr_saldo'];

						//echo "Produto: ".$produto." Valor: ".$vlr_total." Qtde: ".$nr_qtde." ID Saldo: ".$id_saldo."<br>";

						if($nr_saldo != $nr_qtde){

							echo "Saldo divergente!<br>";

							$upd_sd = "update tb_fc_saldo_dia set nr_saldo_mb = '".$nr_qtde."', vlr_mb = '".$vlr_total."' where id = '".$id_saldo."'";
							$res_upd = mysqli_query($link, $upd_sd);

							if(mysqli_affected_rows($link) > 0){


								echo "Saldo atualizado!<br>";
								echo "Produto: ".$produto." Valor: ".$vlr_total." Qtde: ".$nr_qtde." Saldo: ".$nr_saldo." ID Saldo: ".$id_saldo."<br>";

								$result .= "<tr>
												<td style='text-align:center'>".$produto."</td>
												<td style='text-align:right'>".$nr_saldo."</td>
												<td style='text-align:right'>".$nr_qtde."</td>
												<td>SALDO DIVERGENTE</td>
											</tr>";

							}else{

								echo "Nao atualizado.<br>";
								//echo "Produto: ".$produto." Valor: ".$vlr_total." Qtde: ".$nr_qtde." Saldo: ".$nr_saldo." ID Saldo: ".$id_saldo."<br>";

								/*$result .= "<tr>
												<td style='text-align:center'>".$produto."</td>
												<td style='text-align:right'>".$nr_saldo."</td>
												<td style='text-align:right'>".$nr_qtde."</td>
												<td><h3>SALDO NÃO ATUALIZADO</h3></td>
											</tr>";*/

							}

						}else{

							echo "Saldo ok!<br>";
							
							/*$result .= "<tr>
											<td style='text-align:center'>".$produto."</td>
											<td style='text-align:right'>".$nr_saldo."</td>
											<td style='text-align:right'>".$nr_qtde."</td>
											<td><h3>SALDO OK</h3></td>
										</tr>";*/


							//echo "Produto: ".$produto." Valor: ".$vlr_total." Qtde: ".$nr_qtde."<br>";
						}

					}else{

						echo "Produto: ".$produto." nao encontrado.<br>";

						/*$result .= "<tr>
										<td style='text-align:center'>".$produto."</td>
										<td style='text-align:right'>".$nr_saldo."</td>
										<td style='text-align:right'>".$nr_qtde."</td>
										<td><h3>PRODUTO NÃO ENCONTRADO</h3></td>
									</tr>";*/


							//echo "Produto: ".$produto." Valor: ".$vlr_total." Qtde: ".$nr_qtde."<br>";

					}
				}
			}

			$result .= "</tbody>
						</table>";

			fclose($arquivo2);

			$importado = 'sap/importados/'.$nome;
			copy($origem, $importado);

			require 'PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host = "smtp.hostinger.com.br";
			$mail->Port = 587; 
			$mail->SMTPAutoTLS = true;
			$mail->SMTPAuth = true;
			$mail->Username = 'agendamento3c@argussistemas.com.br';
			$mail->Password = 'ag3c2019#';

			$mail->From = "agendamento3c@argussistemas.com.br";
			$mail->FromName = "ARGUS WMS";

			$mail->AddAddress($email_conf, 'Responsável');
			$mail->AddCC($copia_a, 'Destinatário');	
			$mail->AddCC($copia_b, 'Destinatário');	
			$mail->AddCC($copia_c, 'Destinatário');	
			$mail->AddCC($copia_d, 'Sistemas');	
			$mail->AddCC($copia_e, 'Operacional');	
			$mail->AddCC('gabriel.fernandes@3cservices.com.br', 'Coordenador');
						
			$mail->IsHTML(true);
			$mail->CharSet = 'UTF-8';
			$mail->Subject = "Relação de produtos com divergência de saldo com SAP CD ".$empresa." - ".$date2;
			$mail->Body = $result;

			$enviado = $mail->Send();

			$mail->ClearAllRecipients();
			$mail->ClearAttachments();

			if ($enviado) {

				$array_parte = array(
					'info' 	=> "0",
				);
				
				echo "E-mail enviado com sucesso!<br />";

			} else {

				$array_parte = array(
					'info' 	=> "1",
				);
			}

			unlink($origem);

		}else{

			echo "Erro ao realizar upload";

		}

	}
}

$link->close();
?>