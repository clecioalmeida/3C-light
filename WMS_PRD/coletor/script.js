$(document).ready(function(){
	event.preventDefault();
	$('#barcode').keypress(function(event){

		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			console.log($('#barcode').val());
			if($('#barcode').val() == ''){
				alert("Favor bipar o volume!");
			} else {

				var cod_nf_item = $('#cod_nf_item').val();
				var cod_nf = $('#cod_nf').val();
				var cod_rec = $('#cod_rec').val();
				var nr_qtde = $('#nr_qtde').val();
				var barcode = $('#barcode').val();
				
				$.ajax
				({
					url:"xhr/ins_conf.php",
					method: "POST",
					dataType:'json',
					data:{
						cod_nf_item:cod_nf_item,
						cod_nf:cod_nf,
						cod_rec:cod_rec,
						nr_qtde:nr_qtde,
						barcode:barcode
					},
					success:function(j){
						$('#form_conf')[0].reset();
						//$('#myModal').modal('show');
						for(var i=0;i < j.length;i++){
							var total = "Conferido:"+j[i].total_conf;
							$('#TotalConferido').html(total);
							$('#barcode').focus();
						}
					}
				});
				
			}
			return false;
		}

	});
});