<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Consulta tarefas abertas e pendentes por atendente
$sql = "SELECT codigo, descricao ";
$sql .= "FROM tb_tipo_veiculo ";
$sql .= "order by descricao asc";
$stm = $conexao->prepare($sql);
$stm->execute();
while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

    $retorno[] = array(

		'info'              => '0',
        'codigo'            => $row['codigo'],
        'descricao'         => $row['descricao']

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