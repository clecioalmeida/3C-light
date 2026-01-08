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
$link1 = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];

$select_dest = "SELECT produto, sum(nr_qtde_conf) as qtde_conf FROM tb_coleta_pedido WHERE nr_pedido = '$nr_pedido' group by produto";
$res_dest = mysqli_query($link,$select_dest);

while ($dest=mysqli_fetch_assoc($res_dest)) {
    $qtde_conf = $dest['qtde_conf'];
    $produto = $dest['produto'];

    $sql_prd = "update tb_pedido_coleta_produto set fl_status = 'X', nr_qtde_conf = '$qtde_conf',  usr_fim_coleta = '$id', dt_fim_coleta = '$date' where produto = '$produto' and nr_pedido = '$nr_pedido'";
    $res_prd = mysqli_query($link, $sql_prd);

}

$sql_conf = "select cod_conferencia, cod_col, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde
from tb_pedido_conferencia
where nr_pedido = '$pedido'";
$res_conf = mysqli_query($link, $sql_conf);
while ($conf = mysqli_fetch_assoc($res_conf)) {

    $query_cod = "select COALESCE(MIN(cod_estoque),0) as cod_estoque, ds_galpao, coalesce(nr_qtde,0) as nr_qtde_pp, coalesce(produto,0) as produto_pp
    from tb_posicao_pallet
    where ds_prateleira = '".$conf['ds_prateleira']."' and ds_coluna = '".$conf['ds_coluna']."' and ds_altura = '".$conf['ds_altura']."' and produto = '".$conf['produto']."'";
    $res_col = mysqli_query($link, $query_cod);
    while ($parte = mysqli_fetch_assoc($res_col)) {
        $ds_prateleira      = $conf['ds_prateleira'];
        $ds_coluna          = $conf['ds_coluna'];
        $ds_altura          = $conf['ds_altura'];
        $produto            = $conf['produto'];
        $nr_qtde            = $conf['nr_qtde'];
        $ds_galpao          = $parte['ds_galpao'];
        $nr_qtde_pp         = $parte['nr_qtde_pp'];
        $cod_estoque        = $parte['cod_estoque'];
        $produto_pp         = $parte['produto_pp'];
        $cod_conferencia    = $conf['cod_conferencia'];
        $nova_qtde          = $nr_qtde_pp-$nr_qtde;

        if($cod_cli == "4"){

            if($cod_estoque == 0){

                // VALIDA SE O PRODUTO EXISTE NA POSIÇÃO //

                $ds_obs = "Produto não existe na alocação. Atualizar o saldo.";

                $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                $prd = mysqli_query($link1, $sql_prd);

                $sql_ins = "insert into tb_posicao_pallet (produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, nr_qtde_ant, nr_pedido_ant, fl_status, fl_bloq, fl_tipo, fl_empresa, usr_create, dt_create) values ('".$conf['produto']."','".$conf['ds_prateleira']."','".$conf['ds_coluna']."','".$conf['ds_altura']."','0','".$conf['nr_qtde']."','".$pedido."','A','N','D', '".$cod_cli."', '".$id."','".$date."')";
                $res_ins = mysqli_query($link, $sql_ins);


            }else if($nr_qtde > $nr_qtde_pp){

                 // VALIDA SE A QUANTIDADE APONTADA NA SEPARAÇÃO É MAIOR QUE A QUANTIDADE DISPONÍVEL NA POSIÇÃO //

                $ds_obs = "Saldo insuficiente para baixar a quantidade solicitada. Atualizar o saldo.";

                $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                $prd = mysqli_query($link1, $sql_prd);

                $sql_saldo = "update tb_posicao_pallet set nr_qtde = '0', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '$pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
                $saldo = mysqli_query($link, $sql_saldo);

            }else{

                // BAIXA O SALDO DO ESTOQUE SE A QUANTIDADE APONTADA NA SEPARAÇÃO É MENOR OU IGUAL A QUANTIDADE DISPONÍVEL NA POSIÇÃO //

                $sql_saldo = "update tb_posicao_pallet set nr_qtde = '$nova_qtde', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '$pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
                $saldo = mysqli_query($link, $sql_saldo);

                /*$sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque' and nr_pedido = '$pedido'";
                $col = mysqli_query($link, $sql_col);

                $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '$id', dt_lib_exp = '$date', fl_status = 'F' where nr_pedido = '$pedido' and produto = '$produto'";
                $prd = mysqli_query($link1, $sql_prd);*/

            }

        }

    }
}

$upd_col="update tb_coleta_pedido set fl_status = 'X', usr_col = '$id', dt_col = '$date' where nr_pedido = '$pedido'";
$res_upd_col=mysqli_query($link, $upd_col);

$sql = "update tb_pedido_coleta set fl_status = 'X' WHERE nr_pedido =  '$nr_pedido'" or die(mysqli_error($sql));
$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){ 

    echo "Pedido liberado para expedição!";

}else{ 

    echo "Erro no cadastro!";
}

$link->close();
$link1->close();
?>