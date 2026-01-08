<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

if (!empty($_REQUEST['dt_ag'])) {

    $dt_ag  = trim(strip_tags($_REQUEST['dt_ag']));
    $sts    = "A";

    try {

        $sql = "SELECT id, ds_janela ";
        $sql .= "FROM tb_janela ";
        $sql .= "WHERE dt_janela = ? and fl_status = ? ";
        $stm = $conexao->prepare($sql);
        $stm->bindValue(1, $dt_ag);
        $stm->bindValue(2, $sts);
        $stm->execute();
        $count = $stm->rowCount();

        if ($count > 0) {

            while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

                $retorno[] = array(
            
                    'info'          => '0',
                    'id_janela'     => $row['id'],
                    'ds_janela'     => $row['ds_janela']
                );

            }
            echo json_encode($retorno);

        } else {

            $retorno[] = array('info' => '1');
            echo json_encode($retorno);
        
        }

    } catch (PDOException $e) {

        echo json_encode($e->getMessage());
    }

} else {

    $retorno[] = array('info' => '2');
    echo json_encode($retorno);
}
