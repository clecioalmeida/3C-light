<?php
require_once("bd_class.php");

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();
$link3 = $objDb->conecta_mysql();

$nr_pedido = mysqli_real_escape_string($link, $_POST["del_ped"]);

$select_1="select distinct fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
$res_upd_1=mysqli_query($link, $select_1);
if(mysqli_num_rows($res_upd_1) > 0){
    while ($dados_upd=mysqli_fetch_assoc($res_upd_1)) {
        $fl_status=$dados_upd['fl_status'];

        if($fl_status == 'A' || $fl_status == 'C'){

            $sql_upd_1 = "delete from tb_pedido_coleta WHERE nr_pedido = '$nr_pedido'";
            $resultado_id_1 = mysqli_query($link3, $sql_upd_1);

            if(mysqli_affected_rows($link3) > 0){

                $sql_upd_2 = "delete from tb_pedido_coleta_produto WHERE nr_pedido = '$nr_pedido'";
                $resultado_id_2 = mysqli_query($link2, $sql_upd_2);

                $sql_upd_3 = "delete from tb_mb51e WHERE nr_pedido = '$nr_pedido'";
                $resultado_id_3 = mysqli_query($link2, $sql_upd_3);


                $retorno[] = array(
                    'info' => "0",
                );

                echo(json_encode($retorno));

            }else{

                $retorno[] = array(
                    'info' => "2",
                );

                echo(json_encode($retorno));

            }


        }else{

            $retorno[] = array(
                'info' => "1",
            );

            echo(json_encode($retorno));
            
        }
    }
}

$link->close();
$link1->close();
$link2->close();
$link3->close();
?>