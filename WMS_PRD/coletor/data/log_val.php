<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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

//$caminho_do_arquivo =  '../../config/db_config.php';
//if (file_exists($caminho_do_arquivo)) {
//    include_once $caminho_do_arquivo;
////   echo "O include foi processado com sucesso (o arquivo existe)...";
//} else {
//    echo "Erro: O arquivo $caminho_do_arquivo não foi encontrado.";
//    // Você pode optar por parar a execução aqui, se necessário
//    // die();
//}
//


include_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();



if ((isset($_POST['username'])) && (isset($_POST['password']))) {

	$usuario = mysqli_real_escape_string($link, $_POST['username']);
	$senha = mysqli_real_escape_string($link, $_POST['password']);

	$SQL = "select id, nm_login,nm_user, id_op from tb_usuario where nm_login = '$usuario' and ds_senha = '$senha' and (fl_tipo = 'F' or fl_tipo = 'U' or fl_tipo = 'P') and fl_status = 'A'";
	$res = mysqli_query($link, $SQL);

	$dados = mysqli_fetch_assoc($res);

	if (isset($dados)) {
        
		echo "0";
		
		$_SESSION['id'] = $dados['id'];
		$_SESSION['usuario'] = $dados['nm_user'];
		$_SESSION['cod_cli'] = $dados['id_op'];

		$SQL_hist = "insert into tb_historico_acesso (nm_usuario, ds_ip_adress, id_oper, fl_status, dt_acesso) values ('".$usuario."',  '".$ipaddress."', '".$dados['id_op']."', 'ok', '".$date."')";
		$res_hist = mysqli_query($link,$SQL_hist);

	} else {

		echo "1";

//		$SQL_hist = "insert into tb_historico_acesso (nm_usuario, ds_ip_adress, id_oper, fl_status, dt_acesso) values ('".$usuario."',  '".$ipaddress."', '".$dados['id_op']."', 'err', '".$date."')";
//		$res_hist = mysqli_query($link,$SQL_hist);

	}

} else {

	echo "1";

}

$link->close();
?>