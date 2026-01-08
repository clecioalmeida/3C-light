$(document).ready(function () {

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

		var almox = '';

		$('.bs-autocomplete').each(function() {
			var _this = $(this),
			_data = _this.data(),
			_hidden_field = $('#' + _data.hidden_field_id);

			$.getJSON(_data.source, 
			{
				ajax: 'true'
			}, 
			function(j){

				almox = j;
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
					var data = almox.filter(function(item) {
						return item.ds_almox.match(_regexp);
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

});