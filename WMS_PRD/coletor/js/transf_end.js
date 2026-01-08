$(document).ready(function(){

	$(document).on('change', '#lp_org', function () {
        $.getJSON('xhr/consulta_serial_rec.php?search=', { ds_lp: $(this).val(), ajax: 'true' }, function (j) {

            options  = j.info;
            endereco = j.end;
            qtde     = j.qtde;

            $("#prd_org").val(options);
            $("#end_org").val(endereco);
            $("#qtd_org").val(qtde);
        });
    });

	$(document).on('change', '#lp_dst', function () {
        $.getJSON('xhr/consulta_serial_rec.php?search=', {
			ds_lp: $(this).val(),
			ajax: 'true'
		},
			function (j) {
				options  = j.info;
				$("#prd_dst").val(options);
			}
		);
    });

	$(document).on('click','#btnSaveTransf',function(event){
		event.preventDefault();
		$('#btnSaveTransf').prop("disabled", true);
		if(confirm("Confirma a transferência do produto?")){
			var end_org   = $('#end_org').val();
			var prd_org   = $('#prd_org').val();
			var qtd_org   = $('#qtd_org').val();
			var end_dst   = $('#end_dst').val();
			var prd_dst   = $('#prd_dst').val();
			var qtd_dst   = $('#qtd_dst').val();
			var lp_org    = $("#lp_org").val();

			if(qtd_org == qtd_dst && prd_org == prd_dst && lp_org == lp_org){

				$.post("xhr/cons_transf_end.php",
				{

					end_org:end_org,
					prd_org:prd_org,
					qtd_org:qtd_org,
					end_dst:end_dst,
					prd_dst:prd_dst,
					qtd_dst:qtd_dst,
					lp_org:lp_org,

				},
				function(j){

					if(j == 0){

						$.post("xhr/fin_transf_end.php",
						{

							end_org:end_org,
							prd_org:prd_org,
							qtd_org:qtd_org,
							end_dst:end_dst,
							prd_dst:prd_dst,
							qtd_dst:qtd_dst,
							lp_org:lp_org,

						},
						function(k){

							if(k == 0){

								$('#retTransfInfo').html("<h3>Transferência realizada com sucesso.</h3>");

							}else{

								$('#retTransfInfo').html("<h3>Erro na transferência.</h3>");

							}

						});


					}else if(j == 1){
						
						$('#retTransfInfo').html("<h3>Não há quantidade suficiente para a transferência.</h3>");


					}

				});

			}else{

				$('#retTransfInfo').html("<h3>Código do produto ou quantidade não confere.</h3>");

			}

		}
	});

});