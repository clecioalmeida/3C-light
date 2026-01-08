<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_POST['cod_rec'];

$sql = "select cod_nf_entrada, nr_fisc_ent from tb_nf_entrada where cod_rec = '$cod_rec'" or die(mysqli_error($sql));
$res = mysqli_query($link, $sql);

if(mysqli_num_rows($res) > 0){

	while ($conf=mysqli_fetch_assoc($res)) {
		
		$array_conf[] = array(

			'info' 				=> '0',
			'nr_nf_formulario' 	=> $conf['nr_fisc_ent'],
			'nr_nf' 			=> $conf['cod_nf_entrada'],

		);
	}


}else{

	$array_conf[] = array(
		
		'info' 				=> '1',

	);

}

echo(json_encode($array_conf));

$link->close();
?>