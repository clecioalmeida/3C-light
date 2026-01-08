$(document).ready(function () {

    $.getJSON('assets/php/list_jan.php', function (data) {

        function format(d) {

            var sts = d.fl_status == "AG" ? "disabled" : "";
            var fln = d.fl_nivel != "3" ? "disabled" : "";
            var flc = d.fl_nivel != "3" || d.fl_status != "AT" ? "disabled" : "";

            return '<table cellpadding="5" cellspacing="0" border="0" class="table m-0 table-condensed" style="width:70%;">' +
                '<tr>' +
                '<td>Placa:</td>' +
                '<td>' + d.placa + '</td>' +
                '<td>Data e hora de chegada:</td>' +
                '<td style="width:200px">' + d.dt_chegada + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Transportador:</td>' +
                '<td>' + d.transportador + '</td>' +
                '<td>Data e hora de entrada:</td>' +
                '<td>' + d.dt_entrada + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Motorista:</td>' +
                '<td>' + d.ini_car + '</td>' +
                '<td>Início de descarregamento:</td>' +
                '<td>' + d.ini_car + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Observações:</td>' +
                '<td>' + d.ds_obs + '</td>' +
                '<td>Fim de descarregamento:</td>' +
                '<td>' + d.fim_car + '</td>' +
                '</tr>' +
                '<td>Anexos:</td>' +
                '<td colspan="4"></td>' +
                '</tr>' +
                '<tr>' +
                '<td>Ações:</td>' +
                '<td colspan="4" style="width:800px">' +
                "<button class='btn btn-xs sa-btn-success' id='conf_ag' value=" + d.cod_rec + " style='width:100px' " + sts + " " + fln + ">Confirmar</button>" +
                "<button class='btn btn-xs sa-btn-primary' id='edit_ag' value=" + d.cod_rec + " style='margin-left:5px;width:100px' " + fln + ">Editar</button>" +
                "<button class='btn btn-xs sa-btn-success' id='fim_ag' value=" + d.cod_rec + " style='margin-left:5px;width:100px' " + flc + ">Finalizar</button>" +
                "<button class='btn btn-xs sa-btn-primary' id='btn_xml' value=" + d.cod_rec + " style='margin-left:5px;width:100px' " + fln + ">Enviar XML</button>" +
                "<button class='btn btn-xs sa-btn-primary' id='btn_danfe' value=" + d.cod_rec + " style='margin-left:5px;width:100px' " + fln + ">Enviar DANFE</button>" +
                "<button class='btn btn-xs sa-btn-danger' id='btn_rec' value=" + d.cod_rec + " style='margin-left:5px;width:100px' " + fln + ">Recusar</button>" +
                '</td>' +
                '</tr>' +
                '</table>';
        }
        var table = $('#tb_jan').DataTable({
            "sDom": "<'dt-toolbar d-flex'<f><'ml-auto hidden-xs show-control'l>r>" +
                "t" +
                "<'dt-toolbar-footer d-flex'<'hidden-xs'i><'ml-auto'p>>",
            "draw": 1,
            "data": data,
            "bDestroy": true,
            "iDisplayLength": 15,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="fa fa-search"></i></span>'
            },
            "classes": {
                "sWrapper": "dataTables_wrapper dt-bootstrap4"
            },
            "columns": [
                {
                    "class": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                { "data": "cod_rec" },
                { "data": "name" },
                { "data": "cap_veic" },
                { "data": "status" },
                { "data": "dt_create" },
                { "data": "dt_rec" },
                { "data": "peso" },
                { "data": "volume" },
                { "data": "tp_veiculo" },
                { "data": "placa" },
                { "data": "transportador" },
                { "data": "motorista" },
            ],
            "order": [[1, 'asc']],
            "fnDrawCallback": function (oSettings) {
                runAllCharts();
            }
        });

        $('#tb_jan tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

    });

    $('#load_list_ag').on('click', function () {

        event.preventDefault();

        var page = "recebimentos.html";

        window.location.replace(page);

    });

});