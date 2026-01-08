<?php 
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.id, t1.nr_docto,  t2.cod_estoque, t5.nr_pedido, t7.nr_matricula, t7.cod_depto, upper(t7.ds_nome) as ds_nome, t1.dt_docto, DATEDIFF(date(t1.dt_docto), date(now())) as qtd_dias, CASE t1.fl_tipo when 'C' THEN 'CA' when 'L' then 'LAUDO' END as tipo, t2.produto, t3.nm_produto,t2.ds_galpao, t4.nome, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, round(t2.nr_qtde,0) as nr_qtde, coalesce(t2.fl_bloq,'N') as fl_bloq, t5.cod_col, date_format(t6.dt_pedido,'%d/%m/%Y') as dt_pedido, t5.cod_estoque
from tb_ca t1
left join tb_posicao_pallet t2 on t1.id = (CASE t1.fl_tipo WHEN 'C' then t2.cod_ca when 'L' THEN t2.cod_laudo END) and coalesce(t2.fl_bloq,'N') = 'N'
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_armazem t4 on t2.ds_galpao = t4.id
left join tb_coleta_pedido t5 on t2.cod_estoque = t5.cod_estoque
left join tb_pedido_coleta t6 on t5.nr_pedido = t6.nr_pedido
left join tb_funcionario t7 on t6.cod_almox = t7.nr_matricula
where DATEDIFF(date(t1.dt_docto), date(now())) <= '30'
group by t1.nr_docto, t2.cod_estoque, t7.nr_matricula
order by t1.nr_docto, t2.cod_estoque";
$res = mysqli_query($link, $sql);

?>
<br><br><br>
<header>
  <div style="float: center">
      <h3 style="color: #FF8C00"><strong>ALERTA DE VENCIMENTOS</strong></h3>
  </div>
</header>
<div class="col-sm-12 text-align-right">
  <div class="btn-group">
    <button type="submit" class="btn btn-success" id="RepCaAlertEmitExcel" style="float:right;width: 100px">Excel</button>
</div>
</div>
<table id="TbConsCaAlert" class="table" width="100%">

    <?php  while ($dados = mysqli_fetch_assoc($res)) { ?>

        <tr>
            <th colspan="6">Tipo: <?php echo $dados['tipo'];?></th>
        </tr>
        <tr>
            <td>Documento:</td>
            <td><?php echo $dados['nr_docto'];?></td>
            <td>Vencimento:</td>
            <td><?php echo $dados['dt_docto'];?></td>
            <td>Dias até venc.:</td>
            <td><?php echo $dados['qtd_dias'];?></td>
        </tr>
        <tr>
            <td>Produto:</td>
            <td><?php echo $dados['produto'].' - '.$dados['nm_produto'];?></td>
            <td>Quantidade:</td>
            <td><?php echo $dados['nr_qtde'];?></td>
        </tr>
        <tr>
            <td>Local:</td>
            <td><?php echo $dados['cod_estoque'].' - '.$dados['nome'].' - '.$dados['ds_prateleira'].' - '.$dados['ds_coluna'].' - '.$dados['ds_altura'];?></td>
        </tr>
        <tr>
            <th colspan="6">Funcionário:</th>
        </tr>
        <tr>
            <td>Matrícula:</td>
            <td><?php echo $dados['nr_matricula'];?></td>
            <td>C.R.:</td>
            <td><?php echo $dados['cod_depto'];?></td>
            <td>Nome:</td>
            <td><?php echo $dados['ds_nome'];?></td>
        </tr>
        <tr>
            <td>Pedido WMS:</td>
            <td><?php echo $dados['nr_pedido'];?></td>
            <td>Data:</td>
            <td><?php echo $dados['dt_pedido'];?></td>
        </tr>
    <?php } 
    $link->close();?>
</table>