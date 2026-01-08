<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$dt_agenda  = trim(strip_tags($_POST['dt_agenda']));
$hr_agenda  = trim(strip_tags($_POST['hr_agenda']));
$nm_for     = trim(strip_tags($_POST['nm_for']));
$ds_ped     = trim(strip_tags($_POST['ds_ped']));
$ds_mail    = trim(strip_tags($_POST['ds_mail']));
$nr_peso    = trim(strip_tags($_POST['nr_peso']));
$nr_volume  = trim(strip_tags($_POST['nr_volume']));
$tp_vol     = trim(strip_tags($_POST['tp_vol']));
$tp_veic    = trim(strip_tags($_POST['tp_veic']));
$nm_trans   = trim(strip_tags($_POST['nm_trans']));
$ds_mot     = trim(strip_tags($_POST['ds_mot']));
$ds_placa   = trim(strip_tags($_POST['ds_placa']));
$ds_obs     = trim(strip_tags($_POST['ds_obs']));
$fl_status  = trim(strip_tags('S'));
$usr_create = trim(strip_tags('1'));

$insert = "INSERT INTO tb_recebimento_ag ";
$insert .= "(nm_fornecedor, dt_recebimento_previsto, nr_peso_previsto,  nr_volume_previsto, nm_transportadora, nm_motorista, nm_placa, tp_veiculo, ds_tipo_vol, fl_status, usr_create, dt_create, nr_insumo, ds_obs, ds_email_sol) VALUES ";
$insert .= "(:nm_fornecedor,:dt_recebimento_previsto,:nr_peso_previsto,:nr_volume_previsto,:nm_transportadora,:nm_motorista,:nm_placa,:tp_veiculo,:ds_tipo_vol,:fl_status,:usr_create,:dt_create,:nr_insumo,:ds_obs,:ds_email_sol)";

$result = $conexao->prepare($insert);
$result->bindParam(':nm_fornecedor', $nm_for, PDO::PARAM_STR);
$result->bindParam(':dt_recebimento_previsto', $dt_agenda, PDO::PARAM_STR);
$result->bindParam(':nr_peso_previsto', $nr_peso, PDO::PARAM_STR);
$result->bindParam(':nr_volume_previsto', $nr_volume, PDO::PARAM_STR);
$result->bindParam(':nm_transportadora', $nm_trans, PDO::PARAM_STR);
$result->bindParam(':nm_motorista', $ds_mot, PDO::PARAM_STR);
$result->bindParam(':nm_placa', $ds_placa, PDO::PARAM_STR);
$result->bindParam(':tp_veiculo', $tp_veic, PDO::PARAM_STR);
$result->bindParam(':ds_tipo_vol', $tp_vol, PDO::PARAM_STR);
$result->bindParam(':fl_status', $fl_status, PDO::PARAM_STR);
$result->bindParam(':usr_create', $usr_create, PDO::PARAM_STR);
$result->bindParam(':dt_create', $date, PDO::PARAM_STR);
$result->bindParam(':nr_insumo', $ds_ped, PDO::PARAM_STR);
$result->bindParam(':ds_obs', $ds_obs, PDO::PARAM_STR);
$result->bindParam(':ds_email_sol', $ds_mail, PDO::PARAM_STR);

if ($result->execute()) {

    echo "CADASTRO REALIZADO COM SUCESSO";

} else {

    echo "ERRO! FAVOR TENTE NOVAMENTE MAIS TARDE";
    print_r($result->errorInfo());
}
