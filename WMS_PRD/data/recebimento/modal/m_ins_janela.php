<div class="modal fade" id="nova_janela" tabindex="-1" role="dialog">
    <form method="post" action="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #22262E;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: white">INCLUSÃO DE JANELAS EXTRAS</h4>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <section>
                            <div class="form-group">
                                <label class="control-label col-sm-2">DATA</label> 
                                <div class="col-sm-4">
                                    <input class="form-control" type="date" id="dt_janela" name="dt_janela" required="true">
                                </div>
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label class="control-label col-sm-2">HORÁRIO</label> 
                                <div class="col-sm-4">
                                    <input class="form-control" type="time" id="hr_janela" name="hr_janela" required="true" style="text-align: right;">
                                </div>
                            </div>
                        </section>
                    </fieldset>
                    <!--fieldset>
                        <section>
                            <div class="form-group">
                                <label class="control-label col-sm-2">DOCA</label> 
                                <div class="col-sm-4">
                                    <select class="form-control" id="ds_doca" name="ds_doca" required="true">
                                        <option value="Doca 1">DOCA 1</option>
                                        <option value="Doca 2">DOCA 2</option>
                                        <option value="Pátio">PÁTIO</option>
                                    </select>
                                </div>
                            </div>
                        </section>
                    </fieldset-->
                    <fieldset>
                        <section>
                            <div class="form-group">
                                <label class="control-label col-sm-2">SOLICITANTE</label> 
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="ds_solicitante" name="ds_solicitante" required="true">
                                </div>
                            </div>
                        </section>
                    </fieldset>
                    <fieldset>
                        <section>
                            <div class="form-group">
                                <label class="control-label col-sm-2">MOTIVO</label> 
                                <div class="col-sm-10">
                                    <textarea class="form-control" type="text" id="ds_motivo" name="ds_motivo" rows="3" required="true"></textarea>
                                </div>
                            </div>
                        </section>
                    </fieldset>
                </div>
                <div class="modal-footer" style="background-color: #22262E;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" id="btnSaveNovaJanela" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('#nova_janela').modal('show');
    });
</script>