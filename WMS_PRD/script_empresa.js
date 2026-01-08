$(document).on('click', '#btnDtlEmpresa', function(){
		event.preventDefault();
		$.getJSON('data/empresa/list_empresa_teste.php', function(data){
			var empresa = '';
			var nm_empresa = '';
			var cod_empresa = '';
			var nr_cnpj = '';
			$.each(data, function(key, value){
				empresa += '<h5 class="modal-title nm_empresa" id="header_empresa">'+ value.nm_empresa +'</h5>';
				nm_empresa += '<input type="text" class="form-control" value="'+ value.nm_empresa +'" name="nm_empresa" id="form_control_razao_social" placeholder="Razão Social" readonly>';
				cod_empresa += '<input type="text" class="form-control" name="cod_empresa" value="'+ value.cod_empresa +'" id="form_control_apelido" placeholder="Código" readonly>';
				nr_cnpj += '<input type="text" class="form-control" name="nr_cnpj" value="'+ value.nr_cnpj +'" id="form_control_cnpj" placeholder="CNPJ" readonly>';
			});
			$('.modal-header').append(empresa);
			$('#nm_empresa').append(nm_empresa);
			$('#cod_empresa').append(cod_empresa);
			$('#nr_cnpj').append(nr_cnpj);
		});
		$('#detalhe_empresa').modal('show');
		return false;
	});