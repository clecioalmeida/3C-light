<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.cod_estoque, t1.nr_alocado, t2.produto, t2.nr_or, t4.nm_produto, t2.nr_qtde
from tb_aloca t1
left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
left join tb_armazem t3 on t2.ds_galpao = t3.id
left join tb_produto t4 on t2.cod_produto = t4.cod_produto
where t1.fl_status = 'M'";
$res = mysqli_query($link,$SQL);
$tr = mysqli_num_rows($res); 

$link->close();
?>
    <?php
    if($tr>0){
        ?>
        <legend>Produtos</legend>
        <table class="table" id="sample_1">
            <thead>
                <tr>
                    <th> AÇÕES</th>
                    <th style="text-align: right"> CÓDIGO</th>
                    <th style="text-align: right"> PRODUTO </th>
                    <th> DESCRIÇÃO </th>
                    <th style="text-align: right"> QUANTIDADE </th>
                    <th style="text-align: right"> OR </th>
                    <th style="text-align: right"> SALDO ALOCADO</th>
                </tr>
            </thead>
            <tbody>
                <?php                                                           
                while($dados = mysqli_fetch_assoc($res)) 
                    {?>
                        <tr class="odd gradeX">
                            <td> 
                                <button type="submit" id="btnPrintAloc" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">IMPRIMIR</button>
                            </td>
                            <td style="text-align: right; width: 10%"> <?php echo $dados['id']; ?> </td>
                            <td style="text-align: right; width: 10%"> <?php echo $dados['produto']; ?> </td>
                            <td style="text-align: left; width: 55%"> <?php echo $dados['nm_produto']; ?> </td>
                            <td style="text-align: right; width: 10%"> <?php echo $dados['nr_qtde']; ?> </td>
                            <td style="text-align: right; width: 5%"> <?php echo $dados['nr_or']; ?> </td>
                            <td style="text-align: right; width: 10%"> <?php echo $dados['nr_alocado']; ?> </td>
                        </tr>   
                    <?php } ?> 
                </tbody>
            </table>
            <script type="text/javascript">
              $(document).ready(function() {
                $("#checkboxTodosAloc").click(function(){
                  $('input:checkbox').not(this).prop('checked', this.checked);
              });
            });
        </script>
    <?php }else{?>

        <h4>Nao foram encontradas alocações em andamento.</h4>

    <?php }
    ?>