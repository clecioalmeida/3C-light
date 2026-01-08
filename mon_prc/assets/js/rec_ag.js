$(document).ready(function () {

    let cod_rec = sessionStorage.getItem('cod_rec');

    sessionStorage.removeItem('cod_rec');

    $('#ModalrecAg').text("Agendamento:" + cod_rec);
    $('#cod_rec').val(cod_rec);

    $('#btnSaveRecAg').on('click', function () {
        event.preventDefault();
        var upd_rec = $('#cod_rec').val();
        if (confirm("Confirma a recusa do agendamento?")) {

            $.post("assets/php/rec_ag.php", $("#formRecAg").serialize(), function (data) {

                if (data.info == "0") {

                    $.post("assets/php/mail_rec.php", { upd_rec: upd_rec }, function (j) {
                        
                        alert(j);

                    });

                } else if (data.info == "1") {

                    alert("NÃO FOI POSSÍVEL ALTERAR A JANELA DE RECEBIMENTO.");

                }

            }, 'json');
        }
        return false;
    });

});