<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header" style="background-color: #A52A2A; text-align: center">
                            <h4 class="modal-title" id="myModalLabel">Produto já existe no pedido!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Um produto não pode constar duas vezes no mesmo pedido, mas você pode alterar quantidade do produto caso não tenha sido iniciado o picking.</p>    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                        </div>
                        </div>
                    </div>
                </div>
            <script>
                $(document).ready(function () {
                    $('#conf_cadastro').modal('show');
                        });
            </script>