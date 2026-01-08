<?php
require_once('tcpdf/tcpdf.php');

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido     = $_GET['pedido'];
$produto    = $_GET['produto'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.nr_pedido, t2.nm_cliente, t2.ds_endereco, t2.ds_bairro, t2.ds_cidade, t2.ds_uf, t2.ds_cep, t3.nm_produto, t3.cod_prod_cliente, t3.cod_produto, sum(t4.nr_qtde_col) as volume 
from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente 
left join tb_coleta_pedido t4 on t1.nr_pedido = t4.nr_pedido 
left join tb_produto t3 on t4.produto = t3.cod_produto 
where t1.nr_pedido = '$pedido' and t4.produto = '$produto'";
$qtde = mysqli_query($link,$query_qtde);

$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(false, false, "ARGUS", false);

$pdf->setHeaderFont(Array('helvetica', '', 8));

$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);

$pdf->SetMargins(1, 1, 1, 1);

$pdf->SetAutoPageBreak(TRUE, 5);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

$pdf->SetFont('helvetica', '', 10);

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
  'fontsize' => 35,
  'stretchtext' => 20
);

while ($linha=mysqli_fetch_array($qtde)) {
  $nr_pedido      = $linha['nr_pedido'];
  $nm_cliente     = $linha['nm_cliente'];
  $ds_endereco    = $linha['ds_endereco'];
  $ds_bairro      = $linha['ds_bairro'];
  $ds_cidade      = $linha['ds_cidade'];
  $ds_uf        = $linha['ds_uf'];
  $ds_cep       = $linha['ds_cep'];
  $nm_produto     = $linha['nm_produto'];
  $cod_prod_cliente   = $linha['cod_prod_cliente'];
  $cod_produto    = $linha['cod_produto'];
  $volume       = $linha['volume'];

  $hoje       = date("d/m/Y");
  $remetente      = "CTEEP - COMPANHIA DE TRANSMISSÃO DE ENERGIA ELÉTRICA";
  $endRem       = "Rodovia Marechal Rondon, km 348";
  $brRem        = "DISTRITO INDUSTRIAL";
  $cidRem       = "BAURU - SP";
  $cepRem       = "17015-970";


  for ($i = 0; $i < $volume; $i++) {

    $pdf->AddPage();

    $html = '<table border="0.5" cellpadding="1">
    <tr style="border-bottom-width:thin">
      <td style="font-size:4px;height:5px"><img src="i../.././img/Logo3C.jpg" border="0" height="10" width="20" align="top" /></td>
      <td style="font-size:4px;height:5px;text-align:right">NF: </td>
    </tr>
    <tr>
      <td style="font-size:4px;height:5px">DATA: '.$hoje.'</td>
      <td style="font-size:4px;height:5px;text-align:right">PEDIDO: '.$pedido.'</td>
    </tr>
    <tr>
      <td colspan="2" style="font-size:4px;height:5px"><strong>Remetente: '.$remetente.'</strong></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size:4px;height:5px">'.$endRem.'</td>
    </tr>
    <tr>
      <td style="font-size:4px;height:5px">'.$brRem.' - '.$cidRem.'</td>
      <td style="font-size:4px;height:5px;text-align:right">'.$cepRem.'</td>
    </tr>
    <tr>
      <td colspan="2" style="font-size:4px;height:5px"><strong>Destinatário: '.$nm_cliente.'</strong></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size:4px;height:5px">'.$ds_endereco.'</td>
    </tr>
    <tr>
      <td style="font-size:4px;height:5px">'.$ds_bairro.' - '.$ds_cidade.' - '.$ds_uf.'</td>
      <td style="font-size:4px;height:5px;text-align:right">'.$ds_cep.'</td>
    </tr>
    <tr>
      <td style="font-size:4px;height:5px;text-align:center">';

    $params = $pdf->serializeTCPDFtagParameters(array($cod_prod_cliente, 'C128', '', '', 24, 7, 0.3, array('position'=>'S', 'border'=>false, 'padding'=>1, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>2, 'stretchtext'=>6), 'N'));
    $html .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';

    $html.='</td>
      <td style="font-size:8px;height:5px;text-align:center;vertical-align:middle">'.$cod_produto.'</td>
    </tr>
    <tr>
      <td style="font-size:4px;height:5px">Transportador:</td>
      <td style="font-size:4px;height:5px;text-align:right">Argus WMS</td>
    </tr>
    </table>';
    $pdf->writeHTML($html, true, 0, true, 0);

    $pdf->lastPage();
  }

}

$pdf->Output('barcode.pdf', 'I');
$link->close();
?>