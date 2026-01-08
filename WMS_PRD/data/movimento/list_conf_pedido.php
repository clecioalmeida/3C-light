<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["dtl_ped"];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql = "select t2.cod_ped, t1.nr_pedido, t1.cod_almox, t4.ds_almox, t1.fl_status, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, date_format(t1.dt_lib_col,'%d/%m/%Y %H:%i') as dt_lib_col, date_format(t1.dt_separa,'%d/%m/%Y') as dt_separa, date_format(t1.dt_limite,'%d/%m/%Y') as dt_limite, COALESCE(sum(t3.nr_qtde),0) as tot_conf, t2.nr_qtde as tot_qtd, t2.usr_exp, date_format(t2.dt_exp,'%d/%m/%Y %H:%i') as dt_exp, t2.usr_fim_conf, date_format(max(t2.dt_lib_exp),'%d/%m/%Y %H:%i') as dt_lib_exp, t1.doc_material, t1.nr_minuta, t1.usr_init_col, date_format(t1.dt_init_col,'%d/%m/%Y %H:%i') as dt_init_col, t2.usr_fim_coleta, date_format(t11.dt_col,'%d/%m/%Y %H:%i') as dt_fim_coleta, t5.nm_user as nm_init_col, t6.nm_user as nm_exp, t7.nm_user as nm_lib_exp, t8.nm_user as nm_fim_coleta, date_format(t9.dt_expedido,'%d/%m/%Y') as dt_expedido, t10.nm_user as nm_expedido
from tb_pedido_coleta t1
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
left join tb_pedido_conferencia t3 on t1.nr_pedido = t3.nr_pedido and t2.produto = t3.produto
left join tb_coleta_pedido t11 on t1.nr_pedido = t11.nr_pedido
left join tb_almox t4 on t1.cod_almox = t4.cod_almox
left join tb_usuario t5 on t1.usr_init_col = t5.id
left join tb_usuario t6 on t2.usr_exp = t6.id
left join tb_usuario t7 on t2.usr_lib_exp = t7.id
left join tb_usuario t8 on t11.usr_col = t8.id
left join tb_minuta t9 on t1.nr_minuta = t9.cod_minuta
left join tb_usuario t10 on t9.nm_expedido_por = t10.id
where t1.nr_pedido = '$nr_pedido'
GROUP BY t1.nr_pedido, t1.ds_modalidade, t1.dt_limite, t1.fl_status, t1.ds_tipo 
order by date(t2.dt_lib_exp) desc";
$query = mysqli_query($link, $sql);
$coleta = mysqli_num_rows($query);


