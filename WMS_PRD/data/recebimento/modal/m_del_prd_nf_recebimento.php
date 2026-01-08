<?php 

  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $del_nfrec = mysqli_real_escape_string($link, $_POST["del_nfrec"]);

  $select_nf = "select * from tb_nf_entrada_item where cod_nf_entrada_item = '$item_nf'";
  $res_nf = mysqli_query($link,$select_nf);

    while($dados_or=mysqli_fetch_assoc($res_nf)){
        $nr_fisc_ent = $dados_or['nr_fisc_ent'];
    }
$link->close();
?>
<div class="modal fade" id="inativar_nfrecebimento" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #2F4F4F;">
				<h5 class="modal-title" style="color: white">Inativar registro</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
			</div>
			<div class="modal-body" style="overflow-y: auto">
				<form method="post" action="" id="formDelNfRecebimento">
					<div class="form-body">
						<div class="form-group">
							<h5 class="modal-title" id="askDelItemNfItem">Deseja excluir esse item da nota?</h5>
							<h4 id="retDelItemNFOR"></h4>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" style="background-color: #2F4F4F;">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
				<button type="submit" class="btn btn-primary" value="<?php echo $item_nf;?>" id="btnFormConfDelNfRec">Sim</button>
			</div>   
		</div>
	</div>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#inativar_nfrecebimento').modal('show');
    });
</script>