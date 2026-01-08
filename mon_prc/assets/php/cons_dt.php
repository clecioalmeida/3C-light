<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT distinct date_format(dt_janela,'%d/%m/%Y') as janela, dt_janela ";
$sql .= "FROM tb_janela ";
$sql .= "WHERE fl_status = ? ";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, 'A');
$stm->execute();
while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

    $retorno[] = array(

		'info'              => '0',
        'janela'            => $row['janela'],
        'dt_janela'         => $row['dt_janela']
	);

}

if(!empty($retorno))
{

    echo json_encode($retorno);

}else
{

    $retorno[] = array('info' => '1');
    echo json_encode($retorno);

}
