<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$local      = $_POST['local'];

require_once('tcpdf/tcpdf.php');

    $query_qtde = "SELECT t1.id, t1.nr_docto, t1.cod_item, t1.nr_seq, t2.produto, t4.nm_produto, t2.n_serie, 
    DATE_FORMAT(t2.dt_aloca,'%d/%m/%Y') as dt_aloca, t2.ds_lp,
    t2.ds_fabr, t2.ds_ano, t2.ds_enr, t2.ds_kva, t2.produto
    from tb_etiqueta t1
    left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
    left join tb_produto t4 on t2.produto = t4.cod_prod_cliente and t4.fl_status = 'A'
    left join tb_recebimento_ag t5 on t2.nr_or = t5.cod_recebimento
    where t2.ds_galpao = '$local'
    group by t2.cod_estoque";
    $qtde = mysqli_query($link,$query_qtde);  
    
    require_once('tcpdf/tcpdf.php');

    $pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetHeaderData(false, false, "ARGUS", false);
    
    //$pdf->setHeaderFont(Array('helvetica', '', 8));
    
    $pdf->setPrintFooter(false);
    $pdf->setPrintHeader(false);
    
    $pdf->SetMargins(1, 1, 1, 1);
    
    $pdf->SetAutoPageBreak(TRUE, 0);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    
    $resolution= array(100, 51);
    
    $pdf->AddPage('L', $resolution);
    
    $pdf->SetFont('helvetica', '', 8);
    
    $style = array(
        'position' => 'C',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => 'C',
        'border' => false,
        'hpadding' => 'auto',
        'vpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false,
        'text' => false,
        'font' => 'helvetica',
        'fontsize' => 8,
        'stretchtext' => 6
    );
    
    while ($linha=mysqli_fetch_array($qtde)) {
        $nm_produto     	    = $linha['nm_produto'];
        $cod_prod_cliente 	    = $linha['produto'];
        $ds_lp 			        = $linha['ds_lp'];
        $ds_kva 		        = $linha['ds_kva'];
        $nr_serial 		        = $linha['n_serie'];
        $dt_recebimento_real    = $linha['dt_aloca'];

        if($ds_lp != ""){

            $params = $pdf->serializeTCPDFtagParameters(array($ds_lp, 'C128', '', '', 54, 24, 1, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>6), 'N'));
            $codBar1 = '<tcpdf method="write1DBarcode" params="'.$params.'" />';

        }else{

            $params = $pdf->serializeTCPDFtagParameters(array("00000000", 'C128', '', '', 54, 24, 1, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>6), 'N'));
            $codBar1 = '<tcpdf method="write1DBarcode" params="'.$params.'" />';

        }
        if($nr_serial != ""){

            $params2 = $pdf->serializeTCPDFtagParameters(array($nr_serial, 'C128', '', '', 40, 24, 1, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>6), 'N'));
            $codBar2 = '<tcpdf method="write1DBarcode" params="'.$params2.'" />';

        }else{

            $params2 = $pdf->serializeTCPDFtagParameters(array("00000000", 'C128', '', '', 40, 24, 1, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>6), 'N'));
            $codBar2 = '<tcpdf method="write1DBarcode" params="'.$params2.'" />';

        }

        $html = '<table sytle="font-size:8px">
        <tr>
        <td><img src="../../../img/logo3c2.png" border="0" height="14" width="32" align="top" /></td>
        <td><b>Cod.Mat: '.$cod_prod_cliente.'</b></td>
        </tr>
        </table>
        <table sytle="font-size:8px">
        <tr>
        <td>DataRec: </td><td><b>'.$dt_recebimento_real.'</b></td>
        <td>KVA: </td><td><b>'.$ds_kva.'</b></td>
        </tr>
        <tr>
        <td>LP: </td><td><b>'.$ds_lp.'</b></td><td>Nr.Serial:</td><td> <b>'.$nr_serial.'</b></td>
        </tr>
        <tr>
        <td colspan="4" sytle="font-size:6px"><p><b>'.$nm_produto.'</b></p></td>
        </tr>
        <tr>
        <td style="width:200px">
            <tr><td>'.$codBar1.'</td></tr>
        </td>
        <td style="width:200px">
            <tr><td style:float:right>'.$codBar2.'</td></tr>
        </td>
        </tr>
        </table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
    
    }
    
    $pdf->Output('barcode.pdf', 'I');
    
    $link->close();
    ?>