<?php 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $nr_pedido = $_REQUEST['nr_pedido'];
    
    $sql = "select distinct nr_pedido from tb_pedido_manuseio where nr_pedido = '$nr_pedido'";
    $res = mysqli_query($link,$sql);
    $tr=mysqli_num_rows($res);
    if($tr > 0){

        $retorno[] = array(
            'nr_pedido' => "0",
        );
   

    }else{

        $retorno[] = array(
            'nr_pedido' => "1",
        );
     
        echo(json_encode($retorno));

    }
$link->close();
?>