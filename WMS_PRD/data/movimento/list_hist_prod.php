<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

//$histProdWms = $_POST['histProdWms'];
$histProd = $_POST['histProd'];
//$dtInitHistProd = $_POST['dtInitHistProd'];
//$dtFinHistProd = $_POST['dtFinHistProd'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_prod="select cod_produto from tb_produto where cod_prod_cliente = '$histProd' and fl_status <> 'E' and fl_empresa = '$cod_cli' group by cod_prod_cliente";
$query_prod = mysqli_query($link,$sql_prod);
$prod=mysqli_fetch_assoc($query_prod);
$histProdWms = $prod['cod_produto'];

/*if($histProdWms == ''){

    $sql_prod="select cod_produto from tb_produto where cod_prod_cliente = '$histProd' and fl_status <> 'E'";
    $query_prod = mysqli_query($link,$sql_prod);
    while ($prod=mysqli_fetch_assoc($query_prod)) {
        $cod_produto = $prod['cod_produto'];
    }

    $sql = "select t1.nr_pedido as codigo, t1.produto, coalesce(t2.fl_tipo,'P') as tipo, t3.dt_pedido as data, t1.nr_qtde_col as qtde,
    t4.cod_prod_cliente as cod_cliente, t5.ds_apelido, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura
    from tb_coleta_pedido t1
    left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
    left join tb_pedido_coleta t3 on t1.nr_pedido = t3.nr_pedido
    left join tb_produto t4 on t1.produto = t4.cod_produto
    left join tb_armazem t5 on t1.ds_galpao = t5.id
    where t1.produto = '$cod_produto' and t1.fl_status <> 'E'
    union
    select t1.cod_recebimento as codigo, coalesce(t1.fl_tipo,'R') as tipo, t3.dt_rec as data, t3.produto, t3.nr_volume as qtde,
    t4.cod_prod_cliente as cod_cliente, t6.ds_apelido, t5.ds_prateleira, t5.ds_coluna, t5.ds_altura
    from tb_recebimento t1
    inner join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
    inner join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
    inner join tb_produto t4 on t3.produto = t4.cod_prod_cliente
    inner join tb_posicao_pallet t5 on t5.nr_or = t1.cod_recebimento
    inner join tb_armazem t6 on t5.ds_galpao = t6.id
    where t3.produto = '$histProdWms' and t5.nr_qtde > 0";

    $query = mysqli_query($link,$sql);
    $coleta = mysqli_num_rows($query);

}else{*/

    $sum_inv = "select round(sum(t4.cont_1),0) as nr_qtde_conf
    from tb_log_tarefa t1
    left join tb_inv_conf t4 on t1.id_tar = t4.id_tar
    left join tb_posicao_pallet t3 on t1.cod_estoque = t3.cod_estoque
    where t3.produto = '$histProd' and t3.fl_empresa = '$cod_cli'";
    $query_sum_inv = mysqli_query($link,$sum_inv);
    $dados_inv = mysqli_fetch_assoc($query_sum_inv);
    $total_inv = $dados_inv['nr_qtde_conf'];

    $sum_rec = "select coalesce(sum(t1.nr_qtde),0) as total_rec 
    from tb_nf_entrada_item t1
    left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
    where t1.produto = '$histProd' and t3.fl_status = 'F' and t3.fl_empresa = '$cod_cli'";
    $query_sum_rec = mysqli_query($link,$sum_rec);
    $dados_rec=mysqli_fetch_assoc($query_sum_rec);
    $total_rec=$dados_rec['total_rec'];

    $sum_ped = "select round(coalesce(sum(t1.nr_qtde),0),0) as total_ped
    from tb_pedido_coleta_produto t1
    where t1.produto = '$histProd' and t1.fl_status <> 'E' and t1.fl_empresa = '$cod_cli'";
    $query_sum_ped = mysqli_query($link,$sum_ped);
    $dados_ped=mysqli_fetch_assoc($query_sum_ped);
    $total_ped=$dados_ped['total_ped'];

    $sql_inv = "select t1.id_tar, t3.cod_estoque, t3.produto, round(t4.cont_1,0) as nr_qtde_conf, t3.ds_prateleira, t3.ds_coluna, t3.ds_altura, date_format(t1.dt_create,'%d/%m/%Y') as dt_create
