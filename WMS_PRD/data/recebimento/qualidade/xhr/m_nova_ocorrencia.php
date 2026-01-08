<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <script src="https://code.jquery.com/jquery-2.2.4.js"
                  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
                  crossorigin="anonymous"></script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"> 
        <link rel="stylesheet" type="text/css" media="screen" href="css/components.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css"> 
        <link href="css/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="css/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="css/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        
        <link href="css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../../../../../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../../../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../../../../../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
</head>
<body>
<div class="modal fade" id="inserir_ocorrencia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #87CEEB">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
        <h4 class="modal-title">Inserir ocorrência</h4>
      </div>
      <div class="modal-body modal-md" style="overflow-y: auto">
            <div class="form-body">
              <div class="widget-body no-padding">
                <form id="formIns" class="smart-form" method="POST" action="" novalidate="novalidate">
                   <fieldset>
                      <div class="row">
                        <section class="col col-5">
                          <label class="select"> <!--i class="icon-prepend fa fa-circle"></i-->
                          <select name="criticidade">
                          	<option value="0" select disabled="true">Selecione a criticidade</option>
                          	<option value="A">Alta</option>
                            <option value="M">Média</option>
                            <option value="B">Baixa</option>
                          </select>
                          </label>
                        </section>
                        <section class="col col-5">
                          <label class="select"> <!--i class="icon-prepend fa fa-circle"></i-->
                           <select name="tipo">
                          	<option value="0" select disabled="true">Selecione a origem</option>
                          	<option value="A">Armazém</option>
                            <option value="T">Transporte</option>
                            <option value="O">Outros</option>
                          </select>
                          </label>
                        </section>
                      </div>
                      <div class="row">
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-list"></i>
                              <input type="text" name="cod_origem" placeholder="Código de origem">
                            </label>
                          </section>
                        </div>
                     <div class="row">
                          <section class="col col-10">
                            <label class="input"> <i class="icon-prepend fa fa-list"></i>
                              <input type="text" name="nm_ocorrencia" placeholder="Descrição">
                            </label>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                              <input type="text" name="ds_responsavel" placeholder="Responsável">
                            </label>
                          </section>
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-list"></i>
                              <input type="text" name="nm_depto" placeholder="Departamento" >
                            </label>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-5">
                            <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                              <input type="date" name="dt_final" placeholder="Data final para solução">
                            </label>
                          </section>
                          <section class="col col-5">
                            
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-10">
                            <label class="input">
                              <textarea class="form-control" name="ds_obs" placeholder="Observações" rows="5"> </textarea>
                            </label>
                          </section>
                        </div>
                      </fieldset>
                      <button type="submit" id="btnIns" class="btn btn-default btn-block">
                        Salvar
                      </button>
                    </form>
                  </div>
                </div>
              </div>
      <div class="modal-footer modal-lg" style="background-color: #4169E1">
        <a href="http://localhost/wms_dsv/wms/html/ocorrencias.php"><button type="button" class="btn btn-secondary">Fechar</button></a>
      </div>
    </div>
  </div>
</div>
</div><!--Fim modal-->
<?php include 'scripts.php'; ?>
<script>
    $(document).ready(function () {
        $('#inserir_ocorrencia').modal('show');
    });
</script>
<script type="text/javascript">
    $('#btnIns').click(function(){
        $('#formIns').ajaxForm({
            target:'#inserir_ocorrencia',
            url:'ins_ocorrencia.php',
        });
    });
</script>
</div>
</body>
</html>