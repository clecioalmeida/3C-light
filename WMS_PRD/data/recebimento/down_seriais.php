<div class="row">
    <br><br><br><br>
    <article class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-inline" action="" id="testeXml" method="post" enctype="multipart/form-data">
                    <article>
                        <div class="form form-inline">
                            <p>Selecione o intervalo de datas.</p>
                            <form class="form-horizontal" method="post" action="" id="">
                                <label class="input">Período:
                                    <input type="date" class="input-xs" id="dt_ini_ns" name="dt_ini_ns" style="color: black">
                                </label>
                                <label class="input">Até:
                                    <input type="date" class="input-xs" id="dt_fim_ns" name="dt_fim_ns" style="color: black">
                                </label>
                            </form>
                            <button class="btn btn-default btn-primary" type="submit" id="btnDownSeriaisRec">
                                <i class="fa fa-check"></i> Baixar
                            </button>
                            <a id="down_seriais_rec" href="" style="display:none"  download></a>
                        </div>
                        <div id="retImportRepom"></div>
                        <div id="retPedidoSAP"></div>
                    </article>
                </form>
            </div>
        </div>
    </article>
    <article class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div>
            <div class="widget-body">
                <section id="widget-grid" class="">
                    <div class="row">
                        <div class="col-sm-12" id="ret_imp_cte">
                            <div class="aguarde" style="display: none">
                                <h1>
                                    Aguarde...
                                </h1>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </article>
</div>
<!-- meus scripts -->
<script type="text/javascript">
    $('#btnDownSeriaisRec').on('click', function() {
        event.preventDefault();
        var dt_ini_ns = $('#dt_ini_ns').val();
        var dt_fim_ns = $('#dt_fim_ns').val();
        console.log(dt_fim_ns);

        if (dt_ini_ns == '' || dt_fim_ns == '') {

            alert('Por favor preencha todos os campos data');

        } else {

            $('#btnDownSeriaisRec').prop("disabled", true);

            $.ajax({
                url: "data/recebimento/baixa_seriais_wms.php",
                method: "POST",
                dataType: 'json',
                data: {
                    dt_ini: dt_ini_ns,
                    dt_fim: dt_fim_ns
                },
                beforeSend: function(e) {
                    $(".aguarde").show();
                },
                success: function(j) {
                    $(".aguarde").hide();

                    if (j.info == 0) {
                        var arquivo = j.arquivo;
                        var filename = "../arquivos/"+arquivo;
                        $("#down_seriais_rec").attr("href",filename);
                        $("#ret_imp_cte").append("<h2>Arquivo "+dt_ini_ns+" - "+dt_fim_ns+" gerado com sucesso! Aguarde o download.</h2>");

                        document.getElementById('down_seriais_rec').click();

                    } else if (j.info == 1) {

                        $("#ret_imp_cte").append("<h2>O arquivo não pode ser gerado!</h2>");

                    } else {

                        $("#ret_imp_cte").append("<h2>Não há dados no período!</h2>");

                    }
                }
            });

            $('#btnDownSeriaisRec').prop("disabled", false);
        }
        return false;
    });
</script>