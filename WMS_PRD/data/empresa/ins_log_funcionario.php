<?php
session_start();    
?>
<?php

if(isset($_SESSION["id"])){

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION['cod_cli'];

}else{

    echo "<script>alert('Você não está logado!')</script>";
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
$year = date("Y");

require_once 'bd_class_req.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

//$nome = explode(" ", $nome_completo);$primeiro_nome = $nome[0];$ultimo_nome = end($nome);

$nm_forn = $_POST['ds_nome'];

$temp = explode(" ",$nm_forn);

$nomeNovo = $temp[0] . "." . $temp[count($temp)-1];

$string = $nm_forn;
$iniciais = strstr($string, ' ', true)[0] . trim(strstr($string, ' ')[1]);
$senha1 = $iniciais.$year."#";
$ds_senha = password_hash($senha1, PASSWORD_DEFAULT);

$sql = "insert into tb_acesso (ds_nome, ds_usuario, ds_senha, id_oper, fl_status, fl_nivel, usr_create, dt_create) values (upper('$nm_forn'), '$nomeNovo', '$ds_senha', '$cod_cli', 'A', '3', '1', '2022-02-14')";
$resultado_id = mysqli_query($link, $sql);
$n_user = mysqli_insert_id($link);

echo $senha1." - ".$nomeNovo;

$link->close();
?>