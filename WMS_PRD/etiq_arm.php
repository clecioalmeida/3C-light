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
left join tb_galpao t2 on t1.galpao = t2.cod_galpao
where t2.fl_empresa = '$cod_cli'";
$galpao = mysqli_query($link,$sql_galpao);

$sql_galpao_fim="select t1.id, t1.nome 
from tb_armazem t1
left join tb_galpao t2 on t1.galpao = t2.cod_galpao
where t2.fl_empresa = '$cod_cli'";
$galpao_fim = mysqli_query($link,$sql_galpao_fim);
$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Cadastros</li><li>Impressão de etiquetas de endereço de estoque</li>
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
                                        <form class="form-inline" method="POST" id="formConsultaEstoque" action="data/armazem/relatorios/list_etq_all.php" target="_blank">
                                            <fieldset>
                                                <h4>Selecione o intervalo de endereços</h4><br />
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <h3>Início</h3>
                                                        <select class="form-control" id="local_inicio" name="local_inicio">
                                                            <option value="0">Selecione o galpão</option>
                                                            <?php
                                                            while($linha = mysqli_fetch_assoc($galpao)){?>
                                                                <option value="<?php echo $linha['id']; ?>"><?php echo $linha['nome']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <select class="form-control" id="rua_inicio" name="rua_inicio">
                                                            <option value="0">Selecione a rua </option>
                                                            
                                                        </select>
                                                        <select class="form-control" id="coluna_inicio" name="coluna_inicio">
                                                            <option value="0">Selecione a coluna </option>
                                                            
                                                        </select>
                                                        <select class="form-control" id="altura_inicio" name="altura_inicio">
                                                            <option value="0">Selecione a altura </option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <h3>Fim</h3>
                                                        <select class="form-control" id="local_fim" name="local_fim">
                                                            <option value="0">Selecione o galpão</option>
                                                            <?php
                                                            while($linha = mysqli_fetch_assoc($galpao_fim)){?>
                                                                <option value="<?php echo $linha['id']; ?>"><?php echo $linha['nome']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <select class="form-control" id="rua_fim" name="rua_fim">
                                                            <option value="0">Selecione a rua </option>
                                                            
                                                        </select>
                                                        <select class="form-control" id="coluna_fim" name="coluna_fim">
                                                            <option value="0">Selecione a coluna </option>
                                                            
                                                        </select>
                                                        <select class="form-control" id="altura_fim" name="altura_fim">
                                                            <option value="0">Selecione a altura </option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset><br>
                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="submit" class="form-control btn-info" id="btnConsEtiqEnd" value="Pesquisar">
                                                    <input type="submit" class="form-control btn-primary" id="btnPrintEtiqEnd" value="Imprimir todas">
                                                </div>
                                            </fieldset>
                                        </form>
                                        <hr>


                                    </article>         
                                </div> 
                                <div id="retornoEtq"></div>  
                            </section>
                        </div>
                    </div>
                </article>
            </div>
            <div class="row">

            </div>
        </section>           
    </div>
</div>
<script>
    $(document).ready(function()
    {

        $('#local_inicio').on('change', function()
        {
            event.preventDefault();
            if( $(this).val() ) 
            {
                $('#rua_inicio').hide();
                $.getJSON('data/armazem/consulta_rua.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j)
                {
                    var options = '<option value="">Selecione a rua </option>';
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
                    }
                    $('#rua_inicio').html(options).show();
                });
            } else 
            {
                $('#rua_inicio').html('<option value="">Selecione a rua </option>');
            }
            return false;
        });

        $('#rua_inicio').on('change', function()
        {
            if( $(this).val() ) 
            {
                $('#coluna_inicio').hide();
                $.getJSON('data/armazem/consulta_coluna.php?search=',{id_rua: $(this).val(), ajax: 'true'}, function(j)
                {
                    var options = '<option value="">Selecione a coluna </option>';
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].coluna + '">' + j[i].coluna + '</option>';
                    }
                    $('#coluna_inicio').html(options).show();
                });
            } else 
            {
                $('#coluna_inicio').html('<option value="">Selecione a coluna </option>');
            }
            return false;
        });

        $('#coluna_inicio').on('change', function()
        {
            if( $(this).val() ) 
            {
                $('#altura_inicio').hide();
                $.getJSON('data/armazem/consulta_altura.php?search=',{id_coluna: $(this).val(), ajax: 'true'}, function(j)
                {
                    var options = '<option value="">Selecione a altura </option>';
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].altura + '">' + j[i].altura + '</option>';
                    }
                    $('#altura_inicio').html(options).show();
                });
            } else 
            {
                $('#altura_inicio').html('<option value="">Selecione a altura </option>');
            }
            return false;
        });

        $('#local_fim').on('change', function()
        {
            if( $(this).val() ) 
            {
                $('#rua_fim').hide();
                $.getJSON('data/armazem/consulta_rua.php?search=',{id_galpao: $(this).val(), ajax: 'true'}, function(j)
                {
                    var options = '<option value="">Selecione a rua </option>';
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
                    }
                    $('#rua_fim').html(options).show();
                });
            } else 
            {
                $('#rua_fim').html('<option value="">Selecione a rua </option>');
            }
            return false;
        });

        $('#rua_fim').on('change', function()
        {
            if( $(this).val() ) 
            {
                $('#coluna_fim').hide();
                $.getJSON('data/armazem/consulta_coluna.php?search=',{id_rua: $(this).val(), ajax: 'true'}, function(j)
                {
                    var options = '<option value="">Selecione a coluna </option>';
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].coluna + '">' + j[i].coluna + '</option>';
                    }
                    $('#coluna_fim').html(options).show();
                });
            } else 
            {
                $('#coluna_fim').html('<option value="">Selecione a coluna </option>');
            }
            return false;
        });

        $('#coluna_fim').on('change', function()
        {
            if( $(this).val() ) 
            {
                $('#altura_fim').hide();
                $.getJSON('data/armazem/consulta_altura.php?search=',{id_coluna: $(this).val(), ajax: 'true'}, function(j)
                {
                    var options = '<option value="">Selecione a altura </option>';
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].altura + '">' + j[i].altura + '</option>';
                    }
                    $('#altura_fim').html(options).show();
                });
            } else 
            {
                $('#altura_fim').html('<option value="">Selecione a altura </option>');
            }
            return false;
        });
    });
