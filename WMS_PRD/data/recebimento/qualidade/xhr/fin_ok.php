<!DOCTYPE html>
<html lang="pt-br">
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
    <div class="container theme-showcase" role="main">
        <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #9AFF9A">
                        <h4 class="modal-title" id="myModalLabel">Registro alterado com sucesso!</h4>
                    </div>
                    <div class="modal-body">                                
                        
                    </div>
                    <div class="modal-footer">
                        <a href="http://localhost/wms_dsv/wms/html/ocorrencias.php"><button type="button" class="btn btn-primary">Ok</button></a>
                    </div>
                </div>
            </div>
        </div>          
        <script>
            $(document).ready(function () {
                $('#conf_cadastro').modal('show');
            });
        </script>
    </div>
</body>
</html>