 <?php
 session_start();    
 ?>
 <?php

 if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

 	header("Location:../../index.php");
 	exit;

 }else{

 	$id       = $_SESSION["id"];
 	$cod_cli  = $_SESSION["cod_cli"];
 }
 ?>
 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $ds_data = explode('-', $_POST['ds_mes']);
 $ds_mes = $ds_data[1];
 $ds_ano = $ds_data[0];

 $sql_nf = "select id, date_format(ds_data, '%d/%m/%Y') as ds_data, nr_nf_rec, nr_forn_rec, nr_sku_rec, format((nr_sku_rec/nr_forn_rec),2) as avg_sku 
 from tb_fc_sku_rec
 where fl_empresa = '$cod_cli' and month(ds_data) = '$ds_mes' and year(ds_data) = '$ds_ano'
 group by day(ds_data)";
 $res_prod = mysqli_query($link, $sql_nf);

 $link->close();

 while ($dados = mysqli_fetch_assoc($res_prod)) {?>
 	<tr class="odd gradeX">
 		<td style="text-align: left;width:120px"><?php echo $dados['ds_data']; ?></td>
 		<td id="nr_nf_rec" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_nf_rec']; ?></td>
 		<td id="nr_forn_rec" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_forn_rec']; ?></td>
 		<td id="nr_sku_rec" contenteditable="true" style="text-align: right;width:90px"><?php echo $dados['nr_sku_rec']; ?></td>
 		<td style="text-align: right;width:90px"><?php echo $dados['avg_sku']; ?></td>
 		<td style="text-align: left;width:250px">
 			<button type="submit" class="btn btn-primary btn-xs btnSaveUpdNfSku" id="btnSaveUpdNfSku" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>">SALVAR</button>
 			<button type="submit" class="btn btn-danger btn-xs" id="btnDelNfSku" data-mes="<?php echo $ds_mes;?>" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
 		</td>
 	</tr>
 	<?php }?>