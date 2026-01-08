<?php

$del_file =$_POST["file"];

if (!unlink($del_file)){

  echo ("Erro ao deletar $del_file.");

}else{

  echo ("Deletado $del_file com sucesso!");

} 

?>