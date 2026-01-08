<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$sql_etq ="select t1.id, t1.id_produto, t1.id_galpao, t1.id_rua, t1.id_coluna, t1.id_altura, t1.nr_volume,t3.cont_2, t4.cod_prod_cliente, t1.fl_empresa, t2.cod_estoque
from tb_inv_tarefa t1
left join tb_posicao_pallet t2 on t1.id = t2.id_tar
left join tb_inv_conf t3 on t1.id = t3.id_tar
left join tb_produto t4 on t1.id_produto = t4.cod_produto
where t1.fl_empresa = 4 and t1.id_produto > 0 and t1.id_rua = 'J' and date(t1.dt_create) >= '2019-12-18'
order by t1.id_coluna";
$res_id=mysqli_query($link, $sql_etq);

while ($dados=mysqli_fetch_assoc($res_id)) {
  $id_galpao=$dados['id_galpao'];
  $id_rua=$dados['id_rua'];
  $id_coluna=$dados['id_coluna'];
  $id_altura=$dados['id_altura'];
  $nr_volume=$dados['nr_volume'];
  $id_produto=$dados['id_produto'];
  $cod_prod_cliente=$dados['cod_prod_cliente'];
  $nr_qtde=$dados['cont_2'];
  $id_tar=$dados['id'];
  $fl_empresa=$dados['fl_empresa'];
  $cod_estoque=$dados['cod_estoque'];

  if($cod_estoque == ''){

    $ins_saldo="insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_volume, nr_qtde, nm_user_mov, dt_user_mov, fl_status, fl_tipo, fl_empresa, fl_bloq, id_tar, usr_create, dt_create) values ('$cod_prod_cliente', '$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$nr_volume', '$nr_qtde', '$id', '$date', 'A', 'I', '4', 'N', '$id_tar', '1', '$date')";
    $res_saldo=mysqli_query($link, $ins_saldo);

    $updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
    $res_updt=mysqli_query($link1, $updt_conf);
    $tr_upd=mysqli_affected_rows($link1);

    if($tr_upd > 0){

    echo "Galpao ".$id_galpao."Rua ".$id_rua."Coluna ".$id_coluna."Altura ".$id_altura."Volume ".$nr_volume."Produto ".$id_produto."Cod Cliente ".$cod_prod_cliente."Qtde ".$nr_qtde."Tarefa ".$id_tar."CodEstque".$cod_estoque."<br>";



    }else{

      echo "Não gravou.<br>";

    }

  }else{

    $ins_saldo="insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_volume, nr_qtde, nm_user_mov, dt_user_mov, fl_status, fl_tipo, fl_empresa, fl_bloq, id_tar, usr_create, dt_create) values ('$cod_prod_cliente', '$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$nr_volume', '$nr_qtde', '$id', '$date', 'A', 'I', '4', 'N', '$id_tar', '1', '$date')";
    $res_saldo=mysqli_query($link, $ins_saldo);

    $updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
    $res_updt=mysqli_query($link1, $updt_conf);
    $tr_upd=mysqli_affected_rows($link);   

    $updt_conf="update tb_posicao_pallet set fl_status = 'E', nr_qtde = '0', id_tar = '$id_tar', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
    $res_updt=mysqli_query($link1, $updt_conf);
    $tr_upd=mysqli_affected_rows($link1);

    if(mysqli_affected_rows($link1) > 0){

      echo "cod_estoque ".$cod_estoque." alterado.<br>";

    }else{

      echo "Erro na alteração.<br>";

    }

  }
/*echo "GAlpao ".$id_galpao."Rua ".$id_rua."Coluna ".$id_coluna."Altura ".$id_altura."Volume ".$nr_volume."Produto ".$id_produto."Cod Cliente ".$cod_prod_cliente."Qtde ".$nr_qtde."Tarefa ".$id_tar."<br>";

  $sql_end = "select ds_prateleira, ds_coluna, ds_altura, produto, nr_qtde from tb_posicao_pallet where ds_prateleira = '$id_rua' and ds_coluna = '$ds_coluna' and ds_altura = '$ds_altura' and produto = '$cod_prod_cliente' and fl_empresa =  4 order by ds_prateleira, ds_coluna, ds_altura";
  $res_end = mysqli_query($link, $sql_end);
  while ($end=mysqli_fetch_assoc($res_end)) {
  $ds_prateleira=$dados['ds_prateleira'];
  $ds_coluna=$end['ds_coluna'];
  $ds_altura=$end['ds_altura'];
  $produto_e=$end['produto'];
  $nr_qtde_e=$end['nr_qtde'];

  echo "ds_prateleira ".$ds_prateleira."Rua ".$ds_coluna."Coluna ".$ds_altura."produto ".$produto_e."nr_qtde ".$nr_qtde_e."<br>";
}*/
/*$ins_saldo="insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_volume, nr_qtde, nm_user_mov, dt_user_mov, fl_status, fl_tipo, fl_empresa, fl_bloq, id_tar, usr_create, dt_create) values ('$cod_prod_cliente', '$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$nr_volume', '$nr_qtde', '$id', '$date', 'A', 'I', '$cod_cli', 'N', '$id_tar', '$id', '$date')";
$res_saldo=mysqli_query($link, $ins_saldo);

$updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
$res_updt=mysqli_query($link1, $updt_conf);
$tr_upd=mysqli_affected_rows($link1);*/
}

/*for ($i = 1; $i <= $dados['nr_volume']; $i++) {

    $x = $dados['nr_qtde'];
    $y = $dados['nr_volume'];
    $z = $x%$y;
    $vol = ($dados['nr_qtde']-$z)/$dados['nr_volume'];

    $qtde_vol += $vol;
    
    echo "Sobra: ".$z."<br>";

    if($qtde_vol + $z == $dados['nr_qtde']){

        $final = $vol + $z;
        $total = $qtde_vol + $z;
        echo " Final ".$final."<br>";
        echo " Total ".$total."<br>";

    }else{


        echo "Volume: ".$vol."<br>";

    }
  }*/

  $link->close();
  $link1->close();
  ?>