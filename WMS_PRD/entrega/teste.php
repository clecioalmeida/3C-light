<?php
session_start();
include_once("data/movimento/bd_class.php");
$objDb = new db();
    $link = $objDb->conecta_mysql();    


$SQL = "select cod_cliente, nm_usuario, avatar, cod_cli from tb_cliente where nm_usuario = 'EDUARDO' and ds_senha = 'MENOCIO' and (fl_tipo = 'F' or fl_nivel = 'U' or fl_nivel = 'P') and fl_status = '1' "; 
        $res = mysqli_query($link,$SQL); 

        $dados = mysqli_fetch_assoc($res);
        
        //Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
        if(isset($dados)){
            $_SESSION['id'] = $dados['cod_cliente'];
            $_SESSION['usuario'] = $dados['nm_usuario'];
            echo $_SESSION['usuario'];
        }else{   
            //Váriavel global recebendo a mensagem de erro
            $_SESSION['loginErro'] = "Usuário ou senha Inválido";
            echo $_SESSION['loginErro'];
        }
?>