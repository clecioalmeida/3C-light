<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {


  $id     = $_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_ped                = $_POST["cod_ped"];
$nr_new_qtde_pedido     = $_POST["nr_new_qtde_pedido"];

$prod = "select round(coalesce(sum(t1.nr_volume),0),0) as volume, round(coalesce(sum(t1.nr_qtde),0),0) as item
from tb_posicao_pallet t1
left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto 
where t2.cod_ped = '$cod_ped' and t1.nr_qtde > 0 and t1.fl_bloq = 'N'
group by t1.produto";
$res_prod = mysqli_query($link, $prod);
$dados_prod = mysqli_fetch_assoc($res_prod);
$item = $dados_prod['item'];

$sel_prod = "select round(COALESCE(sum(nr_qtde),0),0) as reservado from tb_pedido_coleta_produto where fl_empresa = '$cod_cli' and cod_ped = '$cod_ped' and (fl_status <> 'F' and fl_status <> 'X' and fl_status <> 'E')";
$res = mysqli_query($link, $sel_prod);
$produto = mysqli_fetch_assoc($res);
$reservado = $produto['reservado'];

$saldo = $item-$reservado;

if($saldo <= 0){



}else{



}
$query_status="select fl_status from tb_pedido_coleta_produto where nr_pedido = '$nr_new_qtde_pedido'";
$res_status = mysqli_query($link,$query_status);
while ($status=mysqli_fetch_assoc($res_status)) {
  $fl_status=$status['fl_status'];

  if($fl_status == 'T' || $fl_status == 'A'){

   $upd_qtde = "update tb_pedido_coleta_produto set nr_qtde = '$nr_new_qtde_pedido' where cod_ped = '$cod_ped'";
   $res_upd = mysqli_query($link,$upd_qtde);

   if(mysqli_affected_rows($link) > 0){

    echo "Quantidade alterada.";

  }else{

    echo "Erro.";

  }

}else{

  echo "Pedidos nesse status não podem ser alterados.";

}

}
$link->close();
?>