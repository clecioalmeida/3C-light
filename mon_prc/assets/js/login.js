
$(document).ready(function () {

    $('#btnConsOper').on('click', function () {
        event.preventDefault();
        $('#retErro').hide();
        if ($("input[name='usuario']").val() == "" || $("input[name='senha']").val() == "") {
            alert('Por favor preencha todas as informações!');
        } else {
            var user = $("input[name='email']").val();
            var pass = $("input[name='password']").val();

            $.getJSON('assets/php/consulta_oper.php',
                {
                    user: user,
                    pass: pass,
                    ajax: 'true'
                },
                function (m) {
                    var options = '<option value="">Serviços disponíveis</option>';
                    for (var i = 0; i < m.length; i++) {
                        if (m[i].info == "0") {

                            options += '<option value="' + m[i].id_oper + '">' + m[i].ds_operacao + '</option>';
                            $('#SelServDisp').html(options).append();

                        } else if (m[i].info == "3") {

                            var erro = "Senha incorreta!";

                            $('#retErro').text(erro).show();

                        } else if (m[i].info == "2") {

                            var erro = "Usuário inválido!";

                            $('#retErro').text(erro).show();

                        }

                    }
                });
        }
        return false;
    });

    $('#btnLogApp').on('click', function () {
        event.preventDefault();
        if ($("input[name='usuario']").val() == "" || $("input[name='senha']").val() == "") {
            alert('Por favor preencha todas as informações!');
        } else {
            var user = $("input[name='email']").val();
            var pass = $("input[name='password']").val();
            var id_oper = $("#SelServDisp").val();

            $.ajax
                ({
                    url: 'assets/adm/log_auth.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        user: user,
                        pass: pass,
                        id_oper: id_oper
                    },
                    success: function (j) {
                        if (j.codigo == "1") {

                            alert(j.mensagem);

                            if (j.operacao == 1) {

                                window.location.replace("oper/ELEKTRO/home.php");

                            } else if (j.operacao == 2) {

                                window.location.replace("oper/CTEEP/home.php");

                            } else if (j.operacao == 3) {

                                window.location.replace("oper/EDP_SJC/home.php");

                            } else if (j.operacao == 4) {

                                window.location.replace("oper/EDP_ES/home.php");

                            } else if (j.operacao == 5) {

                                var page = "recebimentos.html";

                                window.location.replace(page);

                            } else if (j.operacao == 6) {

                                var page = "home.html";

                                window.location.replace(page);

                            }  else {

                                alert("Não há bases liberadas para este usuário.");

                            }

                        } else {

                            alert(j.mensagem);

                        }
                    }
                });
        }
        return false;
    });
});