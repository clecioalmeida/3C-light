$(document).ready(function(){

    let cod_rec = sessionStorage.getItem('cod_rec');

    sessionStorage.removeItem('cod_rec');
    $('#cod_rec').val(cod_rec);

    $('#testeXml').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_xml.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retXml").html("<img src='css/loading9.gif'>");
            },
            success: function(data)
            {
                $("#retXml").html(data);
            }
        });
        return false;
    });
});