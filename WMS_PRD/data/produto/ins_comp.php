<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php
	require_once("bd_class.php");
	
	$cod_cli = $_POST['cod_cli'];
	$nm_produto = $_POST['nm_produto'];
	$cod_prod_cliente = $_POST['cod_prod_cliente'];
	$tp_separacao = $_POST['tp_separacao'];
	$codncm = $_POST['codncm'];
	$ean = $_POST['ean'];
	$fl_lote = $_POST['fl_lote'];
	$peso = $_POST['peso'];
	$curva = $_POST['curva'];
	$peso_bruto = $_POST['peso_bruto'];
	$detalhe_produto = $_POST['detalhe_produto'];
	$nr_estoque_min = $_POST['nr_estoque_min'];
	$unid = $_POST['unid'];
	$volume = $_POST['volume'];
	$unid_controle = $_POST['unid_controle'];
	$altura = $_POST['altura'];
	$cod_grupo = $_POST['cod_grupo'];
	$cod_sub_grupo = $_POST['cod_sub_grupo'];
	$compr = $_POST['compr'];
	$largura = $_POST['largura'];
	$cod_identificacao = $_POST['cod_identificacao'];
	$multiplo = $_POST['multiplo'];
	$id_armazem = $_POST['id_armazem'];
	$aloc_aut = $_POST['aloc_aut'];


	$objDb = new db();
	$link = $objDb->conecta_mysql();

    $sql = " insert into tb_produto (cod_cli, nm_produto, cod_prod_cliente, tp_separacao, codncm, ean, fl_lote, peso, curva, peso_bruto, detalhe_produto, nr_estoque_min, unid, volume, unid_controle, altura, cod_grupo, cod_sub_grupo, compr, largura, cod_identificacao, multiplo, id_armazem, aloc_aut, fl_tipo_comp) values ('$cod_cli', '$nm_produto',  '$cod_prod_cliente', '$tp_separacao', '$codncm', '$ean', '$fl_lote', '$peso', '$curva', '$peso_bruto', '$detalhe_produto', '$nr_estoque_min', '$unid', '$volume', '$unid_controle', '$altura', '$cod_grupo', '$cod_sub_grupo', '$compr', '$largura', '$cod_identificacao', '$multiplo', '$id_armazem', '$aloc_aut', '1') ";

           $resultado_id = mysqli_query($link, $sql);

            if(mysqli_affected_rows($link) > 0){ ?>

                <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Cadastro realizado com sucesso!</h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                            	<button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#conf_cadastro').modal('show');
                    });
                </script>

                <?php }else{ ?>    

                <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                            </div>
                            <div class="modal-body">                                

                            </div>
                            <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>          
                <script>
                    $(document).ready(function () {
                        $('#conf_cadastro').modal('show');
                    });
                </script>
    <?php }
    
   
$link->close();
?>