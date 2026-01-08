<?php
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_ocorrencia=$_POST['id_ocor'];

$uploaded_images = array();
foreach($_FILES['upload_images']['name'] as $key=>$val){
	$upload_dir = "uploads/";
	$upload_file = $upload_dir.$_FILES['upload_images']['name'][$key];
	$filename = $_FILES['upload_images']['name'][$key];
	if(move_uploaded_file($_FILES['upload_images']['tmp_name'][$key],$upload_file)){
		$uploaded_images[] = $upload_file;
		$insert_sql = "INSERT INTO tb_img_ocor (id_ocorrencia, img)
		VALUES('$cod_ocorrencia', '".$filename."')";
		mysqli_query($link, $insert_sql) or die("database error: ". mysqli_error($link));
	}
}

if(!empty($uploaded_images)){
	foreach($uploaded_images as $image){
		$ret_img = '<li>
		<img class="images" src="data/qualidade/modal/'.$image.'" alt="">
		</li>';

		echo $ret_img;
	}	
}
$link->close();?>