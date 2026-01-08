<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
//$listColeta = $_POST['listColeta'];

$sql = "SELECT C.cod_cliente, P.nr_pedido, C.nm_cliente, C.ds_cidade, P.nm_usuario, P.ds_modalidade, P.dt_entrega_real, P.dt_limite, P.fl_status, P.ds_tipo FROM  tb_pedido_coleta P INNER JOIN tb_cliente C ON P.cod_cliente = C.cod_cliente where P.fl_status = 'C' or P.fl_status = 'P' or P.fl_status = 'F' or P.fl_status = 'M' or P.fl_status = 'R' GROUP BY C.cod_cli_destinatario, P.nr_pedido, P.nm_cliente, P.nm_usuario, P.ds_modalidade, P.dt_entrega_real, P.dt_limite, P.fl_status, P.ds_tipo order by P.nr_pedido desc ";
    
$query = mysqli_query($link,$sql);
$coleta = mysqli_num_rows($query);
$hoje=date('d/m/Y');
$cor1='#FF6347';
$cor2='#9AFF9A';
$cor3='#FFFF00';
$link->close();
?>
<?php
    if($coleta>0){
    ?>
    <legend>Pedidos aguardando coleta</legend>
    <table class="table table-bordered table-hover table-checkable order-column" id="tbConfPed">
        <thead>
            <tr>
                <th> Pedido</th>
                <th> Destinatário </th>
                <th> Cidade </th>
                <th> Modal </th>
                <th> Data limite</th>
                <th> Situação</th>
                <th> Iniciar </th>
                <th> Imprimir </th>
                <th> Finalizar </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($query)){
                ?>
                <tr class="status" data-status="<?php echo $linha['fl_status'];?>">
                    <td style="width: 30px"> <?php echo $linha['nr_pedido'];?> </td>
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
                                    echo '<bold>COLETA INICIADA</bold>';
                                }elseif($linha['fl_status'] == 'F') {
                                    echo '<bold>COLETADO</bold>';
                                }elseif($linha['fl_status'] == 'X'){
                                    echo '<bold>EXPEDIÇÃO</bold>';
                                }
                            ?>  
                    </td>
                    <td style="text-align: center; width: 5px">
                        <button type="submit" id="btnStartCol" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Iniciar</button>
                    </td>
                    <td style="text-align: center; width: 5px">
                        <button type="submit" id="btnPrintCol" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Imprimir</button>
                    </td>
                    <td style="text-align: center; width: 5px"> 
                        <button type="submit" id="btnEndCol" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button> 
                    </td>
                </tr> 
                <?php }?>
            </tbody>
        </table>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>
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