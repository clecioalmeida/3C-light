<div class="modal fade" id="novo_ns" tabindex="-1" role="dialog">
    <form method="post" action="xhr/ins_nserie.php">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: white">Números de série do produto <?php echo $dados_aloc['produto']; ?>, OR <?php echo $cod_rec; ?></h4>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="n_serie">Números de série:</label>
                             <div class="col-sm-6">
                                <input type="hidden" name="produto" value="<?php echo $produto; ?>">
                                <input type="hidden" name="cod_rec" value="<?php echo $cod_rec; ?>">
                                <input type="hidden" name="cod_estoque" value="<?php echo $cod_estoque; ?>">
                                <input type="text" class="form-control" name="n_serie" id="n_serie" align="right">
                                <input type="text" class="form-control" name="n_serie1" id="n_serie1" align="right">
                                <input type="text" class="form-control" name="n_serie2" id="n_serie2" align="right">
                                <input type="text" class="form-control" name="n_serie3" id="n_serie3" align="right">
                                <input type="text" class="form-control" name="n_serie4" id="n_serie4" align="right">
                                <input type="text" class="form-control" name="n_serie5" id="n_serie5" align="right">
                                <input type="text" class="form-control" name="n_serie6" id="n_serie6" align="right">
                                <input type="text" class="form-control" name="n_serie7" id="n_serie7" align="right">
                                <input type="text" class="form-control" name="n_serie8" id="n_serie8" align="right">
                                <input type="text" class="form-control" name="n_serie9" id="n_serie9" align="right">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->
<script>
    $(document).ready(function () {
        $('#novo_ns').modal('show');
    });
</script>