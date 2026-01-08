<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$ds_galpao = $_POST['ds_galpao'];
$id_rua = $_POST['id_rua'];
$id_coluna = $_POST['id_coluna'];
$id_altura = $_POST['id_altura'];
$cod_produto = $_POST['cod_produto'];

$query_qtde="select sum(t1.nr_qtde) as qtde, t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t2.cod_prod_cliente 
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_produto
where t1.ds_galpao = '$ds_galpao' and t1.ds_prateleira = '$id_rua' and t1.ds_coluna = '$id_coluna' and t1.ds_altura = '$id_altura' and t1.produto = '$cod_produto'
group by t1.produto";
$qtde = mysqli_query($link,$query_qtde);
$tr_qtde = mysqli_num_rows($qtde);

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
<?php
if($tr_qtde>0){?>
<div class="modal" id="barcodemodal" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
     		</div>
      		<div class="modal-body">
			    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
			        <thead>
			            <tr>
			                <th> Código</th>
			                <th></th>
			            </tr>
			        </thead>
			        <tbody>
			            <?php 
			            while($linha = mysqli_fetch_assoc($qtde)){
			                ?>
			            <tr>
               		 		<td id="prtEtq" style="width: 100px;text-align: center">
               		 			<svg id="barcode" 
									class="barcode"
									jsbarcode-format="auto"
									jsbarcode-height="20"
									jsbarcode-displayValue="true"
									jsbarcode-value="<?php echo $linha['produto'];?>"
									jsbarcode-textmargin="0"
									jsbarcode-fontoptions="bold">
								</svg>
								<br />
								<span><?php echo $linha['qtde']." - ".$linha['cod_prod_cliente']." - ".$linha['ds_prateleira'].$linha['ds_coluna'].$linha['ds_altura'];?>
								</span>
							</td>
							<td>
								<button type="submit" onclick="printEtq('prtEtq')" id="btnPrintEtqEstoq" class="btn btn-primary btn-xs" value="">Imprimir
								</button>
								<button type="submit" id="btnPdfEtqEstoq" class="btn btn-primary btn-xs" value="">PDF
								</button>
							</td>
			            </tr>
            			<?php }?>
			        </tbody>
			    </table>
    		</div>
		    <div class="modal-footer">
		    </div>
    	</div>
  	</div>
</div>
<?php 
}else{?>
<h4>Nao foram encontrados produtos com esta descrição.</h4>
<?php 
}
?>
<script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
	JsBarcode(".barcode").init();
</script>
<script>
    $(document).ready(function () {
        $('#barcodemodal').modal('show');
    });
</script>