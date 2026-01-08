<?php 
session_start();
  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $id_nf=$_SESSION['id_nf'];
  $id_rec=$_SESSION['id_rec'];

    $select_nf = "select r.nm_fornecedor, r.nm_transportadora, r.nm_placa, r.ds_obs, DATE_FORMAT(dt_recebimento_previsto ,'%d/%m/%Y') dt_recebimento_previsto, c.nm_cliente, i.cod_nf_entrada, i.nr_fisc_ent, i.dt_emis_ent, i.nr_cfop_ent, i.qtd_vol_ent, i.nr_peso_ent, i.vl_tot_nf_ent, i.tp_vol_ent, i.base_icms_ent, i.vl_icms_ent, i.chavenfe from tb_recebimento r left join tb_cliente c on r.cod_cli = c.cod_cliente left join tb_nf_entrada i on i.cod_rec = r.cod_recebimento where r.cod_recebimento = '$id_rec' and r.fl_status <> 'E'";
  $res_nf = mysqli_query($link,$select_nf);

  $sql_parte = "select * from tb_nf_entrada where cod_nf_entrada = '$id_nf'";
  $res_parte = mysqli_query($link, $sql_parte);
  
  while ($parte=mysqli_fetch_assoc($res_parte)) {
    $dt_emis_ent=$parte['dt_emis_ent'];
    $nr_cfop_ent=$parte['nr_cfop_ent'];
    $qtd_vol_ent=$parte['qtd_vol_ent'];
    $nr_peso_ent=$parte['nr_peso_ent'];
    $tp_vol_ent=$parte['tp_vol_ent'];
    $vl_tot_nf_ent=$parte['vl_tot_nf_ent'];
    $base_icms_ent=$parte['base_icms_ent'];
    $vl_icms_ent=$parte['vl_icms_ent'];
    $chavenfe=$parte['chavenfe'];
    $ds_obs_nf=$parte['ds_obs_nf'];
  }
  unset ($_SESSION["id_nf"]);
  unset ($_SESSION["id_rec"]);
$link->close();
?>
  <label class="control-label" for="or">Emissão</label>
  <input type="text" class="form-control" id="dt_emis_ent" value="<?php echo date('d-m-Y', strtotime($dt_emis_ent));?>" name="dt_emis_ent" placeholder="Emissão">

  <label class="control-label" for="or">Total de volumes</label>
	<input type="text" class="form-control" id="tp_vol_ent" value="<?php echo $qtd_vol_ent;?>" name="qtd_vol_ent" placeholder="Total de volumes">

  <label class="control-label" for="or">Peso total</label>
	<input type="text" class="form-control" id="nr_peso_ent" value="<?php echo $nr_peso_ent;?>" name="nr_peso_ent" placeholder="Peso total (kg)">