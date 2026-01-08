$(document).ready(function(){

    $(document).on('change', '#nr_lp_inv', function () {
        var ds_lp = $(this).val();

        $.getJSON('xhr/consulta_lp_inv.php?search=', {
            ds_lp: ds_lp,
            ajax: 'true'
        },
            function (j) {

                if(j.info == "0"){

                    produto             = j.produto;
                    kva                 = j.kva;
                    serial              = j.serial;
                    faricante           = j.fabr;
                    ano                 = j.ano;
                    cod_estoque         = j.cod_estoque;

                }else{

                    alert("Produto não encontrado no endereço.");

                    produto             = "";
                    kva                 = "";
                    serial              = "";
                    faricante           = "";
                    cod_estoque         = "";

                }

                $("#barcodeInvTransf").val(produto);
                $("#nr_kva_inv").val(kva);
                $("#nr_serial_inv").val(serial);
                $("#nr_fabr_inv").val(faricante);
                $("#nr_ano_inv").val(ano);
                $("#cod_estoque").val(cod_estoque);
                $('#nr_qtde_inv').val("1");
                $('#nr_vol_inv').val("1");
            }
        );
    });

    $(document).on('change', '#ds_galpao_inv', function () {

        $.getJSON('xhr/consulta_endereco_inv.php?search=', { id_glp: $(this).val(), ajax: 'true' }, function (j) {

            $("#localInv").val(j.end);

        });

    });

});