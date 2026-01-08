
<article style="background-color: #D3D3D3">
	<div>
		<form class="form-horizontal" method="post" action="" id="formPedParc">
			<label class="input">PERÍODO
				<input type="date" class="input-xs" id="dt_ini" name="dt_ini" style="color: black">
				<input type="date" class="input-xs" id="dt_fim" name="dt_fim" style="color: black">
			</label>
			<button type="submit" id="btnConsPedParcInfo" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
		</form>
	</div>
</article>
<article id="">
	<div id="retornoPedParc"></div>
	<div id="retModalParc"></div>
	<div id="retModalPedDtlParc"></div>
</article>
<script type="text/javascript">	
	$(document).ready(function(){

		$('#btnConsPedParcInfo').on('click', function(){
			event.preventDefault();
			var dt_ini = $('#dt_ini').val();
			var dt_fim = $('#dt_fim').val();
			$.ajax
			({
				url:"data/movimento/pedido_sql_parcial_info.php",
				method:"POST",
				data:{dt_ini:dt_ini,dt_fim:dt_fim},
				success:function(data)
				{
					$('#retornoPedParc').html(data);
				}
			});
		});

	});
</script>