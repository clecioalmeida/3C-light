<?php
session_start();

if (!isset($_SESSION["id_user"]) || !isset($_SESSION["id_oper"])) {

    header("Location:../../index.php");
    exit;

} else {

    $id_user    = $_SESSION["id_user"];
    $cod_cli    = $_SESSION['id_oper'];

}

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

if (!empty($_POST['cod_rec'])) {

    $cod_rec    = trim(strip_tags($_POST['cod_rec']));
    $dt_agenda  = trim(strip_tags($_POST['dt_agenda']));
    $hr_agenda  = trim(strip_tags($_POST['hr_agenda']));
    $id_for     = trim(strip_tags($_POST['id_for']));
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

    try {

        $sql =  "UPDATE tb_recebimento_ag set nm_fornecedor = ?, id_fornecedor = ?, dt_recebimento_previsto = ?, nr_peso_previsto = ?, ";
        $sql .= "nm_transportadora = ?, nm_motorista = ?, nm_placa = ?, tp_veiculo = ?, ds_tipo_vol = ?, nr_insumo = ?, ";
        $sql .= "ds_obs = ?, ds_email_sol = ?, usr_update = ?, dt_update = ? ";
        $sql .= "where cod_recebimento = ?";
        $result = $conexao->prepare($sql);

        $result->bindParam(1, $nm_for);
        $result->bindParam(2, $id_for);
        $result->bindParam(3, $dt_agenda);
        $result->bindParam(4, $nr_peso);
        $result->bindParam(5, $nm_trans);
        $result->bindParam(6, $ds_mot);
        $result->bindParam(7, $ds_placa);
        $result->bindParam(8, $tp_veic);
        $result->bindParam(9, $tp_vol);
        $result->bindParam(10, $ds_ped);
        $result->bindParam(11, $ds_obs);
        $result->bindParam(12, $ds_mail);
        $result->bindParam(13, $id_user);
        $result->bindParam(14, $date);
        $result->bindParam(15, $cod_rec);

        if ($result->execute()) {

            echo "ALTERAÇÃO REALIZADA COM SUCESSO";

        } else {

            echo "ERRO!";
            print_r($result->errorInfo());

        }

    } catch (PDOException $e) {

        print $e->getMessage();

    }

} else {

    echo "AGENDAMENTO NÃO ENCONTRADO!";

}