$(document).ready(function(){
    $('#btnConsVgCCI').on('click', function(e){
        event.preventDefault();
        var user = "WSWS";
        var password = "1010";

        var id_vg = $('#id_viagem').val();
        var dt_ini = $('#dtIniCci').val();
        var dt_fim = $('#dtFimCci').val();

        var data_ini = dt_ini;
        var dt_ini = data_ini.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');

        var data_fim = dt_fim;
        var dt_fim = data_fim.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');

        if(id_vg != '' && dt_ini != "" && dt_fim != ""){

            alert("Selecione apenas a viagem ou o intervalo e datas")

        }else if(id_vg != '' && dt_ini == "" || dt_fim == ""){

            var url =  "http://186.250.92.150:9090/ws_rest/public/api/viagem/"+id_vg;

        }else if(id_vg == '' && dt_ini != "" && dt_fim != ""){

            var url =  "http://186.250.92.150:9090/ws_rest/public/api/viagem?DataInicioI="+dt_ini+"&DataInicioF="+dt_fim;
        }

        function make_base_auth(user, password) {
            var tok = user + ':' + password;
            var hash = Base64.encode(tok);
            return "Basic " + hash;
        }

        $.ajax
        ({
            type: "GET",
            url: url,
            dataType: 'json',
            async: false,
            //data: '{"username": "' + user + '", "password" : "' + password + '"}',
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Basic " + btoa(user + ":" + password));
            },
            success: function (data){
                for (var i = 0; i < data.viagens.length; i++) {

                    console.log('ID', data.viagens[i].viagemId);
                    console.log('carregado', data.viagens[i].viag_carregado);
                    console.log('cadastro', data.viagens[i].viag_data_cadastro);
                    console.log('inicio', data.viagens[i].viag_data_inicio);
                    console.log('fim', data.viagens[i].viag_data_fim);
                    console.log('distancia', data.viagens[i].viag_distancia);

                    for (var j = 0; j < data.viagens[i].locais.length; j++) {
                        console.log('longitude', data.viagens[i].locais[j].refe_longitude);
                        console.log('descricao', data.viagens[i].locais[j].vloc_descricao);
                    }

                    for (var v = 0; v < data.viagens[i].veiculos.length; v++) {
                        console.log('placa', data.viagens[i].veiculos[v].placa);
                        console.log('modelo', data.viagens[i].veiculos[v].modelo);
                    }

                }
            }
        });
    });
});