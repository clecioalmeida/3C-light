<?php  
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$output = '';  
$sql = "select t1.*, t2.nr_fisc_ent 
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
where t2.cod_rec = 4096";  
$result =mysqli_query($link, $sql);

$sql_nf = "select cod_nf_entrada, nr_fisc_ent 
from tb_nf_entrada where cod_rec = 4096";  
$result_nf =mysqli_query($link, $sql_nf);


$output .= '  
<div class="table-responsive">  
<table class="table table-bordered">  
<tr>  
<th width="10%">Id</th>  
<th width="10%">Nota fiscal</th>  
<th width="10%">Produto</th>
<th width="10%">Estado</th>
<th width="10%">Qtde</th>
<th width="10%">Valor</th>
<th width="10%">Peso</th>
<th width="10%">Tipo Vol</th>
<th width="10%">#</th>  
</tr>';  
if(mysqli_num_rows($result) > 0)  
{  
  while($row = mysqli_fetch_array($result))  
  {  
   $output .= '  
   <tr>  
   <td>'.$row["cod_nf_entrada_item"].'</td>  
   <td class="nr_fisc_ent" data-id1="'.$row["cod_nf_entrada_item"].'" contenteditable>'.$row["nr_fisc_ent"].'</td>  
   <td class="produto" data-id2="'.$row["cod_nf_entrada_item"].'" contenteditable>'.$row["produto"].'</td>
   <td class="estado_produto" data-id2="'.$row["cod_nf_entrada_item"].'" contenteditable>'.$row["estado_produto"].'</td>
   <td class="nr_qtde" data-id2="'.$row["cod_nf_entrada_item"].'" contenteditable>'.$row["nr_qtde"].'</td>
   <td class="vl_unit" data-id2="'.$row["cod_nf_entrada_item"].'" contenteditable>'.$row["vl_unit"].'</td>
   <td class="nr_peso_unit" data-id2="'.$row["cod_nf_entrada_item"].'" contenteditable>'.$row["nr_peso_unit"].'</td>
   <td class="ds_uni_med" data-id2="'.$row["cod_nf_entrada_item"].'" contenteditable>'.$row["ds_uni_med"].'</td>
   <td><button type="button" name="delete_btn" data-id3="'.$row["cod_nf_entrada_item"].'" class="btn btn-xs btn-danger btn_delete">x</button></td>  
   </tr>  
   ';  
 } 
 
 $output .= '  
 <tr>  
 <td></td>  
 <td contenteditable>
 <select id="nr_fisc_ent">';
 while($row_nf = mysqli_fetch_array($result_nf))  
  { 
 $output .= ' 
 <option value="'.$row_nf["cod_nf_entrada"].'">'.$row_nf["nr_fisc_ent"].'</option>'; 
}
$output .= ' 
 </select>
 </td>  
 <td id="produto" contenteditable></td> 
 <td id="estado_produto" contenteditable></td> 
 <td id="nr_qtde" contenteditable></td> 
 <td id="vl_unit" contenteditable></td> 
 <td id="nr_peso_unit" contenteditable></td> 
 <td id="ds_uni_med" contenteditable></td> 
 <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
 </tr>  
 ';
}  
else  
{  
  $output .= '<tr>  
  <td colspan="4">Data not Found</td>  
  </tr>';  
}  
$output .= '</table>  
</div>';  
echo $output;  
$link->close();
?>