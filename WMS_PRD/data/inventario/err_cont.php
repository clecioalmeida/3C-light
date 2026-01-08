<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="http://www.gisis.com.br/app/WMS/wms/html/includes/forms/armazem/xhr/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://www.gisis.com.br/app/WMS/wms/html/includes/forms/armazem/xhr/js/bootstrap.min.js"></script>
    </head>
<body>
    <div class="container theme-showcase" role="main">
        <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #FFA07A">
                        <h4 class="modal-title" id="myModalLabel">Erro na contagem!</h4>
                    </div>
                    <div class="modal-body">                                
                        <?php echo "<h3>É obrigatório que pelo menos duas contagens coincidam com o saldo de estoque!</h3>"; ?>
                    </div>
                    <div class="modal-footer">
                        <a href="http://localhost/WMS_dsv/wms/html/inv_programacao.php#tab_1_2"><button type="button" class="btn btn-danger">Ok</button></a>
                    </div>
                </div>
            </div>
        </div>          
        <script>
            $(document).ready(function () {
                $('#conf_cadastro').modal('show');
            });
        </script>
    </div>
</body>
</html>