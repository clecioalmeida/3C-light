<?php
//action.php
if(isset($_POST["action"]))
{
 require_once('modal/bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $cod_ocorrencia=$_POST['id_ocor'];

 if($_POST["action"] == "fetch")
 {
  $query = "SELECT id, img1, img2, img3 FROM tb_ocorrencias where cod_ocorrencia = '$cod_ocorrencia' ORDER BY id DESC";
  $result = mysqli_query($link,$query); 
  $output = '';
  while($row = mysqli_fetch_array($result))
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
      <td><button type="button" name="update" class="btn btn-warning bt-xs update" id="'.$row["id"].'">Change</button>
      <button type="button" name="delete" class="btn btn-danger bt-xs delete" id="'.$row["id"].'">Remove</button>
      </td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }

 if($_POST["action"] == "insert")
 {
  $file1 = addslashes(file_get_contents($_FILES["image1"]["tmp_name"]));
  $file2 = addslashes(file_get_contents($_FILES["image2"]["tmp_name"]));
  $file3 = addslashes(file_get_contents($_FILES["image3"]["tmp_name"]));
  $query = "update tb_ocorrencias set img1= '$file1', img2='$file2', img3='$file3' where cod_ocorrencia = '$cod_ocorrencia'";
  if(mysqli_query($connect, $query))
  {
   echo 'Image Inserted into Database';
  }
 }
 if($_POST["action"] == "update")
 {
  $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
  $query = "UPDATE tbl_images SET name = '$file' WHERE id = '".$_POST["image_id"]."'";
  if(mysqli_query($connect, $query))
  {
   echo 'Image Updated into Database';
  }
 }
 if($_POST["action"] == "delete")
 {
  $query = "DELETE FROM tbl_images WHERE id = '".$_POST["image_id"]."'";
  if(mysqli_query($connect, $query))
  {
   echo 'Image Deleted from Database';
  }
 }
}
$link->close();
?>