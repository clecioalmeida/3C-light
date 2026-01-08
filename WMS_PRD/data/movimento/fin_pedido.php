
<?php 
    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $nr_pedido = mysqli_real_escape_string($link, $_POST["nr_pedido"]);
    
    $sql = "CALL prc_coleta_fim('$nr_pedido', 2)";
    $res = mysqli_query($link,$sql);

	//session_unset($_SESSION['novo_pedido']);
$link->close();
?>