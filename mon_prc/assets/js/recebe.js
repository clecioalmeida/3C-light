$(document).ready(function () {
    $.getJSON('assets/php/list_rec.php', function (data) {

        function format(d) {
            
            return (
              '<table cellpadding="5" cellspacing="0" border="0" class="table m-0 table-condensed" style="width:70%;">' +
              "<tr>" +
              "<td></td>" +
              "</tr>" +
              "</table>"
            );
        }
        var table = $('#tb_rec').DataTable({
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
                { "data": "cod_recebimento" },
                { "data": "dt_recebimento" },
                { "data": "nm_fornecedor" },
                { "data": "nm_placa" },
                { "data": "nm_motorista" },
                { "data": "qtde_rec" },
                { "data": "ds_lp" },
                { "data": "ds_kva" },
                { "data": "nr_serial" },
                { "data": "ds_fabr" },
                { "data": "ds_ano" },
                { "data": "ds_enr" },
                { "data": "ds_obs" },
                { "data": "situacao" },
            ],
            "order": [[2, 'desc']],
            "columnDefs": [
                { className: "dt-right", "targets": [6,7,8,9] },
                { className: "dt-nowrap", "targets": [0,1] }
              ],
            "fnDrawCallback": function (oSettings) {
                runAllCharts();
            }
        });

        $('#tb_rec tbody').on('click', 'td.details-control', function () {
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

});