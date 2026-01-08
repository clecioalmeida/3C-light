<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$codInsCod = $_POST['codInsCod'];
$codInsDesc = $_POST['codInsDesc'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

if($codInsCod != '' && $codInsDesc == ''){
    $SQL = "select t1.cod_prod_cliente, t1.cod_produto, t1.nm_produto, t1.tp_separacao, t1.cod_cli, t1.cod_grupo, t1.cod_sub_grupo, t1.codncm, t1.fl_lote, t1.ean, t1.peso, t1.peso_bruto, t1.curva, t1.nr_estoque_min, t1.volume, t1.unid, t1.unid_controle, t1.altura, t1.compr, t1.largura, t1.cod_identificacao, t1.multiplo, t1.detalhe_produto, t1.id_armazem, t1.aloc_aut, t2.cod_cliente, t2.nm_cliente, t3.cod_grupo, t3.nm_grupo, t4.cod_sub_grupo, t4.nm_sub_grupo, t5.id, t5.nome from tb_produto t1 left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente left join tb_grupo t3 on t1.cod_grupo = t3.cod_grupo left join tb_sub_grupo t4 on t1.cod_sub_grupo = t4.cod_sub_grupo left join tb_armazem t5 on t1.id_armazem = t5.id where t1.cod_prod_cliente = '$codInsCod' and t1.fl_tipo = 'I'";
    $res = mysqli_query($link,$SQL); 
    $tr_res = mysqli_num_rows($res);

}else{
    $SQL = "select t1.cod_prod_cliente, t1.cod_produto, t1.nm_produto, t1.tp_separacao, t1.cod_cli, t1.cod_grupo, t1.cod_sub_grupo, t1.codncm, t1.fl_lote, t1.ean, t1.peso, t1.peso_bruto, t1.curva, t1.nr_estoque_min, t1.volume, t1.unid, t1.unid_controle, t1.altura, t1.compr, t1.largura, t1.cod_identificacao, t1.multiplo, t1.detalhe_produto, t1.id_armazem, t1.aloc_aut, t2.cod_cliente, t2.nm_cliente, t3.cod_grupo, t3.nm_grupo, t4.cod_sub_grupo, t4.nm_sub_grupo, t5.id, t5.nome from tb_produto t1 left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente left join tb_grupo t3 on t1.cod_grupo = t3.cod_grupo left join tb_sub_grupo t4 on t1.cod_sub_grupo = t4.cod_sub_grupo left join tb_armazem t5 on t1.id_armazem = t5.id where (t1.nm_produto like '%$codInsDesc%') and t1.fl_tipo = 'I'";
    $res = mysqli_query($link,$SQL); 
    $tr_res = mysqli_num_rows($res);
}

$sql_local = "select * from tb_armazem";
$select_local = mysqli_query($link, $sql_local);

$sql_grupo = "select * from tb_grupo";
$select_grupo = mysqli_query($link, $sql_grupo);
$tr = mysqli_num_rows($select_grupo);

$sql_sub_grupo = "select * from tb_sub_grupo";
$select_sub_grupo = mysqli_query($link, $sql_sub_grupo);
$tr = mysqli_num_rows($select_sub_grupo);

$link->close();
?>
<section class="panel col-lg-12">
    <?php
    if($tr_res>0){
    ?>
    <legend>Produtos</legend>
    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
        <thead>
            <tr>
            <th > Ações </th>
                <th data-toggle="tooltip" data-placement="left" title="Código do cliente"> Cód. Cliente</th>
                <th> Cód. WMS</th>
                <th> Produto </th>
                <th> Cliente </th>
                <th> Grupo </th>
                <th> Sub-grupo </th>
            </tr>
        </thead>
        <tbody>
            <?php                                                      
                while($dados = mysqli_fetch_array($res)) {?>
            <tr class="odd gradeX">
                <!--td style="text-align: center; width: 5px">  
                    <button type="submit" id="btnDtlProduto" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_produto']; ?>">Detalhe</button>
                </td-->
                <td style="text-align: center; width: 5px">
                    <button type="submit" id="btnUpdProduto" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_produto']; ?>">Alterar</button>
                </td>
                <td style="text-align: center; width: 10px"> <?php echo $dados['cod_prod_cliente']; ?> </td>
                <td> <?php echo $dados['cod_produto']; ?> </td>
                <td> <?php echo $dados['nm_produto']; ?> </td>
                <td> <?php echo $dados['nm_cliente']; ?> </td>
                <td> <?php echo $dados['nm_grupo']; ?> </td>
                <td> <?php echo $dados['nm_sub_grupo']; ?> </td>
            </tr>
            <?php } ?> 
        </tbody>
    </table>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>
</section>
<div id="retornoInsert"></div>