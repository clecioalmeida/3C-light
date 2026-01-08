var app = new Vue({
	el:"#retorno",
	data: {
		TipoTorres: []


	},

	mounted: function(){
		console.log("mounted");
		this.getTipoTorres();


	},

	methods: {
		getTipoTorres: function(){
			axios.get("http://localhost/wms_20/api.php?action=consulta")
			.then(function(retorno){
				console.log(retorno);
			});
		}


	}
});