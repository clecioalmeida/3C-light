<?php

$id = 2;

require_once 'data/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "select t1.*, t2.nm_cliente, t3.dt_limite, t2.ds_cidade, t3.hr_limite
from tb_nf_saida t1
left join tb_cliente t2 on t1.id_destinatario = t2.cod_cliente
left join tb_pedido_coleta t3 on t1.nr_pedido = t3.nr_pedido";
$res_ped = mysqli_query($link, $sql_ped);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Moros - Confirmação de entregas</title>
	<link rel="shortcut icon" href="_assets/img/moros_logo.png"">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="_assets/js/index.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page" class="jqm-demos jqm-home">
	<div data-role="header" class="jqm-header" style="background-color: #0000CD">
		<h2><img src="_assets/img/moros.png" alt="jQuery Mobile" style="width: 50px;height: 50px"></h2>
	</div><!-- /header -->
	<div role="main" class="ui-content jqm-content" id="retEntrega">
		<h4 style="color: black">Entregas</h4>
		<div data-demo-html="true" data-demo-css="#collapsible-list-item-style-flat">
			<?php
while ($dados = mysqli_fetch_assoc($res_ped)) {

	?>
		    <ul data-role="listview">
		      <li data-role="collapsible" data-iconpos="right" data-inset="false">

		        <h3 style="font-size: 12px"><?php echo $dados['nm_cliente'] . ' - ' . $dados['ds_cidade']; ?></h3>
		        <ul data-theme="a">
		          <p><?php echo $dados['dt_limite']; ?></p>
		          <p><?php echo $dados['hr_limite']; ?></p>
		          <button class="ui-btn ui-btn-inline">Confirmar</button>
		          <button class="ui-btn ui-btn-inline">Ocorrência</button>
		        </ul>
		      </li>
		      <li>
		    </ul>
		        <?php }?>
		</div>
	</div><!-- /content -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>Growup Soluções para logística</p>
		<p>Copyright 2018 - Growup</p>
	</div><!-- /footer -->
	<!-- TODO: This should become an external panel so we can add input to markup (unique ID) -->
</div><!-- /page -->
<!--script type="text/javascript">
	$(document).ready(function(){
		var id = "<?php echo $id; ?>";
		$.getJSON('data/list_entrega.php', {id:id,ajax: 'true'}, function(j){
                var options = '<div data-demo-html="true" data-demo-css="#collapsible-list-item-style-flat">\
		    <ul data-role="listview">\
		      <li id="retEntrega" data-role="collapsible" data-iconpos="right" data-inset="false">';
                for (var i = 0; i < j.length; i++) {
                    options += '<h3 style="font-size: 12px">'+ j[i].nm_cliente +'</h3>';
                }
                $('#retEntrega').html(options).append();
            });
	});
</script-->
</body>
</html>
