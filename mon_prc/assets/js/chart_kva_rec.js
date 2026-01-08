kva = {
    kva_rec : function (value) {
        return value
    }
}

$(document).ready(function () {

    $.post(
        'assets/php/cons_chart_rec_kva.php',
        function (data) {

          var ln_kva = JSON.stringify(data.ln_kva);
          var tb_kva = JSON.stringify(data.tb_kva);

          $('#ln_kva').html(ln_kva);
          $('#tb_kva').html(tb_kva);
          $('table.highchart1').highchartTable();

        },'json'
      );
})