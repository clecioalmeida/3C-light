<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
        <div class="container theme-showcase" role="main">
            <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header" style="background-color: #98FB98; text-align: center">
                            <h4 class="modal-title" id="myModalLabel" style="color: white">Senha alterada com sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                        <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" id="conf_dismiss" data-dismiss="modal" style="background-color: #98FB98; text-align: center">Fechar</button>
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