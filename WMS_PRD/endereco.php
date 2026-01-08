<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION['cod_cli'];
}
?>
<?php
require_once "bd_class.php";

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_gp = "select cod_galpao, galpao from tb_galpao where fl_status = 'A'";
$res_gp = mysqli_query($link, $sql_gp);

$sql_tp = "select id, nome from tb_armazem where id_oper = '$cod_cli' order by nome asc";
$res_tp = mysqli_query($link, $sql_tp);

$inputWidth = "20px";

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li>Home</li><li>Operacional</li><li>Locais de armazenagem</li>
            </ol>
        </div>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
                        <div>
                            <div class="jarviswidget-editbox">

                            </div>
                            <div class="widget-body">
                                <hr class="simple">
                                <ul id="myTab1" class="nav nav-tabs bordered">
                                    <li class="active">
                                        <a href="#s6" id="liRecAg" data-toggle="tab">GALPÕES <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liRecPend" data-toggle="tab">ARMAZÉM </a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="liRecPend" data-toggle="tab">ENDEREÇOS </a>
                                    </li>
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">GALPÃO
                                                        <input type="text" class="input-xs" id="nm_gal" name="nm_gal" style="color: black">
                                                    </label>
                                                    <label class="input">CIDADE
                                                        <input type="text" class="input-xs" id="cid_gal" name="cid_gal" style="color: black">
                                                    </label>
                                                    <label class="input">APELIDO
                                                        <input type="text" class="input-xs" id="apel_gal" name="apel_gal" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnSaveGal" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">SALVAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoGal"></div>
                                            <div id="retModalGal"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s2">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">GALPÃO:
                                                        <select class="form-control" name="ds_galpao" id="ds_galpao">
                                                          <option>Selecione</option>
                                                          <?php
                                                          while ($row_galpao = mysqli_fetch_assoc($res_gp)) {?>
                                                            <option value="<?php echo $row_galpao['cod_galpao']; ?>">
                                                              <?php echo $row_galpao['galpao']; ?>
                                                              </option> <?php }?>
                                                          </select>
                                                      </label>
                                                      <label class="input">NOME:
                                                        <input type="text" class="input-xs" id="ds_nome" name="ds_tipo" style="color: black">
                                                    </label>
                                                    <label class="input">APELIDO:
                                                        <input type="text" class="input-xs" id="ds_apelido" name="ds_apelido" style="color: black">
                                                    </label>
                                                    <label class="input">CURVA:
                                                        <select class="input-xs" name="fl_curva" id="fl_curva">
                                                          <option value="N">NÃO</option>
                                                          <option value="S">SIM</option>
                                                      </select>
                                                  </label>
                                                  <label class="input">TIPO:
                                                    <select class="input-xs" name="fl_tipo" id="fl_tipo">
                                                      <option value="F">FÍSICO</option>
                                                      <option value="V">VIRTUAL</option>
                                                  </select>
                                              </label>
                                              <label class="input">ALOC. AUTOM.:
                                                <select class="input-xs" name="fl_aloc" id="fl_aloc">
                                                  <option value="N">NÃO</option>
                                                  <option value="S">SIM</option>
                                              </select>
                                          </label>
                                          <button type="submit" id="btnInsArm" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">GERAR</button>
                                      </form>
                                  </div>
                              </article>
                              <article>
                                <div id="retornoArm"></div>
                                <div id="retArm"></div>
                                <div id="retModalArm"></div>
                            </article>
                        </div>
                        <div class="tab-pane fade" id="s1">
                            <article>
                                <div>
                                    <form class="form-horizontal" method="post" action="" id="">
                                        <label class="input">GALPÃO:
                                            <select class="form-control" name="cod_galpao" id="cod_galpao">
                                              <option>Selecione</option>
                                              <?php
                                              while ($row_select_tipo = mysqli_fetch_assoc($res_tp)) {?>
                                                <option value="<?php echo $row_select_tipo['id']; ?>">
                                                  <?php echo $row_select_tipo['nome']; ?>
                                                  </option> <?php }?>
                                              </select>
                                          </label>
                                          <label class="input">TIPO:
                                            <input type="text" class="input-xs" id="ds_tipo" name="ds_tipo" style="color: black;width: 200px">
                                        </label>
                                        <label class="input">RUA DE:
                                            <input type="text" class="input-xs" id="rua_ini" name="rua_ini" style="color: black;width: 50px">
                                            <span> ATÉ: </span>
                                            <input type="text" class="input-xs" id="rua_fim" name="rua_fim" style="color: black;width: 50px">
                                        </label>
                                        <label class="input">| COLUNA DE:
                                            <input type="text" class="input-xs" id="col_ini" name="col_ini" style="color: black;width: 50px">
                                            <span> ATÉ: </span>
                                            <input type="text" class="input-xs" id="col_fin" name="col_fin" style="color: black;width: 50px">
                                        </label>
                                        <label class="input">PREFIXO:
                                            <input type="text" class="input-xs" id="ds_pre" name="ds_pre" style="color: black;width: 50px">
                                            <span>POSFIXO: </span>
                                            <input type="text" class="input-xs" id="ds_pos" name="ds_pos" style="color: black;width: 50px">
                                        </label>
                                        <label class="input">| NÍVEL DE:
                                            <input type="text" class="input-xs" id="alt_ini" name="alt_ini" style="color: black;width: 50px">
                                            <span> ATÉ: </span>
                                            <input type="text" class="input-xs" id="alt_fin" name="alt_fin" style="color: black;width: 50px">
                                        </label>
                                        <!--label class="input">| NÍVEIS:
                                            <input type="text" class="input-xs" id="nr_nivel" name="nr_nivel" style="color: black;width: 50px">
                                        </label-->
                                        <label class="input">PREFIXO NIVEL:
                                            <input type="text" class="input-xs" id="ds_pren" name="ds_pren" style="color: black;width: 50px">
                                            <span>POSFIXO NIVEL INI: </span>
                                            <input type="text" class="input-xs" id="ds_posni" name="ds_posni" style="color: black;width: 50px">
                                            <span>POSFIXO NIVEL FIM: </span>
                                            <input type="text" class="input-xs" id="ds_posnf" name="ds_posnf" style="color: black;width: 50px">
                                        </label>
                                        <button type="submit" id="btnInsEnd" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">GERAR</button>
                                    </form>
                                </div>
                            </article>
                            <article>
                                <div id="retornoEnd"></div>
                                <div id="retEnd"></div>
                                <div id="retModalEnd"></div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<div class="row">
    <div id="retModalEntrega">
    </div>
