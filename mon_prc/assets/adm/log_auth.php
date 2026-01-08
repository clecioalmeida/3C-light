<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

$ipaddress = '';
if (getenv('HTTP_CLIENT_IP'))
	$ipaddress = getenv('HTTP_CLIENT_IP');
else if(getenv('HTTP_X_FORWARDED_FOR'))
	$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
else if(getenv('HTTP_X_FORWARDED'))
	$ipaddress = getenv('HTTP_X_FORWARDED');
else if(getenv('HTTP_FORWARDED_FOR'))
	$ipaddress = getenv('HTTP_FORWARDED_FOR');
else if(getenv('HTTP_FORWARDED'))
	$ipaddress = getenv('HTTP_FORWARDED');
else if(getenv('REMOTE_ADDR'))
	$ipaddress = getenv('REMOTE_ADDR');
else
	$ipaddress = 'UNKNOWN';

// Constante com a quantidade de tentativas aceitas
define('TENTATIVAS_ACEITAS', 20); 

// Constante com a quantidade minutos para bloqueio
define('MINUTOS_BLOQUEIO', 1); 

// Require da classe de conexão
require '../bd/conexao.php';

// Verifica se a origem da requisição é do mesmo domínio da aplicação
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "https://argussistemas.com.br/app/3c_lgt_mon/" && $_SERVER['HTTP_REFERER'] != "https://argussistemas.com.br/3cLight/mon_prc/index.html" && $_SERVER['HTTP_REFERER'] != "https://argussistemas.com.br/3cLight/mon_prc/"):
	$retorno = array('codigo' => '0', 'mensagem' => 'Origem da requisição não autorizada!', 'origem' => $_SERVER['HTTP_REFERER']);
	echo json_encode($retorno);
	exit();
endif;

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Recebe os dados do formulário
$user = (isset($_POST['user'])) ? $_POST['user'] : '' ;
$senha = (isset($_POST['pass'])) ? $_POST['pass'] : '' ;
$id_oper = (isset($_POST['id_oper'])) ? $_POST['id_oper'] : '' ;

if (empty($senha)):
	$retorno = array('codigo' => '0', 'mensagem' => 'Preencha sua senha!');
	echo json_encode($retorno);
	exit();
endif;

// Verifica se o usuário já excedeu a quantidade de tentativas erradas do dia
$sql = "SELECT count(*) AS tentativas, MINUTE(TIMEDIFF(NOW(), MAX(data_hora))) AS minutos ";
$sql .= "FROM tb_log_tentativa WHERE ip = ? and DATE_FORMAT(data_hora,'%Y-%m-%d') = ? AND bloqueado = ?";
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $_SERVER['SERVER_ADDR']);
$stm->bindValue(2, date('Y-m-d'));
$stm->bindValue(3, 'SIM');
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);

if (!empty($retorno->tentativas) && intval($retorno->minutos) <= MINUTOS_BLOQUEIO):
	$_SESSION['tentativas'] = 0;
	$retorno = array('codigo' => '0', 'mensagem' => 'Você excedeu o limite de '.TENTATIVAS_ACEITAS.' tentativas, login bloqueado por '.MINUTOS_BLOQUEIO.' minutos!');
	echo json_encode($retorno);
	exit();
endif;

// Válida os dados do usuário com o banco de dados
$sql = 'SELECT id, ds_nome, ds_senha, id_oper, fl_nivel FROM tb_acesso WHERE ds_usuario = ? AND fl_status = ? LIMIT 1';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $user);
$stm->bindValue(2, 'A');
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);

// Válida a senha utlizando a API Password Hash
if(!empty($retorno) && password_verify($senha, $retorno->ds_senha)):
	$_SESSION['id_user'] 	= $retorno->id;
	$_SESSION['ds_nome'] 	= $retorno->ds_nome;
	//$_SESSION['id_oper'] 	= $retorno->id_oper;
	$_SESSION['fl_nivel'] 	= $retorno->fl_nivel;
	$_SESSION['tentativas'] = 0;
	$_SESSION['logado'] 	= 'SIM';
else:
	$_SESSION['logado'] 	= 'NAO';
	$_SESSION['tentativas'] = (isset($_SESSION['tentativas'])) ? $_SESSION['tentativas'] += 1 : 1;
	$bloqueado = ($_SESSION['tentativas'] == TENTATIVAS_ACEITAS) ? 'SIM' : 'NAO';

	// Grava a tentativa independente de falha ou não
	$sql = 'INSERT INTO tb_log_tentativa (ip, user, senha, origem, bloqueado) VALUES (?, ?, ?, ?, ?)';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $_SERVER['SERVER_ADDR']);
	$stm->bindValue(2, $user);
	$stm->bindValue(3, $senha);
	$stm->bindValue(4, $_SERVER['HTTP_REFERER']);
	$stm->bindValue(5, $bloqueado);
	$stm->execute();
endif;

// Se logado envia código 1, senão retorna mensagem de erro para o login
if ($_SESSION['logado'] == 'SIM'):
	$retorno = array('codigo' => '1', 'mensagem' => 'Logado com sucesso!', 'operacao' => $id_oper, 'nivel' => $_SESSION['fl_nivel']);
	echo json_encode($retorno);

	$sql = 'INSERT INTO tb_historico_acesso (ds_usuario, ds_ip, id_oper, fl_status, dt_acesso) VALUES (?, ?, ?, ?, ?)';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $user);
	$stm->bindValue(2, $ipaddress);
	$stm->bindValue(3, $id_oper);
	$stm->bindValue(4, "A");
	$stm->bindValue(5, $date);
	$stm->execute();
	
	exit();
else:
	if ($_SESSION['tentativas'] == TENTATIVAS_ACEITAS):
		$retorno = array('codigo' => '0', 'mensagem' => 'Você excedeu o limite de '.TENTATIVAS_ACEITAS.' tentativas, login bloqueado por '.MINUTOS_BLOQUEIO.' minutos!');
		echo json_encode($retorno);
		exit();
	else:
		$retorno = array('codigo' => '0', 'mensagem' => 'Usuário não autorizado, você tem mais '. (TENTATIVAS_ACEITAS - $_SESSION['tentativas']) .' tentativa(s) antes do bloqueio!');
		echo json_encode($retorno);
		exit();
	endif;
endif;