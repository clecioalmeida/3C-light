<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title> ARGUS </title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/demo.min.css">
    <link rel="shortcut icon" href="img/logo8_1.png" type="image/x-icon">
    <link rel="icon" href="img/logo8_1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">
    <style type="text/css">
        .intro {
            display: table;
            width: 100%;
            height: 100vh;
            padding: 100px 0;
            color: white;
            background: url('img/background_wms2.png') no-repeat bottom center;
            background-position: 30% 45%;
            background-size: cover;
            overflow: hidden;
        }
    </style>
</head>

<body class="desktop-detected pace-done mobile-view-activated smart-style-1 fixed-header fixed-navigation intro">
    <header id="header">
    </header>
    <div id="main" role="main">
        <div id="content" class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm pull-left">
                    <h1 class="txt-color-blue login-header-big"><strong>ARGUS</strong></h1>
                    <h1 class="txt-color-blue login-header-big">Gestão de estoques e gestão de transportes</h1>
                    <div class="hero">
                        <div class="pull-left login-desc-box-l">
                            <!--h3 class="paragraph-header">Uma solução moderna e integrada que agiliza as operações, reduz
                            custos operacionais e melhora o tempo de entrega!</h3-->
                            <div class="login-app-icons">
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 padding-left-0">
                            <div>
                                <img src="img/logo2.png" class="pull-left display-image" alt="" style="width:180px; margin-top: 10px">
                            </div>
                            <div>
                                <img src="img/logo12.PNG" class="pull-left display-image" alt="" style="width:180px; margin-top: 17px;border-radius:10px 10px 10px 10px">
                            </div>
                            <div class="row" style="margin-top:3rem">
                                <iframe style="width:700px;height:300px;margin-top:10px;border-radius:10px 10px 10px 10px" src="https://www.youtube.com/embed/4wqBRNMWSGw" title="2 Anos - 3C Services - Campo Grande MS" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                    <div class="well no-padding">
                        <form action="" method="post" id="login-form" class="smart-form client-form">
                            <header>
                                Login
                            </header>
                            <fieldset>
                                <section>
                                    <label class="label">Usuário</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="text" name="usuario">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor insira um usuário válido</b></label>
                                </section>

                                <section>
                                    <label class="label">Senha</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="senha" id="logPass">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Digite sua senha</b> </label>
                                    <div class="note">
                                        <a href="">Esqueceu sua senha?</a>
                                    </div>
                                </section>
                                <section>
                                    <label class="label">Selecione a aplicação</label>
                                    <div class="inline-group">
                                        <label class="radio">
                                            <input class="login" type="radio" name="appArgus" id="wms_prd" value="wms_prd">
                                            <i></i>WMS PRD
                                        </label>
                                        <label class="radio">
                                            <input class="login" type="radio" name="appArgus" id="wms_hmg" value="wms_hmg">
                                            <i></i>WMS HMG
                                        </label>
                                    </div>
                                </section>
                                <section id="retEmpresa">
                                    <label class="label">Selecione a operação</label>
                                    <select class="form-control" id="selEmpresaLogin" required="true">
                                        <option></option>
                                    </select>
                                </section>
                                <section id="retErro1" style="display: none">
                                    <h3>Não há operações liberadas para este usuário.</h3>
                                </section>
                                <section id="retErro2" style="display: none">
                                    <h3>Usuário não cadastrado.</h3>
                                </section>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary" id="btnLogApp">
                                    Login
                                </button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "WMS_PRD/script_global.php"; ?>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {

        $('.login').on('click', function() {
            $.getJSON('consulta_empresa.php', {
                    user: $("input[name='usuario']").val(),
                    pass: $("input[name='senha']").val(),
                    app: $("input[name='appArgus']:checked").val(),
                    ajax: 'true'
                },
                function(m) {
                    var options = '<option value="">Selecione a operação</option>';
                    for (var i = 0; i < m.length; i++) {
                        if (m[i].info == "0") {

                            options += '<option value="' + m[i].cod_empresa + '">' + m[i].ds_oper + '</option>';
                            $('#retEmpresa').show();
                            $('#retErro1').hide();
                            $('#retErro2').hide();
                            $('#selEmpresaLogin').html(options).append();

                        } else if (m[i].info == "1") {

                            $('#retErro1').show();

                        } else if (m[i].info == "2") {

                            $('#retErro2').show();

                        }

                    }
                });
        });

        $('#btnLogApp').on('click', function() {
            event.preventDefault();
            if ($("input[name='usuario']").val() == "" || $("input[name='senha']").val() == "" || $("input[name='appArgus']").val() == "" || $("#selEmpresaLogin").val() == "") {
                alert('Por favor preencha todas as informações!');
            } else {
                var user = $("input[name='usuario']").val();
                var pass = $("input[name='senha']").val();
                var app = $("input[name='appArgus']:checked").val();
                var emp = $("#selEmpresaLogin").val();

                $.ajax({
                    url: 'valida_usuario.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        user: user,
                        pass: pass,
                        app: app,
                        emp: emp
                    },
                    success: function(j) {

                        for (var i = 0; i < j.length; i++) {

                            if (j[i].info == "0") {

                                window.location.replace("WMS_DSV/home.php");

                            } else if (j[i].info == "2") {

                                window.location.replace("WMS_PRD/home.php");

                            } else {

                                $('#retErro1').show();

                            }
                        }
                    }
                });
            }
            return false;
        });
    });
</script>