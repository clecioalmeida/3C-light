<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id         = $_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "SELECT DISTINCT month(dt_fim_coleta) as mes, year(dt_fim_coleta) as ano FROM tb_pedido_coleta_produto WHERE fl_status = 'F' and dt_fim_coleta is not null";
$res = mysqli_query($link, $sql);

$link->close();
?>
<!--script src="js/recebimento.js"></script-->
<script src="js/ca.js"></script>
<script type="text/javascript" src="jquery.table2excel.js"></script>
<div id="main" role="main">
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
                        <div>
                            <div class="jarviswidget-editbox">

                            </div>
                            <div class="widget-body">
                                <hr class="simple">
                                <ul id="myTab1" class="nav nav-tabs bordered">
                                    <li class="active">
                                        <a href="#s6" id="liRecCa" data-toggle="tab">LAUDOS E CA <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="liRecPend" data-toggle="tab">RELATÓRIOS </a>
                                    </li>
                                    <!--li>
                                        <a href="#s2" id="liRecConf" data-toggle="tab">OR EM CONFERÊNCIA</a>
                                    </li>
                                    <li>
                                        <a href="#s3" id="liRecEnc" data-toggle="tab">OR FINALIZADA</a>
                                    </li>
                                    <li>
                                        <a href="#s4" id="liNf" data-toggle="tab">NOTAS FISCAIS</a>
                                    </li>
                                    <li>
                                        <a href="#s5" id="liPrd" data-toggle="tab">PRODUTOS</a>
                                    </li>
                                    <li>
                                        <a href="#s7" id="liAg" data-toggle="tab">JANELAS</a>
                                    </li>
                                    <li>
                                        <a href="#s8" id="lirep" data-toggle="tab">RELATÓRIOS</a>
                                    </li-->
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">MATRÍCULA
                                                        <input type="text" class="input-xs" id="nr_matr" name="nr_matr" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesqFunc" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">CA / LAUDO
                                                        <input type="text" class="input-xs" id="nr_docto" name="nr_docto" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesqDocto" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoCa"></div>
                                            <div id="retModalCa"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal form-inline" method="post" action="" id="">
                                                    <div class="form-group">
                                                        <select class="form-control" id="ds_data">
                                                            <option>Selecione o mês</option>
                                                            <?php
                                                            while ($dados_mes = mysqli_fetch_assoc($res)) {?>
                                                                <option value="<?php echo $dados_mes['mes']; ?>" data-ano="<?php echo $dados_mes['ano']; ?>"><?php echo $dados_mes['mes']."-".$dados_mes['ano']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <button type="submit" id="btnConsMesCons" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 200px">CONSULTA POR CONSULMO / R$</button>
                                                        <span> | </span>
                                                        <button type="submit" id="btnConsMesFunc" class="btn btn-info btn-xs" style="margin-right: 3px;width: 200px">CONSULTA POR FUNCIONÁRIO</button>
                                                        <span> | </span>
                                                        <label class="input">C.R.
                                                            <input type="text" class="input-xs" id="cr_cons" name="cr_cons" style="color: black">
                                                        </label>
                                                        <button type="submit" id="btnConsCrCons" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                        <!--button type="submit" class="btn btn-success" id="RepCaAlertEmitExcel" style="float:right;width: 100px">Excel</button-->
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoDash"></div>
                                            <div id="retRomaneio"></div>
                                            <div id="retModal"></div>
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

        $('#retornoCa').load('data/recebimento/list_ca.php');

        $('#liRecCa').on('click', function(){
            $('#retornoCa').load('data/recebimento/list_ca.php');
        });
    });
</script>
<script type="text/javascript">    
    $(document).on('click', '#RepCaAlertEmitExcel',function(){
        event.preventDefault();
        var today = new Date();
        $("#TbConsCaAlert").table2excel({
            name: "Relatório de alertas de vencimento",
            filename: "Relatório de alertas de vencimento"
        });
    });
</script>