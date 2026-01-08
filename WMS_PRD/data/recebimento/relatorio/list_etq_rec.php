<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_etq     = $_POST['id_etq'];
$cod_item   = $_POST['cod_item'];

$sql_sum = "SELECT t1.nr_qtde, sum(t2.nr_qtde) as qtde_etq
from tb_nf_entrada_item t1
left join tb_etiqueta t2 on t1.cod_nf_entrada_item = t2.cod_item
where t1.cod_nf_entrada_item = '$cod_item'";
$res_sum = mysqli_query($link,$sql_sum);
$dados = mysqli_fetch_assoc($res_sum);

if($dados['nr_qtde'] == $dados['qtde_etq']){

    $query_qtde="select t1.id, t1.nr_docto, t1.cod_item, t1.nr_seq, t3.produto, t4.nm_produto
    from tb_etiqueta t1
    left join tb_nf_entrada_item t3 on t1.cod_item = t3.cod_nf_entrada_item
    left join tb_produto t4 on t3.produto = t4.cod_prod_cliente
    where t1.id = '$id_etq' and t1.fl_status <> 'E'
    group by t1.id";
    $qtde = mysqli_query($link,$query_qtde);
    while ($linha=mysqli_fetch_assoc($qtde)) {
        $produto        = $linha['produto'];
        $cod_etq        = $linha['id'];
    //$nm_produto     = substr($linha['nm_produto'], 0, 28);
        $nm_produto     = $linha['nm_produto'];
    }

    require_once('tcpdf/tcpdf.php');

    $pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetHeaderData(false, false, "Cod. SAP - ".$produto, false);

    $pdf->setHeaderFont(Array('helvetica', '', 8));
    $pdf->setPrintFooter(false);
    $pdf->setPrintHeader(false);

    $pdf->SetMargins(5, 5, 5, 5);

    $pdf->SetAutoPageBreak(TRUE, 5);

    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    $pdf->SetFont('helvetica', '', 11);

    $resolution= array(100, 50);

    $pdf->AddPage('L', $resolution);
    $pdf->SetFont('helvetica', '', 8);

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
        'fontsize' => 8,
        'stretchtext' => 4
    );

    $txt = $nm_produto;
    $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

    $pdf->write1DBarcode($produto."-".$cod_etq, 'C128', '', '', '', 26, 1, $style, 'N');

    $pdf->Ln();

    $pdf->Output('Recebimneto.pdf', 'I');



}else{

    echo "Quantidades não conferem.";

}
$link->close();
?>