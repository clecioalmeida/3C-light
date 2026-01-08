<?php

$id = 2;

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$id_destinatario = $_GET['idDestinatario'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "SELECT nr_nf, nr_nf_formulario, nr_pedido, dt_emissao, nr_peso, nr_volume FROM `tb_nf_saida` WHERE id_destinatario = '$id_destinatario'";
$res_ped = mysqli_query($link, $sql_ped);

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
	<script src="../js/jquery_form.js"></script>
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
		<h4 style="color: black;margin-top:-30px">Detalhes da entrega</h4>
		<hr>
		<div style="margin-top:-40px;font-size: 12px">
			<table data-role="table" data-mode="reflow" class="table-stroke">
				<thead>
					<tr>
						<th>Nota fiscal</th>

						<th>Pedido</th>
						<th>Emissão</th>
						<th>Volumes</th>
					</tr>
				</thead>

				<tbody>
					<?php
while ($dados = mysqli_fetch_assoc($res_ped)) {

	?>
					<tr>
						<th><?php echo $dados['nr_nf_formulario']; ?></th>


						<td><?php echo $dados['nr_pedido']; ?>
							</td>
						<td><?php echo $dados['dt_emissao']; ?></td>
						<td><?php echo $dados['nr_volume']; ?></td>
						<td>
							<a href="#popupDialog1<?php echo $dados['nr_nf_formulario']; ?>" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-check ui-btn-icon-left ui-btn-b">Confirmar nota fiscal</a>
							<div data-role="popup" id="popupDialog1<?php echo $dados['nr_nf_formulario']; ?>" data-overlay-theme="b" data-theme="a" data-dismissible="false" style="max-width:400px;">
							    <div data-role="header" data-theme="a" style="height: 50px">
							    <h1 style="margin-top: -10px">ATENÇÃO!</h1>
							    </div>
							    <div role="main" class="ui-content" style="margin-top: -30px">
								<p>Nota fiscal:<?php echo $dados['nr_nf_formulario']; ?></p>
							        <h3 class="ui-title">A entrega foi efetuada com sucesso?</p>
							        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Cancela</a>
							        <button href="#" id="btnConfNf" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back" data-transition="flow" value="<?php echo $dados['nr_nf_formulario']; ?>">Confirma</button>
							    </div>
							</div>
							<a href="#popupDialog3<?php echo $dados['nr_nf_formulario']; ?>" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-alert ui-btn-icon-left ui-btn-b">Ocorrência</a>
							<div data-role="popup" id="popupDialog3<?php echo $dados['nr_nf_formulario']; ?>" data-overlay-theme="b" data-theme="a" data-dismissible="false" style="max-width:400px;">
							    <div data-role="header" data-theme="a" style="height: 50px">
							    <h1 style="margin-top: -10px">Ocorrências</h1>
							    </div>
							    <div role="main" class="ui-content" style="margin-top: -30px">
								<!--p>Nota fiscal:<?php echo $dados['nr_nf_formulario']; ?></p-->
<select name="IdOcor" id="IdOcor" data-native-menu="false">
    <option>Selecione</option>
    <option value="Atraso na entrega">Atraso na entrega</option>
    <option value="Documentação">Documentação</option>
    <option value="Não localizado">Não localizado</option>
    <option value="Produto avariado">Produto avariado</option>
</select>
<label for="textarea">Observações:</label>
<textarea cols="40" rows="8" name="ObsOcor" id="ObsOcor"></textarea>
							        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Cancela</a>
							        <button href="#" id="btnConfNf" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back" data-transition="flow" value="<?php echo $dados['nr_nf_formulario']; ?>">Salvar</button>
							    </div>
							</div>
							 <a href="anexo_teste.php?idDestinatario=<?php echo $id_destinatario; ?>&idNf=<?php echo $dados['nr_nf_formulario']; ?>&nrPedido=<?php echo $dados['nr_pedido']; ?>" class="ui-shadow ui-btn ui-corner-all ui-btn-b">Inserir anexo</a>
						</td>
					</tr>
		        <?php }?>
				</tbody>
			</table>
		</div>
		<a href="#popupDialog2" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn ui-corner-all ui-shadow ui-btn-b">Confirmar todas as notas fiscais</a>
							<div data-role="popup" id="popupDialog2" data-overlay-theme="b" data-theme="a" data-dismissible="false" style="max-width:400px;">
							    <div data-role="header" data-theme="a" style="height: 50px">
							    <h1 style="margin-top: -15px">ATENÇÃO!</h1>
							    </div>
							    <div role="main" class="ui-content" style="margin-top: -30px">
							        <h3 class="ui-title">Todas as entregas foram realizadas com sucesso?</p>
							        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Cancela</a>
							        <a href="#" id="btnConfAll" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back" data-transition="flow">Confirma</a>
							    </div>
	</div><!-- /content -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>Growup Soluções para logística</p>
		<p>Copyright 2018 - Growup</p>
	</div><!-- /footer -->
	<!-- TODO: This should become an external panel so we can add input to markup (unique ID) -->
</div><!-- /page -->
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '#btnConfAll', function(){
			event.preventDefault();
			var idDest = "<?php echo $id_destinatario; ?>";
			$.ajax
			({
	            url:"conf_entrega.php",
	            method: "POST",
	            dataType:'json',
	            data:{idDest:idDest},
	            success:function(j)
	            {
	            	for(var i=0;i < j.length;i++){
	            		if(j[i].info == '0'){

	            			alert("Entrega confirmada com sucesso!");

	            		}else{

	            			alert("Ocorreu um erro! Tente novamente.");

	            		}
	            	}
	            }
	        });
		});

		$(document).on('click', '#btnConfNf', function(){
			event.preventDefault();
			var idNf = $(this).val();
			$.ajax
			({
	            url:"conf_entrega_nf.php",
	            method: "POST",
	            dataType:'json',
	            data:{idNf:idNf},
	            success:function(j)
	            {
	            	for(var i=0;i < j.length;i++){
	            		if(j[i].info == '0'){

	            			alert("Entrega confirmada com sucesso!");

	            		}else{

	            			alert("Ocorreu um erro! Tente novamente.");

	            		}
	            	}
	            }
	        });
		});

		$(document).on('click', '#btnLogout', function(){
			event.preventDefault();
			$.ajax
			({
	            url:"../logout.php",
	            method: "GET",
	            success:function(j)
	            {
	            	alert("Saída realizada com sucesso!");
	            	window.location.replace("../index.php");
	            }
	        });
		});
	});
</script>
</body>
</html>
