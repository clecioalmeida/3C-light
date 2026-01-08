<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"])){

    header("Location:../logout.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['nm_movimenta'])){

    if($_POST['nm_movimenta'] != '' && $_POST['cod_movimenta'] == ''){

        $nm_movimenta = $_POST['nm_movimenta'];
        $cod_movimenta = $_POST['cod_movimenta'];
        $galpao = $_POST['local'];

        $sql_mov = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.ds_apelido from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_produto left join tb_armazem t3 on t1.ds_galpao = t3.id where t2.nm_produto like '%$nm_movimenta%' and t1.ds_galpao = '$galpao' and t1.nr_qtde > 0 and t1.fl_status = 'A' and t2.fl_empresa = '$cod_cli'";    
        $mov = mysqli_query($link,$sql_mov);
        $tr = mysqli_num_rows($mov);

    } else if($_POST['nm_movimenta'] == '' && $_POST['cod_movimenta'] != ''){

        $nm_movimenta = $_POST['nm_movimenta'];
        $cod_movimenta = $_POST['cod_movimenta'];
        $galpao = $_POST['local'];

        $sql_mov = "select t1.*, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.ds_apelido from tb_posicao_pallet t1 left join tb_produto t2 on t1.produto = t2.cod_prod_cliente left join tb_armazem t3 on t1.ds_galpao = t3.id where t1.produto = '$cod_movimenta' and t1.ds_galpao = '$galpao' and t1.nr_qtde > 0 and t1.fl_status = 'A' and t2.fl_empresa = '$cod_cli'"; 
        $mov = mysqli_query($link,$sql_mov);
        $tr = mysqli_num_rows($mov);
    }else{

        $tr = 0;

    }

}else{

   $tr = 0;

}



$link->close();
?>
<?php
if($tr>0){
    ?>    
    <table id="dt_basic" class="table" style="width: 70%">
        <thead>
            <tr>
                <th> Código SAP</th>
                <th> Descrição </th>
                <th> Galpão  </th>
                <th> Rua  </th>
                <th> Coluna </th>
                <th> Altura</th>
                <th> Volume</th>
                <th> Qtde</th>
                <th> # </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($mov)){
                $rua=$linha['ds_prateleira'];
                ?>
                <tr>
                    <td style="width: 100px"> <?php echo $linha['produto'];?> </td>
                    <td> <?php echo $linha['nm_produto'];?> </td>
                    <td> <?php echo $linha['ds_apelido'];?> </td>
                    <td> <?php echo $linha['ds_prateleira'];?> </td>
                    <td> <?php echo $linha['ds_coluna'];?> </td>
                    <td> <?php echo $linha['ds_altura'];?> </td>
                    <td> <?php echo $linha['nr_volume'];?> </td> 
                    <td> <?php echo $linha['nr_qtde'];?>   </td>   
                    <td style="text-align: center; width: 5px"> 
                        <form method="post" id="formMovDest" action="">
                            <input type="hidden" name="nr_qtde" id="nr_qtde" value="<?php echo $linha['nr_qtde'];?>">
                            <button type="submit" id="btnMovDestino" value="<?php echo $linha['cod_estoque'];?>" class="btn btn-success btn-xs">Movimentar</button>
                        </form>
                    </td>
                <?php }?>
            </tr>
        </tbody>
    </table>
<?php }else{?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
<?php }
?>
<script type="text/javascript">
    $('.mask').mask("#.##0,00", {reverse: true});
</script>