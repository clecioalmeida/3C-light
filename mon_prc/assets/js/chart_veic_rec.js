veic = {
    veic_rec : function (value) {
        return value
    }
}

$(document).ready(function () {

    $.post(
        'assets/php/cons_chart_rec_veic.php',
        function (data) {
          $('#tb_veic').html(data);
          $('table.highchart3').highchartTable();
        }
      );
})