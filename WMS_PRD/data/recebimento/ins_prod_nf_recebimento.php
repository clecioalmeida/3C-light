 <?php 

  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $id_rec = mysqli_real_escape_string($link, $_POST["prod_nfrec"]);

  $select_codnf = "select cod_nf_entrada from tb_nf_entrada where cod_rec = '$id_rec'";
  $res_codnf = mysqli_query($link,$select_codnf);

  while($dados_cod=mysqli_fetch_assoc($res_codnf)){
        $cod_nf_entrada=$dados_cod["cod_nf_entrada"];
    }

  if(mysqli_num_rows($res_codnf) > 0){

    
    include 'modal/m_prod_nf_recebimento.php';

 }else{

    include 'modal/err_ins_prd_nf_recebimento.php';

  }

$link->close();
?>   