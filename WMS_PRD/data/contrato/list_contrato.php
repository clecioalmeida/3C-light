<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['cnpj']) && isset($_POST['rSocial'])){

	$sql = "select * from tb_contrato where fl_status = 'A'"; 
	$res = mysqli_query($link,$sql); 

}elseif(isset($_POST['cnpj']) && !isset($_POST['rSocial'])){

	//$r_social = mysqli_real_escape_string($link, $_POST['r_social']);

	$sql = "select * from tb_contrato where fl_status = 'A'"; 
	$res = mysqli_query($link,$sql); 

}else{

	$sql = "select * from tb_contrato where fl_status = 'A'"; 
	$res = mysqli_query($link,$sql); 
}

$link->close();
?>
<div id="retorno"></div>
<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
	<thead>	
		<tr>
			<th colspan="2"> Ações </th>
			<th> Cliente</th>
			<th> Descrição </th>
			<th> Valor Mov. </th>
			<th> Franquia </th>
			<th> Manuseio </th>
			<th> Vencimento </th>
			<th> Aprovado em </th>
			<th> Situação </th>
		</tr>
	</thead>
	<?php                                   
		while($dados = mysqli_fetch_array($res)) {?>
		<tr class="odd gradeX">
			<td style="text-align: center; width: 5px">
				<button type="submit" id="btnDtlContrato" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Detalhe</button> 
			</td>
			<td style="text-align: center; width: 5px">
				<button type="submit" id="btnUpdContrato" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Alterar</button> 
			</td>
			<td><?php echo $dados['id_cliente']; ?> </td>
			<td><?php echo $dados['ds_descricao']; ?></td>
			<td><?php echo $dados['vlr_mov']; ?></td>
			<td> <?php echo $dados['nr_franquia_mov']; ?> </td>
			<td> <?php echo $dados['ds_manuseio']; ?> </td>
			<td style="width: 10px"> <?php echo date("d/m/Y", strtotime($dados['dt_vencto'])); ?> </td>
			<td style="width: 50px"> <?php echo date("d/m/Y", strtotime($dados['dt_aprova'])); ?> </td>
			<td style="width: 50px"> <?php echo $dados['fl_status']; ?> </td>
		</tr> 
	<?php } ?> 
	</tbody>
</table>