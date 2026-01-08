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
    $cod_nf_item = $_POST['cod_nf_item'];
    $nr_qtde = $_POST['nr_qtde'];
    $vl_unit = $_POST['vl_unit'];
    $cfop = $_POST['cfop'];
    $nr_lote = $_POST['nr_lote'];
    $dt_validade = $_POST['dt_validade'];  
    $dt_fabr = $_POST['dt_fabr'];
    $estado_produto = $_POST['estado_produto'];  


    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "update tb_nf_entrada_item set nr_qtde = '$nr_qtde', vl_unit = '$vl_unit', cfop = '$cfop', nr_lote = '$nr_lote', dt_validade = '$dt_validade', dt_fabr = '$dt_fabr', estado_produto = '$estado_produto' WHERE cod_nf_entrada_item = '$cod_nf_item'" or die(mysqli_error($sql));
    
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