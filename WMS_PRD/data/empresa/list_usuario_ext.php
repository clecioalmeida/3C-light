<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
	$cnpj 		= $_SESSION["nr_cnpj"];

}
?>
<?php 
require_once('bd_class_site.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select id, ds_nome, ds_usuario, fl_status 
from tb_acesso where fl_status = 'A' and nr_cnpj_transp = '$cod_cli'"; 
$res = mysqli_query($link,$sql); 

//echo $cnpj;

$link->close();
?>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
	<thead>
		<tr>
			<th> Ações </th>
			<th> Código</th>
			<th> Nome </th>
			<th> Usuário </th>
			<th> Status </th>
		</tr>
	</thead>
	<tbody style="font-size: 12px">
		<?php
		
		while ($dados = mysqli_fetch_array($res)) {?>
			<tr class="odd gradeX">
				<td style="text-align: center; width: 200px">
					<button type="submit" id="btnDtlUser" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Detalhe</button>
					<button type="submit" id="btnUpdUser" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Alterar</button>
					<button type="submit" id="btnDelUser" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Excluir</button>
				</td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['id']; ?> </td>
				<td> <?php echo $dados['ds_nome']; ?> </td>
				<td> <?php echo $dados['ds_usuario']; ?> </td>
				<td> 
					<?php
						if($dados['fl_status'] == "A"){

							echo "ATIVO";

						}else{

							echo "INATIVO";

						} 
					?> 
				</td>
			</tr>
		<?php }?>
	</tbody>
</table>