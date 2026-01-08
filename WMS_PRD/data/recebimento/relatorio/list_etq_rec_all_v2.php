<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec 	= $_POST['id_rec'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="SELECT DISTINCT t1.id, t1.nr_docto, t1.cod_item, min(t1.nr_seq) as seq_ini, max(t1.nr_seq) as seq_fim, 
t3.nr_fisc_ent, t2.produto, substring(t4.nm_produto, 1, 30) as nm_produto, t4.cod_prod_cliente, t2.nr_ca, 
date_format(t2.dt_ca,'%d/%m/%Y') as dt_ca, t2.nr_laudo, date_format(t2.dt_laudo,'%d/%m/%Y') as dt_laudo, 
date_format(t2.dt_validade,'%d/%m/%Y') as dt_validade, date_format(t5.dt_recebimento_real,'%d/%m/%Y') as dt_fifo,
SUBSTRING(t5.nm_fornecedor, 1, 20) as nm_fornecedor
from tb_etiqueta t1
left join tb_nf_entrada_item t2 on t1.cod_item = t2.cod_nf_entrada_item
left join tb_nf_entrada t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
left join tb_recebimento t5 on t3.cod_rec = t5.cod_recebimento
where t3.cod_rec = '$id_rec' and t1.fl_status <> 'E' and t1.fl_status <> 'C' and id_tar is null
group by t1.id";
$qtde = mysqli_query($link,$query_qtde);

require_once('tcpdf/tcpdf.php');
exit();
$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(false, false, "ARGUS", false);

$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);

$pdf->SetMargins(1, 1, 1, 1);

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

$resolution= array(100, 50);

$pdf->AddPage('L', $resolution);

$pdf->SetFont('helvetica', '', 8);

while ($linha=mysqli_fetch_array($qtde)) {
	$produto 		= $linha['produto'];
	$cod_etq 		= $linha['id'];
    $nm_produto     = $linha['nm_produto'];
    $seq_ini        = $linha['seq_ini'];
    $seq_fim        = $linha['seq_fim'];
    $nr_fisc_ent    = $linha['nr_fisc_ent'];
    $nr_ca          = $linha['nr_ca'];
    $dt_ca          = $linha['dt_ca'];
    $nr_laudo       = $linha['nr_laudo'];
    $dt_laudo       = $linha['dt_laudo'];
    $dt_validade    = $linha['dt_validade'];
    $dt_fifo        = $linha['dt_fifo'];
    $nm_fornecedor  = $linha['nm_fornecedor'];

	$params = $pdf->serializeTCPDFtagParameters(array($produto."-".$cod_etq, 'C128', '', '', 72, 18, 1.8, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'position' => 'C', 'aligh' => 'C', 'stretchtext'=>6), 'N'));
	$codBar1 = '<tcpdf method="write1DBarcode" params="'.$params.'" />';

	$html = '<table border="0.5" cellpadding="1" sytle="font-size:8px">
	<tr>
	<td><img src="../../../img/logo3c2.png" border="0" height="14" width="32" />&nbsp;&nbsp;&nbsp; <b>OR: '.$id_rec.' - Cód.Vl: '.$cod_etq.'</b></td>
	</tr>
	</table>
	<table border="0.5" cellpadding="1" sytle="font-size:8px">
	<tr>
	<td><b>FIFO: '.$dt_fifo.' - NF: '.$nr_fisc_ent.' - FORN: '.$nm_fornecedor.'</b></td>
	</tr>
	</table>
	<table border="0.5" cellpadding="1" sytle="font-size:8px">
	<tr>
	<td sytle="font-size:8px"><p><b>'.$produto." - ".$nm_produto.'</b></p></td>
	</tr>
	</table>
	<table border="0.5" cellpadding="1">
	<tr>
	<td style="font-size:44px; text-align:center">'.$produto.'</td>
	<td>
    <table>
    <tr>
    <td><b>CA: '.$nr_ca.'</b></td>
    <td><b>'.$dt_ca.'</b></td>
	</tr>
    <tr>
    <td><b>LD: '.$nr_laudo.'</b></td>
    <td><b>'.$dt_laudo.'</b></td>
	</tr>
    <tr>
    <td><b>Validade: </b></td>
    <td><b>'.$dt_validade.'</b></td>
	</tr>
	</table>
    </td>
	</tr>
	</table>
	<table border="0.5" cellpadding="1">
	<tr>
	<td>'.$codBar1.'</td>
	</tr>
	</table>';
	
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->Ln();

}

$pdf->Output('barcode.pdf', 'I');

$link->close();
?>