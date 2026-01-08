<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$listEmbalagem = $_POST['listEmbalagem'];

$sql = "select * from tb_embalagem";
    
$query = mysqli_query($link,$sql);
$coleta = mysqli_num_rows($query);
$hoje=date('d/m/Y');
$cor1='#FF6347';
$cor2='#9AFF9A';
$cor3='#FFFF00';
$link->close();
?>
<style type="text/css">
    .ocupado {
        background-color: #F08080;
    }

    .livre {
        background-color: #7FFFD4;
    }

    .alerta {
        background-color: #EEDD82;
    }

    .finalizado {
        background-color: #ADD8E6;
    }
</style>
<section class="panel col-lg-12" id="tbColeta">
    <?php
    if($coleta>0){
    ?>
    <legend>Embalagens cadastradas</legend>
    <table class="table table-bordered table-hover table-checkable order-column" id="tbConfPed">
        <thead>
            <tr>
                <th> Id</th>
                <th> Descrição </th>
                <th> Cubado </th>
                <th> Peso </th>
                <th> Comprimento</th>
                <th> Largura</th>
                <th> Altura </th>
                <th> Cliente </th>
                <th> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($query)){
                ?>
                <tr>
                    <td> <?php echo $linha['id'];?> </td>
                    <td> <?php echo $linha['ds_tipo'];?> </td>
                    <td> <?php echo $linha['nr_cubado'];?> </td>
                    <td> <?php echo $linha['nr_peso'];?> </td>
                    <td> <?php echo $linha['nr_comprimento'];?> </td>
                    <td> <?php echo $linha['nr_largura'];?> </td>
                    <td> <?php echo $linha['nr_altura'];?> </td>
                    <td> <?php echo $linha['id_cliente'];?> </td>
                    <td style="text-align: center; width: 5px">
                    	<button type="submit" id="btnStartCol" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Detalhe</button>
                    </td>
                </tr> 
                <?php }?>
            </tbody>
        </table>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>
</section>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var status_ = new Array();
        $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "C"){
                $this.addClass('ocupado');
            }else if(status_[i] == "M"){
                $this.removeClass('ocupado').addClass('alerta');
            }else if(status_[i] == "F"){
                $this.removeClass('ocupado').addClass('livre');
            }else if (status_[i] == "P"){
                $this.removeClass('ocupado').addClass('finalizado');
            }
        });
    });
</script>