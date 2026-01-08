<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$conGalpao = $_REQUEST['conGalpao'];
$conRua = $_REQUEST['conRua'];
$conColuna = $_REQUEST['conColuna'];
$conAltura = $_REQUEST['conAltura'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$query_estoque = "select t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, sum(t1.nr_qtde) as saldo, t2.cod_produto, t2.nm_produto, t2.cod_prod_cliente
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.ds_galpao = '$conGalpao' and t1.ds_prateleira = '$conRua' and t1.ds_coluna = '$conColuna' and t1.ds_altura = '$conAltura'
group by t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura";
$res_estoque = mysqli_query($link, $query_estoque);
$tr_estoque = mysqli_num_rows($res_estoque);

$link->close();

?>
<script type="text/javascript">
	function printEtq(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
	}
</script>
<div id="content" style="margin-top: 50px">
	<section id="widget-grid" class="">
		<br>
		<br>
		<!--button type="submit" onclick="printEtq('prtEtq')" id="btnPrintEtqEstoq" class="btn btn-primary btn-xs" value="" style="margin-top: 30px;margin-left: 10px">Imprimir
		</button-->
		<!--a href="data/movimento/relatorio/list_etq_teste.php?id_rua=<?php echo $conRua; ?>&id_coluna=<?php echo $conColuna; ?>&id_altura=<?php echo $conAltura; ?>&ds_galpao=<?php echo $conGalpao; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Imprimir todas</button></a-->
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="prtEtq">
				<!--a href="data/movimento/cons_estoque_prod_pdf.php?id_rua=<?php echo $conRua; ?>&id_coluna=<?php echo $conColuna; ?>&id_altura=<?php echo $conAltura; ?>&ds_galpao=<?php echo $conGalpao; ?>" style="float:left"><button type="submit" id="btnPrintEtq" class="btn btn-primary" value="">Imprimir</button></a--><br /><br />
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="text-center">COD. PRODUTO</th>
							<th>PRODUTO</th>
							<th>TIPO</th>
							<th>ARMAZÉM</th>
							<th>RUA</th>
							<th>COLUNA</th>
							<th>ALTURA</th>
							<th>QTDE</th>
							<!--th>CÓDIGO</th>
							<th>#</th-->
						</tr>
					</thead>
					<tbody id="tbConProdEstoq">

						<?php
						while ($estoque = mysqli_fetch_assoc($res_estoque)) {?>
							<tr>
								<td id="codProdRelEstoq"><?php echo $estoque['cod_prod_cliente']; ?></td>
								<td><?php echo $estoque['nm_produto']; ?></td>
								<td></td>
								<td id="idGalRelEstoq"><?php echo $estoque['ds_galpao']; ?></td>
								<td id="idRuaRelEstoq"><?php echo $estoque['ds_prateleira']; ?></td>
								<td id="idColunaRelEstoq"><?php echo $estoque['ds_coluna']; ?></td>
								<td id="idAlturaRelEstoq"><?php echo $estoque['ds_altura']; ?></td>
								<td id="nrQtdeRelEstoq"><?php echo $estoque['saldo']; ?></td>
								<!--td style="width: 100px;text-align: center">
									<svg id="barcode"
									class="barcode"
									jsbarcode-format="auto"
									jsbarcode-height="20"
									jsbarcode-displayValue="true"
									jsbarcode-value="<?php echo $estoque['cod_prod_cliente']; ?>-0000"
									jsbarcode-textmargin="0"
									jsbarcode-fontoptions="bold">
								</svg>
							</td>
							<td>
								<a href="data/movimento/relatorio/list_etq.php?cod_produto=<?php echo $estoque['cod_produto']; ?>&id_rua=<?php echo $estoque['ds_prateleira']; ?>&id_coluna=<?php echo $estoque['ds_coluna']; ?>&id_altura=<?php echo $estoque['ds_altura']; ?>&ds_galpao=<?php echo $estoque['ds_galpao']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Etiqueta</button></a>
							</td-->

						</tr>

					<?php }?>
				</tbody >
			</table>
		</article>
		<div id="retEstoqueModal"></div>
	</div>
</section>
</div>
<script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
	JsBarcode(".barcode").init();
</script>