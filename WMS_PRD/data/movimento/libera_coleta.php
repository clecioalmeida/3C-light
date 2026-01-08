<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once("bd_class.php");

$nr_pedido = $_POST['col_ped'];

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_status="select fl_status from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido'";
$resultado_status = mysqli_query($link, $sql_status);

while ($dados_upd=mysqli_fetch_assoc($resultado_status)) {
    $fl_status=$dados_upd['fl_status'];

}

if($fl_status == 'A'){

    $sql = "update tb_pedido_coleta set fl_status = 'C', usr_init_col = '$id', dt_init_col = '$date' WHERE nr_pedido = '$nr_pedido'" or die(mysqli_error($sql));
    $resultado_id = mysqli_query($link, $sql);

    $sql_prd = "update tb_pedido_coleta_produto set fl_status = 'C' WHERE nr_pedido =  '$nr_pedido'" or die(mysqli_error($sql));
    $res_prd = mysqli_query($link, $sql_prd);

    if(mysqli_affected_rows($link) > 0){ 


        echo "Pedido liberado para coleta!";


    }else{ 


        echo "Erro no cadastro!";

    } 

} else { 

    echo "Pedido já iniciou a coleta!";

}

$link->close();
?>