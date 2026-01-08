<?php

$id = 2;

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_GET['idDestinatario']) && isset($_GET['idNf'])) {

	$id_destinatario = $_GET['idDestinatario'];
	$nr_nf_formulario = $_GET['idNf'];
	$nr_pedido = $_GET['nrPedido'];

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
	<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script-->
	<script src="../js/jquery_form.js"></script>
	<script src="../_assets/js/index.js"></script>
	<script src="../js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page" class="jqm-demos jqm-home">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="../_assets/img/moros.png" alt="jQuery Mobile" style="width: 50px;height: 50px;margin-top: -5px"></h2>
		<a href="confirma.php?idDestinatario=<?php echo $id_destinatario; ?>" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div><!-- /header -->
	<div role="main" class="ui-content jqm-content" id="retEntrega">
		<h4 style="color: black;margin-top:-30px">Enviar arquivos</h4>
		<hr>
		<form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                     <div id="gallery"></div><div style="clear:both;"></div><br /><br />
                     <div class="col-md-4" align="left">
                          <label>Selecione a imagem</label>
                     </div>
                     <div class="col-md-4">
                          <input name="files[]" type="file" multiple />
               			  <input type="hidden" id="id_destinatario" name="id_destinatario" value="<?php echo $id_destinatario; ?>">
               			  <input type="hidden" id="nr_nf_formulario" name="nr_nf_formulario" value="<?php echo $nr_nf_formulario; ?>">
                          <input type="hidden" id="nr_pedido" name="nr_pedido" value="<?php echo $nr_pedido; ?>">
                     </div>
                     <div class="col-md-4">
                          <input type="submit" id="uploadImage" value="Salvar" />
                     </div>
                     <div style="clear:both"></div>
                </form>

	</div><!-- /content -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>Growup Soluções para logística</p>
		<p>Copyright 2018 - Growup</p>
	</div><!-- /footer -->
	<!-- TODO: This should become an external panel so we can add input to markup (unique ID) -->
</div><!-- /page -->
<script>
 $(document).ready(function(){

    $('#uploadForm').on('submit', function(e){
        event.preventDefault();
        $.ajax({
            url: "upload.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            success: function(data)
            {
                $("#gallery").html(data);
                alert("Imagem enviada");
            }
        });
    	//window.location.reload();
        return false;
      });
 });
 </script>
</body>
</html>
