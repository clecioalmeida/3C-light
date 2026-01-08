<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$sql_etq ="select id, rua, coluna from tb_endereco";
$res_id=mysqli_query($link, $sql_etq);

while ($dados=mysqli_fetch_assoc($res_id)) {
  $rua=$dados['rua'];
  $coluna=$dados['coluna'];
  $id_end=$dados['id'];

  echo "id: ".$id."Rua: ".$rua."Coluna: ".$coluna."<br>";

  $updt_conf="update tb_endereco set coluna = '$rua' and rua = '$coluna' where id = '$id_end'";
  $res_updt=mysqli_query($link1, $updt_conf);

  if(mysqli_affected_rows($link1) > 0){

    echo "Funcionou.<br>";

  }else{

    echo "Não funcionou.<br>";

  }
}
    /*$ins_saldo="insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_volume, nr_qtde, nm_user_mov, dt_user_mov, fl_status, fl_tipo, fl_empresa, fl_bloq, id_tar, usr_create, dt_create) values ('$cod_prod_cliente', '$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$nr_volume', '$nr_qtde', '$id', '$date', 'A', 'I', '$cod_cli',, 'N', '$id_tar', '$id', '$date')";
    $res_saldo=mysqli_query($link, $ins_saldo);

    $updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
    $res_updt=mysqli_query($link1, $updt_conf);
    $tr_upd=mysqli_affected_rows($link1);*/
//}

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