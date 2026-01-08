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
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$inv_ag = "select t1.id, 
date(t1.dt_inicio) as dt_inicio, 
date(t1.dt_fim) as dt_fim, 
CASE t1.ds_tipo WHEN 'R' THEN 'Rotativo' WHEN 'I' THEN 'Transferência' WHEN 'A' THEN 'Anual' ELSE 'Não selecionado' END as ds_tipo, COALESCE(t1.id_galpao,0) as id_galpao,  
COALESCE(t1.id_rua_inicio,0) as id_rua_inicio,  
COALESCE(t1.id_rua_fim,0) as id_rua_fim,  
COALESCE(t1.id_coluna_inicio,0) as id_coluna_inicio,  
COALESCE(t1.id_coluna_fim,0) as id_coluna_fim,  
COALESCE(t1.id_altura_inicio,0) as id_altura_inicio,  
COALESCE(t1.id_altura_fim,0) as id_altura_fim, 
t2.nome, 
COALESCE(t1.id_grupo,0) as id_grupo,
CASE COALESCE(t3.nm_grupo,0) WHEN 0 THEN 'NÃO SELECIONADO' ELSE t3.nm_grupo END as nm_grupo,
COALESCE(t1.id_produto,0) as id_produto,
CASE t1.fl_status WHEN 'A' THEN 'Agendado' WHEN 'F' THEN 'Finalizado' WHEN 'P' THEN 'Em progresso' ELSE 'Cancelado' END as fl_status
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
left join tb_grupo t3 on t1.id_grupo = t3.cod_grupo
where t1.fl_empresa = '$cod_cli' 
order by t1.dt_inicio";
$res_ag = mysqli_query($link, $inv_ag);
$ag = mysqli_num_rows($res_ag);
$link->close();
?>
<section id="widget-grid" class="">
  <?php
  if ($ag > 0) {
   ?>
   <div class="row" id="retImpInv">

    <article class="col-sm-12 col-md-12 col-lg-12">
      <hr>
      <table id="dt_basic" class="table" width="100%">
        <thead>
          <tr style="background-color: #8DB6CD">
            <th data-class="expand"> Código</th>
            <th data-class="expand"> Início</th>
            <th data-class="expand"h> Fim</th>
            <th data-class="expand"> Tipo </th>
            <th data-class="expand"> Galpão </th>
            <th data-hide="phone,tablet"> Endereço inicial  </th>
            <th data-hide="phone,tablet" colspan="2"> Endereço final  </th>
            <th data-hide="phone,tablet" colspan="2"> Grupo </th>
            <th data-hide="phone,tablet" colspan="2"> Produto </th>
            <th data-hide="phone,tablet"> Status </th>
            <th data-hide="phone,tablet" colspan="2"> # </th>
          </tr>
        </thead>
        <tbody>
          <?php  while ($dados_ag = mysqli_fetch_assoc($res_ag)) { ?>
            <tr class="odd gradeX">
              <td><?php echo $dados_ag['id']; ?></td>
              <td><?php echo $dados_ag['dt_inicio']; ?></td>
              <td><?php echo $dados_ag['dt_fim']; ?></td>
              <td><?php echo $dados_ag['ds_tipo']; ?></td>
              <td><?php echo $dados_ag['nome']; ?></td>
              <td><?php echo $dados_ag['id_rua_inicio']." - ".$dados_ag['id_coluna_inicio']." - ".$dados_ag['id_altura_inicio']; ?></td>
              <td><?php echo $dados_ag['id_rua_fim']." - ".$dados_ag['id_coluna_fim']." - ".$dados_ag['id_altura_fim']; ?></td>
              <td>
                <button type="submit" class="btn btn-primary btn-xs GeraTarefaEnd" id="btnGeraTarefaEnd" value="<?php echo $dados_ag['id']; ?>" data-end-ini = "<?php echo $dados_ag['id_galpao']."-".$dados_ag['id_rua_inicio']."-".$dados_ag['id_coluna_inicio']."-".$dados_ag['id_altura_inicio']; ?>" data-end-fim = "<?php echo $dados_ag['id_galpao']."-".$dados_ag['id_rua_fim']."-".$dados_ag['id_coluna_fim']."-".$dados_ag['id_altura_fim']; ?>">Gerar Tarefas</button>
              </td>
              <td><?php echo $dados_ag['nm_grupo']; ?></td>
              <td>
                <button type="submit" class="btn btn-primary btn-xs GeraTarefaGrupo" id="btnGeraTarefaGrupo" value="<?php echo $dados_ag['id']; ?>" data-grp = "<?php echo $dados_ag['id_grupo']; ?>">Gerar Tarefas</button>
              </td>
              <td><?php echo $dados_ag['id_produto']; ?></td>
              <td>
                <button type="submit" class="btn btn-primary btn-xs GeraTarefaPrd" id="btnGeraTarefaPrd" value="<?php echo $dados_ag['id']; ?>" data-prd = "<?php echo $dados_ag['id_produto']; ?>">Gerar Tarefas</button>
              </td>
              <td><?php echo $dados_ag['fl_status']; ?></td>
              <td style="width: 150px">
                <button type="button" class="btn btn-primary btn-xs AlteraInv" value="<?php echo $dados_ag['id']; ?>" id="btnAlteraInv">Alterar</button>
                <button type="button" class="btn btn-danger btn-xs" value="<?php echo $dados_ag['id']; ?>" id="btnEncerraInv">Encerrar</button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </article>
    <div id="retorno_2"></div>
  <?php } else {?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

  <?php }
  ?>
</section>
<script>
 $(document).ready(function(){
  $('.AlteraInv').on('click', function(){
    var id_inv = $(this).val();
    $.ajax
    ({
      url:"data/inventario/modal/m_upd_inv.php",
      method:"POST",
      data:{id_inv:id_inv},
      success:function(data)
      {
        $('#retorno_2').html(data);
      }
    });
  });
});
</script>
<script>
 $(document).ready(function(){
  $('.GeraTarefaEnd').on('click', function(){
    $('.GeraTarefaEnd').prop("disabled", true);
    event.preventDefault();

    var end_ini = $(this).attr("data-end-ini");
    var end_fim = $(this).attr("data-end-fim");

    $.ajax
    ({
      url:"data/inventario/relatorio/list_tarefa_end.php",
      method:"POST",
      data:
      {
        end_ini:end_ini,
        end_fim:end_fim
      },
      beforeSend:function(s)
      {
        $("#info").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
      },
      success:function(j)
      {
        $("#info").html(j);
      }
    });
    $('.GeraTarefaEnd').prop("disabled", false);
    return false;
  });
});
</script>
<script>
 $(document).ready(function(){
  $('.GeraTarefaGrupo').on('click', function(){
    $('.GeraTarefaGrupo').prop("disabled", true);
    event.preventDefault();

    var id_grp = $(this).attr("data-grp");

    if(id_grp == "0"){

      alert("Grupo não selecionado.");

    }else{

      $.ajax
      ({
        url:"data/inventario/relatorio/list_tarefa_grp.php",
        method:"POST",
        data:
        {
          id_grp:id_grp
        },
        beforeSend:function(s)
        {
          $("#info").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
        },
        success:function(j)
        {
          $("#info").html(j);
        }
      });

    }
    $('.GeraTarefaGrupo').prop("disabled", false);
    return false;
  });
});
</script>
<script>
 $(document).ready(function(){
  $('.GeraTarefaPrd').on('click', function(){
    $('.GeraTarefaPrd').prop("disabled", true);
    event.preventDefault();

    var id_prd = $(this).attr("data-prd");

    if(id_prd == "0"){

      alert("Produto não selecionado.");

    }else{

      $.ajax
      ({
        url:"data/inventario/relatorio/list_tarefa_prd.php",
        method:"POST",
        data:
        {
          id_prd:id_prd
        },
        beforeSend:function(s)
        {
          $("#info").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
        },
        success:function(j)
        {
          $("#info").html(j);
        }
      });

    }
    $('.GeraTarefaPrd').prop("disabled", false);
    return false;
  });
});
</script>

