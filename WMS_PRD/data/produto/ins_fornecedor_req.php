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

$nm_fornecedor      = $_POST['nm_cliente'];
$cod_sap            = $_POST['cod_sap'];
$cod_prd            = $_POST['cod_prd'];
$nr_cnpj_cpf        = $_POST['nr_cnpj_cpf'];
$ds_ie_rg           = $_POST['ds_ie_rg'];
$ds_endereco        = $_POST['ds_endereco'];
$ds_bairro          = $_POST['ds_bairro'];
$ds_cidade          = $_POST['ds_cidade'];
$ds_uf              = $_POST['ds_uf'];
$ds_cep             = $_POST['ds_cep'];
$nr_telefone        = $_POST['nr_telefone'];
$ds_email           = $_POST['ds_email'];
$nm_fantasia        = $_POST['nm_fantasia'];
$nm_contato         = $_POST['nm_contato'];
$ds_complemento     = $_POST['ds_complemento'];

$search="select nr_cnpj_cpf from tb_fornecedor where fl_status = 'A' and nr_cnpj_cpf = '$nr_cnpj_cpf'";
$consulta_cnpj = mysqli_query($link, $search);

if(mysqli_num_rows($consulta_cnpj) > 0){ 

    $array_parte = array(
        'info' => "Já existe registro com esse CNPJ.",
        'id_for' => "",
    );

}else{ 
    
    $sql = "insert into tb_fornecedor (nm_fornecedor, nr_cnpj_cpf, ds_ie, nm_fantasia, ds_email, ds_endereco, ds_bairro, ds_cidade, ds_uf, ds_cep, nr_telefone, fl_status, usr_create, dt_create) values ('$nm_fornecedor',  '$nr_cnpj_cpf', '$ds_ie_rg', '$nm_fantasia', '$ds_email','$ds_endereco', '$ds_bairro', '$ds_cidade', '$ds_uf', '$ds_cep', '$nr_telefone', 'A', '$id', now())";
    $resultado_id = mysqli_query($link, $sql);

    if(mysqli_affected_rows($link) > 0){ 

        $nFor = mysqli_insert_id($link);

        $array_parte = array(
            'info'              => "Cadastro realizado com sucesso.",
            'id_for'            => $nFor,
            'nm_fornecedor'     => $nm_fornecedor,
            'cod_prd'           => $cod_prd,
        );

    }else{

        $array_parte = array(
            'info' => "Erro no cadastro.",
            'id_for' => "",
        );

    }
} 

echo (json_encode($array_parte));

$link->close();
?>