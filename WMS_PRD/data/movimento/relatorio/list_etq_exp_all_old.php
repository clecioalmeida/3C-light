<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$hoje				= date("d/m/Y");

$pedido 	= $_POST['nr_ped'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.nr_pedido, t4.produto, t3.nm_produto, t1.cod_almox, t1.ds_destino, t3.nm_produto, t3.cod_prod_cliente, t3.cod_produto, sum(t4.nr_qtde_col) as qtde 
from tb_pedido_coleta t1  
left join tb_coleta_pedido t4 on t1.nr_pedido = t4.nr_pedido 
left join tb_produto t3 on t4.produto = t3.cod_prod_cliente 
where t1.nr_pedido = '$pedido'
group by t4.produto";
$qtde = mysqli_query($link,$query_qtde);

if($cod_cli == "3"){

	$remetente 			= "EDP SAO PAULO DISTRIBUICAO DE ENERGIA. S.A";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "SÃO JOSÉ DOS CAMPOS - SP";
	$cepRem				= "";

}else if($cod_cli == "4"){

	$remetente 			= "EDP ESPIRITO SANTO DISTRIBUIÇÃO DE ENERGIA S.A.";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "VILA VELHA - SP";
	$cepRem				= "";



}

require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(false, false, "ARGUS", false);

//$pdf->setHeaderFont(Array('helvetica', '', 8));

$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);

$pdf->SetMargins(0.5, 0.5, 0.5, 0.5);

$pdf->SetAutoPageBreak(TRUE, 5);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

$resolution= array(100, 51);

//$pdf->AddPage();

$pdf->AddPage('L', $resolution);

$pdf->SetFont('helvetica', '', 12);

/*$style = array(
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
);*/

while ($linha=mysqli_fetch_array($qtde)) {
	$nr_pedido 			= $linha['nr_pedido'];
	$ds_destino 		= $linha['ds_destino'];
	$nm_produto     	= $linha['nm_produto'];
	$cod_prod_cliente 	= $linha['cod_prod_cliente'];
	$volume 			= $linha['qtde'];
	$cod_almox 			= $linha['cod_almox'];
	$ds_destino 		= $linha['ds_destino'];


	$html = '<table border="0.5" cellpadding="1">
	<tr style="border-bottom-width:thin">
	<td style="font-size:10px;height:5px"><img src="i../.././img/logo3c2.png" border="0" height="16" width="36" align="top" /></td>
	<td style="font-size:10px;height:5px;text-align:left">NF: </td>
	</tr>
	<tr>
	<td style="font-size:10px;height:5px">DATA: '.$hoje.'</td>
	<td style="font-size:10px;height:5px;text-align:right">PEDIDO: '.$pedido.'</td>
	</tr>
	<tr>
	<td colspan="2" style="font-size:10px;height:5px"><strong>Remetente: '.$remetente.'</strong></td>
	</tr>
	<tr>
	<td style="font-size:10px;height:5px">'.$cidRem.'</td>
	<td style="font-size:10px;height:5px;text-align:right">'.$cepRem.'</td>
	</tr>
	<tr>
	<td colspan="2" style="font-size:10px;height:5px"><strong>Destinatário: '.$cod_almox." - ".$ds_destino.'</strong></td>
	</tr>
	<tr>
	<td colspan="2" style="font-size:10px;height:5px">'.$cod_prod_cliente." - ".$nm_produto.'</td>
	</tr>
	<tr>
	<td colspan="2" style="font-size:10px;height:8px;text-align:center">';

	$params = $pdf->serializeTCPDFtagParameters(array($cod_prod_cliente, 'C128', '', '', 42, 10, 1.3, array('position'=>'C', 'border'=>false, 'padding'=>1, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>4, 'stretchtext'=>6), 'N'));
	$html .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';

	$html.='</td>
	</tr>
	<tr>
	<td style="font-size:10px;height:8px">Transportador:</td>
	<td style="font-size:8px;height:5px;text-align:right">Argus WMS</td>
	</tr>
	</table>';
	$pdf->writeHTML($html, true, 0, true, 0);

	$pdf->Ln();

	//$pdf->lastPage();

}

$pdf->Output('barcode.pdf', 'I');

$link->close();
?>