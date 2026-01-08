<?php

    require_once('bd_class.php');

    $nm_cliente = $_POST['nm_cliente'];
    $nr_cnpj_cpf = $_POST['nr_cnpj_cpf'];
    $ds_ie_rg = $_POST['ds_ie_rg'];
    $nm_usuario = $_POST['nm_usuario'];
    $nm_dpto = $_POST['nm_dpto'];
    $nm_cargo = $_POST['nm_cargo'];
    $ds_endereco = $_POST['ds_endereco'];
    $ds_bairro = $_POST['ds_bairro'];
    $ds_cidade = $_POST['ds_cidade'];
    $ds_uf = $_POST['ds_uf'];
    $ds_cep = $_POST['ds_cep'];
    $nr_telefone = $_POST['nr_telefone'];
    $ds_email = $_POST['ds_email'];
    $fl_nivel = $_POST['fl_nivel'];
    //$fl_status = $_POST['fl_status'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();
    
    $sql = " insert into tb_cliente (nm_cliente, nr_cnpj_cpf, ds_ie_rg, nm_usuario, nm_dpto, nm_cargo, ds_endereco, ds_bairro, ds_cidade, ds_uf, ds_cep, nr_telefone, ds_email, fl_nivel, fl_tipo, fl_status) values ('$nm_cliente', '$nr_cnpj_cpf',  '$ds_ie_rg', '$nm_usuario', '$nm_dpto', '$nm_cargo','$ds_endereco', '$ds_bairro', '$ds_cidade', '$ds_uf', '$ds_cep', '$nr_telefone', '$ds_email', '$fl_nivel', 'U', 1)";

    $resultado_id = mysqli_query($link, $sql);
 
if($resultado_id){
 
    include 'modal/sucess_ins_user.php';

} else {

    echo 'Dados não cadastrados';
}
$link->close();
?>