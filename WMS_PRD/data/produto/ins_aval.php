<!DOCTYPE html>
<html lang="pt-br">
    <head>
    </head>
    <body>
    <div class="container theme-showcase" role="main">
<?php

    require_once('bd_class.php');

    $nm_avaliacao = $_POST['nm_avaliacao'];
    $nr_valor = $_POST['nr_valor'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = " insert into tb_avaliacao (nm_avaliacao, nr_valor) values ('$nm_avaliacao', '$nr_valor') ";

     
        $resultado_id = mysqli_query($link, $sql);

            if(mysqli_affected_rows($link) > 0){ ?>

    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Registro incluído com sucesso!</h4>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#conf_cadastro').modal('show');
        });
    </script>

    <?php }else{ ?>    

    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                </div>
                <div class="modal-body">                                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>          
    <script>
        $(document).ready(function () {
            $('#conf_cadastro').modal('show');
        });
    </script>
    <?php } 

    
    $link->close();
    ?>
    </div>

</body>
</html>