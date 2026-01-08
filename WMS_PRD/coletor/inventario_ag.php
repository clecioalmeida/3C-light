<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$cod_cli=$_SESSION["cod_cli"];
}
?>
<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['nr_pedido'])) {

	$nr_pedido = $_POST['nr_pedido'];

} else {

	$nr_pedido = $_GET['cod_ped'];

}

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_inv1 = "select t1.id, t1.id_inv, t1.id_estoque, t2.produto, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t3.nome
from tb_inv_tarefa t1
left join tb_posicao_pallet t2 on t1.id_estoque = t2.cod_estoque
left join tb_armazem t3 on t2.ds_galpao = t3.id
where t1.fl_status = 'A' and t2.fl_status = 'A'";
$res_inv1 = mysqli_query($link, $sql_inv1);

$sql_inv2 = "select id, date_format(dt_inicio, '%d/%m/%Y') as dt_inicio, CASE ds_tipo WHEN 'I' THEN 'ABERTURA' WHEN 'R' THEN 'ROTATIVO' WHEN 'A' THEN 'ANUAL' END as ds_tipo, id_rua_inicio, id_rua_fim, id_coluna_inicio, id_coluna_fim, id_altura_inicio, id_altura_fim
from tb_inv_prog
where fl_status = 'P' and fl_empresa = '$cod_cli'";
$res_inv2 = mysqli_query($link, $sql_inv2);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="inventario.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>Selecione o inventário</h4>
						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>
					<div role="content">
						<div class="jarviswidget-editbox">
						</div>
							<div class="widget-body">
								<fieldset>
									<form method="post" action="inv_ag_pri.php">
										<div class="form-group">
											<select class="form-control" name="id_tarefa" id="id_tarefa">
									            <?php 
									                       
									            while ($dados1=mysqli_fetch_assoc($res_inv1)) {?>
									                        
									            <option value="<?php echo $dados1['id']; ?>"><?php echo "Código:".$dados1['produto']." Estoq. ".$dados1['id_estoque']." - ".$dados1['nome']." Rua: ".$dados1['ds_prateleira']." Col: ".$dados1['ds_coluna']." Alt: ".$dados1['ds_altura']; ?></option>
									            <?php } ?>
									        </select>
										</div>
										<div class="form-actions">
											<div>
												<button type="submit" class="btn btn-primary">INICIAR CONTAGEM</button>
											</div>
										</div>
									</form>
								</fieldset>
								<!--fieldset>
									<form method="post" action="inv_ag_sec.php">
										<div class="form-group">
											<select class="form-control" name="nr_inventario2" id="cod_recebimento2">
									            <?php 
									                       
									            while ($dados2=mysqli_fetch_assoc($res_inv2)) {?>
									                        
									            <option value="<?php echo $dados2['id']; ?>"><?php echo $dados2['dt_inicio']." Rua de: ".$dados2['id_rua_inicio']." Até: ".$dados2['id_rua_fim']." Coluna de: ".$dados2['id_coluna_inicio']." Até: ".$dados2['id_coluna_fim']." Altura de: ".$dados2['id_altura_inicio']." Até: ".$dados2['id_altura_fim']; ?></option>
									            <?php } ?>
									        </select>
										</div>
										<div class="form-actions">
											<div>
												<button type="submit" class="btn btn-primary">Selecionar segunda contagem</button>
											</div>
										</div>
									</form>
								</fieldset-->
							</div>
					</div>
				</div>
			</article>
		</div>
		<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
			<p>Growup Soluções para logística</p>
			<p>Copyright 2018 - Growup</p>
		</div>
	</div>
</div>