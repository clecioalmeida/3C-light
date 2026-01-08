<?php
  session_start();  
?>
<?php

  if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../../../index.php");
    exit;

  }else{
    
    $id=$_SESSION["id"];
  }
?>
		<?php
		require_once("bd_class.php");
		$objDb = new db();
		$link = $objDb->conecta_mysql();

		$cod_rec = $_POST['fim_rec'];

		$query_nf="select sum(t1.qtd_vol_ent) as qtde, sum(t2.nr_qtde) as total from tb_nf_entrada t1
		left join tb_nf_entrada_item t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
		where t1.cod_rec = '$cod_rec'";
		$res_nf = mysqli_query($link, $query_nf);

		while ($dados=mysqli_fetch_array($res_nf)) {
			$nr_qtde_nf = $dados['qtde'];
			$total = $dados['total'];
		}

		if($total = $nr_qtde_nf){
			$sql = "CALL prc_recebimento('$id', $cod_rec)";
			$result_id = mysqli_query($link, $sql) or die(mysqli_error($link));

			$retorno[] = array(
			    'info' => "0",
			  );

		}else{

			echo'<scritp>alert("Quantidade digitada não confere com o total desse produto na nota.");</script>';

			exit();

		}

		$cod_rec = 0;
			 
		if(mysqli_affected_rows($link) > 0)
		{ ?>
			<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header" style="background-color: #2F4F4F;">
							<h4 class="modal-title" id="myModalLabel" style="color: white">OR finalizada com sucesso!</h4>
						</div>
						<div class="modal-body">
							
						</div>
						<div class="modal-footer" style="background-color: #2F4F4F;">
							<button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function () {
					$('#conf_cadastro').modal('show');
				});
			</script>

		<?php }
		else
		{ ?>    
			<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Existe(m) NF(s) Sem Produto(s) Recebido(s)!</h4>
						</div>
						<div class="modal-body">                                
						</div>
						<div class="modal-footer">
							
						</div>
					</div>
				</div>
			</div>          
			<script>
				$(document).ready(function () {
					$('#conf_cadastro').modal('show');
				});
			</script>
		<?php } 

					
	$link->close();
?>