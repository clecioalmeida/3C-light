<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$listOnda = $_POST['listOnda'];

$sql = "select * from tb_onda where fl_status <> 'E'";
$query = mysqli_query($link, $sql);
//$coleta = mysqli_num_rows($query);

$hoje = date('d/m/Y');
$cor1 = '#FF6347';
$cor2 = '#9AFF9A';
$cor3 = '#FFFF00';
$link->close();
?>
<?php
if ($query) {
	?>

<br /><br />

<style type="text/css">
    .ocupado {
        background-color: #F08080;
    }

    .livre {
        background-color: #7FFFD4;
    }

    .alerta {
        background-color: #EEDD82;
    }

    .finalizado {
        background-color: #ADD8E6;
    }
</style>
<section id="widget-grid" class="">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <fieldset id="printOnda">
            <div class="row">
                <article class="col-md-4">
                    <fieldset>
                        <div class="widget-body no-padding">
                            <table id="datatable_tabletools" class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr style="background-color: #8DB6CD">
                                        <th> Código</th>
                                        <th> Data</th>
                                        <th> Início </th>
                                        <th> Status </th>
                                        <th style="text-align: center"> # </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
while ($dados = mysqli_fetch_assoc($query)) {
		?>
                                    <tr class="odd gradeX">
                                        <td style="text-align: center"><?php echo $dados['id']; ?></td>
                                        <td style="text-align: right;"><?php echo date("d-m-Y", strtotime($dados['dt_create'])); ?></td>
                                        <td style="text-align: right;">
                                            <?php
if ($dados['dt_inicio'] != "") {

			echo date("d-m-Y", strtotime($dados['dt_inicio']));

		} else {

			echo "";

		}

		?>
                                         </td>
                                        <td style="text-align: right;width: 100px"></td>

                    <!--td class="progresso" style="font-size: x-small;text-align: right;"><span class="percent"><?php echo number_format($percent, 2, ',', ' '); ?>%</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-color-greenLight" style="width: <?php echo ($linha['tot_conf'] / $linha['tot_qtd']) * 100; ?>%"></div>
                        </div>
                    </td-->
                                        <td style="text-align: center;width: 90px">
                                            <button type="submit" class="btn btn-primary btn-xs consulta_onda" id="btnConsDtlOnda" value="<?php echo $dados['id']; ?>" style="width: 80px">Consultar</button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </article>
                <article><div class="col-md-1"></div></article>
                <article class="col-md-7">
                    <fieldset>
                        <div class="row">
                            <fieldset>
                                <div id="aguarde"></div>
                                <div class="widget-body no-padding">
                                    <table id="datatable_tabletools" class="table table-striped table-bordered table-hover table-responsive" style="width: 800px;text-align: right;">
                                        <thead>
                                            <tr style="background-color: #8DB6CD">
                                                <th> Código</th>
                                                <th> Galpão </th>
                                                <th> Rua </th>
                                                <th> Qtde </th>
                                                <th style="text-align: center"> # </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tarefasOnda">

                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </fieldset>
                </article>
            </div>
        </fieldset>
    </div>
</section>
<div id="infoTarefasDia" class="row"></div>
<?php } else {?>
    <h4>Não há ondas ativas.</h4>
<?php }
?>
<script type="text/javascript">
    $(document).ready(function(){
        var status_ = new Array();
        $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "C"){
                $this.addClass('ocupado');
            }else if(status_[i] == "M"){
                $this.removeClass('ocupado').addClass('alerta');
            }else if(status_[i] == "F"){
                $this.removeClass('ocupado').addClass('livre');
            }else if (status_[i] == "P"){
                $this.removeClass('ocupado').addClass('finalizado');
            }
        });
        //console.log(status_);
    });
</script>