<?php
session_start();    
?>
<?php

if(isset($_SESSION["id"])){

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION['cod_cli'];

}else{

    echo "<script>alert('Você não está logado!')</script>";
}

?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$sql = "select * from tb_funcionario where fl_status = 'A' and fl_empresa = '$cod_cli'"; 
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
		</tr>
	</thead>
	<tbody>
		<?php                                  
		while($dados = mysqli_fetch_array($res)) {?>
			<tr class="odd gradeX">
				<td style="text-align: center; width: 200px">  
					<button type="submit" id="btnUpdFunc" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Alterar</button>
					<button type="submit" id="btnDelFunc" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Excluir</button>
				</td>
				<td style="text-align: center; width: 10px"> <?php echo $dados['id']; ?> </td>
				<td> <?php echo $dados['ds_nome']; ?> </td>
				<td> <?php echo $dados['nr_matricula']; ?> </td>
			</tr> 
		<?php } ?> 
	</tbody>
</table>