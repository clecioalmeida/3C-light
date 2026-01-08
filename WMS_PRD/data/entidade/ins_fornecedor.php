<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php

    require_once('bd_class.php');

    $nm_cliente = $_POST['nm_cliente'];
    $cod_sap = $_POST['cod_sap'];
    $nr_cnpj_cpf = $_POST['nr_cnpj_cpf'];
    $ds_ie_rg = $_POST['ds_ie_rg'];
    $ds_endereco = $_POST['ds_endereco'];
    $ds_bairro = $_POST['ds_bairro'];
    $ds_cidade = $_POST['ds_cidade'];
    $ds_uf = $_POST['ds_uf'];
    $ds_cep = $_POST['ds_cep'];
    $nr_telefone = $_POST['nr_telefone'];
    $ds_email = $_POST['ds_email'];
    $nm_fantasia = $_POST['nm_fantasia'];
    $nm_contato = $_POST['nm_contato'];
    $ds_complemento = $_POST['ds_complemento'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $search="select nr_cnpj_cpf from tb_cliente where nr_cnpj_cpf = '$nr_cnpj_cpf' and fl_status = A";
    $consulta_cnpj = mysqli_query($link, $search);

    

     if(mysqli_affected_rows($link) > 0){ ?>

    <div class="modal fade" id="conf_cadastro" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Registro Já existe!</h4>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#conf_cadastro').modal('show');
        });
    </script>

    <?php }else{ 
                $sql = " insert into tb_cliente (nm_cliente, cod_sap, nr_cnpj_cpf, ds_ie_rg, ds_endereco, ds_bairro, ds_cidade, ds_uf, ds_cep, nr_telefone, ds_email, nm_fantasia, nm_contato, ds_complemento, fl_tipo, fl_status) values ('$nm_cliente', '$cod_sap', '$nr_cnpj_cpf',  '$ds_ie_rg', '$ds_endereco', '$ds_bairro', '$ds_cidade', '$ds_uf', '$ds_cep', '$nr_telefone', '$ds_email', '$nm_fantasia', '$nm_contato', '$ds_complemento', 'F', 'A') "; 
               $resultado_id = mysqli_query($link, $sql);

                if(mysqli_affected_rows($link) > 0){ ?>
                    <div class="modal fade" id="conf_cadastro" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #22262E">
                                    <h4 class="modal-title" id="myModalLabel" style="color: white">Registro cadastrado com sucesso!</h4>
                                </div>
                                <div class="modal-body">
                                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
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
                                <div class="modal fade" id="conf_cadastro" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #22262E">
                                                <h4 class="modal-title" id="myModalLabel" style="color: white">Erro no cadastro!</h4>
                                            </div>
                                            <div class="modal-body">                                

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
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
                    } 

    
    $link->close();
    ?>
    </div>

</body>
</html>