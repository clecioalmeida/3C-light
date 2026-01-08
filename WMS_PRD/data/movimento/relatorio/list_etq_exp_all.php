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

$hoje	= date("d/m/Y");

$pedido = $_POST['nr_ped'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.nr_pedido, t1.nr_ped_sap, t1.doc_material, t4.produto, t3.nm_produto, t3.unid, t1.cod_almox, t2.ds_almox, t3.nm_produto, t3.cod_prod_cliente, t3.cod_produto, sum(t4.nr_qtde_col) as qtde 
from tb_pedido_coleta t1  
left join tb_coleta_pedido t4 on t1.nr_pedido = t4.nr_pedido 
left join tb_produto t3 on t4.produto = t3.cod_prod_cliente
left join tb_almox t2 on t1.cod_almox = t2.cod_almox
where t1.nr_pedido = '$pedido'
group by t4.produto
order by t4.ds_prateleira, t4.ds_coluna, t4.ds_altura";
$qtde = mysqli_query($link,$query_qtde);

if($cod_cli == "3"){

	$remetente 			= "EDP - SÃO JOSÉ DOS CAMPOS - SP";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "";
	$cepRem				= "";

}else if($cod_cli == "4"){

	$remetente 			= "EDP - VILA VELHA - SP";
	$endRem 			= "";
	$brRem 				= "";
	$cidRem				= "";
	$cepRem				= "";

}

require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(false, false, "ARGUS", false);

//$pdf->setHeaderFont(Array('helvetica', '', 8));

$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);

$pdf->SetMargins(0, 0, 0, 0);

$pdf->SetAutoPageBreak(TRUE, 5);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

$resolution= array(112, 59);

//$pdf->AddPage();

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
	'text' => false,
	'font' => 'helvetica',
	'fontsize' => 10,
	'stretchtext' => 4
);

while ($linha=mysqli_fetch_array($qtde)) {
	$nr_pedido 			= $linha['nr_pedido'];
	$nm_produto     	= $linha['nm_produto'];
	$cod_prod_cliente 	= $linha['cod_prod_cliente'];
	$volume 			= $linha['qtde'];
	$cod_almox 			= $linha['cod_almox'];
	$ds_destino 		= $linha['ds_almox'];
	$nr_ped_sap 		= $linha['nr_ped_sap'];
	$doc_material 		= $linha['doc_material'];
	$unid 				= $linha['unid'];


	$html = '<table border="1" cellpadding="1">
	<tr>
	<td><img src="i../.././img/logo3c2.png" border="0" height="14" width="32" align="top" /></td>
	<td><b>PK LIST: '.$nr_pedido.'</b></td>
	</tr>
	<tr>
	<td><b>DATA: '.$hoje.'</b></td>
	<td><b>DOC MAT: '.$doc_material.'</b></td>
	</tr>
	<tr>
	<td colspan="2"><b>Rem: '.$remetente.'</b></td>
	</tr>
	<tr>
	<td style="width:300px"><b>Dest: '.$cod_almox." - ".$ds_destino.'</b></td>
	<td><b>UMB:'.$unid.'</b></td>
	</tr>
	<tr>
	<td colspan="2"><b>'.$cod_prod_cliente." - ".$nm_produto.'</b></td>
	</tr>
	<tr>
	<td colspan="2">';

	$params = $pdf->serializeTCPDFtagParameters(array($cod_prod_cliente, 'C128', '', '', 84, 17, 1.8, $style, 'N'));
	$html .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';

	$html.='</td>
	</tr>
	</table>';
	//$pdf->writeHTML($html, true, 0, true, 0);
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->Ln();

}

$pdf->Output('barcode.pdf', 'I');

$link->close();
?>