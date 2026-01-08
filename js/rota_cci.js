$(document).ready(function(){

    $('#btnConsRotaCciCad').on('click', function(e){
        event.preventDefault();
        var ds_org_rota_cad = $('#ds_org_rota_cad').val();
        var ds_dst_rota_cad = $('#ds_dst_rota_cad').val();

        $.ajax
        ({
            url:"data/integracao/list_rota_cci_cad.php",
            method:"POST",
            data:{
                ds_org_rota:ds_org_rota_cad,
                ds_dst_rota:ds_dst_rota_cad
            },
            success:function(rotaCad)
            {
                $('#listRotaCciCad').html(rotaCad);
            }
        });
    });

    $('#btnConsRotaCciNcad').on('click', function(e){
        event.preventDefault();
        var ds_org_rota_ncad = $('#ds_org_rota_ncad').val();
        var ds_dst_rota_ncad = $('#ds_dst_rota_ncad').val();

        $.ajax
        ({
            url:"data/integracao/list_rota_cci_Ncad.php",
            method:"POST",
            data:{
                ds_org_rota:ds_org_rota_ncad,
                ds_dst_rota:ds_dst_rota_ncad
            },
            success:function(rotaNcad)
            {
                $('#listRotaCciNcad').html(rotaNcad);
            }
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