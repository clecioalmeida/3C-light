<?php
    session_start();    
?>
<?php

    if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

        header("Location:../../index.php");
        exit;

    }else{
        
        $id=$_SESSION["id"];
    }

?>
<?php
require_once('bd_class_dsv.php');
$id_tar = $_POST['id_tar'];

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$query_conf="select t1.*, t2.*
			from tb_inv_tarefa t1
			left join tb_inv_conf t2 on t1.id = t2.id_tar
			where t1.id = '$id_tar'";
 $res_conf=mysqli_query($link, $query_conf);

 while ($dados_conf = mysqli_fetch_assoc($res_conf)) {
 	$id_galpao=$dados_conf['id_galpao'];
 	$id_rua=$dados_conf['id_rua'];
 	$id_coluna=$dados_conf['id_coluna'];
 	$id_altura=$dados_conf['id_altura'];
    $ds_embalagem=$dados_conf['ds_embalagem'];
 	$id_inv=$dados_conf['id_inv'];
 	$id_produto=$dados_conf['id_produto'];
 	$nr_qtde=$dados_conf['cont_2'];
    $fl_tipo=$dados_conf['fl_tipo'];
 }

 $selec_id="select id from tb_endereco where rua = '$id_rua' and galpao = '$id_galpao' and coluna = '$id_coluna' and altura = '$id_altura'";
 $res_id=mysqli_query($link, $selec_id);
 while ($dados_id = mysqli_fetch_assoc($res_id)) {
 	$id_end=$dados_id['id'];
 }

 $select_tar="select id_tar from tb_posicao_pallet where id_tar = '$id_tar'";
 $res_tar=mysqli_query($link, $select_tar);
 $tr_tar = mysqli_num_rows($res_tar);

if($tr_tar > 0){ ?>

     <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9AFF9A">
                    <h4 class="modal-title" id="myModalLabel">Erro</h4>
                </div>
                <div class="modal-body">                                
                    <h3>Essa tarefa já foi finalizada anteriormente!</h3>        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>     
    <script>
        $(document).ready(function () {
            $('#conf_cadastro').modal('show');
        });
    </script>
<?php
}else{

    if($id_produto == '47144'){

        $ins_saldo="insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, ds_embalagem, nr_qtde, nm_user_mov, dt_user_mov, fl_status, id_endereco, fl_tipo, id_tar) values ('$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$ds_embalagem', '$nr_qtde', '$id', now(), 'I', '$id_end', 'D', '$id_tar');";
        $res_saldo=mysqli_query($link, $ins_saldo);

        $ins_ocor="insert into tb_ocorrencia (nm_ocorrencia, tipo, fl_resp_cli, finalizadora, criticidade, dt_abertura, fl_status, cod_origem, user_create, dt_create) values ('Produto não identificado no inventário', 'A', 'N', 'N', 'M', now(), 'A', '$id_tar', '$id', now())";
        $res_ocor=mysqli_query($link, $ins_ocor);

     } else {

        $ins_saldo="insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, ds_embalagem, nr_qtde, nm_user_mov, dt_user_mov, fl_status, id_endereco, fl_tipo, id_tar) values ('$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$ds_embalagem', '$nr_qtde', '$id', now(), 'I', '$id_end', 'N', $id_tar');";
        $res_saldo=mysqli_query($link, $ins_saldo);

     }
   
}
 
  $updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
  $res_updt=mysqli_query($link1, $updt_conf);
  $tr_upd=mysqli_affected_rows($link1);

 if( $tr_upd > 0){?>

    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9AFF9A">
                    <h4 class="modal-title" id="myModalLabel">Tarefa finalizada!</h4>
                </div>
                <div class="modal-body">                                
                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>     
    <script>
        $(document).ready(function () {
            $('#conf_cadastro').modal('show');
        });
    </script>


<?php
 } else {

 	include"err_updt.php";

 }

$link->close();
?>