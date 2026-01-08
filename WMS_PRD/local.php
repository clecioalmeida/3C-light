<div id="main" role="main">
    <!--div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Cadastros</li><li>Locais de armazenagem</li>
        </ol>
    </div-->
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div>
                        <div class="widget-body">
                            <section id="widget-grid" class="">
                                <div class="row">                                                        
                                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                                            <header>
                                                <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
                                                <h2>Cadastro de Locais de armazenagem </h2>                
                                                <button type="submit" id="btnNewLocal" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>  

                                            </header>
                                            <div>
                                                <div class="widget-body no-padding" id="dados">
                                                    <div id="retorno"></div>                                                        
                                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                                        <thead>
                                                            <tr>
                                                                <th> Ações </th>
                                                                <th> Código</th>
                                                                <th> Galpão </th>
                                                                <th> Local </th>
                                                                <th> Situação </th>
                                                                <th> Curva </th>
                                                                <th> Alocação automática </th>
                                                                <th> Tipo </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            require_once('data/armazem/list_armazem.php');                                                          
                                                            while($dados = mysqli_fetch_array($res)) {?>
                                                                <tr class="odd gradeX">
                                                                    <td style="text-align: center;width: 150px">  
                                                                        <button type="submit" id="btnUpdLocal" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Alterar</button>
                                                                        <button type="submit" id="btnListEnd" class="btn btn-default btn-xs" value="<?php echo $dados['id']; ?>">Endereços</button>
                                                                    </td>
                                                                    <td style="text-align: center; width: 10px"> 
                                                                        <?php echo $dados['id']; ?> 
                                                                    </td>
                                                                    <td> 
                                                                        <?php echo $dados['nome']; ?> 
                                                                    </td>
                                                                    <td> 
                                                                        <?php echo $dados['galpao']; ?> 
                                                                    </td>
                                                                    <td> 
                                                                        <?php
                                                                        if ($dados['fl_situacao'] == 'A'){
                                                                            echo 'Ativo';
                                                                        }else if($dados['fl_situacao'] == 'B'){
                                                                            echo 'Bloqueado';
                                                                        }
                                                                        ?>   
                                                                    </td>
                                                                    <td> 
                                                                        <?php echo $dados['fl_curva']; ?> 
                                                                    </td>
                                                                    <td> 
                                                                        <?php 
                                                                        if ($dados['aloc_aut'] == 'S'){
                                                                            echo 'Sim';
                                                                        }else{
                                                                            echo 'Não';
                                                                        }
                                                                        ?> 
                                                                    </td>
                                                                    <td> 
                                                                        <?php 
                                                                        if ($dados['fl_tipo'] == 'I'){
                                                                            echo 'Interno';
                                                                        }else if($dados['fl_tipo'] == 'P'){
                                                                            echo 'Pátio';
                                                                        }else if($dados['fl_tipo'] == 'V'){
                                                                            echo 'Virtual';
                                                                        }
                                                                        ?>  
                                                                    </td>
                                                                </tr>
                                                            <?php } ?> 
                                                        </tbody>
                                                    </table>                                                        
                                                </div>
                                            </div>
                                        </div> 
                                    </article>  
                                </div>
                            </section>
                        </div>
                    </div>
                </article>
            </div>
            <div class="row">
                <div class="col-sm-12">
                </div>                            
            </div>
        </section>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $(document).on('click', '#btnListEnd',function(){
            $('#btnListEnd').prop("disabled", true);
            var local      = $(this).val();

            $.ajax
            ({
                url:"data/armazem/list_end.php",
                method:"POST",
                data:{
                    local      :local
                },
                success:function(data)
                {
                    $('#wid-id-0').html(data);
                    $('#btnListEnd').prop("disabled", false);
                }
            });
        });
    });
</script>