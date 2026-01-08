<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();


if(isset($_POST['consLocal'])){

    $produto = mysqli_real_escape_string($link,$_POST['barcodeConsLocPrd']);

    $query_conf = "SELECT t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t2.nome, t3.nm_produto
    from tb_posicao_pallet t1
    left join tb_armazem t2 on t1.ds_galpao = t2.id
    left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
    where t1.produto = ''";
    $res_conf=mysqli_query($link, $query_conf);

    if(mysqli_num_rows($res_conf) > 0){

        while ($conf=mysqli_fetch_assoc($res_conf)) {
            $retorno[] = array(
                'saldo' => $conf['saldo'],
                'nm_produto' => $conf['nm_produto'],
                'cod_prod_cliente' => $conf['cod_prod_cliente'],
                'info' => "1",
            );
        }

        echo(json_encode($retorno));

    }else{

        $retorno[] = array(
            'info' => "2",
        );

    }    

}else{

	$retorno[] = array(
        'info' => "Endereço inválido.",
    );
	echo(json_encode($retorno));
}

$link->close();
?>