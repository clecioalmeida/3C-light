$(document).ready(function(){
    $('.btnCadRotaCci').on('click',function(e){
        event.preventDefault();
        var id_rota = $(this).val();

        $.ajax
        ({
            url:"data/integracao/envia_rota_cci.php",
            method:"POST",
            dataType:'json',
            data:{
                id_rota:id_rota
            },
            success:function(r)
            {
                var user = "WSWS";
                var password = "1010";

                function make_base_auth(user, password) {
                    var tok = user + ':' + password;
                    var hash = Base64.encode(tok);
                    return "Basic " + hash;
                }

                var postRota = r;

                $.ajax
                ({
                    url: 'http://186.250.92.150:9090/ws_rest/public/api/rota',
                    method:"POST",
                    dataType:'json',
                    async: false,
                    data: JSON.stringify(postRota),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader ("Authorization", "Basic " + btoa(user + ":" + password));
                    },
                    success:function(j)
                    {
                        console.log("Funciona!");
                        console.log(postRota);
                    }
                });
            }
        });
        return false;
    }); 
});