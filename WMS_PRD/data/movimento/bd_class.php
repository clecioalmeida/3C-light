<?php
$db_destino = new mysqli('localhost', 'logistica3c_wmsLight', '#wmsLight2025$', 'logistica3c_wms_light');
class db {

    //host
    private $host = 'localhost';

    //usuario
    private $usuario = 'logistica3c_wmsLight';

    //senha
    private $senha = '#wmsLight2025$';

    //banco de dados
    private $database = 'logistica3c_wms_light';

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