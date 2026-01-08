$(document).ready(function(){

    $('#retDash').load("list_dash_home.php");

    $(document).on('click','#btnRetDashHome',function(){
        event.preventDefault();

        var dt_ini_hm  = $('#dt_ini').val();
        var dt_fim_hm  = $('#dt_fim').val();
        var nr_cr_hm   = $('#nr_cr').val();

        if(dt_ini_hm == "" || dt_fim_hm == "" || nr_cr_hm == ""){

            alert("Por favor preencha o período e o centro de custo.");

        }else{
            
            $.ajax
            ({
                url:"list_dash_home_dt.php",
                method:"POST",
                data:{
                    dt_ini_hm:dt_ini_hm,
                    dt_fim_hm:dt_fim_hm,
                    nr_cr_hm:nr_cr_hm
                },
                beforeSend:function(e){
                    $("#retDashDtl").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                },
                success:function(data)
                {
                    $("#retDashDtl").html(data);
                }
            }); 
        }

        return false;
    });

    $(document).on('click','#btnRetDashItemDtl',function(){
        event.preventDefault();

        var nr_cr_it   = $('#nr_cr_it').val();

        if(nr_cr_it == ""){

            alert("Por favor preencha o centro de custo.");

        }else{
            
            $.ajax
            ({
                url:"chart_item_cr_dt.php",
                method:"POST",
                data:
                {
                    nr_cr_it:nr_cr_it
                },
                beforeSend:function(e){
                    $("#retDashItCr").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                },
                success:function(data)
                {
                    $("#retDashItCr").html(data);
                }
            }); 
        }

        return false;
    });

    $(document).on('change','#ano_src',function(){
        event.preventDefault();

        if($(this).val() == "" || $(this).find(':selected').attr("data-mes") == ""){

            alert("Por favor preencha o ano e o mês.");

        }else{
            
            $.ajax
            ({
                url:"list_dash_home_ano.php",
                method:"POST",
                data:{
                    ano_src:$(this).val(),
                    mes_src:$(this).find(':selected').attr("data-mes")
                },
                beforeSend:function(e){
                    $("#retDashDtl").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
                },
                success:function(data)
                {
                    $("#retDashDtl").html(data);
                }
            }); 
        }

        return false;
    });


    $('#btnRelCons').on('click',function(){
        event.preventDefault();

        var dt_ini  = $('#dt_ini').val();
        var dt_fim  = $('#dt_fim').val();
        var nr_cr   = $('#nr_cr').val();

        if(dt_ini == "" || dt_fim == ""){

            alert("Por favor preencha o período.");

        }else{
            
            $("#retDash").html("<img src='../css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
            $('#retDash').load("../WMS_PRD/data/recebimento/rel_consumo_dash.php?search=",{dt_ini:dt_ini,dt_fim:dt_fim,nr_cr:nr_cr});

        }

        return false;
    });

    $('#btnReqMes').on('click',function(){
        event.preventDefault();

        $('#retDash').load("dash_req_mes.php");

        return false;
    });

    $('#btnCrMes').on('click',function(){
        event.preventDefault();

        $('#retDash').load("dash_req_cr.php");

        return false;
    });

    $('#btnResInv').on('click',function(){
        event.preventDefault();

        $('#retDash').load("dash_res_inv.php");

        return false;
    });

    $('#btnCrMesItem').on('click',function(){
        event.preventDefault();

        $('#retDash').load("dash_item_cr.php");

        return false;
    });

    $('#btnHome').on('click',function(){
        event.preventDefault();

        window.location.href = "index.php";

        return false;
    });

    $(document).on('dblclick','.ConsGrupoQtd',function(){
        event.preventDefault();
        var cod_grp = $(this).attr("data-grp");
        var ds_mes = $(this).attr("data-mes");
        $('#retModalDash').load("modal/m_grupo_qtd.php?search=",{cod_grp:cod_grp,ds_mes:ds_mes});
    });

    $(document).on('dblclick','.ConsGrupoVlr',function(){
        event.preventDefault();
        var cod_grp = $(this).attr("data-grp");
        var ds_mes = $(this).attr("data-mes");
        $('#retModalDash').load("modal/m_grupo_vlr.php?search=",{cod_grp:cod_grp,ds_mes:ds_mes});
    });

    $(document).on('dblclick','.ConsCcQtd',function(){
        event.preventDefault();
        var cod_cc = $(this).attr("data-cc");
        var ds_mes = $(this).attr("data-mes");
        $('#retModalDash').load("modal/m_ccusto_qtd.php?search=",{cod_cc:cod_cc,ds_mes:ds_mes});
    });

    $(document).on('dblclick','.ConsCcVlr',function(){
        event.preventDefault();
        var cod_cc = $(this).attr("data-cc");
        var ds_mes = $(this).attr("data-mes");
        $('#retModalDash').load("modal/m_ccusto_vlr.php?search=",{cod_cc:cod_cc,ds_mes:ds_mes});
    });

    $(document).on('dblclick','.mDtlPed',function(){
        event.preventDefault();
        var cod_ped = $(this).attr("data-ped");
        $('#retSubModalDash').load("modal/m_dtl_ped.php?search=",{cod_ped:cod_ped});
    });

});