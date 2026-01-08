<script src="js/empresa.js"></script>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Cadastros</li><li>Empresa</li>
        </ol>
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
                                        <a href="#s1" id="liPrd" data-toggle="tab">EMPRESA <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liUser" data-toggle="tab">USUÁRIOS </a>
                                    </li>
                                    <li>
                                        <a href="#s3" id="liFunc" data-toggle="tab">FUNCIONÁRIOS</a>
                                    </li>
                                    <li>
                                        <a href="#s4" id="liCrgs" data-toggle="tab">CARGOS</a>
                                    </li>
                                    <li>
                                        <a href="#s5" id="liDpto" data-toggle="tab">DEPARTAMENTOS</a>
                                    </li>
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">DESCRIÇÃO
                                                        <input type="text" class="input-xs" id="produtos" name="produtos" style="color: black">
                                                    </label>
                                                    <label class="input">CÓDIGO SAP
                                                        <input type="text" class="input-xs" id="codigo" name="codigo" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaPrd" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>          
                                                    <button type="submit" id="btnNovoProduto" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">Novo</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoPrd">
                                                <table id="dt_basic" class="table" width="100%">
                                                    <thead> 
                                                        <tr>
                                                            <th colspan="2"> Ações </th>
                                                            <th> Código</th>
                                                            <th> Razão Social </th>
                                                            <th> CNPJ </th>
                                                            <th> Cidade </th>
                                                            <th> UF </th>
                                                            <th> Telefone </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        require_once('data/empresa/list_empresa.php');                                  
                                                        while($dados = mysqli_fetch_array($res)) {?>
                                                            <tr class="odd gradeX">
                                                                <td style="text-align: center; width: 5px">
                                                                    <button type="submit" id="btnDtlEmpresa" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_empresa']; ?>">Detalhe</button> 
                                                                </td>
                                                                <td style="text-align: center; width: 5px">
                                                                    <button type="submit" id="btnUpdEmpresa" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_empresa']; ?>">Alterar</button> 
                                                                </td>
                                                                <td style="width: 10px"><?php echo $dados['cod_empresa']; ?> </td>
                                                                <td> <?php echo $dados['nm_empresa']; ?> </td>
                                                                <td> <?php echo $dados['nr_cnpj']; ?> </td>
                                                                <td> <?php echo $dados['ds_cidade']; ?> </td>
                                                                <td style="width: 10px"> <?php echo $dados['ds_uf']; ?> </td>
                                                                <td style="width: 50px"> <?php echo $dados['ds_telefone']; ?> </td>
                                                            </tr> 
                                                        <?php } ?> 
                                                    </tbody>
                                                </table>    
                                            </div>
                                            <div id="retModalPrd"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s2">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">DESCRIÇÃO
                                                        <input type="text" class="input-xs" id="produtosKit" name="produtosKit" style="color: black">
                                                    </label>
                                                    <label class="input">CÓDIGO SAP
                                                        <input type="text" class="input-xs" id="codigoKit" name="codigoKit" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaKit" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornUser">
                                                <table class="table" id="" style="width: 50%">
                                                    <thead>
                                                        <tr>
                                                            <th> Ações </th>
                                                            <th> Código</th>
                                                            <th> Nome </th>
                                                            <th> Depto </th>
                                                            <th> # </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php require_once('data/empresa/list_usuario.php');                                  
                                                        while($dados = mysqli_fetch_array($res)) {?>
                                                            <tr class="odd gradeX">
                                                                <td style="text-align: center; width: 200px">  
                                                                    <button type="submit" id="btnDtlUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Detalhe</button>
                                                                    <button type="submit" id="btnUpdUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Alterar</button>
                                                                    <button type="submit" id="btnDelUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Excluir</button>
                                                                </td>
                                                                <td style="text-align: center; width: 10px"> <?php echo $dados['id']; ?> </td>
                                                                <td> <?php echo $dados['nm_user']; ?> </td>
                                                                <td> <?php echo $dados['nm_cargo']; ?> </td>
                                                                <td style="text-align: center; width: 10px">
                                                                    <button type="submit" id="btnPermUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Permissões</button>
                                                                </td>
                                                            </tr> 
                                                        <?php } ?> 
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="retModalKit"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s3">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">NOME
                                                        <input type="text" class="input-xs" id="ds_nome_func" name="ds_nome_func" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesqDsNomeFunc" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>           
                                                    <label class="input">MATRÍCULA
                                                        <input type="text" class="input-xs" id="nr_matricula" name="nr_matricula" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesqNrMatricula" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="submit" id="btnInsFunc" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">NOVO</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoFunc"></div>
                                            <div id="retModalFunc"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s4">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">DESCRIÇÃO
                                                        <input type="text" class="input-xs" id="produtosNs" name="produtosNs" style="color: black">
                                                    </label>
                                                    <label class="input">CÓDIGO SAP
                                                        <input type="text" class="input-xs" id="codigoNs" name="codigoNs" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaNs" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retornoEnc"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s5">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">

                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_pend"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">

                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_pend"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s7">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">CÓDIGO SAP
                                                        <input type="text" class="input-xs" id="codigoCalib" name="codigoCalib" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesqCodigoComp" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>           
                                                    <label class="input">NUMERO DE SÉRIE
                                                        <input type="text" class="input-xs" id="nserieClb" name="nserieClb" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesqNserie" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>

                                                    <button type="submit" id="btnNovoClb" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">NOVO</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoClb"></div>
                                            <div id="retModalClb"></div>
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

        $('#liFunc').on('click', function(){
            $("#retornoFunc").html("<br><br><br><img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
            $('#retornoFunc').load('data/empresa/list_funcionario.php');
        });

    });
</script>