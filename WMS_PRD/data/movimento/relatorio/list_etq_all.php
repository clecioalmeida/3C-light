<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$ds_galpao = $_GET['ds_galpao'];
$id_rua = $_GET['id_rua'];
$id_coluna = $_GET['id_coluna'];
$id_altura = $_GET['id_altura'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t2.cod_prod_cliente, t3.ds_apelido 
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.ds_galpao = '$ds_galpao' and t1.ds_prateleira = '$id_rua' and t1.ds_coluna = '$id_coluna' and t1.ds_altura = '$id_altura'
group by t1.produto";
$qtde = mysqli_query($link,$query_qtde);

$etq = array();
/*
while ($linha=mysqli_fetch_array($qtde)) {
 $sap = $linha['cod_prod_cliente'];
 $produto = $linha['produto'];
 $ds_prateleira = $linha['ds_prateleira'];
 $ds_coluna = $linha['ds_coluna'];
 $ds_altura = $linha['ds_altura'];
 $ds_apelido = $linha['ds_apelido'];
}
*/
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 049');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 049', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

IMPORTANT:
If you are printing user-generated content, tcpdf tag can be unsafe.
You can disable this tag by setting to false the K_TCPDF_CALLS_IN_HTML
constant on TCPDF configuration file.

For security reasons, the parameters for the 'params' attribute of TCPDF
tag must be prepared as an array and encoded with the
serializeTCPDFtagParameters() method (see the example below).

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


while ($linha=mysqli_fetch_array($qtde)) {
$html = '<h1>Test TCPDF Methods in HTML</h1>
<h2 style="color:red;">IMPORTANT:</h2>
<span style="color:red;">If you are using user-generated content, the tcpdf tag can be unsafe.<br />
You can disable this tag by setting to false the <b>K_TCPDF_CALLS_IN_HTML</b> constant on TCPDF configuration file.</span>
<h2>write1DBarcode method in HTML</h2>';
   
$params = $pdf->serializeTCPDFtagParameters(array($linha['produto'], 'C128', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>true, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
$html .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';
}
// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_049.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
$link->close();
?>