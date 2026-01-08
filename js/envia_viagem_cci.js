$(document).ready(function(){
    $('#btnConsManCci').on('click', function(e){
        event.preventDefault();
        var id_vg = $('#nr_man_cci').val();

        $.ajax
        ({
            url:"data/integracao/consulta_viagem_cci.php",
            method:"POST",
            dataType:'json',
            data:{
                id_vg:id_vg
            },
            success:function(c)
            {
                for (var i = 0; i < c.length; i++) {
                    if(c[i].info == "0"){
                        $('#retConsVgCci').html("<p><h2>CT-e: "+ c[i].vlco_numero +"</h2></p>\
                            <p><h2>Veículo: "+ c[i].veiculos +"</h2></p>\
                            <p><h2>Cidade: "+ c[i].rota_descricao +"</h2></p>\
                            <p><h2>Destino: "+ c[i].destino +"</h2></p>\
                            <button type='button' id='btnConfSendVg' class='btn btn-primary btn-xs'>CONFIRMAR</button>");

                    }else{
                        $('#retConsVgCci').html("<p>CT-e: Conhecimento não encontrado!</p>");
                    }
                }
            }
        });
    });
});  

$(document).on('click', '#btnConfSendVg',function(e){
    event.preventDefault();
    var id_cte = $('#nr_man_cci').val();

    $.ajax
    ({
        url:"data/integracao/envia_viagem_cci.php",
        method:"POST",
        dataType:'json',
        data:{
            id_cte:id_cte
        },
        success:function(viagem)
        {
            var user = "WSWS";
            var password = "1010";

            function make_base_auth(user, password) {
                var tok = user + ':' + password;
                var hash = Base64.encode(tok);
                return "Basic " + hash;
            }

            var postData = viagem;

            $.ajax
            ({
                url: 'http://186.250.92.150:9090/ws_rest/public/api/viagem',
                method:"POST",
                dataType:'json',
                contentType: 'application/json',
                async: false,
                data: JSON.stringify(postData),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "Basic " + btoa(user + ":" + password));
                },
                success:function(j)
                {
                    console.log("Funciona!");
                }
            });
        }
    });
    return false;
}); 