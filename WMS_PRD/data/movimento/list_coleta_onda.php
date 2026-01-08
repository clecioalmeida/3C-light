<?php
//Incluir a conexão com banco de dados
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$listColeta = $_POST['listColetaOnda'];

$sql = "SELECT C.cod_cliente, P.nr_pedido, C.nm_cliente, C.ds_cidade, P.nm_usuario, P.ds_modalidade, P.dt_entrega_real, P.dt_limite, P.fl_status, P.ds_tipo FROM  tb_pedido_coleta P INNER JOIN tb_cliente C ON P.cod_cliente = C.cod_cliente where P.fl_status = 'C' GROUP BY C.cod_cli_destinatario, P.nr_pedido, P.nm_cliente, P.nm_usuario, P.ds_modalidade, P.dt_entrega_real, P.dt_limite, P.fl_status, P.ds_tipo order by P.nr_pedido desc ";
    
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
<section class="panel col-lg-12">
    <?php
    if($coleta>0){
    ?>
    <legend>Pedidos aguardando coleta</legend>
    <table class="table table-bordered table-hover table-checkable order-column" id="tbConfPed">
        <thead>
            <tr>
                <th> #</th>
                <th> Pedido</th>
                <th> Destinatário </th>
                <th> Cidade </th>
                <th> Modal </th>
                <th> Data limite</th>
                <th> Situação</th>
                <!--th> Iniciar </th>
                <th> Imprimir </th>
                <th> Finalizar </th-->
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($query)){
                ?>
                <tr class="status" data-status="<?php echo $linha['fl_status'];?>">
                    <td style="text-align: center">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" value="<?php echo $linha['nr_pedido'];?>" class="checkboxOnda style-0">
                                <span></span>
                            </label>
                        </div>
                    </td>
                    <td class="onda" style="width: 30px"> <?php echo $linha['nr_pedido'];?> </td>
                    <td> <?php echo $linha['nm_cliente'];?> </td>
                    <td> <?php echo $linha['ds_cidade'];?> </td>
                    <td style="width: 100px"> <?php echo $linha['ds_modalidade'];?> </td>
                    <td style="width: 100px">
                            <?php 

                            if(date ("d/m/Y", strtotime($linha['dt_limite'])) == strtotime($hoje) && $linha['ds_modalidade'] == 'P'){
                            echo "<style>.mudacor{background-color:".$cor1.";}</style>"; 
                            } 

                            else{ 

                                echo "<style>.mudacor{background-color:".$cor2.";}</style>";

                            } 

                            echo date("d/m/Y", strtotime($linha['dt_limite']));
                            ?> 
                            
                    </td>
                    <td id="status" style="width: 180px"> <?php 
                                if ($linha['fl_status'] == 'A') {
                                echo '<bold>ABERTO</bold>';
                                }elseif ($linha['fl_status'] == 'P') {
                                    echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
                                }elseif ($linha['fl_status'] == 'E') {
                                    echo '<bold>EXPEDIÇAO</bold>';
                                }elseif ($linha['fl_status'] == 'C') {
                                    echo '<bold>AGUARDANDO COLETA</bold>';
                                }elseif ($linha['fl_status'] == 'M') {
                                    echo '<bold>AGUARDANDO ONDA</bold>';
                                }elseif($linha['fl_status'] == 'F') {
                                    echo '<bold>COLETADO</bold>';
                                }elseif($linha['fl_status'] == 'X'){
                                    echo '<bold>EXPEDIÇÃO</bold>';
                                }
                            ?>  
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
        //console.log(status_);
    });
</script>