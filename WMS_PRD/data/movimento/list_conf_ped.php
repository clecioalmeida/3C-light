<?php
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql = "SELECT C.cod_cliente, P.nr_pedido, C.nm_cliente, C.ds_cidade, P.nm_usuario, P.ds_modalidade, P.dt_entrega_real, P.dt_limite, P.fl_status, P.ds_tipo FROM  tb_pedido_coleta P INNER JOIN tb_cliente C ON P.cod_cliente = C.cod_cliente where P.fl_status = 'C' or P.fl_status = 'P' or P.fl_status = 'A' or P.fl_status = 'F'  or P.fl_status = 'M' GROUP BY C.cod_cli_destinatario, P.nr_pedido, P.nm_cliente, P.nm_usuario, P.ds_modalidade, P.dt_entrega_real, P.dt_limite, P.fl_status, P.ds_tipo order by P.nr_pedido desc ";
    
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
</style>
<section class="panel col-lg-12">
    <?php
    if($coleta>0){
    ?>
    <legend>Pedidos em conferência</legend>
    <table class="table table-bordered table-hover table-checkable order-column" id="tbConfPed">
        <thead>
            <tr>
                <th> Pedido</th>
                <th> Destinatário </th>
                <th> Cidade </th>
                <th> Modal </th>
                <th> Data limite</th>
                <th> Situação</th>
                <th colspan="3" style="text-align: center"> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($query)){
                ?>
                <tr id="trStatus" class="status" data-status="<?php echo $linha['fl_status'];?>">
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
                                        echo 'ABERTO';
                                    }elseif ($linha['fl_status'] == 'F') {
                                        echo 'FINALIZADA';
                                    }elseif ($linha['fl_status'] == 'C') {
                                        echo 'AGUARDANDO COLETA';
                                    }else{
                                        echo 'COLETA INICIADA';
                            }?>  
                    </td>
                    <td style="text-align: center; width: 5px">
                    	<button type="submit" id="btnUpdPedCol" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Alterar</button>
                    </td>
                    <td style="text-align: center; width: 5px">
                    	<button type="submit" id="btnFinPedCol" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button>
                    </td>
                    <td style="text-align: center; width: 5px"> 
                    	<button type="submit" id="btnQuebraCol" class="btn btn-danger btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Quebra</button> 
                    </td>
                </tr> 
                <?php }?>
            </tbody>
        </table>
        <h2 id="retValInfo" style="text-align: center;background-color: #A52A2A;color: white"></h2>
    <?php }else{?>
    
    <h4>Nao foram encontrados pedidos com esta descrição.</h4>
    
    <?php }
    ?>
</section>
<div id="retPicking"></div>
<div id="retUpdEnd"></div>
<!--script src="//code.jquery.com/jquery-1.11.2.min.js"></script-->
<!--script type="text/javascript">
    $('table tr').each(function(){
        var obj1 = $("tr td:contains('AGUARDANDO COLETA')");
        obj1.addClass("ocupado");

        var obj2 = $("tr td:contains('COLETA INICIADA')");
        obj2.addClass("livre");

        var obj3 = $("tr td:contains('FINALIZADA')");
        obj3.addClass("alerta");
    });
</script-->
<script type="text/javascript">
    tableToJSON("table");

    function tableToJSON(tableSelector){
        var array = new Array();
        var $thead = $(tableSelector).find("thead > tr > th");
      var $tbody = $(tableSelector).find("tbody > tr");

      $tbody.each(function(x){
        var obj = new Object();  
        var $row = $(this);
        $thead.each(function(i){
          var attributeName = $(this).text();
          obj[attributeName] = $row.find("td")[i].innerText
        });
        array.push(obj);
      });    
      console.log(array);
      return array;
    }

</script>
<script type="text/javascript">
     $(document).ready(function(){
        var status_ = new Array();
            $('.status').each( function( i,v ){
                var $this = $( this )
                status_[i] = $this.attr('data-status');
                if(status_[i] == "M"){
                    $this.addClass('livre');
                }else if(status_[i] == "C"){
                    $this.removeClass('livre').addClass('alerta');
                }else if(status_[i] == "A"){
                    $this.removeClass('livre').addClass('ocupado');
                }
            });
            console.log(status);
        });
</script>
<!--script type="text/javascript">
    $('#tbConfPed tr').each(function() {
      var valor = parseInt($(this).find('td:nth-child(6)').text());
      if (valor == "AGUARDANDO COLETA")
        $(this).addClass('livre');
    console.log(valor);
    });
</script-->
<!--script type="text/javascript">

     $(document).ready(function(){

      var obj1 = $("tr td:contains('AGUARDANDO COLETA')");
        obj1.addClass("ocupado");

      var obj2 = $("tr td:contains('COLETA INICIADA')");
        obj2.addClass("livre");

        var obj3 = $("tr td:contains('FINALIZADA')");
        obj3.addClass("alerta");
     });
    </script-->
<!--script type="text/javascript">
    $(function() { 
        var texto =  $("#tbConfPed tr:nth-child(2) td:nth-child(6)").text();           
        var result = (texto);
        console.log(result);
                            
        if (result=="ABERTO"){
            $("#tbConfPed").css("background","#FF0000");
        }else if(result=="Delayed"){
            $("#tbConfPed").css("background","#00FF00");
        }else if(result=="FINALIZADA"){
            $("#tbConfPed").css("background","#0000FF");
        }else if(result=="AGUARDANDO COLETA"){
            $("#tbConfPed").css("background","#00FFFF");
        }else{
            $("#tbConfPed").css("background","#ccc");
                }   
})
</script-->
<!--script type="text/javascript">
     $(document).ready(function(){
        //var status = $('.status').attr('data-status');
        console.log($('.status').attr('data-status'));
        $.each($('.status').attr('data-status'), function(){
            if($('.status').attr('data-status') == 'M'){
                $('.status').addClass("livre");
            }else if($('.status').attr('data-status') == 'A'){
                $('.status').removeClass("livre").addClass("ocupado");
            }
        });
     });
</script-->
<!--script type="text/javascript">
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
</script-->