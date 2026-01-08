<?php 

  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $id_rec = $_POST["id_rec"];
  $id_nf = mysqli_real_escape_string($link, $_POST["del_nfrec"]);

  $select_nf = "select * from tb_nf_entrada where cod_nf_entrada = '$id_nf'";
  $res_nf = mysqli_query($link,$select_nf);

    while($dados_or=mysqli_fetch_assoc($res_nf)){
        $nr_fisc_ent = $dados_or['nr_fisc_ent'];
    }
$link->close();
?>
<div class="modal fade" id="del_nfe_rec" aria-hidden="true">
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
							<h5 class="modal-title" id="askDelItemNfItem">Você está excluindo a nota fiscal de entrada <?php echo $nr_fisc_ent; ?>? Se sim, irá excluir também os itens cadastrados.</h5>
							<h4 id="retDelItemNFOR"></h4>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" style="background-color: #2F4F4F;">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				<button type="submit" class="btn btn-primary" value="<?php echo $id_nf;?>" data-or="<?php echo $id_rec;?>" id="btnFormDelNfRecebimento">Sim</button>
			</div>   
		</div>
	</div>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#del_nfe_rec').modal('show');
    });
</script>