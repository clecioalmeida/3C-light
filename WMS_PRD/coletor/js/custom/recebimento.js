$(document).ready(function () {

    $(document).on('click', '#btnSaverec', function () {

        if ($('#nr_placa').val() == "" || $('#ds_endereco').val() == "" || $('#cod_produto').val() == "") {

            alert("Por favor preencha a placa do veículo, local de armazenagem e código do produto.");

        } else {

            $.ajax({
                url: "ins_recebimento.php",
                method: "POST",
                dataType: 'json',
                data: {
                    nm_fornecedor: $('#nm_fornecedor').val(),
                    nm_mot: $('#nm_mot').val(),
                    nr_placa: $('#nr_placa').val(),
                    dt_recebimento: $('#dt_recebimento').val(),
                    ds_galpao: $('#ds_galpao').val(),
                    ds_endereco: $('#ds_endereco').val(),
                    cod_produto: $('#cod_produto').val(),
                    nr_serial: $('#nr_serial').val(),
                    ds_kva: $('#ds_kva').val(),
                    ds_lp: $('#ds_lp').val(),
                    ds_ano: $('#ds_ano').val(),
                    ds_enr: $('#ds_enr').val(),
                    ds_oleo: $('#ds_oleo').val(),
                    ds_fabr: $('#ds_fabr').val(),
                    nr_qtde: $('#nr_qtde').val(),
                    ds_obs: $('#ds_obs').val(),
                    ds_material: $('#ds_material').val()
                },
                success: function (j) {

                    if (j.info == "0") {

                        alert("Recebimento cadastrado.");

                        $('#InsPrd').show();
                        $('#btnFinOR').val($('#nr_placa').val());

                    } else {

                        alert(j.info);

                    }
                }
            });

        }
    });

    $(document).on('click', '#btnSaverecDtl', function () {

        if ($('#nr_placa').val() == "" || $('#ds_endereco').val() == "" || $('#cod_produto').val() == "") {

            alert("Por favor preencha a placa do veículo, local de armazenagem e código do produto.");

        } else {

            $.ajax({
                url: "upd_recebimento.php",
                method: "POST",
                dataType: 'json',
                data: {
                    nm_fornecedor: $('#nm_fornecedor').val(),
                    nm_mot: $('#nm_mot').val(),
                    nr_placa: $('#nr_placa').val(),
                    dt_recebimento: $('#dt_recebimento').val(),
                    ds_galpao: $('#ds_galpao').val(),
                    ds_endereco: $('#ds_endereco').val(),
                    cod_produto: $('#cod_produto').val(),
                    nr_serial: $('#nr_serial').val(),
                    ds_kva: $('#ds_kva').val(),
                    ds_lp: $('#ds_lp').val(),
                    ds_ano: $('#ds_ano').val(),
                    ds_enr: $('#ds_enr').val(),
                    ds_fabr: $('#ds_fabr').val(),
                    nr_qtde: $('#nr_qtde').val(),
                    ds_obs: $('#ds_obs').val(),
                    cod_rec: $(this).val()
                },
                success: function (j) {

                    if (j.info == "0") {

                        alert("Recebimento alterado.");

                    } else {

                        alert("Erro na alteação do recebimento.");

                    }
                }
            });

        }
    });

    $(document).on('click', '#inserePRD', function () {
        console.log($(this).val());
        //window.location.replace("recebimento_prd.php?search=",{ins_rec:$(this).val()});
        $('#load_rec').load("recebimento_prd.php?search=", { ins_rec: $(this).val() });

    });

    $(document).on('change', '#cod_produto', function () {
        $.getJSON('xhr/consulta_produto_rec.php?search=', { cod_prd: $(this).val(), ajax: 'true' }, function (j) {

            options = j.info;

            $('#retNmPrd').html(options);
        });
    });

    $(document).on('click', '#btnFinOR', function () {
        if (confirm("Confirma a finalização do recebimento?")) {

            if ($('#nr_placa').val() == "") {

                alert("Informe a placa do veículo que deseja encerrar o recebimento.");

            } else {

                $.ajax({
                    url: "xhr/fin_rec_simples.php",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        nm_placa: $('#nr_placa').val()
                    },
                    success: function (j) {

                        $('#retRec').html(j.info);

                    }
                });

            }
        }
    });

    $(document).on('click', '#btnFinRec', function () {
        if (confirm("Confirma a finalização do recebimento?")) {

            if ($(this).attr("data-fn") == "") {

                alert("Placa do veículo não encontrada.");

            } else {

                $.ajax({
                    url: "xhr/fin_rec_simples.php",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        nm_placa: $(this).attr("data-fn")
                    },
                    success: function (j) {

                        $('#retFinRec').html(j.info);

                    }
                });

            }
        }
    });

    $(document).on('change', '#ds_galpao', function () {

        $.getJSON('xhr/consulta_endereco_patio.php?search=', { id_glp: $(this).val(), ajax: 'true' }, function (j) {

            $('#ds_endereco').val(j.end);

        });

    });

    $(document).on('click', '#btnDelRec', function () {
        if (confirm("Confirma a exclusão do recebimento?")) {

            $.ajax({
                url: "del_recebimento.php",
                method: "POST",
                dataType: 'json',
                data: {
                    cod_rec: $(this).attr("data-fn")
                },
                success: function (j) {
                    if(j.info == "0"){
                        
                        alert("Recebimento excluído.");

                    }else{
                        
                        alert("Erro na exclusão.");

                    }

                }
            });
        }
    });

});