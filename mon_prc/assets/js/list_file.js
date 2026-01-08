$(document).ready(function () {

    let cod_rec = sessionStorage.getItem('cod_rec');
    sessionStorage.removeItem('cod_rec');

    $('#retPdf').load("assets/php/list_file.php?search=",{cod_rec:cod_rec});

});