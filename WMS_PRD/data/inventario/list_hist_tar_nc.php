<?php

require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_POST['id_inv'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$inv_tar = "select t1.id, t1.dt_create, sum(t2.cont_2) as total_cont, count(t2.id_tar) as total_tar
from tb_inv_tarefa t1 left join tb_inv_conf t2 on t1.id = t2.id_tar
where t1.id_inv = '$id_inv' and t1.fl_tipo = 'D'
group by DAY(t1.dt_create)
order by dt_create desc";
$res_tar = mysqli_query($link,$inv_tar); 
$tar = mysqli_num_rows($res_tar);
$link->close();
?>
    <?php
    if($tar>0){
        ?>
<?php include 'relatorio/chart_inv_nc.php';?>
<br /><br />

                <section id="widget-grid" class="">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                        <fieldset>
                            <div class="row">
                            <article class="col-md-6">
                                <fieldset>
                                    <div class="widget-body no-padding">
                                        <table id="datatable_tabletools" class="table table-striped table-bordered table-hover table-responsive" style="width: 600px">
                                            <thead>
                                                <tr style="background-color: #8DB6CD">
                                                    <th> Data</th>
                                                    <th> Total de tarefas encerradas</th>
                                                    <th> Quantidade conferida </th>
                                                    <th> Peso conferido </th>
                                                    <th> Ações </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php 
                                                while($dados_tar = mysqli_fetch_assoc($res_tar)) {
                                                    ?>
                                                <tr class="odd gradeX">
                                                    <td><?php echo date("d-m-Y", strtotime($dados_tar['dt_create'])); ?></td>
                                                    <td style="width: 100px;text-align: right;"><?php echo $dados_tar['total_tar']; ?></td>
                                                    <td style="width: 50px;text-align: right;"><?php echo $dados_tar['total_cont']; ?></td>
                                                    <td style="width: 50px;text-align: right;"></td>
                                                    <td style="width: 120px;text-align: center">
                                                        <button type="submit" class="btn btn-primary btn-xs" id="btnDtlTarDia" value="<?php echo date("Y-m-d", strtotime($dados_tar['dt_create'])); ?>" style="width: 80px">Detalhe</button>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </article>
                            <article class="col-md-6">
                                <fieldset>
                                    <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
                                        <header role="heading" style=";background-color: #2F4F4F">
                                            <span class="" style="margin-left: 5px;color: white;padding: center">Tarefas finalizadas - últimos 30 dias</span>
                                        </header>
                                        <div class="row">
                                            <fieldset>
                                                <div class="widget-body no-padding">
                                                            <div id="graphTarefa" class="chart no-padding"></div>
                                                        </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </fieldset>
                            </article>
                            </div>
                        </fieldset>
                    </div>
                </section>
                 <div id="infoTarefasDia" class="row"></div>
<?php }else{?>
    <h4>Nao foram encontradas tarefas com essa descrição.</h4>
<?php }
    ?>
<script type="text/javascript">
    $(document).ready(function(){
        Morris.Bar({
            element : 'graphTarefa',
            data:[<?php echo $chart_inv_dia;?>],
            xkey : 'dia',
            ykeys : ['qtde'],
            labels : ['Qtde conferida', 'Data'],
            barColors : function(row, series, type) {
                if (type === 'bar') {
                    var red = Math.ceil(150 * row.y / this.ymax);
                    return 'rgb(' + red + ',0,0)';
                } else {
                    return '#000';
                }
            }
        });
    });
</script>