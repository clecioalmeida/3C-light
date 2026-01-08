<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$new_cod_produto = $_POST['new_cod_produto'];
$new_cod_prod_cliente = $_POST['new_cod_prod_cliente'];
$new_nm_produto = $_POST['new_nm_produto'];
//$cod_produto = $_POST['cod_produto'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);
/*
if(isset($cod_produto)){
$query_prd = "select cod_produto, cod_prod_cliente, nm_produto from tb_produto where cod_produto = '$cod_produto' and fl_status <> 'E'";
$res_prd = mysqli_query($link,$query_prd);
$tr=mysqli_num_rows($res_prd);

while ($dados=mysqli_fetch_assoc($res_prd)) {
$retorno[] = array(
'cod_produto' => $dados['cod_produto'],
'cod_prod_cliente' => $dados['cod_prod_cliente'],
'nm_produto' => $dados['nm_produto'],
);
}

echo(json_encode($retorno));
}
 */
if ($new_cod_produto != '' && $new_cod_prod_cliente == '' && $new_nm_produto == '') {
	$query_prd = "select cod_produto, cod_prod_cliente, nm_produto from tb_produto where cod_produto = '$new_cod_produto' and fl_status <> 'E' and fl_empresa = '$cod_cli'";
	$res_prd = mysqli_query($link, $query_prd);
	$tr = mysqli_num_rows($res_prd);

	if ($tr == 0) {

		$retorno[] = array(
			'info' => "0",
		);

		echo (json_encode($retorno));

		exit();

	} else {
		while ($dados = mysqli_fetch_assoc($res_prd)) {
			$retorno[] = array(
				//'info' => "1",
				'cod_produto' => $dados['cod_produto'],
				'cod_prod_cliente' => $dados['cod_prod_cliente'],
				'nm_produto' => $dados['nm_produto'],
			);
		}

		echo (json_encode($retorno));
	}
} elseif ($new_cod_produto == '' && $new_cod_prod_cliente != '' && $new_nm_produto == '') {
	$query_prd = "select cod_produto, cod_prod_cliente, nm_produto from tb_produto where cod_prod_cliente = '$new_cod_prod_cliente' and fl_status <> 'E' and fl_empresa = '$cod_cli'";
	$res_prd = mysqli_query($link, $query_prd);
	$tr = mysqli_num_rows($res_prd);

	if ($tr == 0) {

		$retorno[] = array(
			'info' => "0",
		);

		echo (json_encode($retorno));

		exit();

	} else {
		while ($dados = mysqli_fetch_assoc($res_prd)) {
			$retorno[] = array(
				//'info' => "1",
				'cod_produto' => $dados['cod_produto'],
				'cod_prod_cliente' => $dados['cod_prod_cliente'],
				'nm_produto' => $dados['nm_produto'],
			);
		}

		echo (json_encode($retorno));

		exit();
	}
} elseif ($new_cod_produto == '' && $new_cod_prod_cliente == '' && $new_nm_produto != '') {
	$query_prd = "select cod_produto, cod_prod_cliente, nm_produto from tb_produto where nm_produto like '%$new_nm_produto%' and fl_status <> 'E' and fl_empresa = '$cod_cli'";
	$res_prd = mysqli_query($link, $query_prd);
	$tr = mysqli_num_rows($res_prd);

	if ($tr == 0) {

		$retorno[] = array(
			'info' => "0",
		);

		echo (json_encode($retorno));

		exit();

	} else {

		while ($dados = mysqli_fetch_assoc($res_prd)) {
			$retorno[] = array(
				//'info' => "3",
				'cod_produto' => $dados['cod_produto'],
				'cod_prod_cliente' => $dados['cod_prod_cliente'],
				'nm_produto' => $dados['nm_produto'],
			);
		}

		echo (json_encode($retorno));
	}
}
/*
if($tr == 0){

$retorno[] = array(
'info' => "0",
);

echo(json_encode($retorno));

exit();

}else{
while ($dados=mysqli_fetch_assoc($res_prd)) {
$retorno[] = array(
'info' => "1",
'cod_produto' => $dados['cod_produto'],
'cod_prod_cliente' => $dados['cod_prod_cliente'],
'nm_produto' => $dados['nm_produto'],
);
}

echo(json_encode($retorno));
}
 */
$link->close();
?>