<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

/*$barcode = explode('-', $_POST['barcodeConsHistPrd']);
$produto = $barcode[0];
$cod_etq = $barcode[1];*/

$produto = $_POST['barcodeConsHistPrd'];

$query_conf = "SELECT t1.produto, t2.cod_rec, t2.nr_fisc_ent, GROUP_CONCAT(t4.ds_prateleira,'-', t4.ds_coluna,'-',t4.ds_altura) as end, date_format(t5.dt_recebimento_real,'%d/%m/%Y') as data_rec, coalesce(round(t4.nr_qtde,0),0) as qtd_pos
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
left join tb_etiqueta t3 on t2.cod_nf_entrada = t3.nr_docto
left join tb_posicao_pallet t4 on t2.cod_rec = t4.nr_or and t4.fl_status = 'A' and t4.nr_qtde > '0'
left join tb_recebimento t5 on t2.cod_rec = t5.cod_recebimento
where t1.produto = '$produto'";
$res_conf = mysqli_query($link, $query_conf);


$table = "<table class='table table-strapped'>
<thead style='font-size:15px'>
    <th>PRODUTO |</th>
    <th> COD RECEBIMENTO |</th>
    <th> DATA RECEBIMENTO |</th>
    <th> NOTA FISCAL |</th>
    <th> ENDEREÇO ALOC. |</th>
    <th> QUANTIDADE</th>
</thead>
<tbody>";

while ($dados = mysqli_fetch_assoc($res_conf)) {

    if ($dados['qtd_pos'] > 0) {

        $table .= "<tr>";
        $table .= "<td>" . $dados['produto'] . "</td>";
        $table .= "<td style='text-align: right'>" . $dados['cod_rec'] . "</td>";
        $table .= "<td style='text-align: center'>" . $dados['data_rec'] . "</td>";
        $table .= "<td style='text-align: right'>" . $dados['nr_fisc_ent'] . "</td>";
        $table .= "<td style='text-align: center'>" . $dados['end'] . "</td>";
        $table .= "<td style='text-align: right'>" . $dados['qtd_pos'] . "</td>";
        $table .= "</tr>";

    } else {

        $table .= "<tr style='text-align:center;background-color:#FFA07A;height:10px'>";
        $table .= "<td colspan = '6'><strong>DADOS NÃO ENCONTRADOS</strong></td>";
        $table .= "</tr>";

    }
}

$table .= "</tbody>
     </table>";

echo $table;

$link->close();
?>