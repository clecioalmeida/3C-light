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
                            <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                        </div>
                        <div class="modal-body">                                
                            <p><h4>Não foi possível gerar as tarefas.</h4></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
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