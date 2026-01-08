<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.produto, t5.nm_produto, count(t1.nr_pedido) as total_ped, round(avg(t1.nr_qtde),0) as media_exp, sum(t1.nr_qtde) as total_exp, round(COALESCE(t2.saldo_prd,0),0) as saldo_prd, COALESCE(t4.total_res,0) as total_res, COALESCE(t3.total_rec,0) as total_rec,  round(COALESCE(t2.saldo_prd,0)+COALESCE(t3.total_rec,0)-COALESCE(t4.total_res,0),0) as total_disp, (round(COALESCE(t2.saldo_prd,0)+COALESCE(t3.total_rec,0)-COALESCE(t4.total_res,0),0)-sum(t1.nr_qtde)) as ds_demanda, CASE WHEN round(COALESCE(t2.saldo_prd,0)+COALESCE(t3.total_rec,0)-COALESCE(t4.total_res,0),0) < sum(t1.nr_qtde)THEN 'REPOSIÇÃO' ELSE 'DISPONÍVEL' END as ds_action, t6.nr_qtde as qtd_rep, t6.dt_previsto as dt_rep, t6.id_fornecedor, t7.nm_fornecedor
from tb_pedido_conferencia t1
left join vw_saldo_produto t2 on t1.produto = t2.produto
left join vw_saldo_rec t3 on t1.produto = t3.produto
left join vw_saldo_ped t4 on t1.produto = t4.produto
left join tb_produto t5 on t1.produto = t5.cod_prod_cliente
left join tb_reposicao_item t6 on t1.produto = t6.cod_produto and t6.id_reposicao is null
left join tb_fornecedor t7 on t6.id_fornecedor = t7.cod_fornecedor
where t1.nr_qtde > 0 and t1.dt_create >= (now())- interval 3 month and t1.fl_status = 'A'
group by t1.produto";
$res = mysqli_query($link,$sql); 

$tr = mysqli_num_rows($res);

$link->close();
?>

