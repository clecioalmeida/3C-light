<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];

$select_dest = "select a.nr_pedido, a.tot_qtd, b.tot_conf
from
(select nr_pedido, sum(nr_qtde) tot_qtd from tb_pedido_coleta_produto group by nr_pedido) a ,
(select nr_pedido, COALESCE(sum(nr_qtde),0) tot_conf from tb_pedido_conferencia group by nr_pedido) b
where
a.nr_pedido = '$nr_pedido' and a.nr_pedido = b.nr_pedido";
$res_dest = mysqli_query($link,$select_dest);
//print_r($res_dest);
if(mysqli_num_rows($res_dest) > 0){

	while ($dest=mysqli_fetch_assoc($res_dest)) {

		if($dest['tot_qtd'] > $dest['tot_conf']){
			$array_dest[] = array(
				'info'	=> "1",
			);

		}else if($dest['tot_qtd'] == $dest['tot_conf']){
			$array_dest[] = array(
				'info'	=> "0",
			);

		}
	}

}else{

	$array_dest[] = array(
		'info'	=> "2",
	);
}

echo(json_encode($array_dest));

$link->close();
?>