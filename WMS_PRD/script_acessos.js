$(document).ready(function(){
	var nivel = '<? echo $fl_nivel;?>'
		
		if(nivel == '3'){
			$('#mDashboard').attr("disable");
			alert('Você não tem acesso a esse menu!');
		}
});