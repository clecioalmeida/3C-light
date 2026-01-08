<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.id as id_req, t2.id as id_prd, date_format(t2.dt_previsto,'%d/%m/%Y') as dt_previsto, t1.dt_previsto as data_prev, t2.cod_produto, t2.nr_qtde, t3.nm_produto, t4.nm_fornecedor, coalesce(t5.cod_recebimento, '0') as cod_recebimento, case t1.fl_status when 'A' then 'PENDENTE' else 'AGUARDANDO ENTREGA' end as fl_status
from tb_reposicao t1
left join tb_reposicao_item t2 on t1.id = t2.id_reposicao
left join tb_produto t3 on t2.cod_produto = t3.cod_prod_cliente
left join tb_fornecedor t4 on t2.id_fornecedor = t4.cod_fornecedor
left join tb_recebimento t5 on t1.id = t5.cod_req
where t1.fl_status = 'A'";
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

    <legend>RELAÇÃO DE RESPOSIÇÕES PENDENTES<button class="btn btn-success" id="geraExcel" style="width: 150px;float: right;margin-top: -10px">EXCEL</button><button class="btn btn-info" id="btnGerPend" style="width: 200px;float: right;margin-top: -10px">REPOSIÇÕES PENDENTES</button><button class="btn btn-info" id="btnPrdSemReq" style="width: 200px;float: right;margin-top: -10px">PRODUTOS S/ RESPOSIÇÃO</button><button class="btn btn-primary" id="btnListPrd" style="width: 200px;float: right;margin-top: -10px">LISTAR PRODUTOS</button><button class="btn btn-success" id="btnLibReq" style="width: 200px;float: right;margin-top: -10px">LIBERAR</button></legend>
    <div class="tableFixHead">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="dt_basic3">
            <thead>
                <tr>
                <tr>
                    <th class="hasinput" style="width: 20px">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="checkboxTodos" class="checkbox style-0">
                                <span></span>
                            </label>
                        </div>
                    </th>
                    <th> REQUISIÇÃO</th>
                    <th> PRODUTO</th>
                    <th> DESCRIÇÃO </th>
                    <th> QUANTIDADE </th>
                    <th> FORNECEDOR </th>
                    <th> DATA PREVISTA </th>
                    <th> O.R. </th>
                    <th> SITUAÇÃO </th>
                    <th> AÇÕES </th>
                </tr>
            </thead>
            <tbody>
                <?php                                                      
                while($dados = mysqli_fetch_array($res)) {?>
                    <tr class="odd gradeX">
                        <td>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="checkbox style-0 checkRepPend" id="checkRepPend" value="<?php echo $dados['id_req']; ?>" data-item="<?php echo $dados['id_prd']; ?>" data-prev="<?php echo $dados['data_prev']; ?>">
                                    <span></span>
                                </label>
                            </div>
                        </td>
                        <td style="text-align: right"> <?php echo $dados['id_req']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['cod_produto']; ?> </td>
                        <td style="text-align: left"> <?php echo $dados['nm_produto']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['nr_qtde']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['nm_fornecedor']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['dt_previsto']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['cod_recebimento']; ?> </td>
                        <td style="text-align: left"> <?php echo $dados['fl_status']; ?> </td>
                        <td style="text-align: center">
                            <?php 
                                if($dados['fl_status'] == "L"){

                                    $btn = "<button type='submit' id='btnPrintReq' value=".$dados['id_prd']." class='btn btn-info btn-xs'>IMPRIMIR</button>";

                                }else{

                                    $btn = "<button type='submit' id='btnPrintReq' value=".$dados['id_prd']." class='btn btn-info btn-xs' disabled>IMPRIMIR</button>";
                                }

                                echo $btn;

                            ?>
                            <button type="submit" id="btnUpdReq" value="<?php echo $dados['id_prd']; ?>" class="btn btn-primary btn-xs">EDITAR</button>
                            <button type="submit" id="btnDelReq" value="<?php echo $dados['id_prd']; ?>"  class="btn btn-danger btn-xs">EXCLUIR</button>
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

    $(document).ready(function() {
        $("#checkboxTodos").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        pageSetUp();
        var responsiveHelper_dt_basic3 = undefined;

        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $('#dt_basic3').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "iDisplayLength": 100,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
            },
            "preDrawCallback" : function() {
                if (!responsiveHelper_dt_basic3) {
                    responsiveHelper_dt_basic3 = new ResponsiveDatatablesHelper($('#dt_basic3'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic3.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic3.respond();
            }
        });
    });

</script> 