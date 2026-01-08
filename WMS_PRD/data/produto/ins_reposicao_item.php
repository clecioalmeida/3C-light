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

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$qtd_rep      = $_POST['qtd_rep'];
$data_rep     = $_POST['data_rep'];
$cod_prd      = $_POST['cod_prd'];
$id_for       = $_POST['id_for'];

if($qtd_rep == "" || $id_for == ""){

    $array_parte = array(
        'info' => "Por favor preencha quantidade e fornecedor.",
    );

}else{

    $search="select cod_produto, nr_qtde from tb_reposicao_item where fl_status = 'A' and cod_produto = '$cod_prd' and nr_qtde = '$qtd_rep'";
    $consulta_cnpj = mysqli_query($link, $search);

    if(mysqli_num_rows($consulta_cnpj) > 0){ 

        $array_parte = array(
            'info' => "Já existe reposição para esse produto.",
        );

    }else{ 

        $sql = "insert into tb_reposicao_item (cod_produto, nr_qtde, id_fornecedor, dt_previsto, fl_status, usr_create, dt_create) values ('$cod_prd',  '$qtd_rep', '$id_for', '$data_rep', 'A', '$id', now())";
        $resultado_id = mysqli_query($link, $sql);

        if(mysqli_affected_rows($link) > 0){ 

            $nItem = mysqli_insert_id($link);

            $array_parte = array(
                'info'              => "Cadastro realizado com sucesso.",
                'id_item'           => $nItem,
                'cod_prd'           => $cod_prd,
            );

        }else{

            $array_parte = array(
                'info' => "Erro no cadastro.",
            );

        }
    } 

}

echo (json_encode($array_parte));

$link->close();
?>