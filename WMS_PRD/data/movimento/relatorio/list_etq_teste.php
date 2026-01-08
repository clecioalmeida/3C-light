<?php
//Incluir a conexão com banco de dados
/*require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$ds_galpao = $_GET['ds_galpao'];
$id_rua = $_GET['id_rua'];
$id_coluna = $_GET['id_coluna'];
$id_altura = $_GET['id_altura'];
$cod_produto = $_GET['cod_produto'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t2.cod_prod_cliente, t3.ds_apelido 
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.ds_galpao = '$ds_galpao' and t1.ds_prateleira = '$id_rua' and t1.ds_coluna = '$id_coluna' and t1.ds_altura = '$id_altura' and t1.produto = '$cod_produto'
group by t1.produto";
$qtde = mysqli_query($link,$query_qtde);
while ($linha=mysqli_fetch_array($qtde)) {
 $sap = $linha['cod_prod_cliente'];
 $produto = $linha['produto'];
 //$nr_qtde = number_format($linha['qtde'], 0, ',', '.');
 $ds_prateleira = $linha['ds_prateleira'];
 $ds_coluna = $linha['ds_coluna'];
 $ds_altura = $linha['ds_altura'];
 $ds_apelido = $linha['ds_apelido'];
}

*/
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

$yp=array('2012','2013','2014');

       $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

       $pdf->SetFont('times', 'A4', 11);
       $pdf->addPage();

       //eror here
       for($i=0;$i<count($yp);$i++) {
    $htmlab.= '<th style="text-align:center;" width="90">'.$yp[$i].'</th>';
 }
       $pdf->writeHTML($htmlab, false, false, true, false, '');

       $html = ob_get_contents();
       ob_end_clean();   
       $pdf->Output('years.pdf', 'I');
?>