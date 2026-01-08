<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();
$nserie = $_POST['nserie'];

$sql_nserie = "select t1.*, t2.cod_produto, t2.nm_produto, t2.cod_prod_cliente, t2.detalhe_produto from tb_nserie t1 left join tb_produto t2 on t1.id_produto = t2.cod_produto where (t2.cod_prod_cliente like '%$nserie%' or t2.nm_produto like '%$nserie%' or t1.n_serie like '%$nserie%')";

$res_serie = mysqli_query($link,$sql_nserie); 
$tr = mysqli_num_rows($res_serie);
$link->close();
?>
<section class="panel col-lg-12">
    <?php
    if($tr>0){
    ?>
    <legend>Produtos</legend>
    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
        <thead>
            <tr>
                <th style="text-align: left"> Código SAP</th>
                <th> Descrição </th>
                <th> Número de série </th>
                <th> Situação </th>
                <th> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php                                                      
                while($dados = mysqli_fetch_array($res_serie)) {?>
            <tr class="odd gradeX">
                <td style="text-align: left; widt"> <?php echo $dados['cod_prod_cliente']; ?> </td>
                    <td style="width: auto; height: auto"> <?php echo $dados['nm_produto']; ?> </td>
                    <td style="width: 130px"> <?php echo $dados['n_serie']; ?> </td>
                    <td> <?php 
                                if($dados['fl_status'] == 'A'){
                                    echo 'Alocado';
                                }elseif ($dados['fl_status'] == 'E') {
                                    echo 'Expedido';
                                }elseif ($dados['fl_status'] == 'R') {
                                    echo 'Reservado';
                                }else {
                                    echo 'Alocação Pendente';
                                }?> 
                    </td>
                    <td style="text-align: center; width: 10px"> 
                            <button type="submit" id="btnHistNs" value="<?php echo $dados['id']; ?>" class="btn btn-default btn-xs">Histórico</button>
                    </td>
            </tr>
            <?php } ?> 
        </tbody>
    </table>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>
</section>