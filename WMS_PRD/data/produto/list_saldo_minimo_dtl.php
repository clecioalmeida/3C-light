<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$codigo     = $_POST['prd_cod'];
//$produtos   = $_POST['prd_desc'];

$sql = "select t1.produto, t5.nm_produto, count(t1.nr_pedido) as total_ped, round(avg(t1.nr_qtde),0) as media_exp, sum(t1.nr_qtde) as total_exp, round(COALESCE(t2.saldo_prd,0),0) as saldo_prd, COALESCE(t4.total_res,0) as total_res, COALESCE(t3.total_rec,0) as total_rec,  round(COALESCE(t2.saldo_prd,0)+COALESCE(t3.total_rec,0)-COALESCE(t4.total_res,0),0) as total_disp
from tb_pedido_conferencia t1
left join vw_saldo_produto t2 on t1.produto = t2.produto
left join vw_saldo_rec t3 on t1.produto = t3.produto
left join vw_saldo_ped t4 on t1.produto = t4.produto
left join tb_produto t5 on t1.produto = t5.cod_prod_cliente
where t1.dt_create >= (now())- interval 3 month and t1.produto = '$codigo'
group by t1.produto";
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

    </style>

    <div class="tableFixHead">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> PRODUTO</th>
                    <th> DESCRIÇÃO </th>
                    <th> PEDIDOS ATENDIDOS </th>
                    <th> MÉDIA POR PEDIDO </th>
                    <th> TOTAL ATENDIDO </th>
                    <th> SALDO ATUAL </th>
                    <th> TOTAL RESERVADO </th>
                    <th> TOTAL A RECEBER </th>
                    <th> DISP. PRÓXIMO PERÍODO </th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php                                                      
                while($dados = mysqli_fetch_array($res)) {?>
                    <tr class="odd gradeX">
                        <td style="text-align: right"> <?php echo $dados['produto']; ?> </td>
                        <td style="text-align: left"> <?php echo $dados['nm_produto']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['total_ped']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['media_exp']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['total_exp']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['saldo_prd']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['total_res']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['total_rec']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['total_disp']; ?> </td>
                        <td style="text-align: center; width: 5px">  
                            <button type="submit" id="btnRepPrd" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_produto']; ?>">REPOSIÇÃO</button>
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