<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header col-sm-12">
                
            </div>
            <div class="modal-body modal-lg"><br/><br/>
                <div class="col-sm-6">
                    <h4 class="modal-title" id="myModalLabel">Lista de inventário</h4>
                </div>
                <div class="col-sm-6">
                    <form method="post" action="gera_tarefa.php" id="formGerar" role="form">
                        <input type="hidden" name="id_galpao" value="<?php echo $id_galpao;?>">
                        <input type="hidden" name="nr_inv" value="<?php echo $nr_inv;?>">
                        <input type="hidden" name="id_produto" value="<?php echo $id_produto;?>">
                        <input type="hidden" name="id_rua_inicio" value="<?php echo $id_rua_inicio;?>">
                        <input type="hidden" name="id_rua_fim" value="<?php echo $id_rua_fim;?>">
                        <input type="hidden" name="id_coluna_inicio" value="<?php echo $id_coluna_inicio;?>">
                        <input type="hidden" name="id_coluna_fim" value="<?php echo $id_coluna_fim;?>">
                        <button type="submit" class="btn btn-primary" style="float: right;"><span aria-hidden="true">Gerar</span></button>
                    </form>
                </div>
                <br /><br /><br />
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr style="background-color: #8DB6CD">
                            <th> Código</th>
                            <th> Armazém</th>
                            <th> Rua </th>
                            <th> Coluna </th>
                            <th> Altura </th>
                            <th> Produto  </th>
                            <th> Quantidade  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($dados_tr = mysqli_fetch_assoc($res)) {
                            $cod_estoque = $dados_tr['cod_estoque'];
                            ?>
                        <tr class="odd gradeX">
                            <td><?php echo $dados_tr['cod_estoque']; ?></td>
                            <td><?php echo $dados_tr['nome']; ?></td>
                            <td><?php echo $dados_tr['ds_prateleira']; ?></td>
                            <td><?php echo $dados_tr['ds_coluna']; ?></td>
                            <td><?php echo $dados_tr['ds_altura']; ?></td>
                            <td><?php echo $dados_tr['produto']; ?></td>
                            <td><?php echo $dados_tr['nr_qtde']; ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
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

<script type="text/javascript">
    
    function tarefas(tarefas)
    {
        var page = "gera_tarefa.php";
        $.ajax
        ({
            type: 'POST',
            dataType: 'html',
            url: page,
            beforeSend: function () {
                $("#info").html("Carregando...");
            },
            data: {id_galpao: id_galpao, nr_inv: nr_inv,id_produto: id_produto,id_rua_inicio: id_rua_inicio,id_rua_fim: id_rua_fim},
            success: function (msg)
            {
                $("#info").html(msg);
            }
        });
    }


    $('#btnAgendados').click(function () {
        tarefas($("#id_galpao").val(),$("#nr_inv").val(),$("#id_produto").val(),$("#id_rua_inicio").val(),$("#id_rua_fim").val())
    });

</script>