</script>
<script>
    $(document).ready(function()
    {

        $('#btnConsEtiqEnd').on('click', function()
        {
            event.preventDefault();
            $('#btnConsEtiqEnd').prop("disabled", true);
            var local_inicio    = $('#local_inicio').val();
            var rua_inicio      = $('#rua_inicio').val();
            var coluna_inicio   = $('#coluna_inicio').val();
            var altura_inicio   = $('#altura_inicio').val();
            var local_fim       = $('#local_fim').val();
            var rua_fim         = $('#rua_fim').val();
            var coluna_fim      = $('#coluna_fim').val();
            var altura_fim      = $('#altura_fim').val();

            if(local_inicio == '' || rua_inicio == '' || coluna_inicio == '' || altura_inicio == '' || local_fim == '' || rua_fim == '' || coluna_fim == '' || altura_fim == '')
            {

                alert("Todos os campos devem ser preenchidos!");
                $('#btnConsEtiqEnd').prop("disabled", false);

            }else
            {

                $.ajax
                ({
                    url:"data/armazem/list_end_arm.php",
                    method:"POST",
                    data:{
                        local_inicio    :local_inicio,
                        rua_inicio      :rua_inicio,
                        coluna_inicio   :coluna_inicio,
                        altura_inicio   :altura_inicio,
                        local_fim       :local_fim,
                        rua_fim         :rua_fim,
                        coluna_fim      :coluna_fim,
                        altura_fim      :altura_fim
                    },
                    success:function(j)
                    {
                        $('#btnConsEtiqEnd').prop("disabled", false);
                        $('#btnPrintEtiqEnd').prop("disabled", false);
                        $('#retornoEtq').html(j);
                    }
                });

            } 
            return false;          
        });
    });
</script>