from tb_log_tarefa t1
left join tb_inv_conf t4 on t1.id_tar = t4.id_tar
left join tb_posicao_pallet t3 on t1.cod_estoque = t3.cod_estoque
    where t3.produto = '$histProd' and t3.fl_empresa = '$cod_cli'
    group by t3.cod_estoque";
    $query_inv = mysqli_query($link,$sql_inv);
    $inventario = mysqli_num_rows($query_inv);

    $sql_rec = "select t1.cod_recebimento as codigo, coalesce(t1.fl_tipo,'R') as tipo, t3.dt_rec as data, t3.produto, sum(t3.nr_qtde) as qtde
    from tb_recebimento t1
    inner join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
    inner join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
    inner join tb_produto t4 on t3.produto = t4.cod_prod_cliente
    where t3.produto = '$histProd' and t1.fl_status = 'F' and t1.fl_empresa = '$cod_cli'
    group by t1.cod_recebimento";
    $query_rec = mysqli_query($link,$sql_rec);
    $recebimento = mysqli_num_rows($query_rec);

    $sql_ped = "select t1.nr_pedido as pedido, date(t1.dt_create) as data, t5.ds_apelido, sum(t1.nr_qtde) as qtde, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura
    from tb_pedido_conferencia t1
    left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
    left join tb_coleta_pedido t3 on t1.cod_col = t3.cod_col
    left join tb_armazem t5 on t3.ds_galpao = t5.id
    where t1.produto = '$histProd' and t2.fl_empresa = '5' and t2.fl_status = 'F' and t2.fl_status <> 'E'
    group by t1.produto, t1.nr_pedido";
    $query_ped = mysqli_query($link,$sql_ped);
    $pedido = mysqli_num_rows($query_ped);
//}
    $link->close();

    ?>
    <div class="row" style="margin-left: 10px">
        <section class="col-lg-3">
            <p>Total Recebido: <?php echo $total_rec;?></p>
        </section>
        <section class="col-lg-4">
            <p>Total em pedidos: <?php echo $total_ped;?></p>
        </section>
        <section class="col-lg-3">
            <p>Total de entradas por inventário: <?php echo $total_inv;?></p>
        </section>
    </div>
    <div class="row" style="margin-left: 20px">
        <section class="col-sm-3" id="tbColeta">
            <?php
            if($recebimento>0){
                ?>
                <legend>RECEBIMENTOS</legend>
                <table class="display responsive nowrap" id="tbConfPed" style="width: 300px">
                    <thead>
                        <tr>
                            <th style="text-align: right;"> Recebimento </th>
                            <th> Data </th>
                            <!--th> Endereço </th-->
                            <th> Quantidade </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($linha = mysqli_fetch_assoc($query_rec)){
                            ?>
                            <tr>
                                <td> <?php echo $linha['codigo'];?> </td>
                                <td> <?php echo date ("d/m/Y", strtotime($linha['data']));?> </td>
                                <!--td> <?php echo $linha['ds_apelido']." - ".$linha['ds_prateleira']." - ".$linha['ds_coluna']." - ".$linha['ds_altura'];?> </td-->
                                <td style="width: 100px;text-align: right;"> <?php echo $linha['qtde'];?> </td>
                            </tr> 
                        <?php }?>
                    </tbody>
                </table>
            <?php }else{?>

                <h4>Não foram encontrados recebimentos com esses parâmetros.</h4>

            <?php }
            ?>
        </section>
        <section class="col-sm-4">
            <?php
            if($pedido>0){
                ?>
                <legend>PEDIDOS</legend>
                <table class="display responsive nowrap" id="tbConfPed" style="width: 500px">
                    <thead>
                        <tr>
                            <th> Pedido </th>
                            <th> Data </th>
                            <th> Endereço </th>
                            <th> Qtd pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($linha = mysqli_fetch_assoc($query_ped)){
                            ?>
                            <tr>
                                <td style="text-align: right;"> <?php echo $linha['pedido'];?> </td>
                                <td> <?php echo date ("d/m/Y", strtotime($linha['data']));?> </td>
                                <td> <?php echo $linha['ds_apelido'].$linha['ds_prateleira'].$linha['ds_coluna'].$linha['ds_altura'];?> </td>
                                <td style="width: 100px;text-align: right;"> <?php echo $linha['qtde'];?> </td>
                            </tr> 
                        <?php }?>
                    </tbody>
                </table>
            <?php }else{?>

                <h4>Não foram encontradaos pedidos com esses parâmetros.</h4>

            <?php }
            ?>
        </section>
        <section class="col-sm-4">
            <?php
            if($inventario>0){
                ?>
                <legend>INVENTÁRIO</legend>
                <table class="display responsive nowrap" id="tbConfPed" style="width: 500px">
                    <thead>
                        <tr>
                            <th> Tarefa </th>
                            <th> Data </th>
                            <th> Endereço </th>
                            <th> Quantidade </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($linha = mysqli_fetch_assoc($query_inv)){
                            ?>
                            <tr>
                                <td style="text-align: right;"> <?php echo $linha['id_tar'];?> </td>
                                <td> <?php echo $linha['dt_create'];?> </td>
                                <td> <?php echo $linha['ds_prateleira']."-".$linha['ds_coluna']."-".$linha['ds_altura'];?> </td>
                                <td style="width: 100px;text-align: right;"> <?php echo $linha['nr_qtde_conf'];?> </td>
                            </tr> 
                        <?php }?>
                    </tbody>
                </table>
            <?php }else{?>

                <h4>Não foram encontradas tarefas com esses parâmetros.</h4>

            <?php }
            ?>
        </section>

    </div>

    	<script type="text/javascript">
		$(document).ready(function() {
			$("#tbConfPed").dataTable({
				"aLengthMenu": [5000]
			});
		});
	</script>