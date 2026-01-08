<?php
	require_once("bd_class.php");
	
	$nr_pedido = $_POST['col_ped'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

    $sql_status="select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
    $resultado_status = mysqli_query($link, $sql_status);

    while ($dados_upd=mysqli_fetch_assoc($resultado_status)) {
        $fl_status=$dados_upd['fl_status'];

    }

        if($fl_status == 'A'){

            $sql = "update tb_pedido_coleta set fl_status = 'C' WHERE nr_pedido =  '$nr_pedido'" or die(mysqli_error($sql));
            $resultado_id = mysqli_query($link, $sql);

            if(mysqli_affected_rows($link) > 0){ 


                echo "<script>alert('Pedido liberado para coleta!');</script>";



             }else{ 


                                echo "<script>alert('Erro no cadastro!');</script>";

                         } 

        } else { 

            echo "<script>alert('Pedido já iniciou o processo de picking');</script>";

        }

    $link->close();
    ?>