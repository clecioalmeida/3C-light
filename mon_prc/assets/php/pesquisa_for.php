<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$nm_for  = '%'.trim(strip_tags($_REQUEST['nm_for'])).'%';

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT id, ds_nome ";
$sql .= "FROM tb_fornecedor ";
$sql .= "WHERE ds_nome LIKE ? ";
$sql .= "order by ds_nome asc";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $nm_for);
$stm->execute();
while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

    $retorno[] = array(

		'info'              => '0',
        'id_for'            => $row['id'],
        'ds_nome'           => $row['ds_nome']
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