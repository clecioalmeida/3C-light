<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('c');
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id         = $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_galpao="select t1.id, t1.nome 
from tb_armazem t1
where t1.id_oper = '$cod_cli'";
$galpao = mysqli_query($link,$sql_galpao);

$sql_galpao2 = "select t1.id, t1.nome 
from tb_armazem t1
where t1.id_oper = '$cod_cli'";
$galpao2 = mysqli_query($link,$sql_galpao2);

$sql_galpao3 = "select t1.id, t1.nome 
from tb_armazem t1
where t1.id_oper = '$cod_cli'";
$galpao3 = mysqli_query($link,$sql_galpao3);

$sql_galpao4 = "select t1.id, t1.nome 
from tb_armazem t1
where t1.id_oper = '$cod_cli'";
$galpao4 = mysqli_query($link,$sql_galpao4);

$sql_galpao_tipo = "SELECT t1.id, t1.nome 
from tb_armazem t1
where t1.id_oper = '$cod_cli'";
$res_galpao_tipo = mysqli_query($link, $sql_galpao_tipo);

$link->close();
?>
<div id="main" role="main">
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
						<div>
							<div class="widget-body">
								<hr class="simple">
								<ul id="myTab1" class="nav nav-tabs bordered">
									<li class="active">
										<a href="#s6" id="liPesqGeral" data-toggle="tab">CONSULTA GERAL <span class="badge bg-color-blue txt-color-white"></span></a>
									</li>
                                    <!--li>
                                        <a href="#s1" id="liRecPend" data-toggle="tab">OR ABERTA </a>
                                    </li-->
                                    <li>
                                    	<a href="#s3" id="liPesqEst" data-toggle="tab">CONSULTA POR PRODUTO</a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="liPesqEst" data-toggle="tab">CONSULTA POR ENDEREÇO</a>
                                    </li>
                                    <li>
                                        <a href="#s8" id="liPesqTipo" data-toggle="tab">CONSULTA POR TIPO</a>
                                    </li>
                                    <li>
                                    	<a href="#s2" id="liRot" data-toggle="tab">CONSULTA POR ROTATIVIDADE</a>
                                    </li>
                                    <li>
                                        <a href="#s7" id="liBlq" data-toggle="tab">PRODUTOS BLOQUEADOS</a>
                                    </li>
                                    <li>
                                    	<a href="#s4" id="liNf" data-toggle="tab">HISTÓRICO POR PRODUTO</a>
                                    </li>
                                    <li>
                                    	<a href="#s5" id="liPrdEtq" data-toggle="tab">ETIQUETAS</a>
                                    </li>
                                    <li>
                                    	<a href="#s9" id="liPrdEtqTrafo" data-toggle="tab"> TRANSFORMADORES</a>
                                    </li>
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                	<div class="tab-pane fade in active" id="s6">
                                		<article>
                                			<div>
                                				<form class="form-inline" method="POST" id="formConsultaEstoqueGeral" action="">
                                					<div class="form-group">
                                						<select class="form-control" id="local" name="local">
                                							<option value="0">Selecione o local</option>
                                							<?php
                                							while($linha = mysqli_fetch_assoc($galpao)){?>
                                								<option value="<?php echo $linha['id']; ?>"><?php echo $linha['nome']; ?></option>
                                							<?php }?>
                                						</select>
                                						<input type="submit" class="form-control btn-info" id="btnPesqEstGeral" value="PESQUISAR">
                                						<input type="submit" class="form-control btn-success" id="btnPesqEstGeralGeral" value="CONSULTA GERAL">
                                					</div>
                                				</form>
                                			</div>
                                		</article>
                                		<article>
                                			<div id="retornoEstGer"></div>
                                			<div id="retRomaneio"></div>
                                			<div id="retModal"></div>
                                		</article>
                                	</div>
                                	<div class="tab-pane fade" id="s3">
                                		<article>
                                			<div>
                                				<form class="form-inline" method="POST" id="formConsultaEstoque" action="">
                                					<div class="form-group">
                                						<input type="text" id="cod_prod_est" name="cod_prod_est" class="form-control" aria-describedby="basic-addon2" placeholder="Digite nome ou código SAP">
                                						<input type="submit" class="form-control btn-info" id="btnPesqEst" value="PESQUISAR">
                                					</div>
                                				</form>
                                			</div>
                                		</article>
                                		<article id="retornoEst">
                                			<div id="retornoAg"></div>
                                			<div id="retModalAg"></div>
                                		</article>
                                	</div>
                                    <div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-inline" method="POST" id="formConsultaEstoqueEnd" action="">
                                                    <div class="form-group">
                                                        <select class="form-control" id="id_galpao" name="id_galpao">
                                                            <option value="0">Selecione o local</option>
                                                            <?php while($linha3 = mysqli_fetch_assoc($galpao3)){?>
                                                                <option value="<?php echo $linha3['id']; ?>"><?php echo $linha3['nome']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <select class="form-control" id="id_rua_ini" name="id_rua_ini">
                                                            <option value="0">Selecione rua de início</option>
                                                        </select>
                                                        <select class="form-control" id="id_rua_fim" name="id_rua_fim">
                                                            <option value="0">Selecione rua de término</option>
                                                        </select>
                                                        <input type="submit" class="form-control btn-info" id="btnPesqEstEnd" value="PESQUISAR">
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="retornoEnd">
                                            <div id="retornoAgEnd"></div>
                                            <div id="retModalEnd"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s8">
                                        <article>
                                            <div>
                                                <form class="form-inline" method="POST" id="formConsultaEstoqueTipo" action="">
                                                    <div class="form-group">
                                                        <select class="form-control" id="id_galpao" name="id_galpao">
                                                            <option value="0">Selecione o local</option>
                                                            <?php while($linha3 = mysqli_fetch_assoc($galpao3)){?>
                                                                <option value="<?php echo $linha3['id']; ?>"><?php echo $linha3['nome']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <input type="submit" class="form-control btn-info" id="btnPesqEstEnd" value="PESQUISAR">
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="retornoEnd">
                                            <div id="retornoAgEnd"></div>
                                            <div id="retModalEnd"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s2">
                                        <article>
                                            <div>
                                                <form class="form-inline" method="POST" id="formConsRot" action="">
                                                    <div class="form-group">
                                                        <input type="submit" class="form-control btn-info" id="btnPesqEstRot" value="PESQUISAR">
                                                        <input type="submit" class="form-control btn-primary" id="btnGeraInvRot" value="GERAR INVENTÁRIO" disabled="true">
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="retornoEstRot">
                                            <div id="retornoAgRot"></div>
                                            <div id="retModalAgRot"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s4">
                                        <article>
                                            <div>
                                                <form method="POST" class="form-inline" id="formListHistProd" action="">
                                                    <div class="form-group">
                                                        <input type="btn" class="form-control" aria-describedby="basic-addon2" name="histProd" id="histProd" placeholder="Digite o código SAP do produto" style="text-align: right;">
                                                        <input type="button" class="btn-info form-control" id="btnFormHistPrd" value="Pesquisar">
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                             <div id="retornoHist"></div>
                                             <div id="retRomaneio"></div>
                                             <div id="retModal"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s5">
                                        <article>
                                            <div>
                                                <form class="form-inline" method="POST" id="formConsultaEstoqueEtq" action="">
                                                    <div class="form-group">
                                                        <select class="form-control" id="local" name="local">
                                                            <option value="0">Selecione o local</option>
                                                            <?php while($linha2 = mysqli_fetch_assoc($galpao2)){?>
                                                                <option value="<?php echo $linha2['id']; ?>"><?php echo $linha2['nome']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <input type="submit" class="form-control btn-info" id="btnPesqEstGeralEtq" value="Pesquisar">
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="responseEtq" style="display: none"></div>  
                                            <div id="retornoEtq"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s7">
                                        <article>
                                            <div>
                                                <form class="form-inline" method="POST" id="formConsultaEstoqueBlq" action="">
                                                    <div class="form-group">
                                                        <input type="submit" class="form-control btn-success" id="btnPesqEstBlqGeral" value="CONSULTA BLOQUEADOS">
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoBlqGer"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s9">
                                        <article>
                                            <div>
                                                <form class="form-inline" method="POST" id="formConsultaEstoqueEtqTrafo" action="">
                                                    <div class="form-group">
                                                        <select class="form-control" id="localTrafo" name="localTrafo">
                                                            <option value="0">Selecione o local</option>
                                                            <?php while($linha4 = mysqli_fetch_assoc($galpao4)){?>
                                                                <option value="<?php echo $linha4['id']; ?>"><?php echo $linha4['nome']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <input type="submit" class="form-control btn-info" id="btnPesqEstGeralEtqTrafo" value="Pesquisar">
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="responseEtqTrafo" style="display: none"></div>  
                                            <div id="retornoEtqTrafo"></div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="row">
               <div id="retModalEntrega">
               </div>
            </div>
        </section>
    </div>
    <div id="retNfTransp"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){		

		$(document).on('click','#btnPesqEstRot',function(e) {
			event.preventDefault();
			$.ajax
			({  
				url:"data/armazem/locais_list_rotativo.php",  
				method:"POST",
				beforeSend:function(e){
					$("#retornoEstRot").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},  
				success:function(data)
				{

					$('#retornoEstRot').html(data);
					$('#btnGeraInvRot').prop("disabled", false);
				}  
			});         
			return false;
		});

	});
</script>
<script type="text/javascript">
	$(document).ready(function(){		

		$(document).on('click','#btnGeraInvRot',function(e) {
			event.preventDefault();

			var val = [];

			$('.checkPrdRot:checked').each(function(){
				val.push($(this).val());

			});

			$.ajax
			({  
				url:"data/armazem/locais_gera_inv.php",  
				method:"POST",
				data:{
					cod_prd :val
				},
				beforeSend:function(e){
					$("#retornoEstRot").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
				},  
				success:function(data)
				{
					$('#retornoEstRot').html(data);
					$('#btnGeraInvRot').prop("disabled", false);
				}  
			});         
			return false;
		});

	});
</script>
<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('change', '#id_galpao', function(){
            $.getJSON('data/armazem/consulta_rua.php', 
            {
                id_galpao: $(this).val(),
                ajax: 'true'
            }, 
            function(j){
                var options = '<option value="">Escolha a rua de início</option>'; 
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
                }
                $('#id_rua_ini').html(options).append();
            });
        });

        $(document).on('change', '#id_rua_ini', function(){
            $.getJSON('data/armazem/consulta_rua.php', 
            {
                id_galpao: $('#id_galpao').val(),
                ajax: 'true'
            }, 
            function(j){
                var options = '<option value="">Escolha a rua de término</option>'; 
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
                }
                $('#id_rua_fim').html(options).append();
            });
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function(){       

        $(document).on('click','#btnPesqEstEnd',function(e) {

            var id_galpao   = $('#id_galpao').val();
            var id_rua_ini  = $('#id_rua_ini').val();
            var id_rua_fim  = $('#id_rua_fim').val();

            event.preventDefault();
            $.ajax
            ({  
                url:"data/armazem/locais_list_endereco.php",  
                method:"POST",
                data:{
                    id_galpao   :id_galpao,
                    id_rua_ini  :id_rua_ini,
                    id_rua_fim  :id_rua_fim

                },
                beforeSend:function(e){
                    $("#retornoEnd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                },  
                success:function(data)
                {

                    $('#retornoEnd').html(data);
                }  
            });         
            return false;
        });

    });
</script>
<script type="text/javascript"> 
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basic = undefined;
		var responsiveHelper_datatable_fixed_column = undefined;
		var responsiveHelper_datatable_col_reorder = undefined;
		var responsiveHelper_datatable_tabletools = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"oLanguage": {
				"sSearch": '<!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});
		var otable = $('#datatable_fixed_column').DataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
			"preDrawCallback" : function() {
				if (!responsiveHelper_datatable_fixed_column) {
					responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_fixed_column.respond();
			}       

		});
		$("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {

			otable
			.column( $(this).parent().index()+':visible' )
			.search( this.value )
			.draw();

		} );
	});

</script>