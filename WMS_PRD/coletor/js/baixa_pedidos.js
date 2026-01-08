$(document).ready(function () {
	$('#retExpEnd1').hide();
	$('#retExpEnd2').hide();


	/*$(document).on('click', '#btnSaveConfProdInvTransf', function (event) {
		event.preventDefault();
		var barcode = $('#barcodeInvTransf').val();
		var localInv = $('#localInv').val();
		var nr_vol_inv = $('#nr_vol_inv').val();
		var nr_qtde_inv = $('#nr_qtde_inv').val();
		var nrInvConf = $('#nrInvConf').val();
		var id_galpao = $('#id_galpao').val();
		var nr_ca_inv = $('#nr_ca_inv').val();
		var dt_ca_inv = $('#dt_ca_inv').val();
		var nr_ld_inv = $('#nr_ld_inv').val();
		var dt_ld_inv = $('#dt_ld_inv').val();
		var dt_val_inv = $('#dt_val_inv').val();

		if ($('#barcodeInvTransf').val() == '') {

			alert("Favor bipar o volume!");

		} else {

			$.post("xhr/conf_picking_inv_transf.php", {
				barcode: barcode,
				localInv: localInv,
				nr_qtde_inv: nr_qtde_inv,
				nr_vol_inv: nr_vol_inv,
				nrInvConf: nrInvConf,
				id_galpao: id_galpao,
				nr_ca_inv: nr_ca_inv,
				dt_ca_inv: dt_ca_inv,
				nr_ld_inv: nr_ld_inv,
				dt_ld_inv: dt_ld_inv,
				dt_val_inv: dt_val_inv
			},
				function (data) {
					var retorno = "Atenção:" + data.info;
					$('#retInvQtdeTransf').html(retorno);
					$('#barcodeInvTransf').val("");
					$('#localInv').val("");
					$('#nr_vol_inv').val("");
					$('#nr_qtde_inv').val("");
					$('#dt_ca_inv').val("");
					$('#dt_ld_inv').val("");
					$('#dt_val_inv').val("");
				}, "json");

			return false;

		}
	});*/

	$(document).on('click', '#btnFinConv', function (event) {
		event.preventDefault();

		var nr_qtde_rec = $('#nr_qtde_rec').val();
		var localExp    = $("#localExp").val();
		var cod_mat     = $('#PrdExp').val();
		var cod_ped 		= $(this).val();
		// var ds_umb 			= $('#ds_umb').val();
		// var cod_dst 		= $('#cod_dst').val();
		// var ds_mat 			= $('#ds_mat').val();

		$.post("xhr/fin_conf_exp_con.php", {
			nr_qtde_rec: 	nr_qtde_rec,
			localExp: 	    localExp,
			cod_mat: 		cod_mat,
			cod_ped: 		cod_ped
			// ds_umb: 		ds_umb,
			// cod_dst: 		cod_dst,
			// ds_mat: 		ds_mat,
		});

	});

	$(document).on('click', '#btnSaveConv', function (event) {
		event.preventDefault();

		var cod_ped 		= $(this).val();
		var nr_ped 			= $(this).attr("data-ped");
		var ds_umb 			= $('#ds_umb').val();
		var nr_qtde_rec 	= $('#nr_qtde_rec').val();
		var cod_dst 		= $('#localExp').val();
		var ds_mat 			= $('#ds_mat').val();
		var cod_mat 		= $('#PrdExp').val();

		$.post("xhr/ins_reclassifica.php", {
			cod_ped: 		cod_ped,
			nr_ped: 		nr_ped,
			ds_umb: 		ds_umb,
			nr_qtde_rec: 	nr_qtde_rec,
			cod_dst: 		cod_dst,
			ds_mat: 		ds_mat,
			cod_mat: 		cod_mat
		},
			function (k) {

				var retorno = "";

				for (var i = 0; i < k.length; i++) {

					if (k[i].info == "0") {

						retorno += "<tr>";
						retorno += "<td>"+k[i].cod_ped+"</td>";
						retorno += "<td>"+k[i].cod_mat+"</td>";
						retorno += "<td>"+k[i].cod_dst+"</td>";
						retorno += "<td>"+k[i].nr_qtde+"</td>";
						retorno += "<td>"+k[i].ds_umb+"</td>";
						retorno += "<td>"+k[i].ds_material+"</td>";
						retorno += "</tr>";

					} else {

						retorno += "<tr>";
						retorno += "<td colspan='4'>MATERIAL "+cod_dst+" NÃO CADASTRADO</td>";
						retorno += "</tr>";
						
					}

				}
				
				$("#retReclassifica").html(retorno);

			}, "json");

	});
});