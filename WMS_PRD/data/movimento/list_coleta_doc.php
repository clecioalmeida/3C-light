<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id         = $_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$doc_mat = $_POST['doc_mat'];

$sql = "select t2.cod_ped, t1.nr_pedido, t1.cod_almox, t4.ds_almox, t1.fl_status, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, date_format(t1.dt_separa,'%d/%m/%Y') as dt_separa, date_format(t1.dt_limite,'%d/%m/%Y') as dt_limite, COALESCE(sum(t3.nr_qtde),0) as tot_conf, t2.nr_qtde as tot_qtd, t2.usr_exp, date_format(t2.dt_exp,'%d/%m/%Y') as dt_exp, t2.usr_fim_conf, date_format(t2.dt_fim_conf,'%d/%m/%Y') as dt_fim_conf, t1.doc_material, t1.nr_minuta, t2.usr_init_col, date_format(t2.dt_init_col,'%d/%m/%Y') as dt_init_col, t2.usr_fim_coleta, date_format(t2.dt_fim_coleta,'%d/%m/%Y') as dt_fim_coleta, t5.nm_user as nm_init_col, t6.nm_user as nm_exp, t7.nm_user as nm_fim_conf, t8.nm_user as nm_fim_coleta
from tb_pedido_coleta t1
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
left join tb_pedido_conferencia t3 on t1.nr_pedido = t3.nr_pedido and t2.produto = t3.produto
left join tb_almox t4 on t1.cod_almox = t4.cod_almox
left join tb_usuario t5 on t2.usr_init_col = t5.id
left join tb_usuario t6 on t2.usr_exp = t6.id
left join tb_usuario t7 on t2.usr_fim_conf = t7.id
left join tb_usuario t8 on t2.usr_fim_coleta = t8.id
where t1.fl_empresa = '$cod_cli' and (t1.fl_status = 'M' or t1.fl_status = 'D') and t1.doc_material = '$doc_mat'";
$query = mysqli_query($link, $sql);
$coleta = mysqli_num_rows($query);


$hoje = date('d/m/Y');
$cor1 = '#FF6347';
$cor2 = '#9AFF9A';
$cor3 = '#FFFF00';
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

  /*table {border: 1px solid #000}
  table td { border: 1px solid #000; padding:5px;}*/
</style>
<section class="panel col-lg-12" id="tbColeta">
  <?php
  if ($coleta > 0) {
   ?>
   <legend>PEDIDOS PENDENTES</legend>
   <table data-toggle="table" id="table" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed">
    <thead>
      <tr>
        <th width="1%"></th>
        <th data-field="" width="5%">PEDIDO</th>
        <th data-field="" width="13%">DOC MATERIAL</th>
        <th data-field="" width="16%">DESTINO</th>
        <th data-field="" width="11%">DATA PEDIDO</th>
        <th data-field="" width="11%">DATA SEPARAÇÃO</th>
        <th data-field="" width="11%">DATA LIMITE</th>
        <th data-field="" width="11%">STATUS</th>
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
          <td><?php echo $linha['cod_almox']." - ".$linha['ds_almox']; ?></td>
          <td><?php echo $linha['dt_pedido']; ?></td>
          <td><?php echo $linha['dt_separa']; ?></td>
          <td><?php echo $linha['dt_limite']; ?></td>
          <td><?php
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
         ?></td>
         <?php
         $sql_parte = "select t1.nr_pedido, COALESCE(sum(t1.nr_qtde),0) as tot_qtd, COALESCE(sum(t2.nr_qtde),0) as tot_conf
         from tb_pedido_coleta_produto t1
         left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
         where t1.nr_pedido = '".$linha['nr_pedido']."'";
         $res_parte = mysqli_query($link, $sql_parte);
         $dados=mysqli_fetch_assoc($res_parte);
         if($dados['tot_conf'] == 0){

          $percentual=0.00;

        }else{

          $percentual=number_format($dados['tot_conf']/$dados['tot_qtd']*100, 2, '.', '');

        }
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
                <th>SEPARADOR</th>
                <th scope="col">LIBERADO PARA SEPARAÇÃO</th>
                <th scope="col">RESP. FIM SEPARAÇÃO</th>
                <th scope="col">DATA FIM SEPARAÇÃO</th>
                <th scope="col">CONFERENTE</th>
                <th scope="col">DATA CONFERÈNCIA</th>
                <th scope="col">ROMANEIO</th>
                <th scope="col">EXPEDIDOR</th>
                <th scope="col">DATA EXPEDIÇÃO</th>
                <th scope="col">*</th>
              </tr>
            </thead>
            <tbody>
              <tr class="subrow1" data-href="#" style="background-color: #E8E8E8">
                <td></td>
                <td width="11%"><?php echo $linha['nm_init_col']; ?></td>
                <td width="11%"><?php echo $linha['dt_init_col']; ?></td>
                <td width="13%"><?php echo $linha['nm_fim_coleta']; ?></td>
                <td width="11%"><?php echo $linha['dt_fim_coleta']; ?></td>
                <td width="13%"><?php echo $linha['nm_fim_conf']; ?></td>
                <td width="11%"><?php echo $linha['dt_fim_conf']; ?></td>
                <td width="11%"><?php echo $linha['nr_minuta']; ?></td>
                <td><?php echo $linha['dt_exp']; ?></td>
                <td><?php echo $linha['nm_exp']; ?></td>
                <td width="13%">
                  <button type="submit" id="btnDtlPedSep" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">DETALHE</button>
                  <button type="submit" id="btnPesqQtdPed" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>" disabled>QUANTIDADES</button>
                </td>
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