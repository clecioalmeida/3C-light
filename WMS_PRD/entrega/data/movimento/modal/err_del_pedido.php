<html lang="pt-br">
    <head>
    </head>
    <body>
        <div class="container theme-showcase" role="main">
            <div class="modal fade" id="sem_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Erro!</h4>
                        </div>
                        <div class="modal-body">
                            <p><h3>O pedido já está em processo de picking e não pode ser excluído!</h3></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#sem_registro').modal('show');
            });
        </script>
    </body>
</html>