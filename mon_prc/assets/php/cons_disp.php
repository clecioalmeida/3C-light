<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

if (!empty($_REQUEST['dt_ag'])) {

    $dt_ag      = trim(strip_tags($_REQUEST['dt_ag']));
    $tp_veic    = trim(strip_tags($_REQUEST['tp_veic']));
    $sts1       = 'S';
    $sts2       = 'AG';
    $sts3       = '0';

    try {

        $sql  = "SELECT total, tp_veiculo, cap_rec FROM ( ";
        $sql .= "SELECT count(r.cod_recebimento) as total, r.tp_veiculo, t.descricao, t.cap_rec, r.fl_status ";
        $sql .= "FROM tb_recebimento_ag r ";
        $sql .= "left join tb_janela j on r.cod_recebimento = j.cod_rec ";
        $sql .= "left join tb_tipo_veiculo t on t.codigo = r.tp_veiculo ";
        $sql .= "where j.dt_janela = ? and (r.fl_status = ? or r.fl_status = ?) and t.cap_rec > ? ";
        $sql .= ") s where total < cap_rec ";
        $stm  = $conexao->prepare($sql);
        $stm->bindValue(1, $dt_ag);
        $stm->bindValue(2, $sts1);
        $stm->bindValue(3, $sts2);
        $stm->bindValue(4, $sts3);
        $stm->execute();
        $count = $stm->rowCount();

        if ($count > 0) {

            $retorno = array('info' => '0');
            echo json_encode($retorno);

        } else {

            $retorno = array('info' => '1');
            echo json_encode($retorno);

        }

    } catch (PDOException $e) {

        echo json_encode($e->getMessage());

    }

} else {

    $retorno[] = array('info' => '2');
    echo json_encode($retorno);

}