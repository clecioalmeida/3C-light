<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;
} else {

  $id_user = $_SESSION["id"];
  $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$id_tar = $_POST['id_tar'];

$query_conf = "SELECT t1.id as id_tar, t6.id as id_end, t1.id_etq, t1.id_galpao, t1.id_rua, t1.id_coluna, t1.id_altura, t1.nr_volume, 
t1.id_inv,t1.id_produto, t1.fl_tipo, t1.ds_lp, t1.ds_kva, t1.ds_serial, t1.ds_fabr, t1.ds_ano, t2.*, 
round(COALESCE(t5.nr_qtde,'0'),0) as qtd_est, t3.cod_prod_cliente, COALESCE(t5.cod_estoque,0) as cod_estoque
from tb_inv_tarefa t1
left join tb_inv_conf t2 on t1.id = t2.id_tar
left join tb_produto t3 on t1.id_produto = t3.cod_produto
left join tb_posicao_pallet t5 on t1.id_estoque = t5.cod_estoque
left join tb_endereco t6 on t1.id_rua = t6.rua and t1.id_coluna = t6.coluna and t1.id_altura = t6.altura
where t1.id = '$id_tar' and t1.fl_status = 'A'
GROUP BY t1.id";
$res_conf = mysqli_query($link, $query_conf);

while ($dados_conf = mysqli_fetch_assoc($res_conf)) {
  $id_tar             = $dados_conf['id_tar'];
  $id_galpao          = $dados_conf['id_galpao'];
  $id_rua             = $dados_conf['id_rua'];
  $id_coluna          = $dados_conf['id_coluna'];
  $id_altura          = $dados_conf['id_altura'];
  $nr_volume          = $dados_conf['nr_volume'];
  $id_inv             = $dados_conf['id_inv'];
  $id_produto         = $dados_conf['id_produto'];
  $cod_produto        = $dados_conf['cod_prod_cliente'];
  $qtd_inv            = $dados_conf['cont_2'];
  $qtd_est            = $dados_conf['qtd_est'];
  $cod_estoque        = $dados_conf['cod_estoque'];
  $id_etq             = $dados_conf['id_etq'];
  $fl_tipo            = $dados_conf['fl_tipo'];
  $ds_lp              = $dados_conf['ds_lp'];
  $ds_kva             = $dados_conf['ds_kva'];
  $ds_serial          = $dados_conf['ds_serial'];
  $ds_fabr            = $dados_conf['ds_fabr'];
  $ds_ano             = $dados_conf['ds_ano'];
  $id_end             = $dados_conf['id_end'];

  // VERIFICA SE EXISTE POSIÇÃO PARA O PRODUTO INVENTARIADO, SENÃO CRIA NOVA POSIÇÃO E FINALIZA //

  if ($cod_estoque > 0) {

    if ($qtd_inv != $qtd_est) {

      $tipo_tar = "D";
    } else {

      $tipo_tar = "N";
    }

    $ins_log = "INSERT into tb_log_tarefa (
        id_tar, cod_estoque, cod_etq, nr_qtd_est, nr_qtd_inv, fl_tipo, usr_create, dt_create
        ) values (
          '$id_tar', '$cod_estoque', '$id_etq', '$qtd_est', '$qtd_inv', '$tipo_tar', '$id_user', '$date'
          )";
    $res_log = mysqli_query($link2, $ins_log);

    if (mysqli_affected_rows($link2) > 0) {

      $updt_conf = "UPDATE tb_inv_tarefa set fl_status = 'X' where id = '" . $id_tar . "'";
      $res_updt = mysqli_query($link1, $updt_conf);

      $updt_est = "UPDATE tb_posicao_pallet set 
        nr_qtde = '$qtd_inv', ds_lp = '$ds_lp', n_serie	 = '$ds_serial', ds_kva = '$ds_kva', ds_ano = '$ds_ano', 
        ds_fabr = '$ds_fabr', id_tar = '$id_tar', user_update = '$id_user', dt_update = '$date', ds_lp = '$ds_lp' 
        where cod_estoque = '$cod_estoque'";
      $res_est  = mysqli_query($link1, $updt_est);

      if (mysqli_affected_rows($link1) > 0) {

        $teste = "Alterado.";
      } else {

        $teste = "Não alterado.";
      }
    } else {
      
      $teste = "Não alterado.";

      /*$updt_conf = "UPDATE tb_inv_tarefa set fl_status = 'X' where id = '" . $id_tar . "'";
      $res_updt = mysqli_query($link1, $updt_conf);

      $ins_log = "INSERT into tb_log_tarefa (
        id_tar, cod_estoque, cod_etq, nr_qtd_est, nr_qtd_inv, fl_tipo, usr_create, dt_create
        ) values (
          '$id_tar', '$cod_estoque', '$id_etq', '$qtd_est', '$qtd_inv', 'B', '$id_user', '$date'
          )";
      $res_log = mysqli_query($link2, $ins_log);*/
    }
  } else {

    $ins_pos = "INSERT into tb_posicao_pallet (
      produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_volume, nr_qtde, id_endereco, ds_lp, n_serie, ds_kva, ds_ano, 
        ds_fabr, fl_status, fl_tipo, fl_bloq, fl_empresa, id_tar, usr_create, dt_create
      ) values (
        '$cod_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$nr_volume', '$qtd_inv', '$id_end',
        '$ds_lp', '$ds_serial', '$ds_kva', '$ds_ano', '$ds_fabr', 'A', 'I', 'N', '$cod_cli', '$id_tar', '$id_user', '$date'
        )";
    $res_pos = mysqli_query($link2, $ins_pos);

    if (mysqli_affected_rows($link2) > 0) {

      $nEst = mysqli_insert_id($link2);

      $updt_conf = "UPDATE tb_inv_tarefa set fl_status = 'X', id_estoque = '$nEst' where id = '$id_tar'";
      $res_updt = mysqli_query($link1, $updt_conf);

      $updt_est = "UPDATE tb_posicao_pallet set 
        fl_status = 'E'
        where cod_estoque = '$cod_estoque'";
      $res_est  = mysqli_query($link1, $updt_est);

      $ins_log = "INSERT into tb_log_tarefa (
        id_tar, cod_estoque, nr_qtd_est, nr_qtd_inv, fl_tipo, usr_create, dt_create
        ) values (
          '$id_tar', '$nEst', '0', '$qtd_inv', 'C', '$id_user', '$date'
          )";
      $res_log = mysqli_query($link2, $ins_log);
    }
  }
}

// VERIFICA SE TODAS AS TAREFAS FORAM BAIXADAS //

$conf = "select user_create
from tb_inv_tarefa
where id = '$id_tar' and fl_status = 'A'";
$res = mysqli_query($link, $conf);

if (mysqli_num_rows($res) > 0) {

  echo "Não foi possível finalizar todas as tarefas.";
} else {

  echo "Tarefas finalizadas.";
}

$link->close();
?>