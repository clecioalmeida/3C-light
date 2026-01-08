$(document).ready(function () {
    $(document).on('click', '#conf_ag', function () {
        event.preventDefault();
        var id_rec = $(this).val();
        if (confirm("Confirma o agendamento?")) {

            $.post("assets/php/conf_ag.php", { id_rec: id_rec }, function (data) {

                if (data.info == "0") {

                    $.post("assets/php/mail_conf.php", { id_rec: id_rec }, function (j) {
                        
                        alert(j);

                    });

                } else if (data.info == "1") {

                    alert("NÃO FOI POSSÍVEL CRIAR O AGENDAMENTO.");

                }

            }, 'json');
        }
        return false;
    });

    $(document).on('click', '#btnSaveUpdAg', function () {
        event.preventDefault();
        $('#edit_ag').prop("disabled", true);
        var id_rec = $(this).val();
        $.ajax
            ({
                url: "assets/php/edit_ag.php",
                method: "POST",
                dataType: 'json',
                data: { id_rec: id_rec },
                success: function (j) {

                    if (j.info == 0) {

                        alert("Agendamento alterado!");
                        $.getScript("assets/js/recebe.js");
                        /*$.ajax
                        ({
                                url: "feed_mail_conf.php",
                                method: "POST",
                                data: {
                                    id_rec: id_rec,
                                    nrec: nrec
                                },
                                success: function (data) {
                                    console.log(data);
                                }
                        });*/

                    } else if (j.info == 1) {

                        alert("Erro no cadastro!");

                    } else if (j.info == 2) {

                        alert("Não há produtos cadastrados!");

                    }
                }
            });
        $('#conf_ag').prop("disabled", false);
        return false;
    });
});