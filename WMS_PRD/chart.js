$(document).ready(function(){
	$.ajax({
		url:"data/movimento/chartjs.php",
		method:"GET",
		success:function(data){
			console.log(data);
			var mes = [];
			var total = [];

			for(var i in data){
				total.push("Total " + data[i].total);
				mes.push(data[i].mes);
			}

			var chartdata = {
				labels: total,
				datasets:[
					{
						label:"Pedidos por mês",
						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: mes
					}
				]
			};

			var ctx = $("#pedidoMes");
			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
		},
		error:function(data){
			console.log(data);
		}
	});
});