<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$local_inicio 	= $_POST['local_inicio'];
$rua_inicio 	= $_POST['rua_inicio'];
$coluna_inicio 	= $_POST['coluna_inicio'];
$altura_inicio 	= $_POST['altura_inicio'];
$local_fim 		= $_POST['local_fim'];
$rua_fim 		= $_POST['rua_fim'];
$coluna_fim 	= $_POST['coluna_fim'];
$altura_fim 	= $_POST['altura_fim'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.id, t1.galpao, t2.ds_apelido, t2.nome, t1.rua, t1.coluna, t1.altura, t1.peso, t1.fl_bloq, t1.fl_status 
from tb_endereco t1 
left join tb_armazem t2 on t1.galpao = t2.id
where t1.galpao BETWEEN '$local_inicio' and '$local_fim' and t1.rua BETWEEN '$rua_inicio' and '$rua_fim' and t1.coluna BETWEEN '$coluna_inicio' and '$coluna_fim' and t1.altura BETWEEN '$altura_inicio' and '$altura_fim'";
$qtde = mysqli_query($link,$query_qtde);

$link->close();
?>
<div id="content">
	<section id="widget-grid" class="">
		<div>
			<div class="widget-body no-padding">
				<div id="retorno"></div>                                                        
				<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
					<thead>
						<tr>
							<th> Código</th>
							<th> Galpão </th>
							<th> Rua </th>
							<th> Coluna </th>
							<th> Altura </th>
							<th> Tipo </th>
							<th> Peso limite </th>
							<th> Cubagem limite </th>
							<th> Bloqueado </th>
							<th> Situação </th>
							<th> Ações </th>
							<th> Etiqueta </th>
						</tr>
					</thead>
					<tbody>
						<?php while($dados = mysqli_fetch_array($qtde)) {?>
							<tr class="odd gradeX">
								<td style="text-align: center; width: 10px"> 
									<?php echo $dados['id']; ?> 
								</td>
								<td> 
									<?php echo $dados['nome']; ?> 
								</td>
								<td> 
									<?php echo $dados['rua']; ?> 
								</td>
								<td> 
									<?php echo $dados['coluna']; ?> 
								</td>
								<td> 
									<?php echo $dados['altura']; ?> 
								</td>
								<td> 

								</td>
								<td> 
									<?php echo $dados['peso']; ?> 
								</td>
								<td> 

								</td>
								<td> 
									<?php echo $dados['fl_bloq']; ?> 
								</td>
								<td> 
									<?php
									if ($dados['fl_status'] == 'A'){
										echo 'Ativo';
									}else{
										echo 'Inativo';
									}
									?>  
								</td>
								<td style="text-align: center;width: 150px">  
									<a href="data/armazem/relatorios/list_etq_end.php?galpao=<?php echo $dados['galpao']; ?>&rua=<?php echo $dados['rua']; ?>&coluna=<?php echo $dados['coluna']; ?>&altura=<?php echo $dados['altura']; ?>&id=<?php echo $dados['id']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="" disabled>Imprimir</button></a>
								</td>
								<td style="width: 100px;text-align: center">
									<svg id="barcode"
									class="barcode"
									jsbarcode-format="auto"
									jsbarcode-height="20"
									jsbarcode-displayValue="true"
									jsbarcode-value="<?php echo $dados['ds_apelido'].$dados['rua'].$dados['altura'].$dados['coluna']; ?>"
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