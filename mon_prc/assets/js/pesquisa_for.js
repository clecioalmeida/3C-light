$(document).ready(function () {

    var nm_for = $('#nm_for').val();

    $.getJSON('assets/php/pesquisa_for.php', { nm_for: nm_for, ajax: 'true' }, function (data) {

        var tb_fr = "";

        for (var i = 0; i < data.length; i++) {

            if (data[i].info == "0") {

                tb_fr += "<tr>";
                tb_fr += "<td><button class='btn btn-default sel_for' type='submit' id='sel_for' value='"+data[i].id_for+"' data-for='"+data[i].ds_nome+"'>Selecionar</button></td>";
                tb_fr += "<td>";
                tb_fr += data[i].ds_nome;
                tb_fr += "</td>";
                tb_fr += "</tr>";

            } else if (data[i].info == "1") {

                tb_fr += "<tr>";
                tb_fr += "<td colspan='2'><span class=d-flex align-items-center>Fornecedor não encontrado.";
                tb_fr += "</span></td>";
                tb_fr += "</tr>";

            }

        }

        $('#ListFor').append(tb_fr);

    });
});