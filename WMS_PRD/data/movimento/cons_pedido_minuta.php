<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
        
$nr_pedido = $_POST['nr_pedido'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

foreach($nr_pedido as $pedido){

  $query_pedido="select nr_pedido from tb_minuta_item where nr_pedido = '$pedido'";
  $res_pedido = mysqli_query($link,$query_pedido);
}
$tr=mysqli_num_rows($res_pedido);
if($tr>0){

	echo "1";

    $retorno[] = array(
		'info'	=> "1",
	);

}else{

	$retorno[] = array(
		'info'	=> "0",
	);

}

$link->close();
?>