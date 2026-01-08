
<?php

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$clause = "where t1.nr_qtde > 0 and t1.dt_create >= (now())- interval 3 month and t1.fl_status = 'A' and (";
$sql_req = "select t1.produto, t5.nm_produto, count(t1.nr_pedido) as total_ped, round(avg(t1.nr_qtde),0) as media_exp, sum(t1.nr_qtde) as total_exp, round(COALESCE(t2.saldo_prd,0),0) as saldo_prd, COALESCE(t4.total_res,0) as total_res, COALESCE(t3.total_rec,0) as total_rec,  round(COALESCE(t2.saldo_prd,0)+COALESCE(t3.total_rec,0)-COALESCE(t4.total_res,0),0) as total_disp, (round(COALESCE(t2.saldo_prd,0)+COALESCE(t3.total_rec,0)-COALESCE(t4.total_res,0),0)-sum(t1.nr_qtde)) as ds_demanda, CASE WHEN round(COALESCE(t2.saldo_prd,0)+COALESCE(t3.total_rec,0)-COALESCE(t4.total_res,0),0) < sum(t1.nr_qtde)THEN 'REPOSIÇÃO' ELSE 'DISPONÍVEL' END as ds_action
from tb_pedido_conferencia t1
left join vw_saldo_produto t2 on t1.produto = t2.produto
left join vw_saldo_rec t3 on t1.produto = t3.produto
left join vw_saldo_ped t4 on t1.produto = t4.produto
left join tb_produto t5 on t1.produto = t5.cod_prod_cliente ";
if (isset($_POST['prd_cod'])) {
    foreach ($_POST['prd_cod'] as $c) {

        if (!empty($c)) {

            $sql_req .= $clause . "t1.produto " . " = " . $c;
            $clause = " or ";

        }

    }
}

$sql_req .= ") group by t1.produto";
$res_req = mysqli_query($link, $sql_req);

$link->close();
?>
<form class="form-horizontal" method="post" action="" id="formCadReqCompra">
    <legend>CADASTRAR REQUISIÇÃO DE REPOSIÇÃO DE PRODUTO<button class="btn btn-primary" id="btnListPrd" style="width: 200px;float: right;margin-top: -10px">LISTAR PRODUTOS</button><button class="btn btn-info" id="btnGerPend" style="width: 200px;float: right;margin-top: -10px">REPOSIÇÕES PENDENTES</button><button class="btn btn-info" id="btnPrdSemReq" style="width: 200px;float: right;margin-top: -10px">PRODUTOS S/ RESPOSIÇÃO</button></legend>
    <article> 
        <div class="form-body">
            <div class="form-group">
                <label class="col-sm-1" for="ds_solicitante">SOLICITANTE</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="ds_solicitante" name="ds_solicitante">
                </div>
                <label class="col-sm-1" for="nr_cr">CENTRO DE CUSTO</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="nr_cr" name="nr_cr" style="text-align: right;">
                </div>
                <label class="col-sm-1" for="dt_previsto">DATA LIMITE DE ENTREGA</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="dt_previsto" name="dt_previsto">
                </div>
            </div>
        </div>
        <hr>
        <table id="dt_basic" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>Cod.Produto</th>
                    <th>Produto</th>
                    <th>Total disponível</th>
                    <th>Total a repor</th>
                    <th>Qtde reposta</th>
                    <th>Data prevista</th>
                    <th>Fornecedor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($dados = mysqli_fetch_assoc($res_req)) {?>
                    <tr class="odd gradeX">
                        <td data-prd="<?php echo $dados['produto']; ?>" style="text-align: right;"><?php echo $dados['produto']; ?></td>
                        <td><?php echo $dados['nm_produto']; ?></td>
                        <td style="text-align: right;"><?php echo $dados['total_disp']; ?></td>
                        <td style="text-align: right;"><?php echo $dados['ds_demanda']; ?></td>
                        <td> <input class="form-control qtd_rep<?php echo $dados['produto']; ?>" type='text' id="qtd_rep" name="qtd_rep" style="width: 100%;text-align: right;"/> </td>
                        <td> <input class="form-control dt_rep<?php echo $dados['produto']; ?>" type='date' id="dt_rep" name="dt_rep" style="width: 100%;text-align: right;"/> </td>
                        <td style="text-align: right;">
                            <div class="input-group input-group-md retCadFor" id="retCadFor" style="width: 100%">
                                <input class="form-control bs-autocomplete_exp nm_for<?php echo $dados['produto']; ?>" id="nm_expedidor" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/produto/consulta_fornecedor.php" data-hidden_field_id="cod_for<?php echo $dados['produto']; ?>" data-item_id="cod_fornecedor" data-item_label="nm_fornecedor" autocomplete="off">
                                <input class="cod_for<?php echo $dados['produto']; ?>" id="cod_fornecedor" name="cod_fornecedor" type="hidden">
                                <span class="input-group-btn">
                                    <button class="btn btn-info btnFor" type="button" id="btnInsfor" value="<?php echo $dados['produto']; ?>"><span class="fa fa-plus" title data-original-title="Cadastrar Fornecedor"></span></button>
                                    <button class="btn btn-danger" type="button" id="btnDelReqLinha"><span class="fa fa-close" title data-original-title="Excluir"></span></button>
                                    <button class="btn btn-success btnSaveItemReq" type="button" id="btnSaveItemReq"><span class="fa fa-check" title data-original-title="Salvar"></span></button>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            <?php }?>
        </table>
        <br><br><br>
        <div style="text-align: right;">
            <button type="submit" class="btn btn-primary" id="btnCadReqCompra" style="width: 100px">Salvar</button>
        </div>
    </article>
</form>
<script type="text/javascript">

    (function() {
        "use strict";

        var expedidor = '';

        $('.bs-autocomplete_exp').each(function() {
            var _this = $(this),
            _data = _this.data(),
            _hidden_field = $('.' + _data.hidden_field_id);
            //console.log(_hidden_field);
            $.getJSON(_data.source, 
            {
                ajax: 'true'
            }, 
            function(j){

                expedidor = j;
            });

            _this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
            .parent('.form-group').addClass('has-feedback');

            var feedback_icon = _this.next('.bs-autocomplete-feedback');
            feedback_icon.hide();

            _this.autocomplete({
                minLength: 2,
                autoFocus: true,

                source: function(request, response) {
                    var _regexp = new RegExp(request.term, 'i');
                    var data = expedidor.filter(function(item) {
                        return item.nm_fornecedor.match(_regexp);
                    });
                    response(data);
                },

                search: function() {
                    feedback_icon.show();
                    _hidden_field.val('');
                },

                response: function() {
                    feedback_icon.hide();
                },

                focus: function(event, ui) {
                    _this.val(ui.item[_data.item_label]);
                    event.preventDefault();
                },

                select: function(event, ui) {
                    _this.val(ui.item[_data.item_label]);
                    _hidden_field.val(ui.item[_data.item_id]);
                    event.preventDefault();
                }
            })
            .data('ui-autocomplete')._renderItem = function(ul, item) {
                return $('<li></li>')
                .data("item.autocomplete", item)
                .append('<a>' + item[_data.item_label] + '</a>')
                .appendTo(ul);
            };
        });
    })();
</script>
<!-- meus scripts -->
<script type="text/javascript">

    $(document).ready(function() {

        pageSetUp();

        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $('#dt_basic').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
            },
            "preDrawCallback" : function() {

                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic.respond();
            }
        });

    })

</script>