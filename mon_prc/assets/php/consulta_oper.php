<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conexao.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$user = $_REQUEST['user'];
$pass = $_REQUEST['pass'];
$sts    = "A";

// Consulta operações liberadas para o usuário
$sql = "SELECT ds_usuario, id_oper, ds_senha ";
$sql .= "FROM tb_acesso ";
$sql .= "where ds_usuario = ? and  fl_status =  ? ";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $user);
$stm->bindValue(2, $sts);
$stm->execute();

$count_usr = $stm->rowCount();

if ($count_usr > 0) {

	$row = $stm->fetch(PDO::FETCH_ASSOC);
	$ds_nome		= $row['ds_usuario'];
	$id_oper		= $row['id_oper'];

	if(password_verify($pass, $row['ds_senha'])){

		$sql_op = "SELECT id, ds_operacao ";
		$sql_op .= "FROM tb_operacao ";
		$sql_op .= "where fl_status = ? and FIND_IN_SET(id, ?) ";
		$stm_op = $conexao->prepare($sql_op);
		$stm_op->bindValue(1, $sts);
		$stm_op->bindValue(2, $id_oper);
		$stm_op->execute();

		$count_op = $stm_op->rowCount();

		if ($count_op > 0) {

			while ($row_op = $stm_op->fetch(PDO::FETCH_ASSOC)) {
			
				$retorno[] = array(
			
					'info'          => '0',
					'id_oper' 		=> $row_op['id'],
					'ds_operacao' 	=> $row_op['ds_operacao'],

				);
			
			}
			echo (json_encode($retorno));

		}else{

			$retorno[] = array(
				'info'	=>	"1",
			);
			echo (json_encode($retorno));

		}

	}else{

		$retorno[] = array(
			'info'	=>	"3",
		);
		echo (json_encode($retorno));

	}

}else{

	$retorno[] = array(
		'info'	=>	"2",
	);
	echo (json_encode($retorno));

}