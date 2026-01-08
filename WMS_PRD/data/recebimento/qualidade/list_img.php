<?php
require_once('bd_class.php');

$cod_ocorrencia=$_POST['id_ocor'];

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_img="select id, img from tb_img_ocor where id_ocorrencia = '$cod_ocorrencia'";
$res_img = mysqli_query($link,$sql_img); 

while ($dados_img=mysqli_fetch_assoc($res_img)) {

	$upload_dir = "uploads/";
	$img = $upload_dir.$dados_img['img'];

	$list_img = '
	<ul>
		<li>
			<img class="images" src="data/qualidade/modal/'.$img.'" alt="">
			<button type="submit" class="btn btn-default btn-xs" id="btnDelImgOcor" value="'.$dados_img['id'].'">Excluir</button>
		</li>
	</ul>';

	echo $list_img;
}

$link->close();
?>