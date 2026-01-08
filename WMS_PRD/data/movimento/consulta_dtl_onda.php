<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }

?>
<?php

require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();
        
$id_onda = $_POST['idOnda'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$sql_pedido="select t1.*, t3.ds_apelido, t2.ds_galpao, t2.ds_prateleira, sum(t2.nr_qtde_col) as qtde, t2.fl_status
from tb_onda t1
left join tb_coleta_pedido t2 on t1.id = t2.nr_onda
left join tb_armazem t3 on t2.ds_galpao = t3.id
where t1.id = '$id_onda'
group by t2.ds_galpao, t2.ds_prateleira";
$res_pedido = mysqli_query($link, $sql_pedido);
while ($dados=mysqli_fetch_assoc($res_pedido)) {
    $array_pedido[] = array(
        'id' => $dados['id'],
        'ds_apelido' => $dados['ds_apelido'],
        'ds_galpao' => $dados['ds_galpao'],
        'ds_prateleira' => $dados['ds_prateleira'],
        'nr_qtde_col' => $dados['qtde'],
    );
}    

echo(json_encode($array_pedido));

$link->close();
?>