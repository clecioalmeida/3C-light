<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$galpao     = $_GET['galpao'];
$rua        = $_GET['rua'];
$coluna     = $_GET['coluna'];
$altura     = $_GET['altura'];
$id         = $_GET['id'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.id, t1.galpao, t1.rua, t1.coluna, t1.altura, t2.nome, t2.ds_apelido
from tb_endereco t1
left join tb_armazem t2 on t1.galpao = t2.id
where t1.galpao = '$galpao' and t1.rua = '$rua' and t1.coluna = '$coluna' and t1.altura = '$altura'";
$qtde = mysqli_query($link,$query_qtde);
while ($linha=mysqli_fetch_array($qtde)) 
{
   $id            = $linha['id'];
   $galpao         = $linha['galpao'];
   $rua            = $linha['rua'];
   $coluna         = $linha['coluna'];
   $altura         = $linha['altura'];
   $nome           = $linha['nome'];
   $ds_apelido     = $linha['ds_apelido'];
}


// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$layout = array(100,50);
//$pdf = new TCPDF('L', 'mm', $layout, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(false, false, $nome, false);

// set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', '', 8));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(1, 1, 1, 1);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set a barcode on the page footer
//$pdf->setBarcode(date('Y-m-d H:i:s'));

// set font
//$pdf->SetFont('helvetica', '', 11);
//$pdf->SetY(100);

$resolution= array(100, 50);

// add a page
$pdf->AddPage('L', $layout);

// -----------------------------------------------------------------------------

$pdf->SetFont('helvetica', '', 22);

// define barcode style
$style = array(
    'position' => 'C',
    'align' => 'C',
    'stretch' => true,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',
    'fontsize' => 10,
    'stretchtext' => 5
);

// PRINT VARIOUS 1D BARCODES

// CODE 128 AUTO
$txt = $nome;
$pdf->Write(0, $ds_apelido.$rua.$altura.$coluna, '', 0, 'C', true, 0, false, false, 0);
//$pdf->Cell(0, 0, "teste", 0, 1);
$pdf->write1DBarcode($ds_apelido.$rua.$altura.$coluna, 'C128', '', '', '', 34, 1, $style, 'N');

$pdf->Ln();

//Close and output PDF document
$pdf->Output('barcode.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+