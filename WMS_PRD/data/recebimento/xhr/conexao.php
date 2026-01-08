<?
//DADOS PARA CONEX�O
$servidor   =   "195.35.61.56";   //SERVIDOR
$bd         =   "gisis";       //DATABASE
$usuario    =   "gisis";        //USU�RIO
$senha      =   "wmsweb2017";            //SENHA

//CONECTANDO
$conexao    =   @mysql_connect($servidor, $usuario, $senha) 
             or die("ERRO NA CONEX�O");

//SELECIONA O DATABASE A SER UTILIZADO
$db      =   @mysql_select_db($bd, $conexao)
             or die("ERRO NA SELE��O DO DATABASE");
?>