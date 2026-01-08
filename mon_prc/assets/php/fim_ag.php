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
    $sts        = "F";

    try {

        $sql =  "update tb_recebimento_ag set fl_status = ?, usr_update = ?, dt_update = ? ";
        $sql .= "where cod_recebimento = ?";
        $result = $conexao->prepare($sql);

        $result->bindParam(1, $sts);
        $result->bindParam(2, $id_user);
        $result->bindParam(3, $date);
        $result->bindParam(4, $cod_rec);

        if ($result->execute()) {

            echo "AGENDAMENTO FINALIZADO COM SUCESSO";

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