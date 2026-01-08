<?php
//Incluir a conexão com banco de dados
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$projeto = $_POST['projeto'];
//$situacao = $_POST['situacao'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

    $sql_local = "select t1.id, t1.nome, t2.cod_estoque, t2.ds_galpao, t2.produto, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.nr_qtde, t2.ds_avaliacao, t2.ds_projeto, t3.cod_prod_cliente, t3.nm_produto, t4.nm_avaliacao 
    from tb_armazem t1
    left join tb_posicao_pallet t2 on t1.id = t2.ds_galpao
    left join tb_produto t3 on t2.produto = t3.cod_produto
    left join tb_avaliacao t4 on t2.ds_avaliacao = t4.id
    where t2.ds_projeto = '$projeto'";
    $res_local = mysqli_query($link,$sql_local);
    $tr_local = mysqli_num_rows($res_local);

$link->close();
?>
<section class="panel col-lg-12">
    <?php
    if($tr_local>0){
    ?>
    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1" style="width: 100%">
                <thead>
                    <tr>
                        <th style="text-align: center;"> # </th>
                        <th> Armazém </th>
                        <th> Rua/Módulo </th>
                        <th> Coluna/Box </th>
                        <th> Altura </th>
                        <th> Cód. SAP</th>
                        <th> Produto </th>
                        <th> Quantidade </th>
                        <th> Avaliação </th>
                        <th> Projeto </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($dados_local = mysqli_fetch_assoc($res_local)) {
                    ?>
                    <tr class="odd gradeX">
                        <td style="text-align: center; width: auto">
                            <button type="submit" id="btnUpdProject" class="btn btn-primary btn-xs" value="<?php echo $dados_local['cod_estoque']; ?>">Alterar projeto</button>
                            <button type="submit" id="btnDelProject" class="btn btn-danger btn-xs" value="<?php echo $dados_local['cod_estoque']; ?>">Excluir projeto</button>
                        </td>
                        <td style="text-align: center; width: auto; line-height: auto;"><?php echo $dados_local['nome']; ?> </td>
                        <td style="text-align: center; width: 5px;"><?php echo $dados_local['ds_prateleira']; ?> </td>
                        <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_coluna']; ?> </td>
                        <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_altura']; ?> </td>
                        <td style="text-align: left; width: 100px"> <?php echo $dados_local['cod_prod_cliente']; ?></td>
                        <td style="text-align: left; width: auto"> <?php echo $dados_local['nm_produto']; ?></td>
                        <td style="text-align: left; width: auto"> <?php echo $dados_local['nr_qtde']; ?></td>
                        <td style="text-align: left; width: auto"> <?php echo $dados_local['nm_avaliacao']; ?></td>
                        <td style="text-align: left; width: auto"> <?php echo $dados_local['ds_projeto']; ?></td>
                    </tr>
                    <?php } ?> 
                </tbody>
            </table>
            <div id="retornoLocais"></div>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>
</section>