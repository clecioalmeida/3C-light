<?php
//upload.php
$id = 2;

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$output = '';
if (is_array($_FILES)) {
	foreach ($_FILES['files']['name'] as $name => $value) {
		$id_destinatario = $_POST['id_destinatario'];
		$nr_nf = $_POST['nr_nf_formulario'];
		$nr_pedido = $_POST['nr_pedido'];
		$upload_dir = "upload/" . $id_destinatario;
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777, true);
		}
		$file_name = explode(".", $_FILES['files']['name'][$name]);
		$allowed_ext = array("jpg", "jpeg", "png", "gif");
		if (in_array($file_name[1], $allowed_ext)) {
			$new_name = $nr_nf . '.' . $file_name[1];
			$sourcePath = $_FILES['files']['tmp_name'][$name];
			//$targetPath = "upload/" . $new_name;
			$targetPath = $upload_dir . "/" . $new_name;
			if (move_uploaded_file($sourcePath, $targetPath)) {
				$output .= '<img src="' . $targetPath . '" width="100px" height="130px" />';
			}
			$sql_code = "INSERT INTO tb_anexo (nr_pedido, id_destino, ds_anexo, dt_create) VALUES('$nr_pedido', '$id_destinatario', '$new_name', NOW())";
			$res_code = mysqli_query($link, $sql_code);
		}
	}
	echo $output;
}
?>