<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$consProdutoNc = $_POST['consProdutoNc'];

if($consProdutoNc == ""){

    $sql = "select t2.cod_prod_cliente, t2.nm_produto, t1.cod_estoque, t3.ds_apelido, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde
    from tb_posicao_pallet t1
    left join tb_produto t2 on t1.produto = t2.cod_produto
    left join tb_armazem t3 on t1.ds_galpao = t3.id
    where t1.fl_status = 'Z'";
        
    $query = mysqli_query($link,$sql);
    $produto = mysqli_num_rows($query);

}else{

    $sql_prod="select cod_produto from tb_produto where cod_prod_cliente = '$consProdutoNc' and fl_status <> 'E'";
    $query_prod = mysqli_query($link,$sql_prod);
    while ($prod=mysqli_fetch_assoc($query_prod)) {
        $cod_produto = $prod['cod_produto'];
    }

    $sql = "select t2.cod_prod_cliente, t2.nm_produto, t1.cod_estoque, t3.ds_apelido, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde
    from tb_posicao_pallet t1
    left join tb_produto t2 on t1.produto = t2.cod_produto
    left join tb_armazem t3 on t1.ds_galpao = t3.id
    where t1.produto = '$cod_produto' and t1.fl_status = 'Z'";
        
    $query = mysqli_query($link,$sql);
    $produto = mysqli_num_rows($query);

}

$link->close();
?>
<section class="panel col-lg-12" id="tbProdutoNc">
    <?php
    if($produto>0){
    ?>
    <legend>Produtos não-conforme</legend>
    <table class="table table-bordered table-hover table-checkable order-column" id="tbConfPed" style="width: 600px">
        <thead>
            <tr>
                <th> Código</th>
                <th> Descrição </th>
                <th> Local </th>
                <th> Quantidade </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($query)){
                ?>
                <tr class="status" data-status="<?php echo $linha['fl_status'];?>">
                    <td style="width: 30px"> <?php echo $linha['cod_prod_cliente'];?> </td>
                    <td style="width: 30px"> <?php echo $linha['nm_produto'];?> </td>
                    <td> <?php echo $linha['ds_apelido'].$linha['ds_prateleira'].$linha['ds_coluna'].$linha['ds_altura'];?> </td>
                    <td> <?php echo $linha['nr_qtde'];?> </td>
                </tr> 
                <?php }?>
            </tbody>
        </table>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>
</section>