<!DOCTYPE html>
<html lang="pt-br">
    <head>
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
                            <p><h4>É necessário que todas as quantidades sejam digitadas</h4></p>
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