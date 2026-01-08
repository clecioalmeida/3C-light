<?php
	require_once("bd_class.php");
	
    $objDb = new db();
	$link = $objDb->conecta_mysql();
    $link1 = $objDb->conecta_mysql();
    $link2 = $objDb->conecta_mysql();

    $nr_pedido = mysqli_real_escape_string($link, $_POST["del_ped"]);

    $select_upd="select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
    $res_upd=mysqli_query($link1, $select_upd);
    $res=mysqli_num_rows($res_upd);

        while ($dados_upd=mysqli_fetch_assoc($res_upd)) {
            $fl_status=$dados_upd['fl_status'];

            if($fl_status != 'A'){

                include "err_del_pedido.php";

            }else {

                $sql_upd_1 = "update tb_pedido_coleta set fl_status = 'D' WHERE nr_pedido = '$nr_pedido'" or die(mysqli_error($sql_upd_1));
                $resultado_id_1 = mysqli_query($link1, $sql_upd_1);

                if (mysqli_affected_rows($link1) > 0){

                    include "success_upd.php";

                }else {

                    include "err_upd.php";
                }
        }
    }

    
    
    $link->close();
    ?>