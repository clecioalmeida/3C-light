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

require_once 'xhr/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec         = $_POST['cod_rec'];
$nm_fornecedor   = strtoupper($_POST['nm_fornecedor']);
$nr_nf           = $_POST['nr_nf'];
$cod_produto     = $_POST['cod_produto'];
$ds_vol          = $_POST['ds_vol'];
$nr_qtde         = $_POST['nr_qtde'];
$ds_obs          = strtoupper($_POST['ds_obs']);

$sql_parte = "select cod_nf_entrada, nr_fisc_ent, cod_rec from tb_nf_entrada where cod_rec = '$cod_rec' and nr_fisc_ent = '$nr_nf' and fl_status <> 'E'";
$res_parte = mysqli_query($link, $sql_parte);

if (mysqli_num_rows($res_parte) > 0) {

	$parte=mysqli_fetch_assoc($res_parte);
    $cod_nf_entrada = $parte['cod_nf_entrada'];

    $sql = "INSERT into tb_nf_entrada_item (
	cod_nf_entrada, cod_rec, fl_status, fl_imp, produto, nr_qtde, nr_volume, dt_rec, ds_obs
	) values (
		'$cod_nf_entrada', '$cod_rec', 'A', 'N', '$cod_produto', '$nr_qtde', '$ds_vol', '$date', '$ds_obs'
		)";
    $res_id = mysqli_query($link, $sql);
    $nRecPrd = mysqli_insert_id($link);

    $sql_conf = "select count(cod_nf_entrada_item) as conf 
    from tb_nf_entrada_item
    where fl_status <> 'E' and cod_rec = '$cod_rec'";
    $res_conf = mysqli_query($link, $sql_conf);
    $dados_conf = mysqli_fetch_assoc($res_conf);
    $saldo 	= $dados_conf['conf'];


    if (mysqli_affected_rows($link) > 0) {

        $retorno = array(
            'info'		=> "0",
            'text' 		=> "<tr style='background-color: #98FB98'>
            <td>".$cod_produto."</td><td".$date."</td><td>".$nr_qtde."</td>
            <td style='text-align:center'><button data-role='none' value='".$nRecPrd."' id='btnDelPrdRec'>EXCLUIR</button></td>
            </tr>",
            'conf' 		=> "Total Recebido: ".$saldo,
        );

        echo (json_encode($retorno));

    } else {

        $retorno = array(
            'info' => "1",
        );

        echo (json_encode($retorno));
    }

} else {

    $sql_nf = "INSERT into tb_nf_entrada (
	nr_fisc_ent, cod_rec, fl_status, usr_create, dt_create
	) values (
		'$nr_nf', '$cod_rec', 'A', '$id', '$date'
		)";
    $res_nf = mysqli_query($link, $sql_nf);
    $nRecNf = mysqli_insert_id($link);

    if (mysqli_affected_rows($link) > 0) {

        $sql = "INSERT into tb_nf_entrada_item (
        cod_nf_entrada, cod_rec, fl_status, fl_imp, produto, nr_qtde, nr_volume, dt_rec, ds_obs
        ) values (
            '$nRecNf', '$cod_rec', 'A', 'N', '$cod_produto', '$nr_qtde', '$ds_vol', '$date', '$ds_obs'
            )";
        $res_id = mysqli_query($link, $sql);

        if (mysqli_affected_rows($link) > 0) {
    
            $retorno = array(
                'info' => "0",
                'id_rec' => $nRec,
            );
    
            echo (json_encode($retorno));
    
        } else {
    
            $retorno = array(
                'info' => "1",
            );
    
            echo (json_encode($retorno));
        }

    } else {

        $retorno = array(
            'info' => "2",
        );

        echo (json_encode($retorno));
    }
}

$link->close();
