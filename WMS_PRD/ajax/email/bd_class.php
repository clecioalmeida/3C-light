<?php



//$caminho_do_arquivo = '../../config/db_config.php';
$caminho_do_arquivo =  '../../config/db_config.php';

if (file_exists($caminho_do_arquivo)) {
    include $caminho_do_arquivo;
  // echo "O include foi processado com sucesso (o arquivo existe).";
} else {
    echo "Erro: O arquivo $caminho_do_arquivo não foi encontrado.";
    // Você pode optar por parar a execução aqui, se necessário
    // die();
}



//require_once __DIR__ . '../config/db_config.php';


//class db {
//
//    //host
//    private $host = '109.106.251.202';
//
//    //usuario
//    private $usuario = 'u478097083_3cLgtRj';
//
//    //senha
//    private $senha = '3cLight22#';
//
//    //banco de dados
//    private $database = 'u478097083_3cLgtRjP';
//
//    public function conecta_mysql(){
//
//        //criar a conexao
//        $con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
//
//        //ajustar o charset de comunicação entre a aplicação e o banco de dados
//        mysqli_set_charset($con, 'utf8');
//
//        //verficar se houve erro de conexão
//        if(mysqli_connect_errno()){
//            echo 'Erro ao tentar se conectar com o BD MySQL: '.mysqli_connect_error();
//        }
//
//        return $con;
//    }
//
//}

?>