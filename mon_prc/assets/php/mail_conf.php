<?php
session_start();

if (!isset($_SESSION["id_user"]) || !isset($_SESSION["id_oper"])) {

    header("Location:../../index.php");
    exit;

} else {

    $id_user    = $_SESSION["id_user"];
    $cod_cli    = $_SESSION['id_oper'];

    if($cod_cli == '3'){

        $local = "3C EDP SÃO JOSÉ DOS CAMPOS-SP";
        $email_copia = "recebimentosjc@3cservices.com.br";
    
    }else if($cod_cli == '4'){
    
        $local = "3C EDP VILA VELHA-ES";
        $email_copia = "recebimentoes@3cservices.com.br";
    
    }

    $mail_sist = "eduardo.menocio@3cservices.com.br";
    $ds_email = "agendamento3c@argussistemas.com.br";
}

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$cod_rec    = trim(strip_tags($_POST['id_rec']));

$sql_rec = "SELECT t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.nr_peso_previsto, t1.nr_volume_previsto, t1.nr_insumo, ";
$sql_rec .= "t1.ds_email_sol, t1.ds_tipo_vol, date_format(t1.dt_create,'%d/%m/%Y %H:%i') as dt_create, ";
$sql_rec .= "CASE t1.fl_status WHEN 'S' THEN 'AGUARDANDO CONFIRMAÇÃO' WHEN 'AG' THEN 'CONFIRMADO' END as fl_status, ";
$sql_rec .= "date_format(t2.dt_janela,'%d/%m/%Y') as dt_janela, t2.ds_janela ";
$sql_rec .= "FROM tb_recebimento_ag t1 ";
$sql_rec .= "left join tb_janela t2 on t2.cod_rec = t1.cod_recebimento ";
$sql_rec .= "WHERE t1.cod_recebimento = ?";
$result = $conexao->prepare($sql_rec);
$result->bindParam(1, $cod_rec);
$result->execute();

$count = $result->rowCount();

if ($count > 0) {

    $dados = $result->fetch(PDO::FETCH_ASSOC);

	$nm_transportadora 		= $dados['nm_transportadora'];
	$nm_motorista 			= $dados['nm_motorista'];
	$nm_placa 				= $dados['nm_placa'];
	$nr_peso_previsto 		= $dados['nr_peso_previsto'];
	$nr_volume_previsto 	= $dados['nr_volume_previsto'];
	$nr_insumo 				= $dados['nr_insumo'];
	$ds_email_sol 			= $dados['ds_email_sol'];
	$dt_janela 				= $dados['dt_janela'];
	$ds_janela 				= $dados['ds_janela'];
	$ds_tipo_vol 			= $dados['ds_tipo_vol'];
	$dt_create 				= $dados['dt_create'];
	$fl_status 				= $dados['fl_status'];

    $sql_arq = "SELECT  coalesce(count(cod_nf_entrada),0) as total_arq ";
    $sql_arq .= "FROM tb_nf_entrada ";
    $sql_arq .= "left join tb_janela t2 on t2.cod_rec = t1.cod_recebimento ";
    $sql_arq .= "WHERE cod_rec = ? and ds_arquivo is null";
    $res_arq = $conexao->prepare($sql_arq);
    $res_arq->bindParam(1, $cod_rec);
    $res_arq->execute();
    $dados_arq = $res_arq->fetch(PDO::FETCH_ASSOC);
    
    $html = '<header id="header">
			<div id="logo-group">
				<span id="logo" style="margin-top: 5px"> <img src="https://www.argussistemas.com.br/img/logo12.png" alt="Argus" style="width:160px;height:60px"></span>
				<span id="logo" style="margin-top: 3px"> <img src="https://www.argussistemas.com.br/img/logo3c2.png" alt="3C" style="width:140px;height:50px"></span>
			</div>
			<div style="float: center">
				<h3 style="color: #FF8C00"><strong>ALTERAÇÃO DE STATUS DE AGENDAMENTO DE ENTREGA</strong></h3>
			</div>
		</header>';

    if($dados_arq['total_arq'] == "0"){

        $html .= '<div><table>';
        $html .= '<tr><th><bold>Atenção: A partir de 01/06/22 os agendamentos que não tiverem o arquivo Xml das Notas Fiscais anexado não poderão ser confirmados.</bold></th></tr><tr></tr>';
        $html .= '</table></div>';
        $html .= '<div><table>';

    }

    $html .= '<div><table>';
    $html .= '<tr><th>Dados do agendamento</th></tr>';
    $html .= '<tr><td>Código:</td><td>'.$cod_rec.'</td></tr>';
    $html .= '<tr><td>Data:</td><td>'.$dt_janela.'</td><td>Horário:</td><td>'.$ds_janela.'</td></tr>';
    $html .= '<tr><td>Agendado em:</td><td>'.$dt_create.'</td><td>Situação:</td><td>'.$fl_status.'</td></tr>';
    $html .= '</table></div>';
    $html .= '<div><table><br>';
    $html .= '<tr><th><bold>Informações importantes</bold></th></tr>';
    $html .= '<tr><td><p>1.Todo material deverá, obrigatoriamente, ser entregue com identificação de forma indelével do código da EDP, e no caso de entregas de dois ou mais materiais ou kit´s distintos, os mesmos deverão ser identificados individualmente.</p>';
    $html .= '<p>2.Todo material deverá, obrigatoriamente, atender aos padrões de embalagens definidos pela EDP, bem como estar devidamente condicionado em Pallet´s padrão PBR, os quais devem acompanhar os materiais na descarga e no seu armazenamento.</p>';
    $html .= '<p>3.Faz necessário que o motorista esteja com documento de identificação e colete reflexivo de segurança, sapato de segurança, luvas de proteção, capacete, óculos de segurança e protetor auricular.</p>';
    $html .= '<p>4.Cumprir com o horário agendado em caso de imprevistos acionar o gestor do pedido.</p>';
    $html .= '</td></tr>';
    $html .= '</table></div>';

    require '../../PHPMailer-master/PHPMailerAutoload.php';

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
   
    $mail->AddAddress($mail_sist, 'Solicitante');
    //$mail->AddCC($email_copia, 'Recebimento 3C'); 
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
   
} else {

    $retorno = array(
        'info' => "2",
    );

    echo (json_encode($retorno));
    //print_r($result->errorInfo());
}