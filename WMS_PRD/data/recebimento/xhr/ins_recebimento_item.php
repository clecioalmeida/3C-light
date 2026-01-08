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

    require_once('bd_class.php');

    $nm_produto = $_POST['nm_produto'];
    $nr_nf_entrada = $_POST['nr_nf_entrada'];
    $nr_qtde_prevista = $_POST['nr_qtde_prevista'];
    $nr_qtde_nf = $_POST['nr_qtde_nf'];
    $nr_qtde = $_POST['nr_qtde'];
    $nr_lote = $_POST['nr_lote'];
    $dt_validade = $_POST['dt_validade'];
    $dt_fabr = $_POST['dt_fabr'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = " insert into tb_saldo_produto (produto, nr_nf_entrada, nr_qtde_prevista, nr_qtde_nf, nr_qtde, nr_lote, dt_validade, dt_fabr, fl_status, fl_tipo) values ('$nm_produto', '$nr_nf_entrada', '$nr_qtde_prevista', '$nr_qtde_nf', '$nr_qtde', '$nr_lote', '$dt_validade', '$dt_fabr', 1, 'R') ";

     
    $resultado_id = mysqli_query($link, $sql);

    if(mysqli_affected_rows($link) > 0){ ?>

    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Cadastro realizado com sucesso!</h4>
                </div>
                <div class="modal-body">
                <?php echo "Produto: $nm_produto, Nota fiscal: $nr_nf_entrada, Quantidade: $nr_qtde_nf, Lote: $nr_lote"; ?>
                </div>
                <div class="modal-footer">
                    <a href="http://localhost/app/WMS/wms/html/recebimento.php"><button type="button" class="btn btn-success">Ok</button></a>
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
                    <a href="http://localhost/app/WMS/wms/html/recebimento.php"><button type="button" class="btn btn-danger">Ok</button></a>
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