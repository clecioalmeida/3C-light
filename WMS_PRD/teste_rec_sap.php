
<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$id_rec = 1;//$_POST["id_rec_sap"];

$sql = "select cod_forn_sap, nr_nf, cod_prod_cliente, tp_movimento, sum(nr_qtde) as saldo from tb_mb51 group by cod_forn_sap, nr_nf, cod_prod_cliente";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados=mysqli_fetch_assoc($res)) {
	echo "cod_forn_sap: ".$dados['cod_forn_sap']." - "."nr_nf: ".$dados['nr_nf']." - "."cod_prod_cliente: ".$dados['cod_prod_cliente']." - "."tp_movimento: ".$dados['tp_movimento']." - "."saldo: ".$dados['saldo']."<br>";
}
$link->close();
$link1->close();
?>