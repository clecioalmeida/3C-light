<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../../index.php");
  exit;

}else{

  $id     = $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$query_prod = "select t1.cod_minuta, date_format(t1.dt_minuta,'%d/%m/%Y') as dt_transp, t1.ds_tipo, t1.ds_transporte, t1.nr_placa, GROUP_CONCAT(DISTINCT t2.cod_almox) AS cod_almox, GROUP_CONCAT(DISTINCT t3.ds_almox) AS ds_almox, GROUP_CONCAT(DISTINCT t2.nr_dem) AS nr_dem, concat('R$ ',format(sum(t2.vlr_dem),2,'de_DE')) as vlr_total, t1.nr_averba, t1.fl_comprovante, t1.tp_veiculo 
from tb_minuta t1
left join tb_pedido_coleta t2 on t1.cod_minuta = t2.nr_minuta
left join tb_almox t3 on t2.cod_almox = t3.cod_almox
left join tb_pedido_coleta_produto t4 on t2.nr_pedido = t4.nr_pedido
where month(dt_minuta) = month(curdate()) and t1.fl_status = 'F' and t2.fl_empresa = '$cod_cli'
group by t1.cod_minuta";
$res_prod = mysqli_query($link,$query_prod);

$sql_mes = "select
case MONTH(dt_minuta)
when 1 then 'Janeiro'
when 2 then 'Fevereiro'
when 3 then 'Março'
when 4 then 'Abril'
when 5 then 'Maio'
when 6 then 'Junho'
when 7 then 'Julho'
when 8 then 'Agosto'
when 9 then 'Setembro'
when 10 then 'Outubro'
when 11 then 'Novembro'
when 12 then 'Dezembro'
end as mes,
MONTH(dt_minuta) as ds_mes, 
YEAR(dt_minuta) as ano
from tb_minuta
where fl_status = 'F' and YEAR(dt_minuta) > 0
group by YEAR(dt_minuta), MONTH(dt_minuta)
order by  YEAR(dt_minuta) asc, MONTH(dt_minuta) desc";
$res_mes = mysqli_query($link, $sql_mes);

$link->close();
?>
<fieldset>
  <section>    
    <div>
      <form class="form-horizontal" method="post" action="" id="formMesMinuta">
        <label class="input">         
          <select class="form-control" id="ds_mes" name="ds_mes" style="color: black">
            <?php
            while($row_mes = mysqli_fetch_assoc($res_mes)){?>
              <option value="<?php echo $row_mes['ds_mes']; ?>"><?php echo $row_mes['mes']." - ".$row_mes['ano']; ?></option>
            <?php }?>
          </select>
        </label>
        <button type="submit" id="btnConsultaMesMinuta" class="btn btn-primary" style="margin-right: 3px;width: 100px">CONSULTAR</button>
        <button type="submit" class="btn btn-success" id="ExpExcelTransp" style="float:right;margin-right: 45px;width: 100px">Excel</button>
      </form>
    </div>
  </section>
</fieldset>
<fieldset id="retTbControlTransp">
  <section>
    <div class="table-responsive-sm">
     <table id="RepIndCronExcel" class="table table-bordered" width="100%">
       <tr>
        <th>Data programada para entrega</th>
        <th>Transporte</th>
        <th>Tipo de veículo</th>
        <th>Motorista</th>
        <th>Placa</th>
        <th>Origem</th>
        <th>Destino</th>
        <th>NF</th>
        <th>Valor Total</th>
        <th>Controle de averbação</th>
        <th>Canhoto das NF assinados?</th>
      </tr>
      <tbody id="listTbCronAt"> 
        <?php while ($dados = mysqli_fetch_assoc($res_prod)) {?>
          <tr class="odd gradeX">
            <td style="text-align: left;width:150px"><?php echo $dados['dt_transp']; ?></td>
            <td  style="width:100px"><?php echo $dados['ds_tipo']; ?></td>
            <td id="nr_at" contenteditable="true"  style="text-align: right;width:100px"></td>
            <td><?php echo $dados['ds_transporte']; ?></td>
            <td><?php echo $dados['nr_placa']; ?></td>
            <td><?php echo $dados['tp_veiculo']; ?></td>
            <td style="width:200px"><?php echo $dados['ds_almox']; ?></td>
            <td style="text-align: right;width:300px"><?php echo $dados['nr_dem']; ?></td>
            <td style="text-align: right;width:150px"><?php echo $dados['vlr_total']; ?></td>
            <td><?php echo $dados['nr_averba']; ?></td>
            <td><?php echo $dados['fl_comprovante']; ?></td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</section>
</fieldset>
<script type="text/javascript">
    $('#ExpExcelTransp').on('click', function(){
        event.preventDefault();
        $('#ExpExcelTransp').prop("disabled", true);
        var today = new Date();
        $("#RepIndCronExcel").table2excel({
            //exclude: ".noExl",
            name: "Relatório de transporte",
            filename: "Relatório de transporte"});
        $('#ExpExcelTransp').prop("disabled", false);

    });
</script>