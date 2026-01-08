<?php 
	//require_once('bd_class_dsv.php');
	//$objDb = new db();
	//$link = $objDb->conecta_mysql();

	//$tr_status = $_REQUEST['tr_status'];
	
	//$sql_tipo = "select tr_tipo, sum(tr_horas) as horas from tarefas group by tr_tipo";
	//$res_tipo = mysqli_query($link, $sql_tipo);

	$sql_status = "select
		case fl_status
		when 'A' then 'ABERTO'
		when 'P' then 'FINALIZADO'
		when 'X' then 'EXPEDIÇÃO'
		when 'C' then 'AG. COLETA'
		when 'M' then 'COL. INICIADA'
		when 'F' then 'COLETADO'
		end as tr_status,
		count(cod_pedido) as total_status, (select count(cod_pedido) as total from tb_pedido_coleta) as total
		from tb_pedido_coleta
    	where fl_status <> 'L' and fl_status <> 'D'
		group by fl_status";
	$res_status = mysqli_query($link, $sql_status);

	//$sql_proj = "select t1.*, sum(t2.tr_horas) as horas, t3.r_social, t4.usr_nome
	//	from projeto t1
	//	left join tarefas t2 on t1.id = t2.id_projeto
	//	left join clientes t3 on t1.id_empresa = t3.id
	//	left join usuario t4 on t1.pj_responsavel = t4.id
	//	group by t1.id";
	//$res_proj = mysqli_query($link, $sql_proj);
?>