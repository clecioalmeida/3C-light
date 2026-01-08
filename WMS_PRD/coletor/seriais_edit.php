<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'xhr/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

if (isset($_GET['id_col'])) {

    $id_col = $_GET['id_col'];

    $sql_ped = "SELECT id as id_col, ds_data, nm_fornecedor, fl_status, usr_create, dt_create
    from tb_nserie_col
    where fl_status = 'A'
    order by ds_data desc";
    $res_ped = mysqli_query($link, $sql_ped);
    $dados_col = mysqli_fetch_assoc($res_ped);
    $nm_fornecedor  = $dados_col['nm_fornecedor'];

    $sql_count = "SELECT COUNT(id) as id_count from tb_nserie where fl_status = 'A' and id_col = '$id_col'";
    $res_count = mysqli_query($link, $sql_count);
    $dados_count = mysqli_fetch_assoc($res_count);

    $sql_ped = "SELECT n_serie, dt_create from tb_nserie where fl_status = 'A' and id_col = '$id_col'";
    $res_ped = mysqli_query($link, $sql_ped);

}else{

    $sql_count = "SELECT COUNT(id) as id_count from tb_nserie where fl_status = 'A' and fl_empresa = '$cod_cli'";
    $res_count = mysqli_query($link, $sql_count);
    $dados_count = mysqli_fetch_assoc($res_count);

    $sql_ped = "SELECT n_serie, dt_create from tb_nserie where fl_status = 'A' and fl_empresa = '$cod_cli'";
    $res_ped = mysqli_query($link, $sql_ped);

    $nm_fornecedor  = "";
    $id_col         = "0";
    
}
$link->close();

?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
    <div data-role="header" class="jqm-header" style="height: 50px">
        <h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
        <a href="seriais.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
        <a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
    </div>
    <div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
        <div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
            <header>
                <h4>CADASTRAR NÚMEROS DE SÉRIE</h4>
                <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                <span id="retRec"></span>
            </header>
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <form id="" method="" action="">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>FORNECEDOR:</label>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="nm_for" name="nm_for" class="form-control" value="<?php echo $nm_fornecedor; ?>">
                                    </div>
                                </div>
                                <label id="retNmPrdMed">PALLET:</label>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="nr_pallet" name="nr_pallet" class="form-control" value="" style="text-align: right;">
                                    </div>
                                </div>
                                <label id="retNmPrdMed">PRODUTO:</label>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="cod_prd_med" name="cod_prd_med" class="form-control" value="" style="text-align: right;">
                                    </div>
                                </div>
                                <label>NÚMERO DE SÉRIE:</label>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="n_serie_med" name="n_serie_med" class="form-control" value="" style="text-align: right;">
                                        <input type="hidden" id="id_col" name="id_col" class="form-control" value="<?= $id_col ?>">
                                    </div>
                                </div>
                                <!--button class="btn btn-primary" type="button" id="btnSaveSerialLight">SALVAR</button-->
                                <!--button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinColetaSerial" value="" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">FINALIZAR</button-->
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row" id="retFinRecDtl">
                        <div>
                            <p>
                                <strong>Qtde de seriais coletados: </strong><span style="background-color:#16a085;color:white;padding:5px" id="retTotalCol"><?= $dados_count['id_count'] ?></span>
                            </p>
                        </div>
                        <table data-role="table" id="" data-mode="" class="table" style="font-size: 10px;">
                            <thead>
                                <tr>
                                    <th data-priority="1">Número de série</th>
                                    <th data-priority="2">Data</th>
                                    <th style="width:50%;text-align:center;">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="list_serial">
                                <?php while ($dados = mysqli_fetch_assoc($res_ped)) { ?>
                                    <tr style='background-color: #98FB98'>
                                        <td>N.série: <?php echo $dados['n_serie']; ?></td>
                                        <td>Data: <?php echo $dados['dt_create']; ?></td>
                                        <td style='text-align:center'><button data-role="none" value="<?php echo $dados['n_serie']; ?>" id='btnDelSerialLight'>EXCLUIR</button></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>

<!-- ================== BEGIN custom-js ================== -->
<!-- ================== END custom-js ================== -->
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#btnLogoutHome', function() {
            event.preventDefault();
            $.ajax({
                url: "logout.php",
                method: "GET",
                success: function(j) {
                    alert("Saída realizada com sucesso!");
                    window.location.replace("index.php");
                }
            });
        });
    });
</script>