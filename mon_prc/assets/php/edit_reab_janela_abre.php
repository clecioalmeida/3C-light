<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

if (!empty($_POST['ins_jn'])) {

    $ins_jn = $_POST['ins_jn'];
    $status = 'A';

    try {

        $sql =  "UPDATE tb_janela SET fl_status = ? ";
        $sql .= "WHERE id = ?";
        $result = $conexao->prepare($sql);

        $result->bindParam(1, $status);
        $result->bindParam(2, $ins_jn);

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