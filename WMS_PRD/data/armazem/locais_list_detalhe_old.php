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
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$local = $_POST['local'];
$produto = $_POST['produto'];

if($produto != '' && $local == "0"){
    $sql_local = "select t1.id, t1.nome, t2.cod_estoque, t2.ds_galpao, t2.produto, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.nr_qtde, t3.cod_prod_cliente, t3.nm_produto, t4.nome, t2.id_tar, date_format(date(t2.dt_create),'%d/%m/%Y') as data
    from tb_armazem t1
    left join tb_posicao_pallet t2 on t1.id = t2.ds_galpao
    left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
    left join tb_armazem t4 on t2.ds_galpao = t4.id
    where t2.fl_empresa = '$cod_cli' and t2.fl_status <> 'E' and t2.nr_qtde > 0 and t2.produto like '%$produto%' group by t2.cod_estoque";
    $res_local = mysqli_query($link,$sql_local);
    $tr_local = mysqli_num_rows($res_local);

}else {
    $sql_local = "select t1.id, t1.nome, t2.cod_estoque, t2.ds_galpao, t2.produto, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.nr_qtde, t3.cod_prod_cliente, t3.nm_produto, t4.nome, t2.id_tar, date_format(date(t2.dt_create),'%d/%m/%Y') as data
    from tb_armazem t1
    left join tb_posicao_pallet t2 on t1.id = t2.ds_galpao
    left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
    left join tb_armazem t4 on t2.ds_galpao = t4.id
    where t2.fl_empresa = '$cod_cli' and t2.fl_status = 'A' and t2.nr_qtde > 0 and produto > 0 and t1.id = '$local' group by t2.cod_estoque";
    $res_local = mysqli_query($link,$sql_local);
    $tr_local = mysqli_num_rows($res_local);

}
$link->close();
?>
<section class="panel col-lg-12">
    <?php
    if($tr_local){
    ?>
    <table class="table" id="sample_1" style="width: 60%">
                <thead>
                    <tr>
                        <!--th colspan="3"> Ações </th-->
                        <th> Código </th>
                        <th> Local </th>
                        <th> Rua </th>
                        <th> Coluna</th>
                        <th> Altura </th>
                        <th> Cód. SAP</th>
                        <th> Produto </th>
                        <th> Quantidade </th>
                        <th> Tarefa </th>
                        <th> Data </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($dados_local = mysqli_fetch_assoc($res_local)) {
                    ?>
                    <tr class="odd gradeX">
                        <!--td style="text-align: center; width: 5px">  
                            <a href="#" data-toggle="modal" data-target="#lista_prd<?php echo $dados_local['id']; ?>" data-toggle="tooltip" data-placement="left" title="Ver produtos"><span class="glyphicon glyphicon-barcode" aria-hidden="true" ></span></a>
                        </td>
                        <td style="text-align: center; width: 5px"><a href="#" data-toggle="modal" data-target="#bloquear<?php echo $dados_local['id']; ?>" data-toggle="tooltip" data-placement="left" title="Bloquear endereço"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true" ></span></a></td>
                        <td style="text-align: center; width: 5px">  
                            <a  href="#" data-toggle="modal" data-target="#desbloquear<?php echo $dados_local['id']; ?>"  data-toggle="tooltip" data-placement="left" title="Desbloquear endereço"><span class="glyphicon glyphicon-ok" aria-hidden="true" ></span></a>
                        </td-->
                        <td style="text-align: center; width: 5px;"><?php echo $dados_local['cod_estoque']; ?> </td>
                        <td style="text-align: left; width: 5px;"><?php echo $dados_local['nome']; ?> </td>
                        <td style="text-align: center; width: 5px;"><?php echo $dados_local['ds_prateleira']; ?> </td>
                        <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_coluna']; ?> </td>
                        <td style="text-align: center; width: 5px"> <?php echo $dados_local['ds_altura']; ?> </td>
                        <td style="text-align: right; width: 100px"> <?php echo $dados_local['produto']; ?></td>
                        <td style="text-align: left; width: auto"> <?php echo $dados_local['nm_produto']; ?></td>
                        <td style="text-align: right; width: auto"> <?php echo $dados_local['nr_qtde']; ?></td>
                        <td style="text-align: right; width: auto"> <?php echo $dados_local['id_tar']; ?></td>
                        <td style="text-align: right; width: auto"> <?php echo $dados_local['data']; ?></td>
                    </tr>
                    <div class="modal fade modal-lg" id="alterar_alocacao<?php echo $dados_local['cod_estoque']; ?>" tabindex="-1" role="dialog">
                        <form method="POST" action="xhr/update_alocacao.php">
                            <input type="hidden" name="cod_estoque" value="<?php echo $dados_local['cod_estoque']; ?>">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Alterar alocação</h4>
                                    </div>
                                    <div class="modal-body modal-lg">
                                        <div class="row">
                                            <div class="form-group">
                                            <label class="col-sm-2 control-label" for="form_control_cliente">Avaliação</label>
                                                <div class="col-sm-4">
                                                    <select class="form-group" name="nm_avaliacao">
                                                        <option value="<?php echo $dados_local['nm_avaliacao']; ?>"><?php echo $dados_local['nm_avaliacao']; ?></option>
                                                        <?php                                                           
                                                        while($dados_aval=mysqli_fetch_assoc($res_aval)) {?>
                                                        <option value="<?php echo $dados_aval['id']; ?>"><?php echo $dados_aval['nm_avaliacao']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="form-control-focus"> </div>
                                                </div>
                                                <label class="col-sm-2 control-label" for="solicitante">Projetos</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="ds_projeto" class="form-control" id="solicitante" value="<?php echo $dados_local['ds_projeto']; ?>">
                                                    <div class="form-control-focus"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-default" id="btnPesquisa" value="Salvar">Salvar</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </form>
                    </div><!-- /.modal -->
                    <div class="modal fade modal-lg" id="alterar_nserie" tabindex="-1" role="dialog">
                        <form method="post" id="modalNS" action="expede_ns_sql.php">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Alterar números de série alocados</h4>
                                    </div>
                                    <div class="modal-body modal-lg">
                                        <div class="row">
                                            <div id="nserie" class="row"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary" id="btnFormNS">Salvar</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </form>
                    </div><!-- /.modal -->
                    <?php } ?> 
                </tbody>
            </table>
    <?php }else{?>
    
    <h4>Nao foram encontrados produtos com esta descrição.</h4>
    
    <?php }
    ?>
</section>

<script type="text/javascript">
/*
    $('#btnPesquisa').click(function(){
        $('#alterar_alocacao').modal('show');
        $('#formAloc').ajaxForm({
            target:'#aloca',
            url:'altera_alocacao.php',
        });
    });

$(document).ready(function(){
    $('#btnNserie').click(function(){
        $('#alterar_nserie').modal('show');
        $('#formAloc').ajaxForm({
            target:'#nserie',
            url:'altera_alocacao.php',
        });
    });
});
*/
</script>