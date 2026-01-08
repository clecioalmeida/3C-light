<?php

class db {

    //host
    private $host = '109.106.251.202';

    //usuario
    private $usuario = 'gisis';

    //senha
    private $senha = 'wmsweb2017';

    //banco de dados
    private $database = 'gisis';

    public function conecta_mysql(){

        //criar a conexao
        $con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

        //ajustar o charset de comunica��o entre a aplica��o e o banco de dados
        mysqli_set_charset($con, 'utf8');

        //verficar se houve erro de conex�o
        if(mysqli_connect_errno()){
            echo 'Erro ao tentar se conectar com o BD MySQL: '.mysqli_connect_error();  
        }

        return $con;
    }

}

?>