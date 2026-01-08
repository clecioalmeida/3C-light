<?php 
session_start();
?>
<?php 

$login	= strtoupper(str_replace("'","",$_POST["user"]));
$senha	= strtoupper(str_replace("'","",$_POST["pass"]));
$app	= $_POST["app"];
$emp	= $_POST["emp"];

if($app == 'wms_prd'){

	require_once("bd_class_prd.php"); 
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$SQL_emp = "select cod_empresa, nr_cnpj, nm_fantasia, id_oper, ds_oper from tb_empresa where cod_empresa = '$emp'"; 
	$res_emp = mysqli_query($link,$SQL_emp);
	
	while ($dados_emp = mysqli_fetch_assoc($res_emp)) {
		$_SESSION['cod_cli'] 		= $dados_emp['cod_empresa'];
		$_SESSION['nm_fantasia'] 	= $dados_emp['nm_fantasia'];
		$_SESSION['ds_oper'] 		= $dados_emp['ds_oper'];
		$_SESSION['nr_cnpj'] 		= $dados_emp['nr_cnpj'];
	}

	$SQL = "select t1.id, t1.nm_login, t1.nm_user, t1.id_op, t1.id_depto, t1.fl_nivel, t1.avatar 
	from tb_usuario t1
	where t1.nm_login = '$login' and t1.ds_senha = '$senha' and (t1.fl_tipo = 'F' or t1.fl_tipo = 'U') and t1.fl_status = 'A'";
	$res = mysqli_query($link,$SQL);

	if(mysqli_num_rows($res) > 0){

		while ($dados = mysqli_fetch_assoc($res)) {

			$_SESSION['id'] 			= $dados['id'];
			$_SESSION['usuario'] 		= $dados['nm_user'];
			$_SESSION['id_op'] 			= $dados['id_op'];
			$_SESSION['id_depto'] 		= $dados['id_depto'];
			$_SESSION['avatar'] 		= $dados['avatar'];
			$_SESSION['fl_nivel'] 		= $dados['fl_nivel'];

		}

		$array_parte[] = array(
			'info'	=>	"2",
		);
		echo (json_encode($array_parte));

	}else{

		$array_parte[] = array(
			'info'	=>	"1",
		);
		echo (json_encode($array_parte));

	}

}else if($app == 'wms_hmg'){

	require_once("bd_class_prd.php"); 
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$SQL_emp = "select cod_empresa, nm_fantasia, nr_cnpj, id_oper, ds_oper from tb_empresa where cod_empresa = '$emp'"; 
	$res_emp = mysqli_query($link,$SQL_emp);
	while ($dados_emp = mysqli_fetch_assoc($res_emp)) {
		$_SESSION['cod_cli'] 		= $dados_emp['cod_empresa'];
		$_SESSION['nm_fantasia'] 	= $dados_emp['nm_fantasia'];
		$_SESSION['ds_oper'] 		= $dados_emp['ds_oper'];
		$_SESSION['nr_cnpj'] 		= $dados_emp['nr_cnpj'];
	}

	$SQL = "select t1.id, t1.nm_user, t1.id_op, t1.fl_nivel, t1.avatar
	from tb_usuario t1
	left join tb_empresa t2 on t1.id_op = t2.cod_empresa
	where t1.nm_login = '$login' and t1.ds_senha = '$senha' and (t1.fl_tipo = 'F' or t1.fl_tipo = 'U') and t1.fl_status = 'A'";
	$res = mysqli_query($link,$SQL);

	if(mysqli_num_rows($res) > 0){

		while ($dados = mysqli_fetch_assoc($res)) {

			$_SESSION['id'] 			= $dados['id'];
			$_SESSION['usuario'] 		= $dados['nm_user'];
			$_SESSION['avatar'] 		= $dados['avatar'];
			$_SESSION['fl_nivel'] 		= $dados['fl_nivel'];

		}

		$array_parte[] = array(
			'info'	=>	"0",
		);
		echo (json_encode($array_parte));

	}else{

		$array_parte[] = array(
			'info'	=>	"1",
		);
		echo (json_encode($array_parte));

	}	

}

$link->close();
?>