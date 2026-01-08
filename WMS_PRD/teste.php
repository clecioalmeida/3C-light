<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
	session_start();	
?>
<?php

	if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

		header("Location:index.php");
		exit;

	}else{
		
		$id=$_SESSION["id"];
	}
?>
<?php include 'data/movimento/chart.php';?>
<?php	
$width = 120;
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> GrowUp </title>
		<meta name="description" content="">
		<meta name="author" content="">
			
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css"> 

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/demo.min.css">

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="img/logo8_1.png" type="image/x-icon">
		<link rel="icon" href="img/logo8_1.png" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- #APP SCREEN / ICONS -->
		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">

	</head>
	<body class="desktop-detected pace-done mobile-view-activated smart-style-1 fixed-header fixed-navigation">
<fieldset>
        <form id="form" action="" method="post">
            Nome:      <input type="text" id="usuario" name="usuario"><br>
            Senha: <input type="text" id="senha" name="senha"><br>
            Token: <input type="text" id="recToken" name="recToken" value=""><br>
            <input id="GetToken" type="button" name="enviar" value="submit">
            <input id="Sendtoken" type="button" name="token" value="token">
        </form><br><br>
    </fieldset>
    <div id="retorno">Teste</div>
             
    <!--fieldset>
        <form id="form" action="" method="post">
            Nome:      <input type="text" id="Edtfirstname" name="Edtfirstname" value="${firstname}"><br>
            Sobrenome: <input type="text" id="Edtlastname" name="Edtlastname" value="${lastname}"><br>
            <input id="submit" type="button" name="enviar" value="submit">
        </form>
    </fieldset-->
    <input id="consultar" type="button" name="consultar" value="consultar">
    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                                            <thead> 
                                                                <tr>
                                                                    <th> id </th>
                                                                    <th> nome </th>
                                                                    <th> sobrenome </th>
                                                                    <th> editar </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                        </table>
    <div class="modal fade" id="editar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    
    <table id="tabela">
        <tbody>
            <tr class="odd gradeX" id="dados1">
                <td class="id" id="id" contenteditable="true" style="width: 10px">123</td>
                <td class="id" id="firstname" contenteditable="true" style="width: 10px">99</td>
                <td id="lastname" contenteditable="true" style="width: 10px">TESTE</td>
                <td id="estado" contenteditable="true" style="width: 10px">1</td>
                <td style="width: 10px">
                    <form method="put" id="formEdita" action="">
                        <input type="submit" id="editaUser" class="btn btn-default btn-xs" value="Editar">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
		<!--================================================== -->		
		<?php include "script_global.php";?>
		<?php include "script.php";?>
		<?php include "script_portaria.php";?>
		<?php include "script_gerenciamento.php";?>
		<!-- SmartChat UI : plugin -->
		<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>
		
		<script type="text/javascript" src="script_torre.js"></script>
		<!--script type="text/javascript" src="script.js"></script-->
		<script type="text/javascript" src="script_empresa.js"></script>
		<script type="text/javascript" src="script_report.js"></script>
		<script type="text/javascript" src="script_qualidade.js"></script>
		<!--script type="text/javascript" src="script_acessos.js"></script-->
		<script type="text/javascript" src="jquery.table2excel.js"></script>
		<!-- ChartJs Dependencies -->
	    <!-- Morris Chart Dependencies -->
		<script src="js/plugin/morris/raphael.min.js"></script>
		<script src="js/plugin/morris/morris.min.js"></script>
		<!--script src="js/plugin/chartjs/chart.min.js"></script-->
		<!--script src="chart.js"></script-->
		
		<script src="js/plugin/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
		
	</body>
</html>