</div>
</section>
</div>
<div id="retNfTransp"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('#btnInsEnd').on('click', function(){
            event.preventDefault();
            if(confirm("Confirma a criação dos endereços?")){
                $('#btnInsEnd').prop("disabled", true);
                var cod_galpao      = $('#cod_galpao').val();
                var rua_ini         = $('#rua_ini').val();
                var rua_fim         = $('#rua_fim').val();
                var col_ini         = $('#col_ini').val();
                var col_fin         = $('#col_fin').val();
                var alt_ini         = $('#alt_ini').val();
                var alt_fin         = $('#alt_fin').val();
                
                var ds_pre          = $('#ds_pre').val();
                var ds_pos          = $('#ds_pos').val();                
                //var nr_nivel        = $('#nr_nivel').val();
                var ds_posni         = $('#ds_posni').val();
                var ds_posnf         = $('#ds_posnf').val();
                var ds_pren         = $('#ds_pren').val();
                var ds_tipo         = $('#ds_tipo').val();
                $.ajax
                ({
                    url:"ins_endereco.php",
                    method:"POST",
                    data:{
                        cod_galpao:cod_galpao,
                        rua_ini:rua_ini,
                        rua_fim:rua_fim,
                        col_ini:col_ini,
                        col_fin:col_fin,
                        alt_ini:alt_ini,
                        alt_fin:alt_fin,
                        ds_pre:ds_pre,
                        ds_pos:ds_pos,
                        //nr_nivel:nr_nivel,
                        ds_posni:ds_posni,
                        ds_posnf:ds_posnf,
                        ds_pren:ds_pren,
                        ds_tipo:ds_tipo
                    },
                    beforeSend:function(e){
                        $("#retornoEnd").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                    },
                    success:function(data)
                    {
                        $('#retornoEnd').html(data);
                    }
                });
                $('#btnInsEnd').prop("disabled", false);
            }
            return false;
        });

        $('#btnSaveGal').on('click', function(){
            event.preventDefault();
            if(confirm("Confirma a criação do loca de armazenagem?")){
                $('#btnSaveGal').prop("disabled", true);
                var nm_gal      = $('#nm_gal').val();
                var cid_gal     = $('#cid_gal').val();
                var apel_gal    = $('#apel_gal').val();
                $.ajax
                ({
                    url:"ins_galpao.php",
                    method:"POST",
                    data:{
                        apel_gal:apel_gal,
                        cid_gal:cid_gal,
                        nm_gal:nm_gal
                    },
                    beforeSend:function(e){
                        $("#retornoGal").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                    },
                    success:function(data)
                    {
                        $('#retornoGal').html(data);
                    }
                });
                $('#btnSaveGal').prop("disabled", false);
            }
            return false;
        });

        $('#btnInsArm').on('click', function(){
            event.preventDefault();
            if(confirm("Confirma a criação do local de armazenagem?")){
                $('#btnInsArm').prop("disabled", true);
                var ds_galpao   = $('#ds_galpao').val();
                var ds_nome     = $('#ds_nome').val();
                var ds_apelido  = $('#ds_apelido').val();
                var fl_curva    = $('#fl_curva').val();
                var fl_tipo     = $('#fl_tipo').val();
                var fl_aloc     = $('#fl_aloc').val();

                $.ajax
                ({
                    url:"ins_armazem.php",
                    method:"POST",
                    data:{
                        ds_galpao:      ds_galpao,
                        ds_nome:        ds_nome,
                        ds_apelido:     ds_apelido,
                        fl_curva:       fl_curva,
                        fl_tipo:        fl_tipo,
                        fl_aloc:        fl_aloc
                    },
                    beforeSend:function(e){
                        $("#retornoArm").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                    },
                    success:function(data)
                    {
                        $('#retornoArm').html(data);
                    }
                });
                $('#btnInsArm').prop("disabled", false);
            }
            return false;
        });
    });
</script>