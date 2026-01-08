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

$SQL = "select t1.id, t1.cod_estoque, t1.nr_alocado, t2.produto, t2.nr_or, t4.nm_produto, format(t2.nr_volume,0) as nr_volume, format(t2.nr_qtde,0) as nr_qtde, t1.fl_status, date(t2.dt_create) as data
from tb_aloca t1
left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
left join tb_armazem t3 on t2.ds_galpao = t3.id
left join tb_produto t4 on t2.cod_produto = t4.cod_produto
where t1.fl_status <> 'A' and t2.fl_empresa = '$cod_cli' and t1.fl_status <> 'E' and t2.nr_qtde > 0 order by t1.id desc";
$res = mysqli_query($link,$SQL);

$link->close();
?>
<?php
if(mysqli_num_rows($res) > 0){
    ?> 
    <article>
        <div>
          <form class="form-horizontal" method="post" action="data/recebimento/relatorio/list_etq_rec_all_aloc.php" id="" target="_blank">
              <input type="hidden" class="input-xs" id="id_rec" name="id_rec" value="<?php echo $id_rec;?>" style="color: black">
              <button type="submit" id="btnPrintEtqRecAlocAll" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">IMPRIMIR TODAS</button>
          </form>
      </form>
  </div>
</article>
<article>
    <legend>Produtos</legend>
    <table class="table" id="">
        <thead>
            <tr>
                <th class="hasinput" style="width: 20px">
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="checkboxTodosAlocGer" class="checkbox style-0">
                            <span></span>
                        </label>
                    </div>
                </th>
                <th> AÇÕES</th>
                <th style="text-align: right"> CÓDIGO</th>
                <th style="text-align: right"> DATA</th>
                <th style="text-align: right"> PRODUTO </th>
                <th> DESCRIÇÃO </th>
                <th style="text-align: right"> VOLUMES </th>
                <th style="text-align: right"> QUANTIDADE </th>
                <th style="text-align: right"> OR </th>
                <th> status </th>
            </tr>
        </thead>
        <tbody>
            <?php                                                           
            while($dados = mysqli_fetch_assoc($res)) 
                {?>
                    <tr class="odd gradeX">
                        <td>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="checkbox style-0 checkboxTodosAlocGer" id="checkboxTodosAlocGer" value="<?php echo $dados['id'];?>">
                                    <span></span>
                                </label>
                            </div>
                        </td>
                        <td style="width: 20%">
                            <form class="form-horizontal" method="post" action="data/recebimento/relatorio/list_etq_rec_aloc.php" id="" target="_blank"> 
                                <button type="button" id="btnLibAloc" class="btn btn-success btn-xs" value="<?php echo $dados['id']; ?>">LIBERAR</button>
                                <button type="button" id="btnPrintAloc" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">IMPRIMIR</button>
                                <input type="hidden" name="cod_estoque" value="<?php echo $dados['cod_estoque'];?>">
                                <button type="submit" id="btnGeraEtqAloc" class="btn btn-default btn-xs" style="margin-right: 3px;width: 150px">GERAR ETIQUETAS</button> 
                            </form>
                        </td>
                        <td style="text-align: right; width: 10%"> <?php echo $dados['id']; ?> </td>
                        <td style="text-align: right; width: 10%"> <?php echo $dados['data']; ?> </td>
                        <td style="text-align: right; width: 10%"> <?php echo $dados['produto']; ?> </td>
                        <td style="text-align: left; width: 40%"> <?php echo $dados['nm_produto']; ?> </td>
                        <td style="text-align: right; width: 10%"> <?php echo $dados['nr_volume']; ?> </td>
                        <td style="text-align: right; width: 10%"> <?php echo $dados['nr_qtde']; ?> </td>
                        <td style="text-align: right; width: 5%"> <?php echo $dados['nr_or']; ?> </td>
                        <?php
                        if ($dados['fl_status'] == 'P') {

                            $td = '<td style="background-color: #F4A460">ALOCAÇÃO GERADA</td>';
                            echo $td;

                        }else if ($dados['fl_status'] == 'L'){

                            $td = '<td style="background-color: #FFFF00">ALOCAÇÃO LIBERADA</td>';
                            echo $td;

                        }else if ($dados['fl_status'] == 'F'){

                            $td = '<td style="background-color: #9AFF9A">ALOCAÇÃO FINALIZADA</td>';
                            echo $td;

                        }
                        ?>
                    </tr>   
                <?php } ?> 
            </tbody>
        </table>
    </article>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#checkboxTodosAlocGer").click(function(){
          $('input:checkbox').not(this).prop('checked', this.checked);
      });
    });
</script>
<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('click', '#btnPrintEtqRecAlocAll', function(){
        event.preventDefault();
        if( $('.checkboxTodosAlocGer:checked').length == 0 ){

            alert('Selecione pelo menos uma alocação!');

        }else{

            var val = [];

            $('.checkboxTodosAlocGer:checked').each(function(){
                val.push($(this).val());
            });

            $.ajax
            ({
                url:'data/recebimento/relatorio/list_etq_rec_all_aloc.php',
                method:'POST',
                data:{
                    id_rec:val
                },
                success:function(j)
                {
                    window.open(j, "_blank"); 
                }
            });
        }
    });

});
</script>
<?php }else{?>

    <h4>Nao foram encontradas alocações geradas.</h4>

<?php }
?>