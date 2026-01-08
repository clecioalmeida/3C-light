<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = mysqli_real_escape_string($link, $_POST["BarcodeRec"]);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql="select t1.cod_recebimento, t2.qtd_vol_ent, t2.nr_fisc_ent, t3.produto, t3.nr_qtde, t4.cod_prod_cliente
from tb_recebimento t1
left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
left join tb_produto t4 on t3.produto = t4.cod_produto
where t1.cod_recebimento = '$cod_rec'";
$res_sql = mysqli_query($link,$sql);
$linha=mysqli_fetch_array($res_sql);
/*
while ($linha=mysqli_fetch_assoc($res_sql)) {
    $qtde = $linha['qtd_vol_ent'];
    $codRec = $linha['cod_recebimento'];
    $codNf = $linha['nr_fisc_ent'];
    $prodRec = $linha['produto'];
    $sap = $linha['cod_prod_cliente'];
    $barcode = $linha['produto'];
}
*/
var_dump($linha);
$link->close();
?>