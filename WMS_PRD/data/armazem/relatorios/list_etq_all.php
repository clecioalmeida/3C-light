<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$local_inicio 	= $_POST['local_inicio'];
$rua_inicio 	= $_POST['rua_inicio'];
$coluna_inicio 	= $_POST['coluna_inicio'];
$altura_inicio 	= $_POST['altura_inicio'];
$local_fim 		= $_POST['local_fim'];
$rua_fim 		= $_POST['rua_fim'];
$coluna_fim 	= $_POST['coluna_fim'];
$altura_fim 	= $_POST['altura_fim'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.id, t1.galpao, t1.rua, t1.coluna, t1.altura, t2.nome, t2.ds_apelido
from tb_endereco t1
left join tb_armazem t2 on t1.galpao = t2.id
where t1.galpao BETWEEN '$local_inicio' and '$local_fim' and t1.rua BETWEEN '$rua_inicio' and '$rua_fim' and t1.coluna BETWEEN '$coluna_inicio' and '$coluna_fim' and t1.altura BETWEEN '$altura_inicio' and '$altura_fim' and t1.fl_status <> 'E'
order by t1.galpao, t1.rua, t1.coluna, t1.altura asc";
$qtde = mysqli_query($link,$query_qtde);

require_once('tcpdf/tcpdf.php');


$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$layout = array(100,50);
//$pdf->SetHeaderData(false, false, $nome, false);
$pdf->setHeaderFont(Array('helvetica', '', 14));
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
$pdf->SetMargins(1, 1, 1, 1);
$pdf->SetAutoPageBreak(TRUE, 5);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage('L', $layout);

$pdf->SetFont('helvetica', 'B', 30);

$style = array(
    'position'      => 'C',
    'align'         => 'C',
    'stretch'       => true,
    'fitwidth'      => true,
    'cellfitalign'  => '',
    'border'        => false,
    'hpadding'      => 'auto',
    'vpadding'      => 'auto',
    'fgcolor'       => array(0,0,0),
    'bgcolor'       => false,
    'text'          => false,
    'font'          => 'helvetica',
    'fontsize'      => 24,
    'stretchtext'   => 5
);

while ($linha=mysqli_fetch_array($qtde)) {
	$id 			= $linha['id'];
	$galpao 		= $linha['galpao'];
	$rua 			= $linha['rua'];
	$coluna 		= $linha['coluna'];
	$altura 		= $linha['altura'];
	$nome 			= $linha['nome'];
	$ds_apelido 	= $linha['ds_apelido'];

	$txt = $nome;
	$pdf->Write(0, $rua."-".$coluna."-".$altura, '', 0, 'C', true, 0, false, false, 0);
	$pdf->write1DBarcode($id."-".$rua."-".$coluna."-".$altura, 'C128', '', '', '', 30, 1, $style, 'N');

	$pdf->Ln();
}

$pdf->Output('barcode.pdf', 'I');

$link->close();
?>