<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_item_prd 	= $_POST['id_item_prd'];
$id_rec    = $_POST['id_rec'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select DISTINCT t1.id, t1.nr_docto, t1.cod_item, t1.nr_seq, t3.nr_fisc_ent, t2.produto, t4.nm_produto
from tb_etiqueta t1
left join tb_nf_entrada_item t2 on t1.cod_item = t2.cod_nf_entrada_item
left join tb_nf_entrada t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
where t2.produto = '$id_item_prd' and t3.cod_rec = '$id_rec' and t1.fl_status <> 'E' and t1.fl_status <> 'C'
group by t1.id";
$qtde = mysqli_query($link,$query_qtde);

require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(false, false, "teste", false);

//$pdf->setHeaderFont(Array('helvetica', '', 8));

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

while ($linha=mysqli_fetch_array($qtde)) {
	$produto 		= $linha['produto'];
	$cod_etq 		= $linha['id'];
    $nm_produto     = substr($linha['nm_produto'], 0, 20);

	$txt = $nm_produto;
	$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
 	
	$pdf->write1DBarcode($produto."-".$cod_etq, 'C128', '', '', '', 34, 1, $style, 'N');

	$pdf->Ln();

}

$pdf->Output('barcode.pdf', 'I');

$link->close();
?>