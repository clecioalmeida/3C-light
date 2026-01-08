<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id         = $_SESSION["id"];
    $cod_cli     = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if (isset($_POST['nr_serial'])) {

    $nr_serial     = $_POST['nr_serial'];

    $upd = "UPDATE tb_nserie set fl_status = 'E' where n_serie = '$nr_serial'";
    $res_upd = mysqli_query($link, $upd);

    if (mysqli_affected_rows($link) > 0) {
        
        $sql_conf = "SELECT count(id) as conf 
        from tb_nserie
        where fl_status = 'A' and fl_empresa = '$cod_cli'";
        $res_conf = mysqli_query($link, $sql_conf);
        $dados_conf = mysqli_fetch_assoc($res_conf);
        $saldo 	= $dados_conf['conf'];

        $retorno = array(
            'info'		=> "0",
            'text' 		=> "<tr style='background-color: #FF7F50'>
            <td>N.série: ".$nr_serial."</td><td>Data: ".$date."</td>
            <td style='text-align:center'>EXCLUÍDO</td>
            </tr>",
            'conf' 		=> "Coletado: ".$saldo,
        );

    }else{

        $retorno = array(
            'text' => "<p style='background-color: #FF7F50'>Erro na exclusão do número de série no pedido.</p>",
        );
    }

}else{

    $retorno = array(
        'info'        => "2",
        'info' => "<h3 style='background-color:#FF7F50'>Favor informar o número de série!</h3>",
    );
}

echo (json_encode($retorno));

$link->close();
?>