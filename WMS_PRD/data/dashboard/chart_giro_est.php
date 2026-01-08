<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$query_giro = "select produto, nr_giro, nr_time
from tb_giro
where nr_giro > 0 and fl_empresa = '$cod_cli'
order by nr_giro desc
limit 0,10";
$res_gir = mysqli_query($link, $query_giro);

while ($parte = mysqli_fetch_assoc($res_gir)) {

	$array_parte[] = array(
		'produto' => $parte['produto'],
		'tempo' => $parte['nr_time'],
		'giro' => $parte['nr_giro'],
	);

}

$link->close();
?>
