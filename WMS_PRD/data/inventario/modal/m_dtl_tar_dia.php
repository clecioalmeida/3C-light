<?php
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_create = $_POST['dt_create'];

$big_select="SET SQL_BIG_SELECTS=1";
$res_big=mysqli_query($link, $big_select);

$query_tar = "select t1.*, t2.id as id_conf, t2.cont_1, t2.cont_2, t2.cont_3, t3.nome, t4.nr_posicao
            from tb_inv_tarefa t1
            left join tb_inv_conf t2 on t1.id = t2.id_tar
            left join tb_armazem t3 on t1.id_galpao = t3.id
            left join tb_produto t5 on t1.id_produto = t5.cod_produto
            left join tb_item_torre t4 on t4.id_item = t5.cod_produto or t4.id_item = t5.id_torre
            where YEAR(t1.dt_create) = YEAR('$dt_create') and MONTH(t1.dt_create) = MONTH('$dt_create') and DAY(t1.dt_create) = DAY('$dt_create')
            order by t1.dt_create desc";
$res_tar=mysqli_query($link, $query_tar);
$tr_tar = mysqli_num_rows($res_tar);

$link->close();
?>
<div class="modal fade in" id="dtlTarDia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 19px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                    </button>
                    <button type="submit" class="btn btn-success" id="SalAnalitTorGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: white">Tarefas finalizadas</h4>
                </div>
                <div class="modal-body modal-lg">
                     <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                <div>
                    <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
                            <table id="TbConsSalTorreAnalit" class="table table-striped table-bordered table-hover">
                                <thead>
                        <tr style="background-color: #8DB6CD">
                            <th> Código estoque</th>
                            <th> Produto </th>
                            <th> Posição </th>
                            <th> Armazém </th>
                            <th> Rua </th>
                            <th> Coluna </th>
                            <th> Altura </th>
                            <th> Quantidade </th>
                            <th> Contagem 1 </th>
                            <th> Contagem 2 </th>
                            <th> Contagem 3 </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($dados_tar = mysqli_fetch_assoc($res_tar)) {
                        ?>
                        <tr class="odd gradeX">
                            <td style="width: 50px"><?php echo $dados_tar['id_estoque']; ?></td>
                            <td><?php echo $dados_tar['id_produto']; ?></td>
                            <td><?php echo $dados_tar['nr_posicao']; ?></td>
                            <td><?php echo $dados_tar['nome']; ?></td>
                            <td><?php echo $dados_tar['id_rua']; ?></td>
                            <td><?php echo $dados_tar['id_coluna']; ?></td>
                            <td><?php echo $dados_tar['id_altura']; ?></td>
                            <td style="width: 50px"><?php echo $dados_tar['nr_qtde']; ?></td>
                            <td id="contA" class="contA" data-toggle="tooltip" data-placement="top" title="Digite a primeira contagem e clique em confirmar" style="width: 100px"><?php echo $dados_tar['cont_1']; ?>
                            </td>
                            <td id="contB" class="contB" data-toggle="tooltip" data-placement="top" title="Digite a segunda contagem e clique em confirmar" style="width: 100px"><?php echo $dados_tar['cont_2']; ?>
                            </td>
                            <td id="contC" class="contC" data-toggle="tooltip" data-placement="top" title="Digite a terceira contagem e clique em confirmar" style="width: 100px"><?php echo $dados_tar['cont_3']; ?>
                            </td>
                        </tr>
                        <?php }?>          
                    </tbody>                
                            </table>
                        </div>
                    </div>
                </div>
            </article>           
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" id="btnAtualiza" class="btn btn-default" data-dismiss="modal">
                        Fechar
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div> <!--Fim Modal-->
<script type="text/javascript">
    $(document).ready(function(){
        $('#dtlTarDia').modal('show');
    });
</script>