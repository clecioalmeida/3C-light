$(document).ready(function () {

    $.getJSON('assets/php/cons_dt.php', function (data) {

        var dt_ag = '<option value="">Selecione a data</option>';
        for (var i = 0; i < data.length; i++) {

            if (data[i].info == "0") {

                dt_ag += '<option value="' + data[i].dt_janela + '">' + data[i].janela + '</option>';

            } else if (data[i].info == "1") {

                dt_ag += '<option>Não há dados para mostrar</option>';

            }
        }

        $('#dt_agenda').html(dt_ag).append();

    });
});