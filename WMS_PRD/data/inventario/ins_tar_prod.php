<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:../index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }

?>
<?php

require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();
        
$id_inv = $_POST['id_inv'];
$id_galpao_inv = $_POST['id_galpao_inv'];
$inv_rua = $_POST['inv_rua'];
$inv_mod = $_POST['inv_mod'];
$inv_alt = $_POST['inv_alt'];
$id_torre = $_POST['id_torre'];
$ds_embalagem = $_POST['ds_embalagem'];
$ds_detalhe = $_POST['ds_detalhe'];
$conf1 = $_POST['conf1'];
$conf2 = $_POST['conf2'];
$qtde1 = $_POST['qtde1'];
$qtde2 = $_POST['qtde2'];

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

if($qtde1 == "" or $qtde2 == "" or $qtde1 != $qtde2){

    include"err_qtd_inv.php";

} else{

    $ins_tar = "insert into tb_inv_tarefa (id_inv, id_produto, id_galpao, id_rua, id_coluna, id_altura, ds_embalagem, ds_detalhe, fl_status, fl_tipo, user_create) values ('$id_inv', 47144, '$id_galpao_inv',  '$inv_rua', '$inv_mod', '$inv_alt', '$ds_embalagem', '$ds_detalhe', 'A', 'D', '$id')";
    $res_ins_tar = mysqli_query($link, $ins_tar);
    $novatar = mysqli_insert_id($link);

    $ins_conf = "insert into tb_inv_conf (id_tar, cont_1, cont_2, dt_conf_1, dt_conf_2, conf_1, conf_2, user_create) values ('$novatar', '$qtde1',  '$qtde2', now(), now(), '$conf1', '$conf2', '$id')";
    $res_ins_conf = mysqli_query($link1, $ins_conf);
}

$sql_tar = "select t1.id, t1.id_produto, t1.id_galpao, t1.id_rua, t1.id_coluna, t1.id_altura, t3.nr_posicao
from tb_inv_tarefa t1
left join tb_produto t2 on t1.id_produto = t2.cod_produto
left join tb_item_torre t3 on t2.id_torre = t3.id_item
where t1.id = '$novatar'";
$res_tar = mysqli_query($link1, $sql_tar);
while ($tar = mysqli_fetch_assoc($res_tar)) {
    $array_tar[] = array(
        'id' => $tar['id'],
        'id_galpao' => $tar['id_galpao'],
        'id_rua' => $tar['id_rua'],
        'id_coluna' => $tar['id_coluna'],
        'id_altura' => $tar['id_altura'],
    );
}

echo (json_encode($array_tar));

$link->close();
?>