<?php

 $cod_ocorrencia=$_POST['id_ocor'];
?>
<script type="text/javascript" src="data/qualidade/modal/upload.js"></script>
<link type="text/css" rel="stylesheet" href="data/qualidade/modal/style.css" />
<div id="imageModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Selecionar fotos</h4>
   </div>
   <div class="modal-body">
    <form method="post" name="upload_form" id="upload_form" enctype="multipart/form-data" action="data/qualidade/modal/upload.php">
    <label>Choose Multiple Images to Upload</label>
    <br>
    <br>
    <input type="file" name="upload_images[]" id="image_file" multiple >
    <input type="hidden" name="id_ocor" id="idOcor" value="<?php echo $cod_ocorrencia;?>">
    <div class="file_uploading hidden">
    <label> </label>
    <img src="data/qualidade/modal/uploading.gif" alt="Uploading......"/>
    </div>
    </form>
    <div id="uploaded_images_preview"></div>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
   </div>
  </div>
 </div>
</div>
<script>
    $(document).ready(function () {
        $('#imageModal').modal('show');
    });
</script>