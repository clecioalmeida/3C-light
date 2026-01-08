$(document).ready(function () {

    let cod_prd = sessionStorage.getItem('cod_prd');

    sessionStorage.removeItem('cod_prd');

    $.getJSON('assets/php/list_est.php', { cod_prd: cod_prd }, function (data) {

        function format(d) {

            return (
                '<table cellpadding="5" cellspacing="0" border="0" class="table m-0 table-condensed">' +
                "<tr>" +
                "<td></td>" +
                "</tr>" +
                "</table>"
            );
        }
        var table = $('#tb_est').DataTable({
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
                { "data": "cod_estoque" },
                { "data": "ds_prateleira" },
                { "data": "ds_coluna" },
                { "data": "ds_altura" },
                { "data": "produto" },
                { "data": "nr_serial" },
                { "data": "nm_produto" },
                { "data": "qtde_est" },
                { "data": "ds_kva" },
                { "data": "ds_ano" },
                { "data": "ds_lp" },
                { "data": "ds_fabr" },
                { "data": "ds_enr" },
                { "data": "dt_recebimento" },
            ],
            "order": [[0, 'desc']],
            /*"columnDefs": [
                { className: "dt-right", "targets": [6, 7, 8, 9] },
                { className: "dt-nowrap", "targets": [0, 1] }
            ],*/
            "fnDrawCallback": function (oSettings) {
                runAllCharts();
            }
        });

        $('#tb_est tbody').on('click', 'td.details-control', function () {
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