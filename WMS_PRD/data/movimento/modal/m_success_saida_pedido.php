<?php
session_start();

session_unset('novo_pedido');

if(isset($_SESSION['novo_pedido'])){

    include 'm_conf_saida_erro.php';

}else{

    include "m_conf_saida_ok.php";

}
?>
