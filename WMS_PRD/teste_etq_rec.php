<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$id_oper 	= $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = 1;//$_POST['cod_rec'];

$query_qtde="select t1.cod_recebimento, t3.produto, t3.nr_qtde, t3.cod_nf_entrada_item
from tb_recebimento t1
left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t2.cod_nf_entrada = '1'";
$qtde = mysqli_query($link,$query_qtde);
while ($dados=mysqli_fetch_assoc($qtde)) {

	/*$ins_etq="insert into tb_etiqueta (nr_docto, fl_status, cod_etq, usr_create, dt_create) values ('$cod_rec', 'A', '$cod_etq', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);
	$nEtq = mysqli_insert_id($link);*/
	for ($i = 1; $i < $dados['nr_qtde']; $i++) {
	$cod_etq =  uniqid();

		echo 'Cod.Etiq.: '.$cod_etq.' Cod.Rec: '.$cod_rec.' Produto: '.$dados['produto'].' Cod.Item: '.$dados['cod_nf_entrada_item'].' Seq: '.$i.'<br>';
	}
}


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
									<a href="data/armazem/relatorios/list_etq_end.php?galpao=<?php echo $dados['galpao']; ?>&rua=<?php echo $dados['rua']; ?>&coluna=<?php echo $dados['coluna']; ?>&altura=<?php echo $dados['altura']; ?>&id=<?php echo $dados['id']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Imprimir</button></a>
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