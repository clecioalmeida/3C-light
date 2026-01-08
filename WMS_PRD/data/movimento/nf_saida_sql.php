<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$nf_saida = "select t1.*, t2.produto, t4.nm_cliente 
from tb_nf_saida t1 left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido
left join tb_produto t3 on t2.produto = t3.cod_produto
left join tb_cliente t4 on t3.cod_cli = t4.cod_cliente
where t2.fl_status = 'T' or t2.fl_status = 'X'
group by t4.nm_cliente";

$res_nfsaida = mysqli_query($link,$nf_saida); 
$tr = mysqli_num_rows($res_nfsaida);
$link->close();
?>

<section class="panel col-lg-12">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#incluir_nfsaida" style="float: right;">Incluir</button><br/><br/>
    <?php
    if($tr > 0){
    ?>
    
    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1" style="width: 600px">
        <thead>
            <tr>
                <th> Ações </th>
                <th> Número Nf</th>
                <th> Pedido </th>
                <th> Série </th>
                <th> Emissão </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($dados_nfsaida = mysqli_fetch_assoc($res_nfsaida)) {
                $id_nf = $dados_nfsaida['nr_nf'];
                
                ?>
                <tr class="odd gradeX">
                    <td style="text-align: center; width: 5px">
                        <!--button type="submit" id="" class="btn btn-primary btn-xs" value="$dados_nfsaida['nr_nf_formulario']" data-toggle="modal" data-target="excluir_nf">Excluir</button-->
                        <a href="#" data-toggle="modal" data-target="#excluir_nf" data-toggle="tooltip" data-placement="left" title="Detalhe da nota"><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span></a>
                    </td>
                    <td style="text-align: center; width: 100px"><?php echo $dados_nfsaida['nr_nf_formulario']; ?></td>
                    <td style="text-align: center; width: 100px"><?php echo $dados_nfsaida['nr_pedido']; ?></td>
                    <td style="text-align: center; width: 10px"><?php echo $dados_nfsaida['nr_serie']; ?></td>
                    <td style="text-align: center; width: 50px"><?php $dt_emissao = $dados_nfsaida['dt_emissao'];
                            if($dt_emissao == '' ){
                                echo '';
                            } else{
                            echo date('d/m/Y', strtotime($dados_nfsaida['dt_emissao'])); 
                            }
                            ?>
                    </td>
                </tr>
                
                <?php }?>
            </tbody>
        </table>
    <?php }else{?>
    
    <h5>Não foram encontrados produtos com esta descrição.</h5>
    
    <?php }
    ?>
</section>
<div class="modal fade" id="incluir_nfsaida" tabindex="-1" role="dialog">
<form method="post" action="data/movimento/ins_nfsaida.php">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color: white">Incluir notas fiscais de saída</h4>
    </div>
    <div class="modal-body modal-lg">
    
        <div class="portlet-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nr_pedido">Pedido</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="nr_pedido" id="nr_pedido">
                        <option>Selecione o pedido</option>
                        <?php 
                        $sql_pedido_nf = "select distinct(nr_pedido) from tb_pedido_coleta where fl_status = 'X' and nr_pedido not in (select nr_pedido from tb_nf_saida)";
                        $res_pedido_nf = mysqli_query($link,$sql_pedido_nf); 
                        while ($dados_pedido=mysqli_fetch_assoc($res_pedido_nf)) {?>
                        
                            <option value="<?php echo $dados_pedido['nr_pedido']; ?>"><?php echo $dados_pedido['nr_pedido']; ?></option>
                        <?php } ?>
                        </select>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <!--label class="col-sm-2 control-label" for="id_destinatario">Destinatário</label-->
                    <div class="col-sm-2" id="nm_destino">
                        
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nr_nf_formulario">Número NF</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="nr_nf_formulario" id="nr_nf_formulario">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="nr_serie">Série</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="nr_serie" id="nr_serie">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-sm-2 control-label" for="dt_emissao">Data de emissão</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" name="dt_emissao" id="dt_emissao">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nr_cfop">CFOP</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="nr_cfop" id="nr_cfop">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="ds_obs_nf">Observações</label>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" name="ds_obs_nf" id="ds_obs_nf"></textarea>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
    
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->
<div class="modal fade" id="excluir_nf" aria-hidden="true">
    <form method="post" action="data/movimento/int_nfsaida.php" id="formCadastrarse">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2F4F4F;">
                <h5 class="modal-title" style="color: white">Excluir registro</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto">
                    <div class="form-body">
                        <div class="form-group">
                            <h5 class="modal-title">Você está excluindo a nota fiscal <?php echo $dados_nfsaida['nr_nf_formulario']; ?></h5>
                            <input type="text" class="form-control" name="nr_nf" value="<?php echo $id_nf; ?>" id="form_control_contato">
                        </div>
                        <div>     
                        </div>
                    </div>
            </div>

            <div class="modal-footer" style="background-color: #2F4F4F;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-primary">Sim</button>
            </div>   
    </div>
</div>
    </form>
</div><!--Fim modal-->
<script type="text/javascript">
    $(function(){
        
            $('#nr_pedido').change(function(){
                if( $(this).val() ) {
                    //$('#id_parte').hide();
                    //$('.carregando').show();
                    $.getJSON('data/movimento/consulta_destino.php?search=',{nr_pedido: $(this).val(), ajax: 'true'}, function(j){
                        //var options = '<option value="">Escolha a parte da Torre</option>'; 
                        for (var i = 0; i < j.length; i++) {
                            var options = '<input type="text" class="form-control" value="' + j[i].nm_cliente + '">';
                        }   
                        $('#id_destino').html(options).show();
                        $('.carregando').hide();
                    });
                } else {
                    $('#id_destino').html('');
                }
            });
        });
</script>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<!--script type="text/javascript">
    $('form.ajax').on('submit', function(){
        var that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};
        that.find('[name]').each(function(index, value){
            var that = $(this),
                name = that.attr('name'),
                value = that.val();
            data[name] = value;
        });
        $.ajax({
            url:url,
            type:type,
            data:data,
            success: function(response){
                console.log(response);
            }
        });
        return false;
    });
</script-->
<script type="text/javascript">
    $("#cnpj").mask("99.999.999/9999-99");
    $("#i_est").mask("999.999.999.999");
    $(".data").mask("99/99/9999");
    $(".hora").mask("99:99");
</script>