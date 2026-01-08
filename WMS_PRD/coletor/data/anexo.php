<?php

$id = 2;

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_GET['idDestinatario']) && isset($_GET['idNf'])) {

	$id_destinatario = $_GET['idDestinatario'];
	$nr_nf_formulario = $_GET['idNf'];

} elseif (isset($_POST['idDestinatario']) && isset($_POST['idNf'])) {

	$id_destinatario = $_POST['idDestinatario'];
	$nr_nf_formulario = $_POST['idNf'];

}

$msg = false;
if (isset($_FILES['file'])) {
	$extensao = strtolower(substr($_FILES['file']['name'], -4)); //pega a extensao do arquivo
	$novo_nome = md5($nr_nf_formulario) . $extensao; //define o nome do arquivo
	$diretorio = "upload/"; //define o diretorio para onde enviaremos o arquivo
	move_uploaded_file($_FILES['file']['tmp_name'], $diretorio . $novo_nome); //efetua o upload
	$sql_code = "INSERT INTO tb_anexo (id_destino, ds_anexo, dt_create) VALUES('$id_destinatario', '$novo_nome', NOW())";
	$res_code = mysqli_query($link, $sql_code);
	if (mysqli_affected_rows($res_code) > 0) {
		$msg = "Arquivo enviado com sucesso!";
	} else {
		$msg = "Falha ao enviar arquivo.";
	}

	echo $novo_nome;
	echo $extensao;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Moros - Confirmação de entregas</title>
	<link rel="shortcut icon" href="../_assets/img/moros_logo.png"">
	<link rel="stylesheet" href="../css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="../_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="../js/jquery.js"></script>
	<script src="../_assets/js/index.js"></script>
	<script src="../js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page" class="jqm-demos jqm-home">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="../_assets/img/moros.png" alt="jQuery Mobile" style="width: 50px;height: 50px;margin-top: -5px"></h2>
		<a href="../../home.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div><!-- /header -->
	<div role="main" class="ui-content jqm-content" id="retEntrega">
		<h4 style="color: black;margin-top:-30px">Enviar arquivos</h4>
		<hr>
<?php if (isset($msg) && $msg != false) {
	echo "<p> $msg </p>";
}
?>
		<form action="anexo.php" method="POST" enctype="multipart/form-data">
			<label for="file">Arquivo:</label>
			<input type="file" name="file" id="file" value="">
			<input type="submit" value="Salvar">
		</form>

	</div><!-- /content -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>Growup Soluções para logística</p>
		<p>Copyright 2018 - Growup</p>
	</div><!-- /footer -->
	<!-- TODO: This should become an external panel so we can add input to markup (unique ID) -->
</div><!-- /page -->
</body>
</html>
