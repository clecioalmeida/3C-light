<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Cadastros</li><li>Docas de armazenagem</li>
        </ol>
    </div>
    <div id="content">

        <div class="row">
                    
            <!-- col -->
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                            
                    <i class="fa-fw fa fa-home"></i> 
                        Cadastros 
                    <span>|  
                        Docas de armazenagem
                    </span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            </div>
                    
        </div>
        <section id="widget-grid" class="">
                
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">   
                        </header>
                
                        <div>
                                    
                            <div class="jarviswidget-editbox">
                                <input class="form-control" type="text">    
                            </div>
                            <div class="widget-body">
                                <section id="widget-grid" class="">
                                                
                                    <div class="row">
                                                        
                                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        
                                            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                                                <header>
                                                    <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
                                                    <h2>Cadastro de Docas de armazenagem </h2>                
                                                    <button type="submit" id="btnNewDoca" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>       
                                                        
                                                </header>
                                                        
                                                <div>
                                                        
                                                    <div class="jarviswidget-editbox">
                                                        
                                                    </div>
                                                    <div class="widget-body no-padding" id="dados">

                                                        <div id="retorno"></div>
                                                        
                                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                                            <thead>
                                                                <tr>
                                                                    <th> Ações </th>
                                                                    <th> Código</th>
                                                                    <th> Armazém</th>
                                                                    <th> Doca </th>
                                                                    <th> Tipo </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                require_once('data/armazem/list_doca.php');

                                                                    if($tr > 0){  

                                                                        while($dados = mysqli_fetch_array($res)) {?>

                                                                        <tr class="odd gradeX">
                                                                            <td style="text-align: center; width: 5px">  
                                                                                <button type="submit" id="btnUpdDoca" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Alterar</button>
                                                                            </td>
                                                                            <td style="text-align: center; width: 10px"> <?php echo $dados['id']; ?> </td>
                                                                            <td> <?php echo $dados['ds_local']; ?> </td>
                                                                            <td> <?php echo $dados['ds_doca']; ?> </td>
                                                                            <td> <?php echo $dados['fl_tipo']; ?> </td>
                                                                        </tr>

                                                                        <?php }

                                                                    }else{
                                                                        
                                                                        echo "<h3>No hay datos para esta búsqueda!</h3>";

                                                                    } 
                                                                ?>
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