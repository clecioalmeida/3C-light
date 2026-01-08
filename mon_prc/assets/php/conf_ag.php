<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$cod_rec = $_POST['id_rec'];

$upd_sts = 'AG';

$upd = "UPDATE tb_recebimento_ag set fl_status = ? where cod_recebimento = ?";
$res_upd = $conexao->prepare($upd);

$res_upd->bindParam(1, $upd_sts);
$res_upd->bindParam(2, $cod_rec);

try {

    $res_upd->execute();
    $count_upd = $res_upd->rowCount();

    if ($count_upd > 0) {

        $upd_jd = 'C';

        $upd_jn = "UPDATE tb_janela set fl_status = ? where cod_rec = ?";
        $res_jn = $conexao->prepare($upd_jn);

        $res_jn->bindParam(1, $upd_jd);
        $res_jn->bindParam(2, $cod_rec);
        $res_jn->execute();

        $retorno = array(
            'info' => "0",
        );

        echo (json_encode($retorno));

    } else {

        $retorno = array(
            'info' => "1",
        );

        echo (json_encode($retorno));
    }

} catch (PDOException $e) {

    echo $e->getMessage();

}