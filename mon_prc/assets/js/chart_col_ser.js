col = {
    col_rec : function (value) {
        return value
    }
}

$(document).ready(function () {

    $.post(
        'assets/php/cons_chart_col_serial.php',
        function (data) {
          $('#tb_ser').html(data);
          $('table.highchart4').highchartTable();
        }
      );
})