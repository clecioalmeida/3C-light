$(document).ready(function(){

    $('#btnTarPrj').on('click',function(){
        event.preventDefault();

        $('#retDash').load("dash_tar.php");

        return false;
    });

    $('#btnTarMes').on('click',function(){
        event.preventDefault();

        $('#content').load("dash_mes.php");

        return false;
    });

    $('#btnPrj').on('click',function(){
        event.preventDefault();

        $('#content').load("dash_prj.php");

        return false;
    });

    $('#btnTartp').on('click',function(){
        event.preventDefault();

        $('#content').load("dash_tp.php");

        return false;
    });

    $('#btnHome').on('click',function(){
        event.preventDefault();

        window.location.href = "index.php";

        return false;
    });

});