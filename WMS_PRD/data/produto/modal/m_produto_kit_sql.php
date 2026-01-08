<?php
session_start(); 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    //$id_kit = mysqli_real_escape_string($link, $_SESSION["id_kit"]);
    $id_kit=$_SESSION['id_kit'];

    $sql_kit_prod = "select t1.*, t2.cod_produto, t2.nm_produto, t3.descricao 
    from tb_kit_produto t1 
    left join tb_produto t2 on t1.cod_estoque = t2.cod_produto
    left join tb_kit t3 on t1.id_kit = t3.id
    where id_kit = '$id_kit'";
    $res_kit_prod = mysqli_query($link,$sql_kit_prod);

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
                  <th> Código kit</th>
                  <th> Qtde </th>
                  <th> Descrição </th>
                  <th> Grupo </th>
                  <th> Subgrupo </th>
                  <th> Segurança </th>
                  <th> Estoque </th>
                  <th> Repor </th>
                  <th> Excluir </th>
                </tr>
              </thead>
              <tbody>
                <?php 
                        while($dados_kit_prod = mysqli_fetch_assoc($res_kit_prod)) {
                    ?>
                <tr>
                  <td> <?php echo $dados_kit_prod['id_kit_produto']; ?> </td>
                  <td style="width: 10px"> <?php echo $dados_kit_prod['quantidade']; ?> </td>
                  <td> <?php echo $dados_kit_prod['nm_produto']; ?> </td>
                  <td style="width: 20px">  </td>
                  <td style="width: 10px">  </td>
                  <td style="width: 10px">  </td>
                  <td style="width: 10px">  </td>
                  <td style="text-align: center; width: 5px">  
                    <a href="" data-toggle="modal" data-target="#rep_kit"><span class="fa fa-plus-circle" aria-hidden="true" ></span></a>
                  </td>
                  <td style="text-align: center; width: 5px">  
                    <a href="#" data-toggle="modal" data-target="#"><span class="fa fa-minus-circle" aria-hidden="true" ></span></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>