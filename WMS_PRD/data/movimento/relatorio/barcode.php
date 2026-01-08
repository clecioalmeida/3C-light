<?php
include 'barcode128.php';
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = array('10000017','10000158','10000168');
$html = "";
foreach ($cod_produto as $value) {
    $code = bar128(stripcslashes($value));
    $html .= <<<EOD
    <center><div style="height: 30%; width: 50%;">
    <center><div style="height: 30%; width: 50%;">$code</p></div></center></div>
    EOD;

	//$html .= '<center><div style="height: 30%; width: 50%;">
	//<center><div style="height: 30%; width: 50%;">'.bar128(stripcslashes($value)).'</p></div></center></div>';

}
//echo $html;
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetFont('times', 'A4', 11);
$pdf->addPage();

$pdf->writeHTML($html, false, false, true, false, '');

$html = ob_get_contents();
ob_end_clean();   
$pdf->Output('years.pdf', 'I');
?>