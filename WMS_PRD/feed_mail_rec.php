 <?php
 session_start();
 ?>
 <?php

 if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

 	header("Location:../../index.php");
 	exit;

 } else {

 	$id         = $_SESSION["id"];
 	$cod_cli    = $_SESSION['cod_cli'];
 }
 ?>
 <?php

 header('Content-Type: text/html; charset=UTF-8');
 date_default_timezone_set('America/Sao_Paulo');
 $date = date('c');

 require_once 'bd_class.php';
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $cod_rec 	= $_POST['upd_rec'];
 $id_jan 	= $_POST['id_jan'];

 $sql = "select t1.cod_recebimento, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.nr_peso_previsto, t1.nr_volume_previsto, t1.nr_insumo, t1.ds_email_sol, t1.ds_tipo_vol, date_format(t1.dt_create,'%d/%m/%Y %H:%i') as dt_create, CASE t1.fl_status WHEN 'S' THEN 'AGUARDANDO CONFIRMAÇÃO' WHEN 'AG' THEN 'CONFIRMADO' END as fl_status,  date_format(t2.dt_janela,'%d/%m/%Y') as dt_janela, t2.ds_janela, t3.ds_cidade, t3.ds_uf, t1.ds_motivo
 from tb_recebimento_ag t1
 left join tb_janela t2 on t2.id = t2.cod_rec
 left join tb_empresa t3 on t2.fl_empresa = t3.cod_empresa
 where t1.cod_recebimento = '$cod_rec'";
 $res = mysqli_query($link, $sql);
 while ($dados = mysqli_fetch_assoc($res)) {
 	$cod_recebimento 		= $dados['cod_recebimento'];
 	$nm_transportadora 		= $dados['nm_transportadora'];
 	$nm_motorista 			= $dados['nm_motorista'];
 	$nm_placa 				= $dados['nm_placa'];
 	$nr_peso_previsto 		= $dados['nr_peso_previsto'];
 	$nr_volume_previsto 	= $dados['nr_volume_previsto'];
 	$nr_insumo 				= $dados['nr_insumo'];
 	$ds_email_sol 			= $dados['ds_email_sol'];
 	$ds_tipo_vol 			= $dados['ds_tipo_vol'];
 	$dt_create 				= $dados['dt_create'];
 	$fl_status 				= $dados['fl_status'];
 	$ds_cidade 				= $dados['ds_cidade'];
 	$ds_uf 					= $dados['ds_uf'];
 	$ds_motivo 				= $dados['ds_motivo'];
 }

 $sql_jan = "select id, date_format(dt_janela,'%d/%m/%Y') as dt_janela, ds_janela
 from tb_janela
 where id = '$id_jan'";
 $res_jan = mysqli_query($link, $sql_jan);
 while ($dados_jan = mysqli_fetch_assoc($res_jan)) {
 	$id 		= $dados_jan['id'];
 	$dt_janela 	= $dados_jan['dt_janela'];
 	$ds_janela 	= $dados_jan['ds_janela'];
 }
 if($cod_cli == '3'){

 	$email_copia = "recebimentosjc@3cservices.com.br";

 }else{

 	$email_copia = "recebimentoes@3cservices.com.br";

 }

 $html = '<header id="header">
 <div id="logo-group">
 <span id="logo" style="margin-top: 5px"> <img src="https://www.argussistemas.com.br/img/logo12.png" alt="Argus" style="width:160px;height:60px"></span>
 <span id="logo" style="margin-top: 3px"> <img src="https://www.argussistemas.com.br/img/logo3c2.png" alt="3C" style="width:140px;height:50px"></span>
 </div>
 <div style="float: center">
 <h3 style="color: #FF8C00"><strong>ALTERAÇÃO DE STATUS DE AGENDAMENTO DE ENTREGA</strong></h3>
 </div>
 </header>';
 $html .= '<div><table>';
 $html .= '<tr><th>ATENÇÃO: Agendamento N.o: '.$cod_recebimento.' Data: '.$dt_janela.' Horário: '.$ds_janela.' NOVO STATUS: RECUSADO.</th></tr>';
 $html .= '<tr><td>Motivo: </td><td><p style="text-align:rigth">'.$ds_motivo.'</p></td></tr>';
 $html .= '</table></div>';

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
 $mail->FromName = "Agendamento de entregas 3C EDP";

 $mail->AddAddress($ds_email_sol, 'Solicitante');
 $mail->AddCC($email_copia, 'Recebimento 3C'); 
 $mail->IsHTML(true);
 $mail->CharSet = 'UTF-8';
 $mail->Subject = "Agendamento de entregas 3C EDP";
 $mail->Body = $html;

 $enviado = $mail->Send();

 $mail->ClearAllRecipients();
 $mail->ClearAttachments();

 if ($enviado) {

 	echo "E-mail enviado!";

 } else {

 	echo "E-mail não enviado!";
 }

//echo $html;
 $link->close();
 ?>