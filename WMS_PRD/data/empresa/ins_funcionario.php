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

require_once('bd_class.php'); 
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_nome        = $_POST['ds_nome'];
$nr_matricula   = $_POST['nr_matricula'];
$cod_depto      = $_POST['cod_depto'];

$sql_parte = "SELECT nr_matricula, ds_nome FROM tb_funcionario where fl_status = 'A' and nr_matricula = '$nr_matricula' and fl_empresa = '$cod_cli' and fl_status <> 'E'";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) == 0){

    $sql = " insert into tb_funcionario (ds_nome, nr_matricula, cod_depto, fl_status, fl_empresa, usr_create, dt_create) values ('$ds_nome',  '$nr_matricula', '$cod_depto', 'A', '$cod_cli', '$id', '$date')";

    $resultado_id = mysqli_query($link, $sql);

    if(mysqli_affected_rows($link) > 0){

        $array_info = array(
            'info' => "Funcionário incluído com sucesso.",
            'result' => "0",
        );

    } else {

        $array_info = array(
            'info' => "Dados não cadastrados.",
            'result' => "1",
        );
    }

}else{

    $array_info = array(
        'info' => "Matrícula já existe no cadastro.",
        'result' => "2",
    );

}

echo (json_encode($array_info));

$link->close();
?>