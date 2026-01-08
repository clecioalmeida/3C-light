$(document).ready(function(){
    $('#btnConsVgAverba').on('click', function(e){
        event.preventDefault();
        var cod_cte = $('#cod_cte').val();

        $.ajax
        ({
            url:"data/integracao/gera_xml_atm.php",
            method:"POST",
            dataType:'json',
            data:{
                cod_cte:cod_cte
            },
            success:function(c)
            {
                var user = "ws";
                var password = "base123";

                function make_base_auth(user, password) {
                    var tok = user + ':' + password;
                    var hash = Base64.encode(tok);
                    return "Basic " + hash;
                }
                if(c.info == "0"){

                    var xml_cte = JSON.stringify(c.xml);
                    var cod_atm = c.cod_atm;

                    $.ajax
                    ({
                        url: 'http://webserver.averba.com.br/20/averbaCTe',
                        method:"POST",
                        dataType:'xml',
                        contentType: "text/xml; charset=\"utf-8\"",
                        async: false,
                        data: xml_cte,
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader ("Authorization", "Basic " + btoa(user + ":" + password),cod_atm);
                        },
                        success:function(j)
                        {
                            $('#retConsVgAtm').html("<p>Retorno: "+j+"</p>");
                        }
                    });

                }else{
                    $('#retConsVgAtm').html("<p>CT-e: Conhecimento não encontrado!</p>");
                }
            }
        });
    });
});  
/*
$(document).ready(function(){
    $( '#btnConfSendVgAtm').on('click',function(e){
        event.preventDefault();
        var ch_cte = "35190704214233000903570010000020031000020034";//$('#nr_man_cci').val();

        
        return false;
    });
});*/