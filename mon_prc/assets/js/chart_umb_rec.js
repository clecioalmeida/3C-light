umb = {
    umb_rec : function (value) {
        return value
    }
}

$(document).ready(function () {

    $.post(
        'assets/php/cons_chart_rec_umb.php',
        function (data) {

            var ln_umb = JSON.stringify(data.ln_umb);
            var tb_umb = JSON.stringify(data.tb_umb);

            $('#ln_umb').html(ln_umb);
            $('#tb_umb').html(tb_umb);

            $('table.highchart').highchartTable();
        },'json'
    );
})