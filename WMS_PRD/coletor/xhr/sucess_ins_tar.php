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
                            <h4 class="modal-title" id="myModalLabel">Tarefas de inventário geradas com sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <!--p><h3>Não esqueça de se planejar!</h3></p> 
                            <p><h4>O inventário não poderá ser ativado se houver alguma movimentação pendente e quando o inventário for ativado as movimentações serão bloqueadas.</h4></p-->
                        </div>
                        <div class="modal-footer">
                            <a href="http://localhost/wms_20/coletor/inventário.php"><button type="button" class="btn btn-danger">Fechar</button></a>
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