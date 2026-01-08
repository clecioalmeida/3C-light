$(document).ready(function () {

    $.getJSON('assets/php/cons_dt.php', function (data) {

        var dt_ag = '<option value="">Selecione a data</option>';
        for (var i = 0; i < data.length; i++) {

            if (data[i].info == "0") {

                dt_ag += '<option value="' + data[i].dt_janela + '">' + data[i].janela + '</option>';

            } else if (data[i].info == "1") {

                dt_ag += '<option>Não há dados para mostrar</option>';

            }
        }

        $('#dt_agenda').html(dt_ag).append();

    });

    $.getJSON('assets/php/cons_veic.php', function (data) {

        var vc_ag = '<option value="">Selecione o veículo</option>';
        for (var i = 0; i < data.length; i++) {

            if (data[i].info == "0") {

                vc_ag += '<option value="' + data[i].codigo + '">' + data[i].descricao + '</option>';

            } else if (data[i].info == "1") {

                vc_ag += '<option>Não há dados para mostrar</option>';

            }
        }

        $('#tp_veic').html(vc_ag).append();

    });

    $('#tp_veic').on('change', function () {

        var dt_ag = $('#dt_agenda').find(':selected').val();
        var tp_vc = $(this).find(':selected').val();

        if (dt_ag == "") {

            alert("Por favor selecione a data antes de selecionar o veículo.");

            $.getJSON('assets/php/cons_veic.php', function (data) {

                var vc_ag = '<option value="">Selecione o veículo</option>';
                for (var i = 0; i < data.length; i++) {

                    if (data[i].info == "0") {

                        vc_ag += '<option value="' + data[i].codigo + '">' + data[i].descricao + '</option>';

                    } else if (data[i].info == "1") {

                        vc_ag += '<option>Não há dados para mostrar</option>';

                    }
                }

                $('#tp_veic').html(vc_ag).append();

            });

        } else if (tp_vc == '8' || tp_vc == '9' || tp_vc == '10' || tp_vc == '12' || tp_vc == '13' || tp_vc == '14') {

            $.getJSON('assets/php/cons_disp.php?search=', {
                dt_ag: dt_ag,
                tp_veic: tp_vc,
                ajax: 'true'
            }, function (h) {

                if (h.info == "0") {

                    alert("Não há mais janelas disponíveis para esse tipo de veículo.");

                    $.getJSON('assets/php/cons_veic.php', function (data) {

                        var vc_ag = '<option value="">Selecione o veículo</option>';
                        for (var i = 0; i < data.length; i++) {

                            if (data[i].info == "0") {

                                vc_ag += '<option value="' + data[i].codigo + '">' + data[i].descricao + '</option>';

                            } else if (data[i].info == "1") {

                                vc_ag += '<option>Não há dados para mostrar</option>';

                            }
                        }

                        $('#tp_veic').html(vc_ag).append();

                    });
                }

            });

        }

    });

    $('#dt_agenda').on('change', function () {

        $.getJSON('assets/php/cons_hr.php?search=', { dt_ag: $(this).find(':selected').val(), ajax: 'true' }, function (j) {

            var hr_ag = '<option value="">Selecione a hora</option>';
            for (var i = 0; i < j.length; i++) {

                if (j[i].info == "0") {

                    hr_ag += '<option value="' + j[i].id_janela + '">' + j[i].ds_janela + '</option>';

                } else if (j[i].info == "1") {

                    hr_ag += '<option>Não há dados para mostrar</option>';

                }
            }

            $('#hr_agenda').html(hr_ag);

        });

    });

    let cod_rec = sessionStorage.getItem('cod_rec');

    sessionStorage.removeItem('cod_rec');

    $.getJSON('assets/php/cons_ag.php?search=', { cod_rec: cod_rec, ajax: 'true' }, function (j) {

        $('#myModalLabel').text("Agendamento: " + j.cod_rec);
        var dt_janela = '<option value="' + j.dt_janela + '" selected>' + j.dt_janela + ' [ Selecionado]</option>';
        $('#dt_agenda').append(dt_janela);
        var ds_janela = '<option value="' + j.id_janela + '" selected>' + j.ds_janela + ' [ Selecionado]</option>';
        $('#hr_agenda').append(ds_janela);
        $('#nm_for').val(j.name);
        $('#ds_ped').val(j.nr_insumo);
        $('#ds_mail').val(j.ds_mail);
        $('#nr_peso').val(j.peso);
        $('#nr_volume').val(j.volume);
        var tp_vol = '<option value="' + j.ds_tipo_vol + '" selected>' + j.ds_tipo_vol + ' [ Selecionado]</option>';
        $('#tp_vol').append(tp_vol);
        var tp_veic = '<option value="' + j.id_veiculo + '" selected>' + j.tp_veiculo + ' [ Selecionado]</option>';
        $('#tp_veic').append(tp_veic);
        $('#nm_trans').val(j.transportador);
        $('#ds_mot').val(j.motorista);
        $('#ds_placa').val(j.placa);
        $('#ds_obs').val(j.ds_obs);
        $('#cod_rec').val(j.cod_rec);

    });

    $('#btnSaveUpdAg').on('click', function () {

        event.preventDefault();

        $.post("assets/php/edit_ag.php", $("#formUpdAg").serialize(), function (data) {
            alert(data);
        });
        return false;

    });

    $(document).on('click', '#sel_for', function () {

        event.preventDefault();

        var cod_for = $(this).val();
        var nm_forn = $(this).attr("data-for");

        $("#id_for").val(cod_for);
        $('#nm_for').val(nm_forn);

    });

    $(document).on('click', '#cancEdit', function () {

        event.preventDefault();

        var page = "recebimentos.html";

        window.location.replace(page);

    });


});