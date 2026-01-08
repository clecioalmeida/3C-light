<?php
session_start();

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    //$id_kit = mysqli_real_escape_string($link, $_POST["var_kit"]);
    $id_kit=$_SESSION['id_kit'];

    $sql_kit_var = "select t1.*, t2.descricao, t3.nm_produto 
    from tb_kit_var t1
    left join tb_kit t2 on t1.id_kit = t2.id_kit
    left join tb_produto t3 on t1.cod_estoque = t3.cod_produto and t2.cod_estoque_sbst = t3.cod_produto
    where t1.id_kit = '$id_kit'";
    $res_kit_var = mysqli_query($link,$sql_kit_var);

    $SQL = "select * from tb_kit where id = '$id_kit'";
    $res_kit = mysqli_query($link,$SQL);

    while ($dados = mysqli_fetch_assoc($res_kit)) {
    $descricao=$dados['descricao'];
}

session_destroy();

$link->close();
?>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> Código</th>
                    <th> Kit</th>
                    <th> Descrição </th>
                    <th> Produto </th>
                    <th> Produto substituto </th>
                    <th> Excluir </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                        while($dados_kit_var = mysqli_fetch_assoc($res_kit_var)) {
                    ?>
                    <td><?php echo $dados_kit_var['id_kit_var']; ?></td>
                    <td><?php echo $dados_kit_var['id_kit']; ?></td>
                    <td><?php echo $dados_kit_var['descricao']; ?></td>
                    <td><?php echo $dados_kit_var['cod_estoque']; ?></td>
                    <td><?php echo $dados_kit_var['cod_estoque_sbst']; ?></td>
                    <td style="text-align: center">  
                        <a href="" data-toggle="modal" data-target="#"><span class="fa fa-minus-circle" aria-hidden="true" ></span></a>
                    </td>
                </tr> 
                <?php } ?>
            </tbody>
        </table>