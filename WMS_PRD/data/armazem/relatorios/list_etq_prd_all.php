<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

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

$pdf->SetFont('helvetica', '', 10);

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

//foreach ($_POST['cod_est'] as $c) {

    $query_qtde = "select t1.id, t1.nr_docto, t1.cod_item, t1.nr_seq, t2.produto, t4.nm_produto
    from tb_etiqueta t1
    left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
    left join tb_produto t4 on t2.produto = t4.cod_prod_cliente and t4.fl_status = 'A'
    where t1.cod_estoque = '".$_POST['cod_est']."'
    group by t4.cod_prod_cliente";
    $qtde = mysqli_query($link,$query_qtde);  

    while ($linha=mysqli_fetch_array($qtde)) {
        $produto        = $linha['produto'];
        $cod_etq        = $linha['id'];
        //$nm_produto     = substr($linha['nm_produto'], 0, 28);
        $nm_produto     = $linha['nm_produto'];

        $txt = $nm_produto;
        $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

        $pdf->write1DBarcode($produto."-".$cod_etq, 'C128', '', '', '', 34, 1, $style, 'N');

        $pdf->Ln();

    }
    
//}

$pdf->Output('barcode.pdf', 'I');

$link->close();
?>