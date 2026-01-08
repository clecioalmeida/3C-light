<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../../index.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $id_oper    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_estoque 	= $_POST['cod_estoque'];
//$cod_produto    = $_POST['cod_produto'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_qtde="select DISTINCT t1.id, t1.nr_docto, t1.cod_item, t1.nr_seq, t3.nr_fisc_ent, t2.produto, t4.nm_produto
from tb_etiqueta t1
left join tb_nf_entrada_item t2 on t1.cod_item = t2.cod_nf_entrada_item
left join tb_nf_entrada t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
left join tb_posicao_pallet t5 on t3.cod_rec = t5.nr_or
where t1.cod_estoque = '$cod_estoque'
group by t1.id";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){

    require_once('tcpdf/tcpdf.php');

    $pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetHeaderData(false, false, "teste", false);

    $pdf->setPrintFooter(false);
    $pdf->setPrintHeader(false);

    $pdf->SetMargins(1, 1, 1, 1);

    $pdf->SetAutoPageBreak(TRUE, 5);

    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    $resolution= array(100, 51);

    $pdf->AddPage('L', $resolution);

    $pdf->SetFont('helvetica', '', 12);

    $style = array(

        'position'      => 'C',
        'align'         => 'C',
        'stretch'       => false,
        'fitwidth'      => true,
        'cellfitalign'  => '',
        'border'        => false,
        'hpadding'      => 'auto',
        'vpadding'      => 'auto',
        'fgcolor'       => array(0,0,0),
        'bgcolor'       => false,
        'text'          => true,
        'font'          => 'helvetica',
        'fontsize'      => 10,
        'stretchtext'   => 4
    );

    while ($linha=mysqli_fetch_array($qtde)) {
        $produto        = $linha['produto'];
        $cod_etq        = $linha['id'];
        //$nm_produto     = substr($linha['nm_produto'], 0, 20);
        $nm_produto     = $linha['nm_produto'];

        $txt = $nm_produto;
        $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

        $pdf->write1DBarcode($produto."-".$cod_etq, 'C128', '', '', '', 34, 1, $style, 'N');

        $pdf->Ln();

    }

    $pdf->Output('barcode.pdf', 'I');


}else{

    $sql_etq="select t1.nr_or, t1.produto, coalesce(t1.nr_volume,0) as nr_volume, t4.cod_nf_entrada, t4.cod_nf_entrada_item
    from tb_posicao_pallet t1
    left join tb_nf_entrada t3 on t1.nr_or = t3.cod_rec
    left join tb_nf_entrada_item t4 on t3.cod_nf_entrada = t4.cod_nf_entrada and t1.produto = t4.produto
    where t1.cod_estoque = '$cod_estoque' and t4.cod_nf_entrada_item is not null";
    $etq = mysqli_query($link,$sql_etq);
    while ($dados=mysqli_fetch_assoc($etq)) {

        for ($i = 1; $i <= $dados['nr_volume']; $i++) {

            $cod_etq                =  uniqid();
            $cod_nf_entrada         = $dados['cod_nf_entrada'];
            $cod_nf_entrada_item    = $dados['cod_nf_entrada_item'];

            $ins_etq="insert into tb_etiqueta (nr_docto, cod_item, cod_estoque, nr_seq, fl_status, cod_etq, usr_create, dt_create) values ('$cod_nf_entrada', '$cod_nf_entrada_item', '$cod_estoque', '$i', 'A', '$cod_etq', '$id', '$date')";
            $ins = mysqli_query($link,$ins_etq);

        }
    }

    if($etq){

        $query_qtde="select DISTINCT t1.id, t1.nr_docto, t1.cod_item, t1.nr_seq, t3.nr_fisc_ent, t2.produto, t4.nm_produto
        from tb_etiqueta t1
        left join tb_nf_entrada_item t2 on t1.cod_item = t2.cod_nf_entrada_item
        left join tb_nf_entrada t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
        left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
        left join tb_posicao_pallet t5 on t3.cod_rec = t5.nr_or
        where t1.cod_estoque = '$cod_estoque'
        group by t1.id";
        $qtde = mysqli_query($link,$query_qtde);

        if(mysqli_num_rows($qtde) > 0){

            require_once('tcpdf/tcpdf.php');

            $pdf = new TCPDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetHeaderData(false, false, "teste", false);

            $pdf->setPrintFooter(false);
            $pdf->setPrintHeader(false);

            $pdf->SetMargins(1, 1, 1, 1);

            $pdf->SetAutoPageBreak(TRUE, 5);

            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            $resolution= array(100, 51);

            $pdf->AddPage('L', $resolution);

            $pdf->SetFont('helvetica', '', 12);

            $style = array(

                'position'      => 'C',
                'align'         => 'C',
                'stretch'       => false,
                'fitwidth'      => true,
                'cellfitalign'  => '',
                'border'        => false,
                'hpadding'      => 'auto',
                'vpadding'      => 'auto',
                'fgcolor'       => array(0,0,0),
                'bgcolor'       => false,
                'text'          => true,
                'font'          => 'helvetica',
                'fontsize'      => 10,
                'stretchtext'   => 4
            );

            while ($linha=mysqli_fetch_array($qtde)) {
                $produto        = $linha['produto'];
                $cod_etq        = $linha['id'];
                //$nm_produto     = substr($linha['nm_produto'], 0, 20);
                $nm_produto     = $linha['nm_produto'];

                $txt = $nm_produto;
                $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

                $pdf->write1DBarcode($produto."-".$cod_etq, 'C128', '', '', '', 34, 1, $style, 'N');

                $pdf->Ln();

            }

            $pdf->Output('barcode.pdf', 'I');


        }else{

            echo "<h1>Erro ao gerar etiquetas(1).</h1>";

        }


    }else{

        echo "<h1>Erro ao gerar etiquetas(2).</h1>";

    }

}


$link->close();
?>