<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nm_forn = "GABRIEL FERNANDES";
$nm_user = "gabriel.fernandes@3cservices.com.br";
$senha1 = "gf2022##";
$senha = password_hash($senha1, PASSWORD_DEFAULT);

$sql = "insert into tb_acesso (ds_nome, ds_usuario, ds_senha, id_oper, fl_status, fl_nivel) values (upper('$nm_forn'), '$nm_user', '$senha', '5', 'A', '3')";
$resultado_id = mysqli_query($link, $sql);
$n_user = mysqli_insert_id($link);
echo "novo id" . "-" . $n_user . " Fornecedor" . "-" . $nm_forn . " Cnpj" . "-" . $nm_user . " Senha 1" . "-" . $senha1 . " senha" . "-" . $senha . "<br>\n";


$link->close();