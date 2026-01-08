
	$(document).ready(function () {
		$('.base').maskMoney();

		$('#insOpCte').on('change', function(){
			$.getJSON('data/expedicao/consulta_rota_venda.php', 
			{
				cod_dst:$('#insDestTabela').val(),
				ajax: 'true'
			}, 
			function(j){
				var options = '<option value="">Escolha a rota</option>'; 
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' +j[i].rateio + '">' + j[i].rota + '</option>';
				}
				$('#insTipoRota').html(options).append();
			});
		});

		$('#insDestTabela').on('change', function(){
			$.getJSON('data/expedicao/consulta_rota_venda.php', 
			{
				cod_dst:$('#insDestTabela').val(),
				ajax: 'true'
			}, 
			function(j){
				var options = '<option value="">Escolha a rota</option>'; 
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' +j[i].rateio + '">' + j[i].rota + '</option>';
				}
				$('#insTipoRota').html(options).append();
			});
		});
	});

	$.widget("ui.autocomplete", $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var that = this;
		ul.attr("class", "nav nav-pills nav-stacked  bs-autocomplete-menu");
		$.each(items, function(index, item) {
			that._renderItemData(ul, item);
		});
	},

	_resizeMenu: function() {
		var ul = this.menu.element;
		ul.outerWidth(Math.min(
			ul.width("").outerWidth() + 1,
			this.element.outerWidth()
			));
	}

});

(function() {
	"use strict";

	var entidades = '';
	var _hidden_field_uf = '';

	$('.bs-autocomplete').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);
		_hidden_field_uf = $('#' + _data.hidden_field_uf);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			entidades = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = entidades.filter(function(item) {
					return item.nm_municipio.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
				_hidden_field_uf.val('');
			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();
			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				_hidden_field_uf.val(ui.item[_data.item_uf]);
				event.preventDefault();
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();

(function() {
	"use strict";

	var expedidor = '';

	$('.bs-autocomplete_exp').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			expedidor = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = expedidor.filter(function(item) {
					return item.nm_expedidor.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();
			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				event.preventDefault();
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();

(function() {
	"use strict";

	var recebedor = '';

	$('.bs-autocomplete_rec').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			recebedor = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = recebedor.filter(function(item) {
					return item.nm_recebedor.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();
			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				event.preventDefault();
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();

(function() {
	"use strict";

	var pagador = '';

	$('.bs-autocomplete_pag').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			pagador = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = pagador.filter(function(item) {
					return item.nm_pagador.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();
			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				event.preventDefault();
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();

(function() {
	"use strict";

	var motorista = '';

	$('.bs-autocomplete_mot').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			motorista = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = motorista.filter(function(item) {
					return item.nm_motorista.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();
			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				event.preventDefault();
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();

(function() {
	"use strict";

	var veiculo = '';
	var _hidden_prop = '';
	var _hidden_tipo= '';


	$('.bs-autocomplete_veic').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);
		_hidden_prop = $('#' + _data.hidden_field_prop);
		_hidden_tipo = $('#' + _data.hidden_field_tipo);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			veiculo = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = veiculo.filter(function(item) {
					return item.nr_placa.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
				_hidden_prop.val('');
				_hidden_tipo.val('');

			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();

			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				_hidden_prop.val(ui.item[_data.item_prop]);
				_hidden_tipo.val(ui.item[_data.item_tipo]);
				event.preventDefault();

				var id_veic = ui.item[_data.item_id];
				$.getJSON('data/expedicao/consulta_cadastro_veic.php', 
				{
					id_veic: id_veic,
					ajax: 'true'
				}, 
				function(j){
					for (var i = 0; i < j.length; i++) {

						if(j[i].uf == '0' || j[i].tp_veiculo == '0.00' || j[i].tara == '0.00' || j[i].peso_q == '0'){

							var cod_veic = j[i].nr_veiculo;

							alert("Dados cadastrados insuficientes para validação de documentos fiscais.");
							$('#retModalIns').load("data/transportador/modal/m_upd_veic_terc_cte.php?search=",{cod_veic:cod_veic});

						}else{

							$('#nm_veic').val(j[i].nr_placa);
							$('#id_veic').val(j[i].nr_veiculo);	
							$('#id_prop').val(j[i].id_prop);	

						}					

					}

				});
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();

(function() {
	"use strict";

	var carreta = '';

	$('.bs-autocomplete_car').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			carreta = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = carreta.filter(function(item) {
					return item.nr_placa.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();
			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				event.preventDefault();
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();

(function() {
	"use strict";

	var carreta2 = '';

	$('.bs-autocomplete_car2').each(function() {
		var _this = $(this),
		_data = _this.data(),
		_hidden_field = $('#' + _data.hidden_field_id);

		$.getJSON(_data.source, 
		{
			ajax: 'true'
		}, 
		function(j){

			carreta2 = j;
		});

		_this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader">Aguarde...</div></div>')
		.parent('.form-group').addClass('has-feedback');

		var feedback_icon = _this.next('.bs-autocomplete-feedback');
		feedback_icon.hide();

		_this.autocomplete({
			minLength: 2,
			autoFocus: true,

			source: function(request, response) {
				var _regexp = new RegExp(request.term, 'i');
				var data = carreta2.filter(function(item) {
					return item.nr_placa.match(_regexp);
				});
				response(data);
			},

			search: function() {
				feedback_icon.show();
				_hidden_field.val('');
			},

			response: function() {
				feedback_icon.hide();
			},

			focus: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				event.preventDefault();
			},

			select: function(event, ui) {
				_this.val(ui.item[_data.item_label]);
				_hidden_field.val(ui.item[_data.item_id]);
				event.preventDefault();
			}
		})
		.data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
			.data("item.autocomplete", item)
			.append('<a>' + item[_data.item_label] + '</a>')
			.appendTo(ul);
		};
	});
})();