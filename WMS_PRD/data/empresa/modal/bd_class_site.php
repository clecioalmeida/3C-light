<?php

class db {

    //host
    private $host = '109.106.251.202';

    //usuario
    private $usuario = 'u846824167_u8468';

    //senha
    private $senha = 'gup21877#';

    //banco de dados
    private $database = 'u846824167_extac';

    public function conecta_mysql(){

        //criar a conexao
        $con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

        //ajustar o charset de comunicação entre a aplicação e o banco de dados
        mysqli_set_charset($con, 'utf8');

        //verficar se houve erro de conexão
        if(mysqli_connect_errno()){
            echo 'Erro ao tentar se conectar com o BD MySQL: '.mysqli_connect_error();  
        }

        return $con;
    }

}

?>