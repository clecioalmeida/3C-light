<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARGUS - Conferência eletrônica</title>
    <link rel="shortcut icon" href="_assets/img/logoArgus.png">
    <link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.external-png.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.inline-png.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.inline-svg.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.structure.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.theme.min.css">
    <!--link rel="stylesheet" href="_assets/css/jqm-demos.css"-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <script src="js/jquery.js"></script>
    <script src="_assets/js/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.min.js"></script>
    <!--script src="js/jquery.mobile-1.4.5.min.js"></script-->
</head>
<style type="text/css">
.login-page
{
    background-image: url('css/img/background.jpg');
    background-repeat: no-repeat;
    background-size:100%;
    bottom: 0;
    color: black;
    left: 0;
    overflow: auto;
    padding: 3em;
    position: absolute;
    right: 0;
    text-align: center;
    top: 0;
    background-size: cover;
}
</style>
<body>
    <section data-role="page" id="login_page" class="login-page">
        <header data-role="header" data-position="fixed">
            <h3>LOGIN</h3>
        </header>
        <article data-role="content">
            <!--div style="background-color: gray;opacity:0.7">
                <p style="opacity: 1.5">Insira o dados de login e senha informados na Minuta</p>
            </div-->


            <form id="form_login">
                <div data-role="fieldcontain" class="ui-hide-label">
                    <label for="textUser">Usuário: </label>
                    <input type="text" name="textUser" id="textUser" placeholder="Usuário"/>
                </div>
                <div data-role="fieldcontain" class="ui-hide-label">
                    <label for="textPassword">Senha: </label>
                    <input type="password" name="textPassword" id="textPassword" placeholder="Senha"/>
                </div>
                <input type="button" value="Login" id="btnLogin"/>
                <a class="ui-btn" data-rel="back">Cancelar</a>
            </form>
        </article>
        <footer data-role="footer" data-position="fixed">
        </footer>
    </section>

    <section data-role="dialog" id="pageError">
        <header data-role="header" data-position="fixed">
            <h3>Error</h3>
        </header>
        <article data-role="content">
            <h1>Usuário ou senha inválidos!!</h1>
        </article>
        <footer data-role="footer" data-position="fixed">
        </footer>
    </section>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#btnLogin").on("click", function(event){
                event.preventDefault(); // impede o submit normal do form

                var user = $("#textUser").val();
                var pass = $("#textPassword").val();

                console.log("Enviando:", { username: user, password: pass });

                $.ajax({
                    url: "data/log_val.php",
                    method: "POST",
                    data: { username: user, password: pass },
                    dataType: "text", // vamos tratar como texto simples
                    success: function(data, status, xhr){
                        console.log("STATUS:", status);
                        console.log("RAW RESPONSE:", data);

                        // tira espaços e quebras de linha
                        var resp = $.trim(data);

                        if (resp === "0") {
                            alert("Login efetuado com sucesso!");
                            window.location.replace("home.php");
                        } else {
                            alert("Usuário ou senha inválidos!\nRetorno: " + resp);
                        }
                    },
                    error: function(xhr, status, error){
                        console.error("ERRO AJAX:", status, error);
                        console.log("ResponseText:", xhr.responseText);
                        alert("Erro na comunicação com o servidor.");
                    }
                });

                return false;
            });

        });
    </script>


    <!--    <script type="text/javascript">-->
<!--        $(document).ready(function(){-->
<!--            event.preventDefault();-->
<!--            $("#btnLogin").click(function(){-->
<!--                var user = $("#textUser").val();-->
<!--                var pass = $("#textPassword").val();-->
<!--                $.ajax-->
<!--                ({-->
<!--                    url:"data/log_val.php",-->
<!--                    method: "POST",-->
<!--                    data:{username:user, password:pass},-->
<!--                    success:function(data){-->
<!--                        if(data == "0"){-->
<!---->
<!--                            alert("Login efetuado com sucesso!");-->
<!--                            window.location.replace("home.php");-->
<!---->
<!--                        }else{-->
<!--                            console.log(data);-->
<!--                            alert("Usuário ou senha inválidos?!");-->
<!---->
<!--                           -->
<!---->
<!--                        }-->
<!--                    }-->
<!--                });-->
<!--                return false;-->
<!--                });-->
<!--        });-->
<!--    </script>-->
</body>
</html>