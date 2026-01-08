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

$query_prod = "SELECT t1.cod_recebimento as cod_rec, t1.fl_status, t5.cod_recebimento, date_format(t1.dt_recebimento_previsto,'%d/%m/%Y') as dt_recebimento, t1.nm_fornecedor, t1.nr_volume_previsto, date_format(t4.dt_janela,'%d/%m/%Y') as dt_janela, t4.ds_janela, round(sum(COALESCE(t6.nr_volume,0)),0) as nr_volume, concat('R$ ', format(sum(COALESCE(t7.vl_tot_nf_ent,0)),2,'de_De')) as vl_tot_nf_ent, GROUP_CONCAT(DISTINCT coalesce(TRIM(LEADING '0' FROM t7.nr_fisc_ent),0)) as nr_fisc_ent, t1.ds_obs, t1.hr_chegada, t1.init_descarga, t1.fim_descarga, t1.t_descarregamento, t1.t_permanece, date_format(t5.dt_recebimento_real, '%d/%m/%Y') as dt_recebimento_real
from tb_recebimento_ag t1
left join tb_janela t2 on t1.cod_recebimento = t2.cod_rec
left join tb_janela t4 on t1.cod_recebimento = t4.cod_rec
left join tb_recebimento t5 on t1.cod_rec = t5.cod_recebimento
left join tb_posicao_pallet t6 on t5.cod_recebimento = t6.nr_or
left join tb_nf_entrada t7 on t5.cod_recebimento = t7.cod_rec
where month(t2.dt_janela) = month(curdate()) and t1.fl_status <> 'E' and t2.fl_empresa = '$cod_cli' and (t1.fl_status = 'F' or t1.fl_status = 'ST' or t1.fl_status = 'FA')
group by t1.cod_recebimento";
$res_prod = mysqli_query($link,$query_prod);

$sql_mes = "SELECT
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
<style type="text/css">

  .tableFixHead          { overflow-y: auto; height: 640px; }
  .tableFixHead thead th { position: sticky; top: 0; }
  table  { border-collapse: collapse; width: 100%; }
  th, td { padding: 8px 16px; }
  th     { background:#eee; }

  /* CAMPO INPUT DENTRO DA TD */

  table td {
    position: relative;
  }

  table td input {
    position: absolute;
    display: block;
    top:0;
    left:0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
    font-size: 12px;
    text-align: right;

    }table td select {
      position: absolute;
      display: block;
      top:0;
      left:0;
      margin: 0;
      height: 100%;
      width: 300px;
      border: none;
      padding: 10px;
      box-sizing: border-box;
      font-size: 12px;
      text-align: right;
    }

  </style>
  <br><br>
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
        <button type="submit" id="btnRepRecMes" class="btn btn-primary" style="margin-right: 3px;width: 100px">CONSULTAR</button>
      </form>
    </div>
  </section>
</fieldset>
<fieldset id="retTbControlTransp">
  <section>
  <div class="tableFixHead">
    <table class="display responsive nowrap" id="example3" style="width:100%">
       <tr>
        <th>CÓD. AGENDAMENTO</th>
        <th>CÓD. RECEBIMENTO</th>
        <th>STATUS</th>
        <th>DATA</th>
        <th>FORNECEDOR</th>
        <th>VOLUMES</th>
        <th>VEÍCULO</th>
        <th>OBSERVAÇÕES</th>
        <th>AGENDADO</th>
        <th>JANELA</th>
        <th>VALOR TOTAL NF</th>
        <th style="width: 100px">NOTAS FISCAIS</th>
        <th>HORÁRIO CHEGADA</th>
        <th>INÍCIO DESCARGA</th>
        <th>FIM DESCARGA</th>
        <th>TEMPO DESCARGA</th>
        <th>TEMPO PERMANÊNCIA</th>
        <th>% TD/TP</th>
      </tr>
      <tbody id="listTbCronAt"> 
        <?php while ($dados = mysqli_fetch_assoc($res_prod)) {?>
          <tr class="odd gradeX">
            <td><?php echo $dados['cod_rec']; ?></td>
            <td><?php echo $dados['cod_recebimento']; ?></td>
            <?php
            if ($dados['fl_status'] == 'F' || $dados['fl_status'] == 'ST') {

              $td = '<td style="background-color: #9AFF9A">AGENDAMENTO FINALIZADO</td>';
              echo $td;

            }else if ($dados['fl_status'] == 'FA'){

              $td = '<td style="background-color: #FFFF00">FORA DA AGENDA</td>';
              echo $td;

            }else if ($dados['fl_status'] == 'AT'){

              $td = '<td style="background-color: #FFFF00">ATRASOU</td>';
              echo $td;
            }else if ($dados['fl_status'] == 'NC'){

              $td = '<td style="background-color: #FFFF00">NÃO COMPARECEU</td>';
              echo $td;
            }
            ?>
            <td><?php echo $dados['dt_recebimento_real']; ?></td>
            <td style="width: 100px"><?php echo $dados['nm_fornecedor']; ?></td>
            <td><?php echo $dados['nr_volume']; ?></td>
            <td><?php echo $dados['descricao']; ?></td>
            <td><?php echo $dados['ds_obs']; ?></td>
            <td><?php echo $dados['dt_janela']; ?></td>
            <td><?php echo $dados['ds_janela']; ?></td>
            <td><?php echo $dados['vl_tot_nf_ent']; ?></td>
            <td style="width: 100px"><?php echo $dados['nr_fisc_ent']; ?></td>
            <td><?php echo $dados['hr_chegada']; ?></td>
            <td><?php echo $dados['init_descarga']; ?></td>
            <td><?php echo $dados['fim_descarga']; ?></td>
            <td><?php echo $dados['t_descarregamento']; ?></td>
            <td><?php echo $dados['t_permanece']; ?></td>
            <td></td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</section>
</fieldset>

<script type="text/javascript">
	$(document).ready(function() {
		$("#example3").dataTable({
			"aLengthMenu": [5000]
		});
	});
</script>