<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = "4626";

$select_dest = "SELECT produto, sum(nr_qtde) as qtde_conf FROM tb_pedido_conferencia WHERE nr_pedido = '$nr_pedido' group by produto";
$res_dest = mysqli_query($link,$select_dest);

while ($dest=mysqli_fetch_assoc($res_dest)) {
    $qtde_conf = $dest['qtde_conf'];
    $produto = $dest['produto'];

    $sql_prd = "update tb_pedido_coleta_produto set fl_status = 'W', nr_qtde_conf = '$qtde_conf', usr_fim_conf = '$id', dt_fim_conf = '$date' where produto = '$produto' and nr_pedido = '$nr_pedido'";
    $res_prd = mysqli_query($link, $sql_prd);

}

$sql = "update tb_pedido_coleta set fl_status = 'W', fl_tipo = 'P' WHERE nr_pedido = '$nr_pedido'" or die(mysqli_error($sql));
$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){ 

    $sql = "insert into tb_ocorrencias (nm_ocorrencia, tipo, ds_responsavel, nm_depto, criticidade, dt_abertura, fl_status, cod_origem, ds_obs, fl_empresa, user_create, dt_create) values ('Pedidos liberado parcialemnte', '', 'id', 'Separação', 'A', '$date', 'A', '$nr_pedido', '', '$cod_cli', '$id', '$date')";
    $resultado_id = mysqli_query($link, $sql);

    echo "Pedido liberado para expedição!";

}else{ 

    echo "Erro no cadastro!";

} 

$link->close();
?>