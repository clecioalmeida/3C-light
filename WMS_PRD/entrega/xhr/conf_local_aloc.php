<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_estoque = mysqli_real_escape_string($link,$_POST['cod_estoque']);
$local = mysqli_real_escape_string($link,$_POST['local']);
$end = mysqli_real_escape_string($link,$_POST['end']);
//$nr_pedido = mysqli_real_escape_string($link,$_POST['pedido']);

if($local == $end){

	$query_conf="select count(produto) as total
            from tb_pedido_conferencia
            where nr_pedido = '$cod_estoque'";
        $res_conf=mysqli_query($link, $query_conf);
        $tr_conf = mysqli_num_rows($res_conf);
                
        while ($conf=mysqli_fetch_assoc($res_conf)) {
            $retorno[] = array(
                'total' => $conf['total'],
                'info' => "1",
            );
        }

        echo(json_encode($retorno));

}else{

	$retorno[] = array(
            'info' => "Por favor selecione o endereço correto.",
        );
	echo(json_encode($retorno));
}

?>