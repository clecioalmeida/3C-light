<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select p.cod_estoque, 
t.id as id_etq,
p.ds_galpao, 
p.ds_prateleira, 
p.ds_coluna, 
p.ds_altura, 
p.produto,
m.nm_produto,
a.nome
from tb_posicao_pallet p
left join tb_produto m on p.produto = m.cod_prod_cliente
left join tb_armazem a on p.ds_galpao = a.id
left join tb_etiqueta t on p.cod_estoque = t.cod_estoque
where p.fl_status = 'A' and p.fl_empresa = '$cod_cli' and p.nr_qtde > 0 and COALESCE(p.ds_galpao,0) > 0 and coalesce(p.cod_estoque,0) > 0
group by p.cod_estoque
order by p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura, p.produto";
$res_local = mysqli_query($link,$sql_local);
$tr_local = mysqli_num_rows($res_local);

$link->close();
?>
<?php
if($tr_local){?>

    <div class="col-sm-12 text-align-right">
        <div class="btn-group">
            <button type="submit" class="btn btn-success" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button>
        </div>
    </div>
    <div id="reportSalEstoque">
        <div class="padding-10">
            <div class="pull-left">
                <img src="../../../img/logo3c2.png" width="80" height="32" alt="Argus">
                <address>
                    <br>
                    <strong>3C Services</strong>
                </address>
            </div>
            <div class="pull-right" style="width: 400px">
                <h1 class="font-200">Relatório produtos para inventário</h1>
                <p><strong>ATENÇÃO:</strong> <h5>O arquivo excel gerado pode ser editado contanto que não se altere a ordem das colunas. Caso contrário a importação não funcionará.</h5></p>
            </div>
            <div class="clearfix"></div>
            <br>
            <br>
            <table class="table table-striped table-hover" id="" style="width: 100%">
                <thead>
                    <tr>
                        <th> Cód. Estoque </th>
                        <th> Cód. Etiqueta </th>
                        <th> Nome </th>
                        <th> Galpão </th>
                        <th> Rua </th>
                        <th> Coluna</th>
                        <th> Altura </th>
                        <th> Cód. SAP</th>
                        <th> Produto </th>
                        <th> Primeira contagem </th>
                        <th> Segunda contagem </th>
                        <th> Terceira contagem </th>
                        <th> Validade </th>
                        <th> CA </th>
                        <th> Validade CA </th>
                        <th> Laudo </th>
                        <th> Validade Laudo </th>
                        <th> Data inventário </th>
                        <th> Inventariante </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($dados_local = mysqli_fetch_assoc($res_local)) {
                        ?>
                        <tr class="odd gradeX">
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['cod_estoque']; ?> </td>
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['id_etq']; ?> </td>
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['nome']; ?> </td>
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['ds_galpao']; ?> </td>
                            <td style="text-align: center; width: 5px;"><?php echo $dados_local['ds_prateleira']; ?> </td>
                            <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_coluna']; ?> </td>
                            <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_altura']; ?> </td>
                            <td style="text-align: right; width: 5px"> <?php echo $dados_local['produto']; ?></td>
                            <td style="text-align: left; width: auto"> <?php echo $dados_local['nm_produto']; ?></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                            <td style="width: 50px"></td>
                        </tr>              
                    <?php } ?> 
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $('#RepEstoqGenExcel').on('click', function(){
            event.preventDefault();
            $('#RepEstoqGenExcel').prop("disabled", true);
            var today = new Date();
            $("#reportSalEstoque").table2excel({
                exclude: ".noExl",
                name: "Relatório posições com saldo para inventário",
                filename: "Relatório posições com saldo para inventário " + today});
            $('#RepEstoqGenExcel').prop("disabled", false);

        });
    </script>
<?php }else{?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

    <?php }?>