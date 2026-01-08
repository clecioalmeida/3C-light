<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION['cod_cli'];
}
?>
<?php
require_once "bd_class.php";

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_tp = "select cod_galpao, galpao from tb_galpao where fl_empresa = '$cod_cli'";
$res_tp = mysqli_query($link, $sql_tp);

$link->close();
?>
<div class="widget-body">
    <hr class="simple">
    <ul id="myTab1" class="nav nav-tabs bordered">
        <li class="active">
            <a href="#s6" id="liRecAg" data-toggle="tab">PENDENTES <span class="badge bg-color-blue txt-color-white"></span></a>
        </li>
    </ul>
    <div id="myTabContent1" class="tab-content padding-10">
        <div class="tab-pane fade in active" id="s6">
            <article>
                <div>
                    <form class="form-horizontal" method="post" action="" id="">
                        <label class="input">PERÍODO DE:
                            <input type="date" class="input-xs" id="dt_ini_div" name="dt_ini_div" style="color: black">
                        </label>
                        <label class="input">ATÉ:
                            <input type="date" class="input-xs" id="dt_fim_div" name="dt_fim_div" style="color: black">
                        </label>
                        <button type="submit" id="btnPesqNfDt" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                        <span> | </span>
                        <button type="submit" id="btnInsDivNf" class="btn btn-info btn-xs" style="margin-right: 3px;width: 200px">CADASTRAR DIVERGÊNCIA</button>
                        <button type="submit" id="btnInsNFDiv" class="btn btn-info btn-xs" style="margin-right: 3px;width: 200px">CADASTRAR NOTA FISCAL</button>
                    </form>
                </div>
            </article>
            <article id="loading">
                <div id="retornoNfPend"></div>
                <div id="retModalNfPend"></div>
            </article>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){        

        $('#retornoNfPend').load('data/recebimento/list_nf_rec_pend.php');
        
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
    });
</script>
<script type="text/javascript"> 
    $(document).ready(function() {
    });

</script>