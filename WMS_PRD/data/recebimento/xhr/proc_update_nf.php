<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php
    require_once("bd_class.php");
    
    $cod_nf_entrada = $_POST['cod_nf_entrada'];
    $nm_fornecedor = $_POST['nm_fornecedor'];
    $nr_fisc_ent = $_POST['nr_fisc_ent'];
    $dt_emis_ent = $_POST['dt_emis_ent'];
    $nr_cfop_ent = $_POST['nr_cfop_ent'];
    $qtd_vol_ent = $_POST['qtd_vol_ent'];
    $nr_peso_ent = $_POST['nr_peso_ent'];
    $tp_vol_ent = $_POST['tp_vol_ent'];
    $vl_tot_nf_ent = $_POST['vl_tot_nf_ent'];
    $base_icms_ent = $_POST['base_icms_ent'];
    $vl_icms_ent = $_POST['vl_icms_ent'];
    $chavenfe = $_POST['chavenfe'];
    $ds_obs_nf = $_POST['ds_obs_nf'];


    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "update tb_recebimento set cod_nf_entrada ='$cod_nf_entrada', nm_fornecedor =  '$nm_fornecedor', nr_fisc_ent =  '$nr_fisc_ent', dt_emis_ent =  '$dt_emis_ent', nr_cfop_ent =  '$nr_cfop_ent', qtd_vol_ent =  '$qtd_vol_ent', nr_peso_ent =  '$nr_peso_ent', tp_vol_ent =  '$tp_vol_ent', vl_tot_nf_ent =  '$vl_tot_nf_ent', base_icms_ent =  '$base_icms_ent', chavenfe = '$chavenfe', ds_obs_nf = '$ds_obs_nf' WHERE cod_nf_entrada =  '$cod_nf_entrada'" or die(mysqli_error($sql));
    
    $resultado_id = mysqli_query($link, $sql);
 
if(mysqli_affected_rows($link) > 0){ ?>

    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Registro alterado com sucesso!</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <a href="../../../recebimento.php"><button type="button" class="btn btn-success">Ok</button></a>
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
                    <a href="../../../recebimento.php""><button type="button" class="btn btn-danger">Ok</button></a>
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
    </div>

</body>
</html>