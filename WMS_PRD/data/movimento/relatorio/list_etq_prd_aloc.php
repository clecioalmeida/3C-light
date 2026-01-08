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

$cod_estoque    = $_GET['cod_estoque'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.cod_estoque, t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t2.cod_prod_cliente, t3.ds_apelido, t2.nm_produto 
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.cod_estoque = '$cod_estoque'";
$qtde = mysqli_query($link,$query_qtde);

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

$resolution = array(100, 51);

$pdf->AddPage('L', $resolution);

$pdf->SetFont('helvetica', '', 12);

$style = array(

    'position'      => 'C',
    'align'         => 'C',
    'stretch'       => false,
    'fitwidth'      => true,
    'cellfitalign'  => '',
    'border'        => false,
    'hpadding'      => 'auto',
    'vpadding'      => 'auto',
    'fgcolor'       => array(0,0,0),
    'bgcolor'       => false,
    'text'          => true,
    'font'          => 'helvetica',
    'fontsize'      => 10,
    'stretchtext'   => 4
);

$linha = mysqli_fetch_array($qtde);
$produto        = $linha['produto'];
$cod_estoque    = $linha['cod_estoque'];
$nm_produto     = substr($linha['nm_produto'], 0, 20);

$txt = $nm_produto;
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

$pdf->write1DBarcode($produto."-".$cod_estoque, 'C128', '', '', '', 34, 1, $style, 'N');

$pdf->Ln();

$pdf->Output('barcode.pdf', 'I');

$link->close();
?>