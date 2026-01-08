<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nrPedido 	= $_POST['nrPedido'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.nr_pedido, t2.nm_cliente, t2.ds_endereco, t2.ds_bairro, t2.ds_cidade, t2.ds_uf, t3.nm_produto, t3.cod_prod_cliente, t3.cod_produto, sum(t4.nr_qtde_col) as volume 
from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente 
left join tb_coleta_pedido t4 on t1.nr_pedido = t4.nr_pedido 
left join tb_produto t3 on t4.produto = t3.cod_produto 
where t1.fl_status = 'X' and t1.nr_pedido = '$nrPedido'
group by t4.produto";
$qtde = mysqli_query($link,$query_qtde);

$link->close();
?>
<div id="content">
	<section>
		<a href="data/movimento/relatorio/list_etq_exp_all.php?pedido=<?php echo $nrPedido; ?>" target="_blank"><button type="button" id="btnListEtqExpAll" class="btn btn-primary" value="">Imprimir todas</button></a>
	</section><br><br>
	<section id="widget-grid" class="">
		<div>
			<div class="widget-body no-padding">
				<div id="retorno"></div>                                                        
				<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
					<thead>
						<tr>
							<th> Pedido</th>
							<th> Destinatário </th>
							<th> Endereço </th>
							<th> Bairro </th>
							<th> Cidade </th>
							<th> UF </th>
							<th> Produto </th>
							<th> Cod. SAP </th>
							<th> Volumes </th>
							<th> Ações </th>
							<th> Etiqueta </th>
						</tr>
					</thead>
					<tbody>
						<?php while($dados = mysqli_fetch_array($qtde)) {?>
							<tr class="odd gradeX">
								<td style="text-align: center; width: 10px"> 
									<?php echo $dados['nr_pedido']; ?> 
								</td>
								<td> 
									<?php echo $dados['nm_cliente']; ?> 
								</td>
								<td> 
									<?php echo $dados['ds_endereco']; ?> 
								</td>
								<td> 
									<?php echo $dados['ds_bairro']; ?> 
								</td>
								<td> 
									<?php echo $dados['ds_cidade']; ?> 
								</td>
								<td> 
									<?php echo $dados['ds_uf']; ?> 
								</td>
								<td> 
									<?php echo $dados['nm_produto']; ?> 
								</td>
								<td> 
									<?php echo $dados['cod_prod_cliente']; ?> 
								</td>
								<td> 
									<?php echo $dados['volume']; ?> 
								</td>
								<td style="text-align: center;width: 150px">  
									<a href="data/movimento/relatorio/print_etq_exp.php?pedido=<?php echo $dados['nr_pedido']; ?>&produto=<?php echo $dados['cod_produto']; ?>" target="_blank"><button type="submit" id="btnPrintEtqExpUni" class="btn btn-primary btn-xs" value="">Imprimir</button></a>
								</td>
								<td style="width: 100px;text-align: center">
									<svg id="barcode"
									class="barcode"
									jsbarcode-format="auto"
									jsbarcode-height="20"
									jsbarcode-displayValue="true"
									jsbarcode-value="<?php echo $dados['nr_pedido'].$dados['cod_produto'].$dados['cod_prod_cliente']; ?>"
									jsbarcode-textmargin="0"
									jsbarcode-fontoptions="bold">
								</svg>
							</td>
						</tr>
					<?php } ?> 
				</tbody>
			</table>                                                        
		</div>
	</div>
</section>
</div>
<script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
	JsBarcode(".barcode").init();
</script>