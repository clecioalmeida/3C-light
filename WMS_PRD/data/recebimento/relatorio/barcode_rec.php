<?php
	//require_once('tcpdf/config/lang/eng.php');
	//require_once('tcpdf/tcpdf.php');
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$cod_rec = mysqli_real_escape_string($link, $_POST["BarcodeRec"]);

	$sql = "select t1.cod_recebimento, t2.qtd_vol_ent, t3.produto, t3.nr_qtde
		from tb_recebimento t1
		left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
		left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
		where t1.cod_recebimento = '$cod_rec'";
	$res_bar = mysqli_query($link,$sql);
	while ($cont=mysqli_fetch_assoc($res_bar)) {
		$qtde = $cont['qtd_vol_ent'];
		$codRec = $cont['cod_recebimento'];
		$prodRec = $cont['produto'];
		$barcode = $cont['cod_recebimento'].$cont['produto'];

	}
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 027', PDF_HEADER_STRING);
		
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

		// add a page
		$pdf->AddPage();

		// define barcode style
		$style = array(
		    'position' => '',
		    'align' => 'C',
		    'stretch' => false,
		    'fitwidth' => true,
		    'cellfitalign' => '',
		    'border' => true,
		    'hpadding' => 'auto',
		    'vpadding' => 'auto',
		    'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255),
		    'text' => true,
		    'font' => 'helvetica',
		    'fontsize' => 8,
		    'stretchtext' => 4
		);

		// CODE 128 AUTO
		$pdf->Cell(0, 0, 'CODE 128 AUTO', 0, 1);
		$style['position'] = 'C';
		$pdf->write1DBarcode($barcode, 'C128', '', '', '', 18, 0.4, $style, 'N');

		$pdf->Ln();


	//Close and output PDF document
	$pdf->Output('example_027.pdf', 'I');
$link->close();
?>