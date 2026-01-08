<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('c');
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_galpao="select t1.id, t1.nome 
from tb_armazem t1
where t1.id_oper = '$cod_cli'";
$galpao = mysqli_query($link,$sql_galpao);

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Cadastros</li><li>Consulta estoque</li>
        </ol>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div>
                        <div class="jarviswidget-editbox">
                            <input class="form-control" type="text">    
                        </div>
                        <div class="widget-body">
                            <section id="widget-grid" class="">
                                <div class="row">

                                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <form class="form-inline" method="POST" id="formConsultaEstoqueGeral" action="">
                                            <fieldset>
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <select class="form-control" id="local" name="local">
                                                            <option value="0">Selecione o local</option>
                                                            <?php
                                                            while($linha = mysqli_fetch_assoc($galpao)){?>
                                                                <option value="<?php echo $linha['id']; ?>"><?php echo $linha['nome']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <input type="submit" class="form-control btn-info" id="btnConsultaEstoqueGeral" value="Pesquisar">
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form><br /><br />
                                        <div id="locais"> Resultado da pesquisa</div>
                                    </article>
                                </div>    
                            </section>
                        </div>  
                    </div>
                </article>
            </div>
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
        </section>
    </div>