$hoje = date('d/m/Y');
$cor1 = '#FF6347';
$cor2 = '#9AFF9A';
$cor3 = '#FFFF00';
?>
<?php
if ($coleta > 0) {
 ?>
 <table data-toggle="table" id="table" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed">
  <thead>
    <tr>
      <th width="1%"></th>
      <th data-field="" width="5%">PEDIDO</th>
      <th data-field="" width="13%">DOC MATERIAL</th>
      <th width="13%">SEPARADOR</th>
      <th data-field="" width="13%">DESTINO</th>
      <th data-field="" width="10%">DATA PEDIDO</th>
      <th data-field="" width="10%">DATA SEPARAÇÃO</th>
      <th data-field="" width="10%">DATA LIMITE</th>
      <th data-field="" width="10%">STATUS</th>
      <th data-field="" width="30%">PROGRESSO SEPARAÇÃO</th>
    </tr>
  </thead>
  <?php
  while ($linha = mysqli_fetch_assoc($query)) {
    $percent = ($linha['tot_conf'] / $linha['tot_qtd']) * 100;
    $cod_ped = $linha['cod_ped'];
    ?>
    <tbody>
      <tr class="clickable js-tabularinfo-toggle" data-toggle="collapse" id="row1" data-target=".row1<?php echo $cod_ped;?>">
        <td><i class="tabularinfo__icon fa fa-plus"></i></td>
        <td><?php echo $linha['nr_pedido']; ?></td>
        <td><?php echo $linha['doc_material']; ?></td>
        <td><?php echo $linha['nm_init_col']; ?></td>
        <td><?php echo $linha['cod_almox']." - ".$linha['ds_almox']; ?></td>
        <td><?php echo $linha['dt_pedido']; ?></td>
        <td><?php echo $linha['dt_separa']; ?></td>
        <td><?php echo $linha['dt_limite']; ?></td>
        <td>
          <?php
          if ($linha['fl_status'] == 'A') {
            echo '<bold>ABERTO</bold>';
          } elseif ($linha['fl_status'] == 'P') {
            echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
          } elseif ($linha['fl_status'] == 'E') {
            echo '<bold>EXPEDIÇAO</bold>';
          } elseif ($linha['fl_status'] == 'C') {
            echo '<bold>AGUARDANDO COLETA</bold>';
          } elseif ($linha['fl_status'] == 'M' || $linha['fl_status'] == 'D') {
           echo '<bold>COLETA INICIADA</bold>';
         } elseif ($linha['fl_status'] == 'F') {
           echo '<bold>COLETADO</bold>';
         } elseif ($linha['fl_status'] == 'X') {
           echo '<bold>EXPEDIÇÃO</bold>';
         }
         ?>
       </td>
       <?php
       $sql_parte = "SELECT tot_conf, tot_qtd, (tot_qtd/tot_conf)*100 as percent
        FROM
        (
          SELECT COALESCE(sum(nr_qtde),0) as tot_conf,
          (select sum(nr_qtde) from tb_pedido_conferencia where nr_pedido = '".$linha['nr_pedido']."') as tot_qtd
          from tb_pedido_coleta_produto s
          where nr_pedido = '".$linha['nr_pedido']."'
        ) s";
       $res_parte = mysqli_query($link, $sql_parte);
       $dados=mysqli_fetch_assoc($res_parte);

        $percentual = number_format($dados['percent'], 2, '.', '');

      $total = '<td class="progresso" style="font-size: x-small;text-align: right;width:200px"><span id="percent">'.$percentual.'%</span><div class="progress progress-sm"><div class="progress-bar bg-color-redLight" style="width:'.$percentual.'%"></div></div></td>';
      echo $total;
      ?>
    </tr>
    <tr  class="tabularinfo__subblock collapse row1<?php echo $cod_ped;?>">
      <td colspan="9">
        <table id="" class="table" data-detail-view="">
          <thead>
            <tr class="" data-toggle="" id="" data-target=".subrow1">
              <th></th>
              <th scope="col">LIBERAÇÃO PARA SEPARAÇÃO</th>
              <th scope="col">INICIO DA SEPARAÇÃO</th>
              <th scope="col">DATA FIM SEPARAÇÃO</th>
              <th scope="col">RESP. FIM SEPARAÇÃO</th>
              <th scope="col">DATA CONFERÈNCIA EXPEDIÇÃO</th>
              <th scope="col">CONFERENTE EXPEDIÇÃO</th>
              <th scope="col">ROMANEIO</th>
              <th scope="col">DATA EXPEDIÇÃO</th>
              <th scope="col">EXPEDIDOR</th>
            </tr>
          </thead>
          <tbody>
            <tr class="subrow1" data-href="#" style="background-color: #E8E8E8">
              <td></td>
              <td width="11%"><?php echo $linha['dt_lib_col']; ?></td>
              <td width="11%"><?php echo $linha['dt_init_col']; ?></td>
              <td width="11%"><?php echo $linha['dt_fim_coleta']; ?></td>
              <td width="13%"><?php echo $linha['nm_fim_coleta']; ?></td>
              <td width="11%"><?php echo $linha['dt_lib_exp']; ?></td>
              <td width="13%"><?php echo $linha['nm_lib_exp']; ?></td>
              <td width="11%"><?php echo $linha['nr_minuta']; ?></td>
              <td width="11%"><?php echo $linha['dt_expedido']; ?></td>
              <td width="13%"><?php echo $linha['nm_expedido']; ?></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  <?php } $link->close();
  ?>
</tbody>
</table>
<?php 
} else {
  ?>

  <h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php }
?>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var status_ = new Array();
    $('.status').each( function( i,v ){
      var $this = $( this )
      status_[i] = $this.attr('data-status');
      if(status_[i] == "C"){
        $this.addClass('ocupado');
      }else if(status_[i] == "F"){
        $this.removeClass('ocupado').addClass('livre');
      }else if (status_[i] == "P"){
        $this.removeClass('ocupado').addClass('finalizado');
      }
    });
  });
  $(document).ready(function(){
   $('.js-tabularinfo').bootstrapTable({
    escape: false,
    showHeader: false
  });
 }); 
</script>