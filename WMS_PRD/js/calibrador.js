$(document).ready(function(){

	$(document).on('click', '#btnNovoClb', function(){
		event.preventDefault();
		$.ajax
		({
			url:"novo_calib.php",
			method:"POST",
			success:function(data)
			{
				$('#retornoClb').html(data);
			}
		});
		return false;
	});

});