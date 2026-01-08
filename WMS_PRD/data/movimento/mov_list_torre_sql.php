<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$selRuaTorre = $_POST['selRuaTorre'];
$selModTorre = $_POST['selModTorre'];
$selFeixe = $_POST['selFeixe'];

if ($selRuaTorre != '' && $selFeixe == '') {

	$sql_mov = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.ds_apelido from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto left join tb_armazem t3 on t1.ds_galpao = t3.id where t1.ds_prateleira = '$selRuaTorre' and t1.ds_galpao = 17 and ds_coluna = '$selModTorre' and t1.nr_qtde > 0 order by t1.produto asc";
	$mov = mysqli_query($link, $sql_mov);
	$tr = mysqli_num_rows($mov);

} else {

	$sql_mov = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.ds_apelido from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto left join tb_armazem t3 on t1.ds_galpao = t3.id where t1.ds_prateleira = '$selRuaTorre' and ds_coluna = '$selModTorre' and t1.ds_embalagem = '$selFeixe' and t1.ds_galpao = 17 and t1.nr_qtde > 0 order by t1.produto asc";
	$mov = mysqli_query($link, $sql_mov);
	$tr = mysqli_num_rows($mov);
}
$link->close();
?>
<?php
if ($tr > 0) {
	?>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                <div>
                    <div class="jarviswidget-editbox"></div>
                    <div class="widget-body no-padding">
                        <table id="dt_basic" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th> Código WMS</th>
                                    <th> Descrição </th>
                                    <th> Galpão  </th>
                                    <th> Rua  </th>
                                    <th> Coluna </th>
                                    <th> Altura</th>
                                    <th> Embalagem</th>
                                    <th> Qtde</th>
                                    <th> # </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
while ($linha = mysqli_fetch_assoc($mov)) {
		$rua = $linha['ds_prateleira'];
		?>
                                <tr>
                                    <td style="width: 100px"> <?php echo $linha['produto']; ?> </td>
                                    <td> <?php echo $linha['nm_produto']; ?> </td>
                                    <td> <?php echo $linha['ds_apelido']; ?> </td>
                                    <td> <?php echo $linha['ds_prateleira']; ?> </td>
                                    <td> <?php echo $linha['ds_coluna']; ?> </td>
                                    <td> <?php echo $linha['ds_altura']; ?> </td>
                                    <td> <?php echo $linha['ds_embalagem']; ?> </td>
                                    <td style="text-align: right"> <?php echo $linha['nr_qtde']; ?> </td>
                                    <td style="text-align: center; width: 5px">
                                        <form method="post" id="formMovDest" action="">
                                            <input type="hidden" name="nr_qtde" id="nr_qtde" value="<?php echo $linha['nr_qtde']; ?>">
                                            <button type="submit" id="btnMovTorreDestino" value="<?php echo $linha['cod_estoque']; ?>" class="btn btn-success btn-xs">Movimentar</button>
                                        </form>
                                    </td>
                                <?php }?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </article>
        <div id="retMovimenta"></div>
        <div id="retMovConf"></div>
    </div>
</section>
<?php } else {?>

<h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php }
?>
<script type="text/javascript">
    $('.mask').mask("#.##0,00", {reverse: true});
</script>