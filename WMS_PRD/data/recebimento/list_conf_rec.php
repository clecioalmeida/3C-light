<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select cod_recebimento, fl_status, dt_user_criado_por, dt_descarregamento, dt_user_recebido_por from tb_recebimento where fl_status <> 'F'";    
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
    background-color: #4169E1;
}
</style>
<section class="panel col-lg-12">
    <?php
    if($coleta>0){
        ?>
        <legend>Recebimentos pendentes</legend>
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> OR</th>
                    <th> Data </th>
                    <th> Descarregado </th>
                    <th> Finalizado </th>
                    <th> Status </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while($linha = mysqli_fetch_assoc($query)){
                    ?>
                    <tr class="odd gradeX">
                        <td style="width: 30px"> <?php echo $linha['cod_recebimento'];?> </td>
                        <td>
                            <?php  
                            if($linha['dt_user_criado_por'] == 0)
                            { 
                                echo "";
                            }
                            else
                            { 
                                echo date ("d/m/Y", strtotime($linha['dt_user_criado_por'])); 
                            }
                            ?>
                            
                        </td>
                        <td>
                            <?php  
                            if($linha['dt_descarregamento'] == 0)
                            { 
                                echo "";
                            }
                            else
                            { 
                                echo date ("d/m/Y", strtotime($linha['dt_descarregamento'])); 
                            }
                            ?>
                            
                        </td>
                        <td style="width: 100px">
                            <?php  
                            if($linha['dt_user_recebido_por'] == 0)
                            { 
                                echo "";
                            }
                            else
                            { 
                                echo date ("d/m/Y", strtotime($linha['dt_user_recebido_por'])); 
                            };
                            ?>
                            
                        </td>
                        <td id="status" style="width: 180px"> 
                            <?php 
                            if ($linha['fl_status'] == 'A') 
                            {
                                echo 'ABERTO';
                            }
                            elseif ($linha['fl_status'] == 'F') 
                            {
                                echo 'FINALIZADA';; 
                            }
                            elseif ($linha['fl_status'] == 'C') 
                            {
                                echo 'CONFERÊNCIA';
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

  var obj1 = $("tr td:contains('AGUARDANDO COLETA')");
  obj1.addClass("ocupado");

  var obj2 = $("tr td:contains('COLETA INICIADA')");
  obj2.addClass("livre");

  var obj3 = $("tr td:contains('FINALIZADA')");
  obj3.addClass("alerta");
});
</script>
<script type="text/javascript">
    $('form.ajax').on('submit', function(){
        var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};
        that.find('[name]').each(function(index, value){
            var that = $(this),
            name = that.attr('name'),
            value = that.val();
            data[name] = value;
        });
        $.ajax({
            url:url,
            type:type,
            data:data,
            success: function(response){
                console.log(response);
            }
        });
        return false;
    });
</script>