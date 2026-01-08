<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../../index.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $id_oper    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_qtde    = $_POST['nr_qtde'];
$id_tar     = $_POST['id_tar'];

$sql_etq="select id 
from tb_etiqueta
where id_tar = '$id_tar'";
$etq = mysqli_query($link,$sql_etq);

if(mysqli_num_rows($etq) > 0){

    $query_qtde="select t1.cod_prod_cliente, t1.nm_produto 
    from tb_produto t1
    left join tb_inv_tarefa t2 on t1.cod_produto = t2.id_produto
    where t2.id = '$id_tar'";
    $qtde = mysqli_query($link,$query_qtde);
    $linha=mysqli_fetch_array($qtde);
    $produto        = $linha['cod_prod_cliente'];
    $nm_produto     = substr($linha['nm_produto'], 0, 20);

}else{

    $query_qtde="select t1.cod_produto, t1.cod_prod_cliente, t1.nm_produto 
    from tb_produto t1
    left join tb_inv_tarefa t2 on t1.cod_produto = t2.id_produto
    where t2.id = '$id_tar'";
    $qtde = mysqli_query($link,$query_qtde);
    $linha=mysqli_fetch_array($qtde);
    $cod_produto    = $linha['cod_produto'];
    $produto        = $linha['cod_prod_cliente'];
    $nm_produto     = substr($linha['nm_produto'], 0, 20);

    for ($i = 1; $i <= $nr_qtde; $i++) {

        $cod_etq =  uniqid();

        $ins_etq="insert into tb_etiqueta (cod_item, id_tar, nr_seq, fl_status, cod_etq, usr_create, dt_create) values ('$cod_produto', '$id_tar', '$i', 'A', '$cod_etq', '$id', '$date')";
        $etq = mysqli_query($link,$ins_etq);

    }

    if($etq_ins){

        $query_qtde="select DISTINCT t1.id, t1.nr_docto, t1.cod_item, t1.nr_seq, t3.nr_fisc_ent, t4.cod_prod_cliente, t4.nm_produto
        from tb_etiqueta t1
        left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
        where t1.id_tar = '$id_tar' and t1.fl_status <> 'E'
        group by t1.id";
        $qtde = mysqli_query($link,$query_qtde);
        $linha=mysqli_fetch_array($qtde);
        $produto        = $linha['cod_prod_cliente'];
        $cod_etq        = $linha['id'];
        $nm_produto     = substr($linha['nm_produto'], 0, 20);

    }

}

require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(false, false, "teste", false);

$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);

$pdf->SetMargins(3, 3, 3, 3);

$pdf->SetAutoPageBreak(TRUE, 5);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$resolution= array(100, 51);

$pdf->AddPage('L', $resolution);

$pdf->SetFont('helvetica', '', 12);

$style = array(
    'position' => 'C',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false,
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 10,
    'stretchtext' => 4
);

for ($i = 0; $i < $nr_qtde; $i++) {

    $txt = $nm_produto;
    $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
    
    $pdf->write1DBarcode($produto."-".$cod_etq, 'C128', '', '', '', 34, 1, $style, 'N');

   $pdf->Ln();

}
$pdf->Output('barcode.pdf', 'I');

$link->close();
?>