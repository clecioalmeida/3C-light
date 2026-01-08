<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title> ARGUS </title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/smartadmin-production-plugins.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/smartadmin-production.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/smartadmin-skins.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/smartadmin-rtl.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/demo.min.css">
	<link rel="shortcut icon" href="img/logo8.png" type="image/x-icon">
	<link rel="icon" href="img/logo8.png" type="image/x-icon">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	<style type="text/css">
		.intro {
			display: table;
			width: 100%;
			height: 100vh;
			padding: 100px 0;
			color: black;
			background: url('img/background_wms2.png') no-repeat bottom center;
			background-position: 30% 45%;
			background-size: cover;
			/*overflow: hidden;*/
		}

		h2 {

			font-size: 14px;
			text-align: center;

		}

		.container {
			width: 100%;
		}
	</style>
</head>
<body class="desktop-detected pace-done mobile-view-activated smart-style-1 fixed-header fixed-navigation minified intro">
	<header id="header">
		<div id="logo-group">
		</div>
	</div>
	<div style="float: right;margin-top:10px">
		<button type="submit" id="btnHome" class="btn btn-danger btn-xs" style="width: 150px;margin-right: 10px">HOME</button>
		<button type="submit" id="btnHome" class="btn btn-primary btn-xs" onclick="window.location.href='https://argussistemas.com.br/argus/3c/';" style="width: 150px;margin-right: 10px">VOLTAR</button>
	</div>
	<div style="float: center">
	</div>
</header>
<div id="main" role="main" class="" style="margin-top: -50px">
	<div id="content" class="container">
		<div class="row">                         
			<h2 class="txt-color-blue login-header-big" style="text-align: left"><strong>ARGUS - WMS 3C - SÃO GONÇALO - RJ</strong></h2>
			<hr>
			<div class="col-sm-6">
				<div id="fade">
					<div class="col-md-12 padding-left-0">
						<div>
							<img src="img/logo2.png" class="pull-left display-image" alt="" style="width:150px; margin-top: 10px">
						</div>
						<div>
							<img src="img/logo12.png" class="pull-left display-image" alt="" style="width:150px; margin-top: 17px;border-radius: 20px">
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div>
					<fieldset>
						<section>
							<br><br>
						</section>
					</fieldset>
					<fieldset class="col-sm-12">
						<section class="col-sm-6">
							<input type="submit" class="btn-primary form-control" id="btnRelCons" value="RELATÓRIO DE CONSUMO">
							<br>
							<input type="submit" class="btn-primary form-control" id="btnReqMes" value="REQUISIÇÕES POR MÊS">
							<br>
							<input type="submit" class="btn-primary form-control" id="btnCrMes" value="REQUISIÇÕES POR CENTRO DE CUSTO">
						</section>
						<section class="col-sm-6">
							<input type="submit" class="btn-primary form-control" id="btnResInv" value="RESULTADOS DE INVENTÁRIOS">
							<br>
							<input type="submit" class="btn-primary form-control" id="btnCrMesItem" value="ITENS POR CENTRO DE CUSTO">
						</section>
					</fieldset>
				</div>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-sm-12" id="retDash"></div>
		</div>
		<div id="retModalDash"></div>
		<div id="retSubModalDash"></div>
	</div>
</div>
<?php include "script_global.php";?>
<script type="text/javascript" src="jquery.table2excel.js"></script>
<script type="text/javascript" src="js/dash.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
    $("#retDash").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");

		$("#fade").fadeIn(3000);

	});
</script>
</body>
</html>