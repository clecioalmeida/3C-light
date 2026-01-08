<?php
session_start();	
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id=$_SESSION["id"];
}
?>
<style type="text/css">
	.ocupado {
		background-color: #FFA07A;
	}

	.livre {
		background-color: #98FB98;
	}

	.alerta {
		background-color: #FFFF00;
	}
</style>

<table class="table table-bordered table-hover table-checkable order-column" id="tbConfPed">
	<thead>
		<tr>
			<th style="text-align: center; width: 300px"> Ações </th>
			<th> Chegada </th>
			<th> Entrada </th>
			<th> Placa</th>
			<th> Veículo </th>
			<th> Empresa  </th>
			<th> Nome  </th>
			<th> Departamento </th>
			<th> Contato </th>
			<th> Motivo </th>
			<th> Doca </th>
			<th> Saída</th>
			<th> Situação </th>
		</tr>
	</thead>
	<tbody>
		<?php 
		require_once('list_registros.php');
		while($dados = mysqli_fetch_array($res)) {?>
			<tr  class="status" data-status="<?php echo $dados['fl_status'];?>" data-id="<?php echo $dados['id'];?>">
				<td>
					<button type="submit" id="btnLibEntPrt" class="btn btn-primary btn-xs" value="<?php echo $dados['id'];?>" style="width: 60px">LIBERAR</button> 
					<button type="submit" id="btnLibSaidaPrt" class="btn btn-success btn-xs" value="<?php echo $dados['id'];?>" style="width: 60px">SAÍDA</button>
					<button type="submit" id="btnLibSaidaPrt" class="btn btn-info btn-xs" value="<?php echo $dados['id'];?>" style="width: 60px">ALTERAR</button>								
				</td>
				<td><?php echo $dados['dt_chegada'];?></td>
				<td><?php echo $dados['dt_entrada'];?></td>
				<td><?php echo $dados['ds_placa'];?></td>
				<td><?php echo $dados['ds_veiculo'];?></td>
				<td style="text-align: right;"><?php echo $dados['ds_empresa'];?></td>
				<td style="text-align: right;"><?php echo $dados['ds_nome'];?></td>
				<td><?php echo $dados['ds_dpto'];?></td>
				<td><?php echo $dados['ds_contato'];?></td>
				<td><?php echo $dados['ds_motivo'];?></td>
				<td><?php echo $dados['ds_doca'];?></td>
				<td><?php 
				if($dados['dt_saida'] == 0){
					echo '';
				}else{
					echo date('d-m-Y',strtotime($dados['dt_saida']));
				}
				?>
			</td>
			<?php 
			if($dados['fl_status'] == 'A' || $dados['fl_status'] == 'CR'){
				$td = '<td style="background-color: #FFA07A">AGUARDANDO</td>';
			}elseif($dados['fl_status'] == 'L'){
				$td = '<td style="background-color: #FFFF00">ENTRADA LIBERADA</td>';
			}elseif($dados['fl_status'] == 'S'){
				$td = '<td style="background-color: #98FB98">SAÍDA LIBERADA</td>';
			}
			echo $td;
			?>
		</tr>
	<?php } ?> 
</tbody>
</table>
<div id="retornoDoca"></div>
<!--script type="text/javascript">
    $(document).ready(function(){

        var status_ = new Array();
        $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "A"){
                $this.addClass('ocupado');
            }else if(status_[i] == "S"){
                $this.removeClass('ocupado').addClass('alerta');
            }else if(status_[i] == "L"){
                $this.removeClass('ocupado').addClass('livre');
            }
        });
        //console.log(status_);
    });
</script-->