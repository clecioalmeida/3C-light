$(document).ready(function () {
    $(document).on('click', '#btnSaveExp', function (event) {
        event.preventDefault();
        var barcode = $('#barcodeExpSp').val();
        var serial_exp = $('#serial_exp').val();
        var nr_qtde = $('#nr_qtde').val();
        var pedido = $(this).val();
        if ($('#barcodeExpSp').val() == '' || $('#localExp').val() == '') {
            alert("Favor bipar o endereço e inserir o código do produto!");
        } else {
            $.ajax
                ({
                    url: "xhr/conf_exp.php",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        barcode: barcode,
                        pedido: pedido,
                        serial_exp: serial_exp,
                        nr_qtde: nr_qtde
                    },
                    success: function (j) {
                        $('#form_conf')[0].reset();
                        $('#barcodeExpSp').focus();
                        var total_conf = "Conferido:" + j.info;
                        $('#TotalConferido').text(total_conf);
                    }
                });
            return false;
        }
    });

    $(document).on('click', '#btnFinConfExp', function (event) {
        if (confirm("Confirma a finalização do pedido?")) {

            $('#retExpEnd1').hide();
            $('#retExpEnd2').hide();

            event.preventDefault();
            var pedido = $(this).val();
            $.ajax({
                url: "xhr/fin_conf_exp.php",
                method: "POST",
                dataType: 'json',
                data: { pedido: pedido },
                success: function (j) {
                    for (var i = 0; i < j.length; i++) {
                        var info = j[i].info;
                        if (info == 1) {

                            $('#retExpEnd1').show();
                            $('#retExpEnd1').html("Conferência finalizada com sucesso!");

                        } else {

                            $('#retExpEnd2').show();
                            $('#retExpEnd2').html(info);

                        }
                    }
                }
            });
            return false;
        }
    });
});