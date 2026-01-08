<?php

 define('HOST', 'sql449.main-hosting.eu');  
 define('DBNAME', 'u478097083_3cAg');  
 define('CHARSET', 'utf8');  
 define('USER', 'u478097083_Agdn3C');  
 define('PASSWORD', 'Agn#3C2022');  

 class Conexao {  

    private static $pdo;
 
    private function __construct() {  
     
    } 
    public static function getInstance() {  
      if (!isset(self::$pdo)) {  
        try {  
          $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', PDO::ATTR_PERSISTENT => TRUE,PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
          self::$pdo = new PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . "; charset=" . CHARSET . ";", USER, PASSWORD, $opcoes);
        } catch (PDOException $e) {  
          print "Erro: " . $e->getMessage();  
        }  
      }  
      return self::$pdo;  
    }  
  }