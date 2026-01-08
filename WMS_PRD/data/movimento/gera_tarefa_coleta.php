<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$ins_onda = "insert into tb_onda (dt_create, usr_create) values (now(), '$id')";
$res_onda = mysqli_query($link, $ins_onda);
$onda = mysqli_insert_id($link);

if ($onda != '') {

	$sql_coleta = "select distinct nr_pedido from tb_coleta_pedido where fl_status = 'M'";
	$res_coleta = mysqli_query($link1, $sql_coleta);

	while ($dados_coleta = mysqli_fetch_assoc($res_coleta)) {
		$nr_pedido = $dados_coleta['nr_pedido'];
		//$nr_qtde = $dados_coleta['nr_qtde'];
		//$produto = $dados_coleta['produto'];
		//$cod_estoque = $dados_coleta['cod_estoque'];
		//$ds_galpao = $dados_coleta['ds_galpao'];
		//$ds_prateleira = $dados_coleta['ds_prateleira'];
		//$ds_coluna = $dados_coleta['ds_coluna'];
		//$ds_altura = $dados_coleta['ds_altura'];

		$update = "update tb_coleta_pedido set nr_onda = '$onda', fl_status = 'R' where nr_pedido = '$nr_pedido'";
		$res_update = mysqli_query($link1, $update);
	}

}

$select_produto = "select t1.*, t2.dt_limite, t3.ds_doca, t3.fl_tipo, t4.nome
        from tb_coleta_pedido t1
        left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido
        left join tb_doca t3 on t2.id_doca = t3.id
        left join tb_armazem t4 on t1.ds_galpao = t4.id
        where t1.fl_status = 'M'
        group by t1.ds_prateleira, t1.ds_coluna, t1.ds_altura
        order by t2.dt_limite, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna";
$res_produto = mysqli_query($link2, $select_produto);

$link->close();
?>


    <?php
if (mysqli_affected_rows($link2) > 0) {

	?>
    <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <i class="icon-settings font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> Tarefas pendentes</span>

                </div>
                    <!--div class="actions">

                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                </div-->
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> Tarefa</th>
                            <th> Produto</th>
                            <th> Pedido </th>
                            <th> Dt Limite </th>
                            <th> Doca </th>
                            <th> Galpão </th>
                            <th> Rua </th>
                            <th> Coluna</th>
                            <th> Altura </th>
                            <th> Quantidade </th>
                            <th> Coletado </th>
                            <!--th> Quebra </th>
                            <th> Finalizar </th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
while ($linha = mysqli_fetch_assoc($res_produto)) {
		?>
                            <tr class="odd gradeX">
                                <td style="width: 30px"> <?php echo $linha['cod_ped']; ?> </td>
                                <td style="width: 30px"> <?php echo $linha['produto']; ?> </td>
                                <td style="width: 30px"><?php echo $linha['nr_pedido']; ?>  </td>
                                <td style="width: 100px"><?php echo date("d/m/Y", strtotime($linha['dt_limite'])); ?>  </td>
                                <td><?php echo $linha['ds_doca'] . "-" . $linha['fl_tipo']; ?> </td>
                                <td><?php echo $linha['nome']; ?> </td>
                                <td style="width: 100px"> <?php echo $linha['ds_prateleira']; ?> </td>
                                <td style="width: 100px"> <?php echo $linha['ds_coluna']; ?></td>
                                <td style="width: 100px"> <?php echo $linha['ds_altura']; ?></td>
                                <td style="width: 100px"> <?php echo $linha['nr_qtde']; ?></td>
                                <td style="width: 100px"></td>
                                <!--td style="text-align: center; width: 5px">
                                    <a href="http://localhost/Backup/210917/WMS/wms/html/includes/forms/movimentacao/xhr/inf_quebra.php?tar_col=<?php echo $linha['cod_ped']; ?>"><span class="glyphicon glyphicon-log-in" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Informa quebra"></span></a>
                                </td>
                                <td style="text-align: center; width: 5px">
                                    <a href="http://localhost/Backup/210917/WMS/wms/html/includes/forms/movimentacao/xhr/upd_tar_col.php?tar_col=<?php echo $linha['cod_ped']; ?>"><span class="glyphicon glyphicon-cog" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Finalizar coleta"></span></a>
                                </td-->
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>

    <?php } else {?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

    <?php }
?>
<script type="text/javascript">
    $('form.ajax').on('submit', function(){
        var that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};
        that.find('[name]').each(function(index, value){
            var that = $(this),
                name = that.attr('name'),
                value = that.val();
            data[name] = value;
        });
        $.ajax({
            url:url,
            type:type,
            data:data,
            success: function(response){
                console.log(response);
            }
        });
        return false;
    });
</script>