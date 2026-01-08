<?php 
  require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();
$id_endereco = $_POST['id_endereco'];

$sql_ocupacao = "select t1.produto, t1.nr_qtde, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t2.nm_produto, t3.nr_posicao from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto left join tb_item_torre t3 on t2.cod_produto = t3.id_item or t2.id_torre = t3.id_item where id_endereco = '$id_endereco'";
$res_ocupacao = mysqli_query($link,$sql_ocupacao);
$tr_ocupacao = mysqli_num_rows($res_ocupacao);

$link->close();
?>
    <?php
    if($tr_ocupacao>0){
        ?>
        <table class="table">
            <thead>                         
                <tr>
                    <th data-hide="phone"> Código SAP </th>
                    <th data-class="expand"> Posição / Descrição </th>
                    <th data-class="expand"> Quantidade </th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($dados_ocupacao=mysqli_fetch_assoc($res_ocupacao)) { ?>
                <tr>
                    <td><?php echo $dados_ocupacao['produto']; ?></td>
                    <td><?php echo $dados_ocupacao['nr_posicao']." - ".$dados_ocupacao['nm_produto']; ?></td>
                    <td><?php echo $dados_ocupacao['nr_qtde']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
     
     <?php }else{?>
     
     <h4>Não foram encontrados produtos nessa alocação.</h4>
     
     <?php }
     ?>