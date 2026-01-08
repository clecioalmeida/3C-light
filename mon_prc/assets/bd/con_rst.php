<?php 
 
 define('HOST', 'sql449.main-hosting.eu');  
 define('DBNAME', 'u478097083_3cRstStg');  
 define('CHARSET', 'utf8');  
 define('USER', 'u478097083_ArgRstStg');  
 define('PASSWORD', '3c#2021Rst');  

 class Conexao {  

   private static $pdo;

   private function __construct() {  
    
   } 
   public static function getInstance() {  
     if (!isset(self::$pdo)) {  
       try {  
         $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', PDO::ATTR_PERSISTENT => TRUE);  
         self::$pdo = new PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . "; charset=" . CHARSET . ";", USER, PASSWORD, $opcoes);  
       } catch (PDOException $e) {  
         print "Erro: " . $e->getMessage();  
       }  
     }  
     return self::$pdo;  
   }  
 }