$('#btnPesqAlmox').on('click',function(){
	event.preventDefault();

	if($('#nm_almox').val() == ""){

		alert("Digite o código do almox.");

	}else{

		var cod_almox = $('#nm_almox').val();

		$.post("data/movimento/consulta_almox_ped.php",{cod_almox:cod_almox},function(data){

			$('#cod_almox').val(data.cod_almox);
			$('#nm_almox').val(data.ds_almox);

		}, "json");

	}
	return false;
});