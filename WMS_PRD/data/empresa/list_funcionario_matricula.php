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
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_matricula = $_POST['nr_matricula'];

$sql = "select * from tb_funcionario where fl_status = 'A' and nr_matricula = '$nr_matricula' and fl_empresa = '$id_oper'"; 
$res = mysqli_query($link,$sql); 

$link->close();
?>
<table class="table" id="" style="width: 50%">
	<thead>
		<tr>
			<th> Ações </th>
			<th> Código</th>
			<th> Nome </th>
			<th> Matrícula </th>
			<th> CR </th>
			<th> Criado em </th>
		</tr>
	</thead>
	<tbody>
		<?php while($dados = mysqli_fetch_array($res)) {?>
			<tr class="odd gradeX">
				<td style="text-align: center; width: 200px">  
					<button type="submit" id="btnUpdFunc" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Alterar</button>
					<button type="submit" id="btnDelFunc" class="btn btn-danger btn-xs" value="<?php echo $dados['id']; ?>">Excluir</button>
				</td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['id']; ?> </td>
				<td> <?php echo $dados['ds_nome']; ?> </td>
				<td> <?php echo $dados['nr_matricula']; ?> </td>
				<td> <?php echo $dados['cod_depto']; ?> </td>
				<td> <?php echo $dados['dt_create']; ?> </td>
			</tr> 
		<?php } ?> 
	</tbody>
</table>