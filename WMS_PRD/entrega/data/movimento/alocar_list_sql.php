<?php 
  require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();
    $alocar = $_POST['alocar'];
    $codigo = $_POST['codigo'];

    if($codigo == ''){
        $SQL = "select t1.cod_estoque, t1.nr_nf_entrada, t1.ds_galpao, t1.nr_qtde, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto where t1.ds_galpao = 'recebimento' and nr_qtde > 0 and (nm_produto like '%$alocar%' or nr_nf_entrada like '%$alocar%') ";
    
       $res = mysqli_query($link,$SQL);
       $tr = mysqli_num_rows($res); 
   }else{
    $SQL = "select t1.cod_estoque, t1.nr_nf_entrada, t1.ds_galpao, t1.nr_qtde, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto where t1.ds_galpao = 'recebimento' and nr_qtde > 0 and cod_prod_cliente = '$codigo'";
    
   $res = mysqli_query($link,$SQL);
   $tr = mysqli_num_rows($res); 
   }

    
/*
$result_cat_post = "SELECT * FROM tb_grupo";
$resultado_cat_post = mysqli_query($link, $result_cat_post);
*/

?>
<section class="panel col-lg-12">
    <?php
    if($tr>0){
    ?>
    <legend>Produtos</legend>
    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
        <thead>
            <tr>
                <th> Alocar</th>
                <th> Galpão</th>
                <th> Código SAP </th>
                <th> Descrição </th>
                <th> O.R.  </th>
                <th> Saldo a alocar </th>
                <th> Sistêmica </th>
            </tr>
        </thead>
        <tbody>
            <?php                                                           
            while($dados = mysqli_fetch_array($res)) 
                {?>
            <tr class="odd gradeX">
                <td> 
                    <button type="submit" id="btnAlocMan" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_estoque']; ?>">Alocar</button>
                </td>
                <td style="text-align: left; width: 10%"> <?php echo $dados['ds_galpao']; ?> </td>
                <td style="text-align: right; width: 10%"> <?php echo $dados['cod_prod_cliente']; ?> </td>
                <td style="text-align: left; width: 55%"> <?php echo $dados['nm_produto']; ?> </td>
                <td style="text-align: right; width: 5%"> <?php echo $dados['nr_nf_entrada']; ?> </td>
                <td style="text-align: right; width: 10%"> <?php echo $dados['nr_qtde']; ?> </td>
                <td  style="text-align: center; width: 10px">  
                    <button type="submit" id="btnAlocAut" class="btn btn-success btn-xs" value="<?php echo $dados['cod_estoque']; ?>">Automática</button>
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