<?php 

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_min = $_POST["cod_min"];

$sql_min = "select fl_status
from tb_minuta
where cod_minuta = '$cod_min'";
$res_min = mysqli_query($link,$sql_min);
while ($minuta = mysqli_fetch_assoc($res_min)) {
  $fl_status      = $minuta['fl_status'];

}

$table = "";

$sql_ped="select nr_pedido, nr_ped_sap, doc_material, cod_almox, ds_destino, nr_dem, vlr_dem
from tb_pedido_coleta
where nr_minuta = '$cod_min'";
$res_ped = mysqli_query($link,$sql_ped);
while ($dados = mysqli_fetch_assoc($res_ped)) {

  $table .= '
  <tr>
  <td>
  <div class="form-group">
  <label class="checkbox-inline">
  <input type="checkbox" class="checkbox style-0 checkPedRom" id="checkPedRom" value="'.$dados['nr_pedido'].'" data-vol="" checked>
  <span></span>
  </label>
  </div>
  </td>
  <td style="text-align: right">'.$dados['nr_pedido'].'</td>
  <td style="text-align: right">'.$dados['nr_ped_sap'].'</td>
  <td style="text-align: right">'.$dados['doc_material'].'</td>
  <td style="text-align: right">'.$dados['nr_dem'].'</td>
  <td style="text-align: right">'.$dados['vlr_dem'].'</td>
  <td style="text-align: right">'.$dados['cod_almox'].'</td>
  <td>'.$dados['ds_destino'].'</td>
  <td style="text-align: center">
  <button type="submit" id="btnDelPedRomaneio" class="btn btn-danger btn-xs" data-min="'.$cod_min.'" data-st="'.$fl_status.'" value="'.$dados['nr_pedido'].'">Excluir</button>
  </td>
  </tr>';

}
echo $table;

$link->close();
?>