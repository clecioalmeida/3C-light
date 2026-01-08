<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$cod_produto = $_GET['cod_produto'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

//$query_qtde = "select t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t2.cod_prod_cliente, t3.ds_apelido
//from tb_posicao_pallet t1
//left join tb_produto t2 on t1.produto = t2.cod_produto
//left join tb_armazem t3 on t1.ds_galpao = t3.id
//where t1.ds_galpao = '$ds_galpao' and t1.ds_prateleira = '$id_rua' and t1.ds_coluna = '$id_coluna' and t1.ds_altura = '$id_altura' and t1.produto = '$cod_produto'
//group by t1.produto";
//$qtde = mysqli_query($link, $query_qtde);
//while ($linha = mysqli_fetch_array($qtde)) {
//	$sap = $linha['cod_prod_cliente'];
//	$produto = $linha['produto'];
//$nr_qtde = number_format($linha['qtde'], 0, ',', '.');
//	$ds_prateleira = $linha['ds_prateleira'];
//	$ds_coluna = $linha['ds_coluna'];
//	$ds_altura = $linha['ds_altura'];
//	$ds_apelido = $linha['ds_apelido'];
//}

// Include the main TCPDF library (search for installation path).
require_once 'tcpdf/tcpdf.php';

// create new PDF document
$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(false, false, $cod_produto, false);

// set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', '', 8));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, 5, 5, 5);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once dirname(__FILE__) . '/lang/eng.php';
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set a barcode on the page footer
//$pdf->setBarcode(date('Y-m-d H:i:s'));

// set font
$pdf->SetFont('helvetica', '', 11);

$resolution = array(60, 40);

// add a page
$pdf->AddPage('L', $resolution);

// -----------------------------------------------------------------------------

$pdf->SetFont('helvetica', '', 8);

// define barcode style
$style = array(
	'position' => 'C',
	'align' => 'C',
	'stretch' => false,
	'fitwidth' => true,
	'cellfitalign' => '',
	'border' => false,
	'hpadding' => 'auto',
	'vpadding' => 'auto',
	'fgcolor' => array(0, 0, 0),
	'bgcolor' => false, //array(255,255,255),
	'text' => true,
	'font' => 'helvetica',
	'fontsize' => 8,
	'stretchtext' => 4,
);

// PRINT VARIOUS 1D BARCODES

// CODE 128 AUTO
$txt = $cod_produto;
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
//$pdf->Cell(0, 0, "Cod.SAP:".$sap." - ".$ds_apelido.$ds_prateleira.$ds_coluna.$ds_altura, 0, 1);
$pdf->write1DBarcode($cod_produto, 'C128', '', '', '', 26, 1, $style, 'N');

$pdf->Ln();

//Close and output PDF document
$pdf->Output('barcode.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
$link->close();
?>