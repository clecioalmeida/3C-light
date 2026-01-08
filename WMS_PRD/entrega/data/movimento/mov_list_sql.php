<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$movimenta = $_POST['movimenta'];
$galpao = $_POST['local'];

if($galpao < 1){
    $sql_mov = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.ds_apelido from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto left join tb_armazem t3 on t1.ds_galpao = t3.id where (t2.nm_produto like '%$movimenta%' or t2.cod_prod_cliente like '%$movimenta%') and t1.ds_galpao not in ('RECEBIMENTO') ";
    
    $mov = mysqli_query($link,$sql_mov);
    $tr = mysqli_num_rows($mov);
} else{
    $sql_mov = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.ds_apelido from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto left join tb_armazem t3 on t1.ds_galpao = t3.id where (t2.nm_produto like '%$movimenta%' or t2.cod_prod_cliente like '%$movimenta%') and t1.ds_galpao like '%$galpao%' and t1.ds_galpao not in ('RECEBIMENTO') ";
 
    $mov = mysqli_query($link,$sql_mov);
    $tr = mysqli_num_rows($mov);
}

?>
<?php
    if($tr>0){
    ?>
<section id="widget-grid" class="">
                
                    <!-- row -->
                    <div class="row">
                
                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                                <!-- widget options:
                                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                
                                data-widget-colorbutton="false"
                                data-widget-editbutton="false"
                                data-widget-togglebutton="false"
                                data-widget-deletebutton="false"
                                data-widget-fullscreenbutton="false"
                                data-widget-custombutton="false"
                                data-widget-collapsed="true"
                                data-widget-sortable="false"
                
                                -->
                                <!--header>
                                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                    <h2>Standard Data Tables </h2>
                
                                </header-->
                
                                <!-- widget div-->
                                <div>
                
                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->
                
                                    </div>
                                    <!-- end widget edit box -->
                
                                    <!-- widget content -->
                                    <div class="widget-body no-padding">
                
    
    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
        <thead>
            <tr>
                <th> Código SAP</th>
                <th> Descrição </th>
                <th> Galpão  </th>
                <th> Rua  </th>
                <th> Coluna </th>
                <th> Altura</th>
                <th> Qtde</th>
                <th> # </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($mov)){
                $rua=$linha['ds_prateleira'];
                ?>
            <tr>
                <td style="width: 100px"> <?php echo $linha['cod_prod_cliente'];?> </td>
                <td> <?php echo $linha['nm_produto'];?> </td>
                <td> <?php echo $linha['ds_apelido'];?> </td>
                <td> <?php echo $linha['ds_prateleira'];?> </td>
                <td> <?php echo $linha['ds_coluna'];?> </td>
                <td> <?php echo $linha['ds_altura'];?> </td>
                <td> <?php echo $linha['nr_qtde'];?> </td>  
                <td style="text-align: center; width: 5px"> 
                    <form method="post" id="formMovDest" action="">
                        <input type="hidden" name="cod_estoque" id="cod_estoque" value="<?php echo $linha['cod_estoque'];?>">
                        <input type="hidden" name="nr_qtde" id="nr_qtde" value="<?php echo $linha['nr_qtde'];?>">
                        <button type="submit" id="btnMovDest" class="btn btn-success btn-xs">Movimentar</button>
                    </form>
                    </td>
                <?php }?>
            </tr>
        </tbody>
    </table>
                                        </div>
                                    <!-- end widget content -->
                
                                </div>
                                <!-- end widget div -->
                
                            </div>
                            <!-- end widget -->
                
                        </article>
                        <!-- WIDGET END -->
                
                    </div>
                
                    <!-- end row -->
                
                    <!-- end row -->
                
                </section>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>