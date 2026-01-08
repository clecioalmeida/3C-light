<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$nm_placa = $_POST['nm_placa'];

// CRIA ARRAY COM QUANTIDADE DA POSIÇÃO APONTADA NA SEPARAÇÃO POR APONTAMENTO DA SEPARAÇÃO //

$sql_conf = "SELECT cod_recebimento, cod_cli, id_end, ds_galpao, ds_rua, ds_coluna, ds_altura, cod_produto,
nr_serial, nr_qtde
        from tb_recebimento_ag
        where nm_placa = '$nm_placa' and fl_status = 'A'";
$res_conf = mysqli_query($link, $sql_conf);

if (mysqli_num_rows($res_conf) > 0) {

    while ($conf = mysqli_fetch_assoc($res_conf)) {

        $cod_recebimento        = $conf['cod_recebimento'];
        $cod_cli                = $conf['cod_cli'];
        $id_end                 = $conf['id_end'];
        $ds_galpao              = $conf['ds_galpao'];
        $ds_rua                 = $conf['ds_rua'];
        $ds_coluna              = $conf['ds_coluna'];
        $ds_altura              = $conf['ds_altura'];
        $cod_produto            = $conf['cod_produto'];
        $nr_serial              = $conf['nr_serial'];
        $nr_qtde                = $conf['nr_qtde'];

        $sql_ins = "INSERT into tb_posicao_pallet (
            produto, id_endereco, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde, n_serie, nr_or,
             fl_status, fl_bloq, fl_tipo, fl_empresa, usr_create, dt_create
             ) values (
                '" . $cod_produto . "','" . $id_end . "','" . $ds_galpao . "','" . $ds_rua . "','" . $ds_coluna . "',
                '" . $ds_altura . "', '" . $nr_qtde . "','" . $nr_serial . "','" . $cod_recebimento . "','A','N','D',
                 '" . $cod_cli . "', '" . $id . "','" . $date . "')";
        $res_ins = mysqli_query($link2, $sql_ins);

        if(mysqli_affected_rows($link2) > 0){

            $sql_prd = "UPDATE tb_recebimento_ag set fl_status = 'F', usr_aloca = '".$id."', dt_aloca = '" . $date . "' where cod_recebimento = '" . $cod_recebimento . "'";
            $prd = mysqli_query($link1, $sql_prd);

        }else{

        }
    }
} else {
}

// VALIDA SE TODOS OS PRODUTOS DO PEDIDO FORAM FINALIZADOS //

$conf_st = "SELECT fl_status from tb_recebimento_ag where nm_placa = upper('$nm_placa') and fl_status <> 'F'";
$res_st = mysqli_query($link, $conf_st);

// MANTÉM O PEDIDO ABERTO ENQUANTO TODOS OS ITENS SÃO FINALIZADOS //

if (mysqli_num_rows($res_st) > 0) {

    $retorno = array(
        'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Recebimento não pode ser finalizado.</span></h3>",
    );

    echo (json_encode($retorno));

} else {

    $retorno = array(
        'info' => "<h3 style='background-color: #98FB98;text-align:center'><span>Recebimento finalizado com sucesso!</span></h3>",
    );

    echo (json_encode($retorno));
}

$link->close();
$link1->close();
$link2->close();
?>