$(document).ready(function () {
  $.getJSON("assets/php/list_ag_adm_jan.php", function (data) {
    var table = $("#tb_rec_adm_jan").DataTable({
      draw: 1,
      data: data,
      bDestroy: true,
      iDisplayLength: 15,
      oLanguage: {
        sSearch:
          '<span class="input-group-addon"><i class="fa fa-search"></i></span>',
      },
      classes: {
        sWrapper: "dataTables_wrapper dt-bootstrap4",
      },
      columns: [
        { data: "dt_janela_conf" },
        { data: "ds_janela" },
        { data: "fl_status" },
        { data: "cod_recebimento" },
        { data: "nm_fornecedor" },
        { data: "nr_peso_previsto" },
        { data: "nr_volume_previsto" },
        { data: "acoes" },
      ],
      order: [[1, "asc"]],
    });

  });

});
