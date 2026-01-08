<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id=$_SESSION["id"];
    $cod_cli=$_SESSION["cod_cli"];
}
?>
<?php
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_inv = $_POST['nr_inv'];

$sql_inv="select * from tb_inv_prog where id = '$nr_inv'";
$res_inv = mysqli_query($link, $sql_inv);
while ($dados=mysqli_fetch_assoc($res_inv)) {
    $id_galpao          = $dados['id_galpao'];
    $id_rua_inicio      = $dados['id_rua_inicio'];
    $id_rua_fim         = $dados['id_rua_fim'];
    $id_coluna_inicio   = $dados['id_coluna_inicio'];
    $id_coluna_fim      = $dados['id_coluna_fim'];
    $id_grupo           = $dados['id_grupo'];
    $id_sub_grupo       = $dados['id_sub_grupo'];
    $id_produto         = $dados['id_produto'];

    $sql_pos = "select t1.*, t2.cod_estoque, t4.id as id_etq, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto, t2.nr_qtde, t2.produto, t3.nome, t5.cod_produto 
    from tb_inv_prog t1 
    left join tb_posicao_pallet t2 on t2.ds_galpao = t1.id_galpao and t2.produto = t1.id_produto
    left join tb_armazem t3 on t1.id_galpao = t3.id
    left join tb_etiqueta t4 on t2.cod_estoque = t4.cod_estoque
    left join tb_produto t5 on t5.cod_prod_cliente = t1.id_produto
    where t1.id = '$nr_inv'
    group by t2.cod_estoque";
    $res_pos = mysqli_query($link, $sql_pos);

    while ($dados=mysqli_fetch_assoc($res_pos)) {
        $id_inv         = $dados['id'];
        $id_estoque     = $dados['cod_estoque'];
        $id_etq         = $dados['id_etq'];
        $id_produto     = $dados['produto'];
        $id_galpao_pp   = $dados['id_galpao'];
        $id_rua_pp      = $dados['ds_prateleira'];
        $id_coluna_pp   = $dados['ds_coluna'];
        $id_altura      = $dados['ds_altura'];
        $nr_qtde        = $dados['nr_qtde'];
        $cod_produto        = $dados['cod_produto'];

        $sql = "insert into tb_inv_tarefa (id_inv, id_estoque, id_etq, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_qtde, fl_status, fl_empresa, user_create, dt_create) values ('$id_inv', '$id_estoque', '$id_etq', '$cod_produto', '$id_galpao_pp', '$id_rua_pp', '$id_coluna_pp', '$id_altura', '$nr_qtde', 'A', '$cod_cli', '$id', now())";
        $res_insert = mysqli_query($link1, $sql);

    }
}

if(mysqli_affected_rows($link1) > 0){

    $retorno[] = array(
        'info' => "0",
    );

    echo(json_encode($retorno));

}else{

    $retorno[] = array(
        'info' => "1",
    );

    echo(json_encode($retorno));

} 

$link->close();
?>