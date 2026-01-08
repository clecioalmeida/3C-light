$(document).ready(function () {

	$('#btnPesqNsDt').on('click', function () {
		event.preventDefault();

		var dt_ini = $("#dt_ini_ns").val();
		var dt_fim = $("#dt_fim_ns").val();

		$.post("data/produto/list_ns_dt.php", { dt_ini: dt_ini, dt_fim:dt_fim },
			function (data) {
				$('#retornoEnc').html(data);
			});

	});

	$('#liNs').on('click', function () {
		event.preventDefault();

		$.post("data/produto/list_ns.php",
			function (data) {
				$('#retornoEnc').html(data);
			});

	});

});