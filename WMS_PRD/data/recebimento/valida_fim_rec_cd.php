<?php
  session_start();  
?>
<?php

  if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../../index.php");
    exit;

  }else{
    
    $id=$_SESSION["id"];
  }
?>
<?php

require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_POST['cod_rec'];

$query_nf="select sum(distinct t1.qtd_vol_ent) as qtde, sum(t2.nr_qtde) as total from tb_nf_entrada t1
left join tb_nf_entrada_item t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
where t1.cod_rec = '$cod_rec' and t1.fl_status = 'C' and t2.fl_status <> 'E'";
$res_nf = mysqli_query($link, $query_nf);

while ($dados=mysqli_fetch_array($res_nf)) {
	$nr_qtde_nf = $dados['qtde'];
	$total = $dados['total'];
}

//$query_usr="select usr_create, dt_create from tb_nf_entrada_conf where cod_rec = '$cod_rec'";
//$res_usr = mysqli_query($link, $query_usr);

//while ($dados_conf=mysqli_fetch_array($res_usr)) {
//	$usr_create = $dados_conf['usr_create'];
//	$dt_create = $dados_conf['dt_create'];
//}

if($total == $nr_qtde_nf){
	$sql = "CALL prc_recebimento_cd('$id', '$cod_rec')";
	$result_id = mysqli_query($link, $sql);

	$upd_or="update tb_recebimento set fl_status = 'F', nm_user_conferido_por = '$id', dt_user_conferido_por = now() where cod_recebimento = '$cod_rec'";
	$res_upd = mysqli_query($link, $upd_or);

	$retorno[] = array(
		'info' => "0",
	);

	echo(json_encode($retorno));

}else{

	$retorno[] = array(
		'info' => "1",
	);

	echo(json_encode($retorno));

}
$link->close();
?>