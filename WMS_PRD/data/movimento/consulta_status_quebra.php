<?php 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $nr_pedido = $_REQUEST['nr_pedido'];
    
    $sql = "select distinct fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
    $res = mysqli_query($link,$sql);
    $tr=mysqli_num_rows($res);

    while ($dados=mysqli_fetch_assoc($res)){
        $fl_status = $dados['fl_status'];
    }
    if($fl_status == "M"){

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