<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Sao_Paulo');
$date = date('c');

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.id, t1.nr_docto, t1.dt_docto, DATEDIFF(date(t1.dt_docto), date(now())) as qtd_dias, CASE t1.fl_tipo when 'C' THEN 'CA' when 'L' then 'LAUDO' END as tipo, t2.produto, t3.nm_produto, t2.cod_estoque, t2.ds_galpao, t4.nome, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, round(t2.nr_qtde,0) as nr_qtde, coalesce(t2.fl_bloq,'N') as fl_bloq, t5.cod_col, t5.nr_pedido, upper(t7.ds_nome) as ds_nome, date_format(t6.dt_pedido,'%d/%m/%Y') as dt_pedido, t5.cod_estoque
from tb_ca t1
left join tb_posicao_pallet t2 on t1.id = (CASE t1.fl_tipo WHEN 'C' then t2.cod_ca when 'L' THEN t2.cod_laudo END) and coalesce(t2.fl_bloq,'N') = 'N'
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_armazem t4 on t2.ds_galpao = t4.id
left join tb_coleta_pedido t5 on t2.cod_estoque = t5.cod_estoque
left join tb_pedido_coleta t6 on t5.nr_pedido = t6.nr_pedido
left join tb_funcionario t7 on t6.cod_almox = t7.nr_matricula
where DATEDIFF(date(t1.dt_docto), date(now())) = '30'";
$res = mysqli_query($link, $sql);

$ds_email = "agendamento3c@argussistemas.com.br";
$email_principal = "paulo.lopes@3cservices.com.br";
$email_copia = "vanessa.rossi@3cservices.com.br";

if(mysqli_num_rows($res) > 0){

	$html = '<header id="header">
				<div id="logo-group">
					<span id="logo" style="margin-top: 5px"> <img src="https://www.argussistemas.com.br/img/logo12.png" alt="Argus" style="width:160px;height:60px"></span>
					<span id="logo" style="margin-top: 3px"> <img src="https://www.argussistemas.com.br/img/logo3c2.png" alt="3C" style="width:140px;height:50px"></span>
				</div>
				<div style="float: center">
					<h3 style="color: #FF8C00"><strong>ALERTA DE VENCIMENTO DE VALIDADE</strong></h3>
				</div>
			</header>';
	$html .= '<div><table>';

	while ($dados = mysqli_fetch_assoc($res)) {

		$html .= '<tr><th>Tipo: '.$dados['tipo'].'</th></tr>';
		$html .= '<tr><td>Documento:</td><td>'.$dados['nr_docto'].'</td><td>Vencimento:</td><td>'.$dados['dt_docto'].'</td><td>Dias até venc.:</td><td>'.$dados['qtd_dias'].'</td></tr>';
		$html .= '<tr><td>Produto:</td><td>'.$dados['produto'].' - '.$dados['nm_produto'].'</td><td>Quantidade:</td><td>'.$dados['nr_qtde'].'</td></tr>';
		$html .= '<tr><td>Local:</td><td>'.$dados['cod_estoque'].' - '.$dados['nome'].' - '.$dados['ds_prateleira'].' - '.$dados['ds_coluna'].' - '.$dados['ds_altura'].'</td></tr>';

		$sql_fun = "select t5.cod_col, t5.nr_pedido, t6.cod_almox, upper(t7.ds_nome) as ds_nome, date_format(t6.dt_pedido,'%d/%m/%Y') as dt_pedido, t5.cod_estoque, t7.cod_depto
		from tb_coleta_pedido t5
		left join tb_pedido_coleta t6 on t5.nr_pedido = t6.nr_pedido
		left join tb_funcionario t7 on t6.cod_almox = t7.nr_matricula
		where t5.cod_estoque = '".$dados['cod_estoque']."'";
		$res_fun = mysqli_query($link, $sql_fun);
		while ($dados_func = mysqli_fetch_assoc($res_fun)) {
			
			$html .= '<tr><th>Funcionário:</th></tr>';
			$html .= '<tr><td>Matrícula:</td><td>'.$dados_func['cod_almox'].'</td><td>C.R.:</td><td>'.$dados_func['cod_depto'].'</td><td>Nome:</td><td>'.$dados_func['ds_nome'].'</td></tr>';
			$html .= '<tr><td>Pedido WMS:</td><td>'.$dados_func['nr_pedido'].'</td><td>Data:</td><td>'.$dados_func['dt_pedido'].'</td></tr>';
		}

	}

	$html .= '</table></div>';
	$html .= '<hr>';
	$html .= '<div><table>';
	$html .= '<tr><th>Informações importantes</th></tr>';
	$html .= '<tr><td><p>1.Todo material que será bloqueado após o vencimento da validade.</p>';
	$html .= '</table></div>';

	require '../../../PHPMailer-master/PHPMailerAutoload.php';

	$mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->Host = "smtp.hostinger.com.br";
	$mail->Port = 587; 
	$mail->SMTPAutoTLS = true;
	$mail->SMTPAuth = true;
	$mail->Username = 'agendamento3c@argussistemas.com.br';
	$mail->Password = 'ag3c2019#';

	$mail->From = "agendamento3c@argussistemas.com.br";
	$mail->FromName = "Informativo de vencimento de validades";

	$mail->AddAddress($email_principal, 'Operação logística'); 
	$mail->AddCC('eduardomenocio@growupsti.com.br', 'Sistemas 3C Logística');
	$mail->AddCC($email_copia, 'Compras'); 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Subject = "ARGUS - Informativo de vencimento de validades";
	$mail->Body = $html;

	$enviado = $mail->Send();

	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	if ($enviado) {
		
		echo "E-mail Ok! ";

		$sql_alert = "insert into tb_log_ca (dt_alerta, tp_alerta, fl_status, usr_create, dt_create) values ('$date', 'LAUDO 30 dias', 'OK', '99', '$date')";
		$res_alert = mysqli_query($link, $sql_alert);

	} else {

		echo "E-mail não enviado!";

		$sql_alert = "insert into tb_log_ca (dt_alerta, tp_alerta, fl_status, usr_create, dt_create) values ('$date', 'LAUDO 30 dias', 'ERRO', '99', '$date')";
		$res_alert = mysqli_query($link, $sql_alert);
	}

}else{

	echo "Não há vencimentos.";

		$sql_alert = "insert into tb_log_ca (dt_alerta, tp_alerta, fl_status, usr_create, dt_create) values ('$date', 'LAUDO 30 dias', 'VAZIO', '99', '$date')";
		$res_alert = mysqli_query($link, $sql_alert);

}

$link->close();
?>