<?php
//action.php
 require_once('modal/bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $cod_ocorrencia=$_POST['id_ocor'];
 $file1 = addslashes(file_get_contents($_POST["image1"]["tmp_name"]));
 $file2 = addslashes(file_get_contents($_POST["image2"]["tmp_name"]));
 $file3 = addslashes(file_get_contents($_POST["image3"]["tmp_name"]));

 $insert = "update tb_ocorrencias set img1= '$file1', img2='$file2', img3='$file3' where cod_ocorrencia = '$cod_ocorrencia'";
 $result = mysqli_query($link,$insert); 

  $query = "SELECT cod_ocorrencia, img1, img2, img3 FROM tb_ocorrencias where cod_ocorrencia = '$cod_ocorrencia' ORDER BY cod_ocorrencia DESC";
  $result_query = mysqli_query($link,$query); 
  $output = '';
  while($row = mysqli_fetch_array($result_query))
  {
   $output .= '

    <tr>
     <td>
      <img src="data:image/jpeg;base64,'.base64_encode($row['img1'] ).'" height="60" width="75" class="img-thumbnail" />
     </td>
      <td>
      <img src="data:image/jpeg;base64,'.base64_encode($row['img2'] ).'" height="60" width="75" class="img-thumbnail" />
     </td>
      <td>
      <img src="data:image/jpeg;base64,'.base64_encode($row['img3'] ).'" height="60" width="75" class="img-thumbnail" />
     </td>
     
    </tr>
    <tr>
      <td><button type="button" name="update" class="btn btn-warning bt-xs update" id="'.$row["cod_ocorrencia"].'">Alterar</button>
      <button type="button" name="delete" class="btn btn-danger bt-xs delete" id="'.$row["cod_ocorrencia"].'">Excluir</button>
      </td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
$link->close();
?>