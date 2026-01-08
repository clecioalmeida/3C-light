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
	
	//$cod_cli = $_POST['cod_cli'];
    $nm_fornecedor = $_POST['nm_fornecedor'];
    $nr_peso_previsto = $_POST['nr_peso_previsto'];
    $dt_recebimento_previsto = $_POST['dt_recebimento_previsto'];
    $nr_volume_previsto = $_POST['nr_volume_previsto'];
    $nm_transportadora = $_POST['nm_transportadora'];
    $nm_motorista = $_POST['nm_motorista'];
    $nm_placa = $_POST['nm_placa'];
    $dt_recebimento_real = $_POST['dt_recebimento_real'];
    $tp_rec = $_POST['tp_rec'];
    $ds_obs = $_POST['ds_obs'];
    $cod_recebimento = $_POST['cod_recebimento'];
    $nm_user_recebido_por = $_POST['nm_user_recebido_por'];
    $dt_user_recebido_por = $_POST['dt_user_recebido_por'];
    $nm_user_autorizado_por = $_POST['nm_user_autorizado_por'];
    $dt_user_autorizado_por = $_POST['dt_user_autorizado_por'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "update tb_recebimento set nm_fornecedor =  '$nm_fornecedor', nr_peso_previsto =  '$nr_peso_previsto', dt_recebimento_previsto =  STR_TO_DATE('$dt_recebimento_previsto', '%d/%m/%Y'), nr_volume_previsto =  '$nr_volume_previsto', nm_transportadora =  '$nm_transportadora', nm_motorista =  '$nm_motorista', nm_placa =  '$nm_placa', dt_recebimento_real =  STR_TO_DATE('$dt_recebimento_real', '%d/%m/%Y'), tp_rec = '$tp_rec', ds_obs = '$ds_obs', nm_user_recebido_por = '$nm_user_recebido_por', dt_user_recebido_por = STR_TO_DATE('$dt_user_recebido_por', '%d/%m/%Y'), nm_user_autorizado_por = '$nm_user_autorizado_por', dt_user_autorizado_por = STR_TO_DATE('$dt_user_autorizado_por', '%d/%m/%Y') WHERE cod_recebimento = '$cod_recebimento'";
	
	$resultado_id = mysqli_query($link, $sql);
 
if(mysqli_affected_rows($link) > 0){ ?>

    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Registro alterado com sucesso!</h4>
                </div>
                <div class="modal-body">
                <?php echo "Produto: $nm_produto, Nota fiscal: $nr_nf_entrada, Quantidade: $nr_qtde_nf, Lote: $nr_lote"; ?>
                </div>
                <div class="modal-footer">
                    <a href="../../../../recebimento.php"><button type="button" class="btn btn-success">Ok</button></a>
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
                    <a href="../../../../recebimento.php"><button type="button" class="btn btn-danger">Ok</button></a>
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