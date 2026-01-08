<?php
require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $conGalpao = $_GET['ds_galpao'];
    $conRua = $_GET['id_rua'];
    $conColuna = $_GET['id_coluna'];
    $conAltura = $_GET['id_altura'];

    $query="SET SQL_BIG_SELECTS=1";
    $res_query=mysqli_query($link, $query);

    $query_estoque="select t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, sum(t1.nr_qtde) as saldo, t2.cod_produto, t2.nm_produto
    from tb_posicao_pallet t1
    left join tb_produto t2 on t1.produto = t2.cod_produto or t1.produto = t2.id_torre
    where ds_galpao = '$conGalpao' and ds_prateleira = '$conRua' and ds_coluna = '$conColuna' and ds_altura = '$conAltura'
    group by t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura";
    $res_estoque=mysqli_query($link, $query_estoque);
    $tr_estoque = mysqli_num_rows($res_estoque);

$link->close();
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('relatorio/tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = 'relatorio/img/logo3C.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 10, 'Relatório de saldos de estoque', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

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
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<div id="content">                                        
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <br>
                <br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">COD. PRODUTO</th>
                            <th>PRODUTO</th>
                            <th>TIPO</th>
                            <th>ARMAZÉM</th>
                            <th>RUA</th>
                            <th>COLUNA</th>
                            <th>ALTURA</th>
                            <th>QTDE</th>
                        </tr>
                    </thead>
                    <tbody id="tbConProdEstoq">';
                            
                            while ($estoque=mysqli_fetch_assoc($res_estoque)) {

$html .='
                        <tr>
                            <td id="codProdRelEstoq">'.$estoque['cod_produto'].'</td>
                            <td>'.$estoque['nm_produto'].'</td>
                            <td></td>
                            <td id="idGalRelEstoq">'.$estoque['ds_galpao'].'</td>
                            <td id="idRuaRelEstoq">'.$estoque['ds_prateleira'].'</td>
                            <td id="idColunaRelEstoq">'.$estoque['ds_coluna'].'</td>
                            <td id="idAlturaRelEstoq">'.$estoque['ds_altura'].'</td>
                            <td id="nrQtdeRelEstoq">'.$estoque['saldo'].'</td>
                        </tr>';

                        }
$html .='
                    </tbody >
                </table>
            </article>
        </div>
    </section>
</div>
<script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
    JsBarcode(".barcode").init();
</script>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>