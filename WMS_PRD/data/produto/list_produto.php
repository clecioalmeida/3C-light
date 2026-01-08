<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id=$_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$codigo     = $_POST['codigo'];

$sql = "select t1.cod_prod_cliente, t1.cod_produto, t1.nm_produto, t1.peso, t1.unid from tb_produto t1 where (t1.cod_prod_cliente = '$codigo' or t1.nm_produto like '%$codigo%') and fl_empresa = '$cod_cli'";
$res = mysqli_query($link,$sql);

$tr = mysqli_num_rows($res);

$link->close();
?>

<?php if($tr > 0){ ?>

    <style type="text/css">
        .tableFixHead          { overflow-y: auto; height: 640px; }
        .tableFixHead thead th { position: sticky; top: 0; }
        table  { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 16px; }
        th     { background:#eee; }

    </style>

    <div class="tableFixHead">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> Ações </th>
                    <th data-toggle="tooltip" data-placement="left" title="Código do cliente"> COD. CLIENTE</th>
                    <th> COD. WMS </th>
                    <th> PRODUTO </th>
                    <th> PESO UNIT </th>
                    <th> UNIDADE </th>
                </tr>
            </thead>
            <tbody>
                <?php                                                      
                while($dados = mysqli_fetch_array($res)) {?>
                    <tr class="odd gradeX">
                        <td style="text-align: center; width: 150px">  
                            <button type="submit" id="btnDtlProduto" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_produto']; ?>">Detalhe</button>
                            <button type="submit" id="btnUpdProduto" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_produto']; ?>">Alterar</button>
                        </td>
                        <td style="text-align: right"> <?php echo $dados['cod_prod_cliente']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['cod_produto']; ?> </td>
                        <td> <?php echo $dados['nm_produto']; ?> </td>
                        <td style="text-align: right"> <?php echo $dados['peso']; ?> </td>
                        <td> <?php echo $dados['unid']; ?> </td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
<?php }else{?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php } ?>


<div id="retornoInsert"></div>