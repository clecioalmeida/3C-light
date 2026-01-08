<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
        <div class="container theme-showcase" role="main">
            <div class="modal fade" id="sem_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2F4F4F;">
                            <h4 class="modal-title" id="myModalLabel" style="color: white">Exclusão realizada com sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                        <div class="modal-footer" style="background-color: #2F4F4F;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#sem_registro').modal('show');
                });
            </script>
        </div>
    </body>
</html>