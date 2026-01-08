<?php 
  require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $big_select="set sql_big_selects=1";
    $res_select = mysqli_query($link,$big_select);

    $cod_prod_cliente = mysqli_real_escape_string($link, $_POST["cod_prod_cliente"]);
    $nm_produto = mysqli_real_escape_string($link, $_POST["nm_produto"]);
    $nr_pedido = mysqli_real_escape_string($link, $_POST["nr_pedido"]);

    if($cod_prod_cliente == '' and $nm_produto == ''){

        echo "<script> alert('Digite pelo menos uma das informações')</script>";

    }elseif ($cod_prod_cliente == '' and $nm_produto != ''){

        $sel_prod="select t1.cod_produto, t1.nm_produto, sum(t2.nr_qtde) as saldo, sum(t3.nr_qtde) as reservado
        from tb_produto t1
        left join tb_posicao_pallet t2 on t1.cod_produto = t2.produto
        left join tb_pedido_coleta_produto t3 on t1.cod_produto = t3.produto
        where t1.nm_produto like '%$nm_produto%' and t2.nr_qtde > 0 and t3.fl_status <> 'F'and t3.fl_status <> 'X'and t3.fl_status <> 'L' and t2.ds_projeto is null and t2.ds_avaliacao is null
        group by t1.cod_produto";
        $res = mysqli_query($link,$sel_prod); 

    }elseif ($cod_prod_cliente != '' and $nm_produto == ''){

        $sel_prod="select t1.cod_produto, t1.nm_produto, sum(t2.nr_qtde) as saldo, sum(t3.nr_qtde) as reservado
        from tb_produto t1
        left join tb_posicao_pallet t2 on t1.cod_produto = t2.produto
        left join tb_pedido_coleta_produto t3 on t1.cod_produto = t3.produto
        where t1.cod_prod_cliente = '$cod_prod_cliente' and t3.fl_status <> 'F'and t3.fl_status <> 'X'and t3.fl_status <> 'L' and t2.ds_projeto is null and t2.ds_avaliacao is null
        group by t1.cod_produto";
        $res = mysqli_query($link,$sel_prod); 

    }

$link->close();
?>

<fieldset>
    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
        <thead>
            <tr>
                <th> Código SAP</th>
                <th> Descrição </th>
                <th> Quantidade </th>
                <th> Reservado </th>
                <th> Saldo </th>
                <th> Nova reserva  </th>
                <th> #  </th>
            </tr>
        </thead>
        <tbody><?php
            while($dados = mysqli_fetch_array($res)) {?>
            <tr class="odd gradeX">
                <td> 
                    <?php echo $dados['cod_produto']; ?> 
                    <input type="hidden" name="cod_produto" id="cod_produto" value="<?php echo $dados['cod_produto']; ?>">
                </td>
                <td> <?php echo $dados['nm_produto']; ?> </td>
                <td style="text-align: right;"> <?php echo number_format($dados['saldo'], 0, ',', '.'); ?> </td>
                <td style="text-align: right;"> <?php echo $dados['reservado']; ?> </td>
                <td style="text-align: right;"> <?php echo $dados['saldo']-$dados['reservado']; ?> </td>
                <td><input type="text" id="nr_qtde_pedido" name="nr_qtde_pedido"></td>
                <td style="text-align: center; width: 5px">
                    <input type="hidden" name="nr_pedido" id="nr_pedido" value="<?php echo $nr_pedido;?>">  
                    <button type="submit" id="btnInsertPrdPedido" class="btn btn-primary btn-xs" value="">Inserir</button>
                </td>
            </tr>
            <?php } ?> 
        </tbody>
    </table>
</fieldset>
