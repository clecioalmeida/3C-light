<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../assets/bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

if (!empty($_POST['id_tarefa'])) {

    $id_tar         = trim(strip_tags($_POST['id_tarefa']));
    $tr_at          = trim(strip_tags($_POST['ds_resp_int']));
    $dt_fim         = trim(strip_tags($_POST['dt_fim']));
    $tr_sts         = 'E';

    try {

        $sql = "update tarefas set tr_atendente = ?, tr_fim = ?, tr_status = ? where id = ?";
        $result = $conexao->prepare($sql);

        $result->bindParam(1, $tr_at);
        $result->bindParam(2, $dt_fim);
        $result->bindParam(3, $tr_sts);
        $result->bindParam(4, $id_tar);
        $result->execute();
        $count = $result->rowCount();

        if ($count > 0) {

            echo "Tarefa finalizada com sucesso.";

        } else {

            echo "Desculpe-nos, mas não foi possível alterar esta tarefa. Entre em contato com o suporte!";
        }

    } catch (PDOException $e) {

        print $e->getMessage();

    }

} else {

    echo "Tarefa não encontrada!";
    
}
