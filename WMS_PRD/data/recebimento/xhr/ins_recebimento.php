<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!--script src="js/jquery-3.2.1.js"></script-->
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php
	require_once('bd_class.php');

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
    $user = $_POST['user'];
 
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = " insert into tb_recebimento (cod_cli, nm_fornecedor, nr_peso_previsto, dt_recebimento_previsto, nr_volume_previsto, nm_transportadora, nm_motorista, nm_placa, dt_recebimento_real, fl_status, tp_rec, nm_user_criado_por, dt_user_criado_por) values (110, '$nm_fornecedor', '$nr_peso_previsto', '$dt_recebimento_previsto', '$nr_volume_previsto', '$nm_transportadora', '$nm_motorista', '$nm_placa', '$dt_recebimento_real', 'A', '$tp_rec', '$user', now()) ";

	$resultado_id = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link) > 0){ ?>

    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Cadastro efetuado com sucesso!</h4>
                </div>
                <div class="modal-body">
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
                    <a href="../../../../recebimento.php""><button type="button" class="btn btn-danger">Ok</button></a>
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