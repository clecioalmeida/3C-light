<?php
//insert.php  
$connect = mysqli_connect("mysql.gisis.com.br", "gisis", "wmsweb2017", "gisis");
if(!empty($_POST))
{
 $saida = '';
    $cod_rec = mysqli_real_escape_string($connect, $_POST["cod_rec"]);  
    $ds_nome_r = mysqli_real_escape_string($connect, $_POST["ds_nome_r"]);  
    $nr_fisc_ent = mysqli_real_escape_string($connect, $_POST["nr_fisc_ent"]);  
    $nr_cfop_ent = mysqli_real_escape_string($connect, $_POST["nr_cfop_ent"]);  
    $vl_tot_nf_ent = mysqli_real_escape_string($connect, $_POST["vl_tot_nf_ent"]);  
    $nr_peso_ent = mysqli_real_escape_string($connect, $_POST["nr_peso_ent"]);
    $qtd_vol_ent = mysqli_real_escape_string($connect, $_POST["qtd_vol_ent"]);
    $tp_vol_ent = mysqli_real_escape_string($connect, $_POST["tp_vol_ent"]);
    $vl_icms_ent = mysqli_real_escape_string($connect, $_POST["vl_icms_ent"]);
    $base_icms_ent = mysqli_real_escape_string($connect, $_POST["base_icms_ent"]);
    $chavenfe = mysqli_real_escape_string($connect, $_POST["chavenfe"]);
    $ds_obs_nf = mysqli_real_escape_string($connect, $_POST["ds_obs_nf"]);
    $query = "
    INSERT INTO tb_nf_entrada(cod_rec, ds_nome_r, nr_fisc_ent, nr_cfop_ent, vl_tot_nf_ent, nr_peso_ent, qtd_vol_ent, tp_vol_ent, vl_icms_ent, base_icms_ent, chavenfe, ds_obs_nf)  
     VALUES('$cod_rec', '$ds_nome_r', '$nr_fisc_ent', '$nr_cfop_ent', '$vl_tot_nf_ent', '$nr_peso_ent', '$qtd_vol_ent', '$tp_vol_ent', '$vl_icms_ent', '$base_icms_ent', '$chavenfe', '$ds_obs_nf')";
    if(mysqli_query($connect, $query))
    {
     $saida .= '<label class="text-success">Dados cadastrados</label>';
     $select_query = "SELECT * FROM tb_nf_entrada ORDER BY dt_nf DESC";
     $result = mysqli_query($connect, $select_query);
     $saida_nf .='
        <div class="table-responsive">
          <table class="table table-bordered">
              <tr>
                <th> Código </th>
                <th> O.R. </th>
                <th> NF </th>
                <th> Emissão </th>
                <th> Emitente </th>
                <th> Peso </th>
                <th> Volume </th>
                <th> Valor </th>
                <th> Produtos </th>
              </tr>
              ';
        while ($linha_nf = mysqli_fetch_array($result)) {
          $saida_nf .='
              <tr>
                <td> '.$linha_nf['cod_nf_entrada'].'  </td>
                <td> '.$linha_nf['cod_rec'].' </td>
                <td> '.$linha_nf['nr_fisc_ent'].' </td>
                <td> '.$linha_nf['dt_emis_ent'].'  </td>
                <td> '.$linha_nf['ds_nome_r'].'  </td>
                <td> '.$linha_nf['nr_peso_ent'].'  </td>
                <td> '.$linha_nf['qtd_vol_ent'].'  </td>
                <td> '.$linha_nf['vl_tot_nf_ent'].'  </td>
                <td>
                  <a href="" data-toggle="modal" data-target="#produto_modal" data-toggle="tooltip" data-placement="left" title="Incluir produtos"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" ></span></a>
                </td>
              </tr>
          ';
        }
        $saida_nf .='</table></div>';
    }
    echo $saida_nf;
}
?>