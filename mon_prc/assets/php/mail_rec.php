<?php
session_start();

if (!isset($_SESSION["id_user"]) || !isset($_SESSION["id_oper"])) {

    header("Location:../../index.php");
    exit;

} else {

    $id_user    = $_SESSION["id_user"];
    $cod_cli    = $_SESSION['id_oper'];

    if($cod_cli == '3'){
   
        $mail_rec = "recebimentosjc@3cservices.com.br";
   
    }else{
   
        $mail_rec = "recebimentoes@3cservices.com.br";
   
    }

    $mail_sist = "eduardo.menocio@3cservices.com.br";
}

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$cod_rec    = trim(strip_tags($_POST['upd_rec']));

$sql_rec = "SELECT t1.cod_recebimento, date_format(t2.dt_janela,'%d/%m/%Y') as dt_janela, CAST(t2.ds_janela AS char) as ds_janela, t1.ds_motivo, t1.ds_email_sol ";
$sql_rec .= "FROM tb_recebimento_ag t1 ";
$sql_rec .= "left join tb_janela t2 on t2.cod_rec = t1.cod_recebimento ";
$sql_rec .= "WHERE t1.cod_recebimento = ?";
$result = $conexao->prepare($sql_rec);
$result->bindParam(1, $cod_rec);
$result->execute();

$count = $result->rowCount();

if ($count > 0) {

    $row = $result->fetch(PDO::FETCH_ASSOC);

    $cod_recebimento 		= $row['cod_recebimento'];
    $ds_email_sol 			= $row['ds_email_sol'];
    $ds_motivo 				= $row['ds_motivo'];
    $ds_janela 				= $row['ds_janela'];
    $dt_janela 				= $row['dt_janela'];
    
    $html = '<header id="header">';
    $html .= '<div id="logo-group"><span id="logo" style="margin-top: 5px"> <img src="https://www.argussistemas.com.br/img/logo12.png" alt="Argus" style="width:160px;height:60px"></span>';
    $html .= '<span id="logo" style="margin-top: 3px"> <img src="https://www.argussistemas.com.br/img/logo3c2.png" alt="3C" style="width:140px;height:50px"></span>';
    $html .= '</div>';
    $html .= '<div style="float: center">';
    $html .= '<h3 style="color: #FF8C00"><strong>ALTERAÇÃO DE STATUS DE AGENDAMENTO DE ENTREGA</strong></h3>';
    $html .= '</div>';
    $html .= '</header>';
    $html .= '<div><table>';
    $html .= '<tr><th>ATENÇÃO: Agendamento N.o: '.$cod_recebimento.' Data: '.$dt_janela.' Horário: '.$ds_janela.' NOVO STATUS: RECUSADO.</th></tr>';
    $html .= '<tr><td>Motivo: '.$ds_motivo.'</td></tr>';
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