$(document).ready(function () {

    // Links

    $('#pesq_prd').on('click', function () {
        event.preventDefault();
        var cod_prd = $('#cod_prd').val();
        sessionStorage.setItem('cod_prd', cod_prd);
        $('#load_estoque').load("assets/modal/list_estoque.html");

    });

    $('#load_list_dash').on('click', function () {

        event.preventDefault();
        /*var page = "recebimento.html";

        window.location.replace(page);*/
       // $('#load_pages').load("dash.html");
        return false;

    });

    $('#load_list_rec').on('click', function () {

        event.preventDefault();
        /*var page = "recebimento.html";

        window.location.replace(page);*/
       // $('#load_pages').load("recebimento.html");
        return false;

    });


});