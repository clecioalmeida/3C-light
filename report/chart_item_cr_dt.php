<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_cr  = $_POST['nr_cr_it'];

$sql = "SELECT centro_custo, GROUP_CONCAT(qtd_total) as qtd_group, GROUP_CONCAT(ano_cr) as ano_cr, qtd_total 
FROM
(
  select t2.cod_depto as centro_custo,  round(sum(t3.nr_qtde),0) as qtd_total, year(t1.dt_create) as ano_cr
  from tb_pedido_coleta t1
  left join tb_funcionario t2 on t1.cod_almox = t2.nr_matricula
  left join tb_pedido_coleta_produto t3 on t1.nr_pedido = t3.nr_pedido
  where t2.cod_depto = '$nr_cr'
  group by t2.cod_depto, year(t1.dt_create)
) s
group by centro_custo
order by qtd_total desc, ano_cr asc
LIMIT 20";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

  $qtd = explode(',', $parte['qtd_group']);

  $array_parte[] = array(
    'centro_custo'  => $parte['centro_custo'],
    'qtd_total1'  => $qtd[0],
    'qtd_total2'  => $qtd[1],
  );

}

$link->close();
?>
<div>
  <table style="margin-left: 30px;margin-bottom: -20px">
    <tbody>
      <tr>
        <td colspan="5" style="color: white">LEGENDA</td>
      </tr>
      <tr>
        <td style="color: white">2020&nbsp;</td>
        <td style="background-color: #0061B3;color: #0061B3">2020</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td style="color: white">2021&nbsp;</td>
        <td style="background-color: #009933;color: #009933">2021</td>
      </tr>
    </tbody>
  </table>
</div>
<div id="dash_it_cr" class="chart no-padding" style="height: 300px;"></div>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'centro_custo',
    ykeys: ['qtd_total1','qtd_total2'],
    labels: ['Qtde total de itens atendidos','Qtde total de itens atendidos'],
    pointSize: 5,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors: ['#0061B3','#009933','#D96123'],
    axes: true,
    ymax: 20000,
    ymin: 0,
    xLabelAngle: '45',
    padding: 40,
    barGap:4,
    barSizeRatio:0.55,
    parseTime: false,    
    labelTop: true 
  };
  config.element = 'dash_it_cr';
  config.stacked = false;
  config.hideHover = true;
  Morris.Bar(config);
</script>