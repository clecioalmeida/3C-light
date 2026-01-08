<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;
} else {

	$id 			= $_SESSION["id"];
	$cod_cli 		= $_SESSION["cod_cli"];
	$nm_fantasia 	= $_SESSION["ds_oper"];
}

?>
<div id="logo-group">
	<span id="logo"> <img src="img/logo12.png" alt="ARGUS" style="width: 70%; height: 83%; margin-top: -5px;margin-left: 15px"> </span>
</div>
<div class="pull-right">
	<div id="logout" class="btn-header transparent pull-right">
		<span> <a href="logout.php" title="Logout" data-action="userLogout" data-logout-msg="Você pode também fechar o navegador para sair do sistema!"><i class="fa fa-sign-out"></i></a> </span>
	</div>
	<div id="fullscreen" class="btn-header transparent pull-right">
		<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Tela cheia"><i class="fa fa-arrows-alt"></i></a> </span>
	</div>
	<div id="home" class="btn-header transparent pull-right">
		<span> <a href="home.php" title="Início"><i class="fa fa-home"></i></a> </span>
	</div>
	<ul class="header-dropdown-list hidden-xs">
		<li>
			<h3 style="color: white;margin-right: 20px;margin-top: 10px; margin-left: 20px;font-size:14px">ARGUS - GESTÃO DE ARMAZÉNS E CONTROLE DE ESTOQUE</h3>
		</li>
		<li>
			<h3 style="color: white;margin-right: 20px;margin-top: 10px;background-color: red;font-size:14px">BASE DE PRODUÇÃO: <?php echo $nm_fantasia; ?></h3>
		</li>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="img/blank.gif" class="flag flag-br" alt="Brasil"> <span> Português (BR) </span> <i class="fa fa-angle-down"></i> </a>
		</li>
	</ul>

</div>