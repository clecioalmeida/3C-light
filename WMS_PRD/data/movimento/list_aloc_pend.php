<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id=$_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql = "select t1.cod_nf_entrada_item, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.nr_fisc_ent,
t3.qtd_vol_ent, t3.tp_vol_ent, t4.ds_galpao, t4.nr_nf_entrada, t4.ds_prateleira, t4.ds_coluna,
t4.ds_altura, t4.nr_qtde, t5.ds_apelido
from tb_nf_entrada_item t1
left join tb_produto t2 on t1.produto = t2.cod_produto or t1.produto = t2.cod_prod_cliente
left join tb_nf_entrada t3 on t1.cod_nf_entrada = t3.cod_nf_entrada
left join tb_posicao_pallet t4 on t3.cod_rec = t4.nr_nf_entrada
left join tb_armazem t5 on t4.ds_galpao =  t5.id
where t4.nr_or = 0 and t4.nr_qtde > 0 and t2.fl_empresa = '$cod_cli'
group by t4.ds_galpao, t4.ds_prateleira, t4.ds_coluna, t4.ds_altura";
    
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
    <legend>Alocações pendentes</legend>
                                        <table class="table table-hover" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>COD RECEBIMENTO</th>
                                                    <th>COD PRODUTO</th>
                                                    <th>COD CLIENTE</th>
                                                    <th>PRODUTO</th>
                                                    <th style="text-align: right;">NOTA FISCAL</th>
                                                    <th style="text-align: center;">VOLUME</th>
                                                    <th style="text-align: right;">GALPÃO</th>
                                                    <th style="text-align: right;">RUA</th>
                                                    <th style="text-align: right;">COLUNA</th>
                                                    <th style="text-align: right;">ALTURA</th>
                                                    <th style="text-align: right;">QTD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    while ($dados=mysqli_fetch_assoc($query)) {
                                                ?>
                                                 <tr id="trStatus" class="status" data-status="<?php echo $linha['fl_status'];?>">
                                                    <td id="cod_produto" style="text-align: center;"><?php echo $dados['nr_nf_entrada'];?></td>
                                                    <td id="cod_produto" style="text-align: center;"><?php echo $dados['cod_produto'];?></td>
                                                    <td><?php echo $dados['cod_prod_cliente'];?></td>
                                                    <td><?php echo $dados['nm_produto'];?></td>
                                                    <td style="text-align: right;"><?php echo $dados['nr_fisc_ent'];?></td>
                                                    <td style="text-align: center;"><?php echo $dados['tp_vol_ent'];?></td>
                                                    <td style="text-align: right;"><?php echo $dados['ds_apelido'];?></td>
                                                    <td style="text-align: right;"><?php echo $dados['ds_prateleira'];?></td>
                                                    <td style="text-align: right;"><?php echo $dados['ds_coluna'];?></td>
                                                    <td style="text-align: right;"><?php echo $dados['ds_altura'];?></td>
                                                    <td style="text-align: right;"><?php echo $dados['nr_qtde'];?></td>
                                                </tr>
                                                <?php } ?>
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