<?php if($tr > 0){ ?>

    <style type="text/css">
        .tableFixHead          { overflow-y: auto; height: 640px; }
        .tableFixHead thead th { position: sticky; top: 0; }
        table  { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 16px; }
        th     { background:#eee; }

        .saldoMinOk { background-color: green; color:white; }
        .saldoMinDiv { background-color: red; color:white; }

    </style>
    <legend>PROJEÇÃO DE SALDOS PARA OS PRÓXIMOS 3 MESES
        <button class="btn btn-success" id="geraExcel" style="width: 150px;float: right;margin-top: -10px">EXCEL</button>
        <button class="btn btn-info" id="btnGerPend" style="width: 200px;float: right;margin-top: -10px">REPOSIÇÕES PENDENTES</button>
        <button class="btn btn-info" id="btnPrdSemReq" style="width: 200px;float: right;margin-top: -10px">PRODUTOS S/ REPOSIÇÃO</button>
        <button class="btn btn-primary" id="btnListPrd" style="width: 200px;float: right;margin-top: -10px">LISTAR PRODUTOS</button>
        <button class="btn btn-primary" id="btnGerRep" style="width: 200px;float: right;margin-top: -10px">GERAR REPOSIÇÃO</button>
    </legend>
    <div style="display: none"> 
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
    </div>
    <div class="tableFixHead">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="dt_basic2">
            <thead>
                <tr>
                    <th class="hasinput" style="width: 20px">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="checkboxTodos" class="checkbox style-0">
                                <span></span>
                            </label>
                        </div>
                    </th>
                    <th> PRODUTO</th>
                    <th> DESCRIÇÃO </th>
                    <!--th> PEDIDOS ATENDIDOS </th>
                    <th> MÉDIA POR PEDIDO </th-->
                    <th> TOTAL SAÍDA (3 MESES) </th>
                    <th> SALDO ATUAL </th>
                    <!--th> TOTAL RESERVADO </th-->
                    <th> TOTAL A RECEBER </th>
                    <!--th> DISP. PRÓXIMO PERÍODO </th-->
                    <th> SALDO PARA O PRÓXIMO PERÍODO </th>
                    <th> SITUAÇÃO </th>
                    <th> QTDE DA COMPRA </th>
                    <th> DATA DE ENTREGA </th>
                    <th> FORNECEDOR </th>
                </tr>
            </thead>
            <tbody>
                <?php                                                      
                while($dados = mysqli_fetch_array($res)) {?>
                    <tr class="odd gradeX">
                        <td>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="checkbox style-0 checkSldMin" id="checkSldMin" data-dem="<?php echo $dados['ds_demanda']; ?>" value="<?php echo $dados['produto']; ?>">
                                    <span></span>
                                </label>
                            </div>
                        </td>
                        <td data-prd="<?php echo $dados['produto']; ?>" style="text-align: right"> <?php echo $dados['produto']; ?> </td>
                        <td style="text-align: left"> <?php echo $dados['nm_produto']; ?> </td>
                        <!--td style="text-align: right"> <?php echo $dados['total_ped']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['media_exp']; ?> </td-->
                        <td style="text-align: right"> <?php echo $dados['total_exp']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['saldo_prd']; ?> </td>
                        <!--td style="text-align: right"> <?php echo $dados['total_res']; ?> </td-->
                        <td style="text-align: right"> <?php echo $dados['total_rec']; ?> </td>
                        <!--td style="text-align: right"> <?php echo $dados['total_disp']; ?> </td-->
                        <td style="text-align: right"> <?php echo $dados['ds_demanda']; ?> </td>
                        <td class="<?php if($dados['total_disp'] < $dados['total_exp']){ echo 'saldoMinDiv';}else{ echo 'saldoMinOk';} ?>" style="text-align: left"> <?php echo $dados['ds_action']; ?> </td>
                        <td style="width: 50px"> <input class="form-control qtd_rep<?php echo $dados['produto']; ?>" type='text' id="qtd_rep" name="qtd_rep" value="<?php echo $dados['qtd_rep']; ?>" style="width: 100%;text-align: right;"/> </td>
                        <td style="width: 50px"> <input class="form-control dt_rep<?php echo $dados['produto']; ?>" type='date' id="dt_rep" name="dt_rep" value="<?php echo $dados['dt_rep']; ?>" style="width: 100%;text-align: right;"/> </td>
                        <td style="text-align: right;width: 400px">
                            <div class="input-group input-group-md retCadFor" id="retCadFor" style="width: 100%">
                                <input class="form-control bs-autocomplete_exp nm_for<?php echo $dados['produto']; ?>" id="nm_expedidor" placeholder="Digite dois ou mais caracteres" type="text" data-source="data/produto/consulta_fornecedor.php" data-hidden_field_id="cod_for<?php echo $dados['produto']; ?>" data-item_id="cod_fornecedor" data-item_label="nm_fornecedor" value="<?php echo $dados['nm_fornecedor']; ?>" autocomplete="off">
                                <input class="cod_for<?php echo $dados['produto']; ?>" id="cod_fornecedor" name="cod_fornecedor" value="<?php echo $dados['id_fornecedor']; ?>" type="hidden">
                                <span class="input-group-btn">
                                    <button class="btn btn-info btnFor" type="button" id="btnInsfor" value="<?php echo $dados['produto']; ?>"><span class="fa fa-plus" title data-original-title="Cadastrar Fornecedor"></span></button>
                                    <button class="btn btn-danger" type="button" id="btnDelReqLinha"><span class="fa fa-close" title data-original-title="Excluir"></span></button>
                                    <button class="btn btn-success btnSaveItemReq" type="button" id="btnSaveItemReq" value="<?php echo $dados['produto']; ?>"><span class="fa fa-check" title data-original-title="Salvar"></span></button>
                                </span>
                            </div>
                        </td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
<?php }else{?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php } ?>


<div id="retornoInsert"></div>
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
<script type="text/javascript"> 
    $(document).ready(function() {
        $("#checkboxTodos").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        pageSetUp();
        var responsiveHelper_dt_basic2 = undefined;

        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $('#dt_basic2').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "iDisplayLength": 100,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
            },
            "preDrawCallback" : function() {
                if (!responsiveHelper_dt_basic2) {
                    responsiveHelper_dt_basic2 = new ResponsiveDatatablesHelper($('#dt_basic2'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic2.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic2.respond();
            }
        });
    });

</script> 