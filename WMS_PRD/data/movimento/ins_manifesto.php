<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }
?>
<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
        
$nr_pedido = $_POST['nr_pedido'];
$ds_obs = $_POST['ds_obs'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

foreach($nr_pedido as $pedido){
  $query_pedido="select nr_pedido from tb_minuta_item where nr_pedido = '$pedido'";
  $res_pedido = mysqli_query($link,$query_pedido);
}

if(mysqli_num_rows($res_pedido) > 0){

    $retorno[] = array(
      'info' => "3",
    );
    echo(json_encode($retorno));

}else{

  if(isset($_POST['cod_por'])){


    $cod_por = $_POST['cod_por'];

    $query_port="select * from tb_portaria where id = '$cod_por'";
    $res_port = mysqli_query($link,$query_port);
    while ($dados=mysqli_fetch_assoc($res_port)) {
      $ds_placa=$dados['ds_placa'];
      $ds_nome=$dados['ds_nome'];
    }

    $ins_min = "insert into tb_minuta (nr_placa, nm_motorista, ds_obs, dt_minuta) values ('$ds_placa', '$ds_nome', '$ds_obs', now())";
    $res_ins = mysqli_query($link1, $ins_min);
    $minuta = mysqli_insert_id($link1);

    $user_temp = "insert into tb_log_temp (nm_user, ds_senha, ds_doc, usr_create, dt_create) values ('$ds_placa', '$ds_placa', '$minuta', '$id', now())";
    $res_ins = mysqli_query($link, $user_temp);

    $upd_veic = "update tb_portaria set fl_status = 'C' where ds_placa = '$ds_placa' and fl_status = 'L'";
    $res_upd = mysqli_query($link, $upd_veic);

    foreach($nr_pedido as $pedido){

      $ins_min_item = "insert into tb_minuta_item (cod_minuta, nr_pedido) values ('$minuta', '$pedido')";
      $res_item = mysqli_query($link,$ins_min_item);  
    }

  }else{

    $ds_motorista = $_POST['ds_motorista'];
    $nr_placa = $_POST['nr_placa'];

    $ins_min = "insert into tb_minuta (nr_placa, nm_motorista, ds_obs, dt_minuta) values ('$nr_placa', '$ds_motorista', '$ds_obs', now())";
    $res_ins = mysqli_query($link1, $ins_min);
    $minuta = mysqli_insert_id($link1);

    $user_temp = "insert into tb_log_temp (nm_user, ds_senha, ds_doc, usr_create, dt_create) values ('$nr_placa', '$nr_placa', '$minuta', '$id', now())";
    $res_ins = mysqli_query($link, $user_temp);

    $upd_veic = "update tb_portaria set fl_status = 'C' where ds_placa = '$nr_placa' and fl_status = 'L'";
    $res_upd = mysqli_query($link, $upd_veic);

    foreach($nr_pedido as $pedido){

      $ins_min_item = "insert into tb_minuta_item (cod_minuta, nr_pedido) values ('$minuta', '$pedido')";
      $res_item = mysqli_query($link,$ins_min_item);  
    }

  }  

}

if($res_item){

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