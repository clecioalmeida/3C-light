// INDICADORES - 05/05/20 //

$(document).ready(function(){

	$(document).on('click','#CadPrcNfSap',function(e){  
		event.preventDefault();          
		$('#retornoPrcNF').load('data/dashboard/dash_process_nf.php');
	});

	$(document).on('click','#CadDemRecSap',function(e){  
		event.preventDefault();          
		$('#retornoPrcNF').load('data/dashboard/dash_deem_rec.php');
	});

	$(document).on('click','#CadConsNfSku',function(e){  
		event.preventDefault();          
		$('#retornoPrcNF').load('data/dashboard/dash_nf_sku.php');
	});

	$(document).on('click','#CadConsAgFor',function(e){  
		event.preventDefault();          
		$('#retornoPrcNF').load('data/dashboard/dash_ag_for.php');
	});

	$(document).on('click','#CadConsAgEx',function(e){  
		event.preventDefault();          
		$('#retornoPrcNF').load('data/dashboard/dash_ag_ex.php');
	});

	$(document).on('click','#dashCronEnt',function(e){  
		event.preventDefault();          
		$('#retransporte').load('data/dashboard/dash_cron_ent.php');
	});

	$(document).on('click','#dashVeicNr',function(e){  
		event.preventDefault();          
		$('#retransporte').load('data/dashboard/dash_veic_nr.php');
	});

	$(document).on('click','#dashVeicSpt',function(e){  
		event.preventDefault();          
		$('#retTempoMedio').load('data/dashboard/dash_veic_spt.php');
	});

	$(document).on('click','#dashQtdIten',function(e){  
		event.preventDefault();          
		$('#retTempoMedio').load('data/dashboard/dash_qtd_at.php');
	});

	$(document).on('click','#dashPedEmerg',function(e){  
		event.preventDefault();          
		$('#retTempoMedio').load('data/dashboard/dash_ped_em.php');
	});

	$(document).on('click','#dashOcupInt',function(e){  
		event.preventDefault();          
		$('#retDashOcupa').load('data/dashboard/dash_ocupa_int.php');
	});

	$(document).on('click','#dashOcupExt',function(e){  
		event.preventDefault();          
		$('#retDashOcupa').load('data/dashboard/dash_ocupa_ext.php');
	});

	$(document).on('click','#dashVlrEst',function(e){  
		event.preventDefault();          
		$('#retDashOcupa').load('data/dashboard/dash_vlr_est.php');
	});

	$(document).on('click','#dashGiroEst',function(e){  
		event.preventDefault();          
		$('#retDashOcupa').load('data/dashboard/dash_giro_est.php');
	});

	$(document).on('click','#dashInvDep',function(e){  
		event.preventDefault();          
		$('#retInvDep').load('data/dashboard/dash_inv_dep.php');
	});

	$(document).on('click','#dashInvCl',function(e){  
		event.preventDefault();          
		$('#retInvDep').load('data/dashboard/dash_inv_cl.php');
	});

	$(document).on('click','#dashInvAc',function(e){  
		event.preventDefault();          
		$('#retInvDep').load('data/dashboard/dash_inv_ac.php');
	});

	$(document).on('click','#dashSeg',function(e){  
		event.preventDefault();          
		$('#retorno_seg').load('data/dashboard/dash_seg.php');
	});

	$(document).on('click','#dashTran',function(e){  
		event.preventDefault();          
		$('#retransporte').load('data/dashboard/dash_tran.php');
	});

	$(document).on('click','#dashQld',function(e){  
		event.preventDefault();          
		$('#retorno_qld').load('data/dashboard/dash_qld.php');
	});

	$(document).on('click','#dashImpMb52',function(e){  
		event.preventDefault();          
		$('#retorno_fec').load('importa_mb52_mensal.php');
	});

	$(document).on('click','#dashTempoMedio',function(e){  
		event.preventDefault();          
		$('#retTempoMedio').load('data/dashboard/dash_tempo_medio.php');
	});

	$(document).on('click','#dashAvMat',function(e){  
		event.preventDefault();          
		$('#retorno_outros').load('data/dashboard/dash_avaria.php');
	});

	$(document).on('click','#dashLogRev',function(e){  
		event.preventDefault();          
		$('#retorno_outros').load('data/dashboard/dash_reversa.php');
	});

	$(document).on('click','#dashSucata',function(e){  
		event.preventDefault();          
		$('#retorno_outros').load('data/dashboard/dash_sucata.php');
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnCadInvDep',function(){
		$('#retModalInv').load("data/dashboard/modal/m_ins_inv_dep.php");
	});

	$(document).on('click', '#btnSaveInvDep', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveInvDep').prop("disabled", true);
			var ds_mes 			= $('#ds_mes').val();
			var ds_ano 			= $('#ds_ano').val();
			var nr_sku_qtde  	= $('#nr_sku_qtde').val();
			var nr_sku_sobra 	= $('#nr_sku_sobra').val();
			var nr_sku_falta 	= $('#nr_sku_falta').val();
			var nr_ac_sku 		= $('#nr_ac_sku').val();
			//var vlr_ini 		= $('#vlr_ini').val().substring(3).replace('.','').replace('.','').replace(',','.');
			//var vlr_sobra 		= $('#vlr_sobra').val().substring(3).replace('.','').replace('.','').replace(',','.');
			//var vlr_falta 		= $('#vlr_falta').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_fim 		= vlr;
			var vlr_div 		= acur_vlr;

			$.ajax
			({
				url:"data/dashboard/ins_inv_dep.php",
				method:"POST",
				data:{
					ds_ano: 		ds_ano,
					ds_mes: 		ds_mes,
					nr_sku_qtde: 	nr_sku_qtde,
					nr_sku_sobra: 	nr_sku_sobra,
					nr_sku_falta: 	nr_sku_falta,
					nr_ac_sku: 		nr_ac_sku,
					vlr_ini: 		vlr_ini,
					vlr_sobra: 		vlr_sobra,
					vlr_falta: 		vlr_falta,
					vlr_fim: 		vlr_fim,
					vlr_div: 		vlr_div
				},
				success:function(data)
				{
					alert(data);
					$('#listTbInvDep').load('data/dashboard/modal/list_tb_inv_dep.php?search=',{id_ind:id_ind});
					$('#retInvDep').load('data/dashboard/dash_inv_dep.php');
				}
			});			
			$('#btnSaveInvDep').prop("disabled", false);
		}
	});
	
	$(document).on('dblclick','.indInvDep',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalInv').load("data/dashboard/modal/m_list_inv_dep.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '.btnSaveUpdInvDep', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdInvDep').prop("disabled", true);
			var id_ind 			= $(this).val();
			var ds_data     	= $(this).closest('tr').find('#ds_data').text();
			var nr_sku_qtde     = $(this).closest('tr').find('#nr_sku_qtde').text();
			var nr_sku_sobra    = $(this).closest('tr').find('#nr_sku_sobra').text();
			var nr_sku_falta    = $(this).closest('tr').find('#nr_sku_falta').text();
			var nr_ac_sku     	= $(this).closest('tr').find('#nr_ac_sku').text();
			var vlr_ini     	= $(this).closest('tr').find('#vlr_ini').text().replace('.','').replace('.','').replace(',','.');
			var vlr_sobra     	= $(this).closest('tr').find('#vlr_sobra').text().replace('.','').replace('.','').replace(',','.');
			var vlr_falta     	= $(this).closest('tr').find('#vlr_falta').text().replace('.','').replace('.','').replace(',','.');
			var vlr_fim     	= $(this).closest('tr').find('#vlr_fim').text().replace('.','').replace('.','').replace(',','.');
			//var vlr_div     	= $(this).closest('tr').find('#vlr_div').text();

			console.log(vlr_ini, vlr_sobra, vlr_falta, vlr_fim);

			$.ajax
			({
				url:"data/dashboard/upd_inv_dep.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					ds_data: 		ds_data,
					nr_sku_qtde: 	nr_sku_qtde,
					nr_sku_sobra: 	nr_sku_sobra,
					nr_sku_falta: 	nr_sku_falta,
					nr_ac_sku: 		nr_ac_sku,
					vlr_ini: 		vlr_ini,
					vlr_sobra: 		vlr_sobra,
					vlr_falta: 		vlr_falta,
					vlr_fim: 		vlr_fim
					//vlr_div: 		vlr_div
				},
				success:function(data)
				{
					alert(data);
					$('#retInvDep').load('data/dashboard/dash_inv_dep.php');
					$('#listTbInvDep').load('data/dashboard/modal/list_tb_inv_dep.php?search=',{id_ind:id_ind});
				}
			});			
			$('#btnSaveUpdInvDep').prop("disabled", false);
		}
	});

	// INDICADOR INVENTÁRIO CL //

	$(document).on('click', '#btnCadInvCl',function(){
		$('#retModalInv').load("data/dashboard/modal/m_ins_inv_cl.php");
	});

	$(document).on('click', '#btnSaveInvCl', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveInvCl').prop("disabled", true);
			var ds_mes 			= $('#ds_mes').val();
			var ds_ano 			= $('#ds_ano').val();
			var nr_sku_qtde  	= $('#nr_sku_qtde').val();
			var nr_sku_sobra 	= $('#nr_sku_sobra').val();
			var nr_sku_falta 	= $('#nr_sku_falta').val();
			var nr_ac_sku 		= $('#nr_ac_sku').val();
			//var vlr_ini 		= $('#vlr_ini').val().substring(3).replace('.','').replace('.','').replace(',','.');
			//var vlr_sobra 		= $('#vlr_sobra').val().substring(3).replace('.','').replace('.','').replace(',','.');
			//var vlr_falta 		= $('#vlr_falta').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_fim 		= vlr;
			var vlr_div 		= acur_vlr;

			$.ajax
			({
				url:"data/dashboard/ins_inv_cl.php",
				method:"POST",
				data:{
					ds_ano: 		ds_ano,
					ds_mes: 		ds_mes,
					nr_sku_qtde: 	nr_sku_qtde,
					nr_sku_sobra: 	nr_sku_sobra,
					nr_sku_falta: 	nr_sku_falta,
					nr_ac_sku: 		nr_ac_sku,
					vlr_ini: 		vlr_ini,
					vlr_sobra: 		vlr_sobra,
					vlr_falta: 		vlr_falta,
					vlr_fim: 		vlr_fim,
					vlr_div: 		vlr_div
				},
				success:function(data)
				{
					alert(data);
					$('#retInvDep').load('data/dashboard/dash_inv_cl.php');
				}
			});			
			$('#btnSaveInvCl').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnUpdInvCl',function(){
		var id_ind = $(this).val();
		$('#retModalInv').load('data/dashboard/modal/m_upd_inv_cl.php?search=',{id_ind:id_ind});
	});

	$(document).on('click', '.btnSaveUpdInvCl', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdInvCl').prop("disabled", true);
			var id_ind 			= $(this).val();
			var ds_data     	= $(this).closest('tr').find('#ds_data').text();
			var nr_sku_qtde     = $(this).closest('tr').find('#nr_sku_qtde').text();
			var nr_sku_sobra    = $(this).closest('tr').find('#nr_sku_sobra').text();
			var nr_sku_falta    = $(this).closest('tr').find('#nr_sku_falta').text();
			var nr_ac_sku     	= $(this).closest('tr').find('#nr_ac_sku').text();
			var vlr_ini     	= $(this).closest('tr').find('#vlr_ini').text().replace('.','').replace('.','').replace(',','.');
			var vlr_sobra     	= $(this).closest('tr').find('#vlr_sobra').text().replace('.','').replace('.','').replace(',','.');
			var vlr_falta     	= $(this).closest('tr').find('#vlr_falta').text().replace('.','').replace('.','').replace(',','.');
			var vlr_fim     	= $(this).closest('tr').find('#vlr_fim').text().replace('.','').replace('.','').replace(',','.');
			var vlr_div     	= $(this).closest('tr').find('#vlr_div').text();

			$.ajax
			({
				url:"data/dashboard/upd_inv_cl.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					ds_data: 		ds_data,
					nr_sku_qtde: 	nr_sku_qtde,
					nr_sku_sobra: 	nr_sku_sobra,
					nr_sku_falta: 	nr_sku_falta,
					nr_ac_sku: 		nr_ac_sku,
					vlr_ini: 		vlr_ini,
					vlr_sobra: 		vlr_sobra,
					vlr_falta: 		vlr_falta,
					vlr_fim: 		vlr_fim,
					vlr_div: 		vlr_div
				},
				success:function(data)
				{
					alert(data);
					$('#listTbInvCl').load('data/dashboard/modal/list_tb_inv_cl.php?search=',{id_ind:id_ind});
					$('#retInvDep').load('data/dashboard/dash_inv_cl.php');
				}
			});			
			$('#btnSaveUpdInvCl').prop("disabled", false);
		}
	});
	
	$(document).on('click', '#btnCadInvAc',function(){
		$('#retModalInv').load("data/dashboard/modal/m_ins_inv_ac.php");
	});

	$(document).on('click', '#btnSaveInvAc', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveInvAc').prop("disabled", true);
			var ds_mes 			= $('#ds_mes').val();
			var ds_ano 			= $('#ds_ano').val();
			var nr_sku_qtde  	= $('#nr_sku_qtde').val();
			var nr_sku_sobra 	= $('#nr_sku_sobra').val();
			var nr_sku_falta 	= $('#nr_sku_falta').val();
			var nr_ac_sku 		= $('#nr_ac_sku').val();
			var vlr_ini 		= $('#vlr_ini').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_sobra 		= $('#vlr_sobra').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_falta 		= $('#vlr_falta').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_fim 		= $('#vlr_fim').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_div 		= $('#vlr_div').val();

			$.ajax
			({
				url:"data/dashboard/ins_inv_ac.php",
				method:"POST",
				data:{
					ds_ano: 		ds_ano,
					ds_mes: 		ds_mes,
					nr_sku_qtde: 	nr_sku_qtde,
					nr_sku_sobra: 	nr_sku_sobra,
					nr_sku_falta: 	nr_sku_falta,
					nr_ac_sku: 		nr_ac_sku,
					vlr_ini: 		vlr_ini,
					vlr_sobra: 		vlr_sobra,
					vlr_falta: 		vlr_falta,
					vlr_fim: 		vlr_fim,
					vlr_div: 		vlr_div
				},
				success:function(data)
				{
					alert(data);
					$('#retInvDep').load('data/dashboard/dash_inv_ac.php');
				}
			});			
			$('#btnSaveInvAc').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnUpdInvAc',function(){
		var id_ind = $(this).val();
		$('#retModalInv').load('data/dashboard/modal/m_upd_inv_ac.php?search=',{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdInvAc', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdInvAc').prop("disabled", true);
			var id_ind 			= $(this).val();
			var ds_mes 			= $('#ds_mes').val();
			var ds_ano 			= $('#ds_ano').val();
			var nr_sku_qtde  	= $('#nr_sku_qtde').val();
			var nr_sku_sobra 	= $('#nr_sku_sobra').val();
			var nr_sku_falta 	= $('#nr_sku_falta').val();
			var nr_ac_sku 		= $('#nr_ac_sku').val();
			var vlr_ini 		= $('#vlr_ini').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_sobra 		= $('#vlr_sobra').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_falta 		= $('#vlr_falta').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_fim 		= $('#vlr_fim').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_div 		= $('#vlr_div').val();

			$.ajax
			({
				url:"data/dashboard/upd_inv_ac.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					ds_ano: 		ds_ano,
					ds_mes: 		ds_mes,
					nr_sku_qtde: 	nr_sku_qtde,
					nr_sku_sobra: 	nr_sku_sobra,
					nr_sku_falta: 	nr_sku_falta,
					nr_ac_sku: 		nr_ac_sku,
					vlr_ini: 		vlr_ini,
					vlr_sobra: 		vlr_sobra,
					vlr_falta: 		vlr_falta,
					vlr_fim: 		vlr_fim,
					vlr_div: 		vlr_div
				},
				success:function(data)
				{
					alert(data);
					$('#retInvDep').load('data/dashboard/dash_inv_ac.php');
				}
			});			
			$('#btnSaveUpdInvAc').prop("disabled", false);
		}
	});
});

// INDICADORES - SEGURANÇA //

$(document).ready(function(){
	$(document).on('click', '#btnCadIndSeg',function(){
		$('#retModalSeg').load("data/dashboard/modal/m_ins_seg.php");
	});

	$(document).on('click', '#btnSaveSeg', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveSeg').prop("disabled", true);
			var ds_mes 			= $('#ds_mes').val();
			var ds_ano 			= $('#ds_ano').val();
			//var qtd_ipal_prev  	= $('#qtd_ipal_prev').val();
			//var qtd_ipal_exe 	= $('#qtd_ipal_exe').val();
			var nr_irreg_seg 	= $('#nr_irreg_seg').val();
			var nr_acd_fat 		= $('#nr_acd_fat').val();

			$.ajax
			({
				url:"data/dashboard/ins_seg.php",
				method:"POST",
				data:{
					ds_ano: 		ds_ano,
					ds_mes: 		ds_mes,
					//qtd_ipal_prev: 	qtd_ipal_prev,
					//qtd_ipal_exe: 	qtd_ipal_exe,
					nr_irreg_seg: 	nr_irreg_seg,
					nr_acd_fat: 	nr_acd_fat
				},
				success:function(data)
				{
					alert(data);
					$('#retorno_seg').load('data/dashboard/dash_seg.php');
				}
			});			
			$('#btnSaveSeg').prop("disabled", false);
		}
	});

	$(document).on('click', '.btnUpdSeg',function(){
		var id_ind = $(this).val();
		$('#retModalSeg').load('data/dashboard/modal/m_upd_seg.php?search=',{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdSeg', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdSeg').prop("disabled", true);
			var id_ind 			= $(this).val();
			var ds_data     	= $(this).closest('tr').find('#ds_data').text();
			//var qtd_ipal_prev   = $(this).closest('tr').find('#qtd_ipal_prev').text();
			//var qtd_ipal_exe    = $(this).closest('tr').find('#qtd_ipal_exe').text();
			var nr_irreg_seg    = $(this).closest('tr').find('#nr_irreg_seg').text();
			var nr_acd_fat     	= $(this).closest('tr').find('#nr_acd_fat').text();

			$.ajax
			({
				url:"data/dashboard/upd_seg.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					ds_data: 		ds_data,
					//qtd_ipal_prev: 	qtd_ipal_prev,
					//qtd_ipal_exe: 	qtd_ipal_exe,
					nr_irreg_seg: 	nr_irreg_seg,
					nr_acd_fat: 	nr_acd_fat
				},
				success:function(data)
				{
					alert(data);
					$('#retorno_seg').load('data/dashboard/dash_seg.php');
				}
			});			
			$('#btnSaveUpdSeg').prop("disabled", false);
		}
	});

	$(document).on('click','#btnDelSeg',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			$('#btnDelSeg').prop("disabled", true);
			var id_ind = $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_seg.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#retorno_seg').load('data/dashboard/dash_seg.php');
				}
			});

			$('#btnDelSeg').prop("disabled", true);
			return false;
		}

	});
});

// INDICADORES - NOVO LAY-OUT //

$(document).ready(function(){
	$(document).on('dblclick','.indvg',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#retModalPrcNf').load("data/dashboard/modal/m_list_ind_rec.php?search=",{ds_mes:ds_mes});
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnCadRecNf',function(){
		$('#retModalPrcNf').load("data/dashboard/modal/m_ins_ind_rec.php");
	});

	$(document).on('click', '#btnSaveIndRec', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveIndRec').prop("disabled", true);
			var ds_data 	= $('#ds_data').val();
			var nr_nf 		= $('#nr_nf').val();
			var nr_nf_div 	= $('#nr_nf_div').val();

			$.ajax
			({
				url:"data/dashboard/ins_ind_rec.php",
				method:"POST",
				data:{
					ds_data:ds_data,
					nr_nf:nr_nf,
					nr_nf_div:nr_nf_div
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_process_nf.php');
				}
			});			
			$('#btnSaveIndRec').prop("disabled", false);
		}
		return false;
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnCadIndDem',function(){
		$('#retModalPrcNf').load("data/dashboard/modal/m_ins_ind_dem.php");
	});

	$(document).on('click', '#btnSaveIndDem', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveIndDem').prop("disabled", true);
			var ds_data 		= $('#ds_data').val();
			var nr_trans_dep 	= $('#nr_trans_dep').val();
			var nr_dem_proc 	= $('#nr_dem_proc').val();

			$.ajax
			({
				url:"data/dashboard/ins_ind_dem.php",
				method:"POST",
				data:{
					ds_data:ds_data,
					nr_trans_dep:nr_trans_dep,
					nr_dem_proc:nr_dem_proc
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_deem_rec.php');
				}
			});			
			$('#btnSaveIndDem').prop("disabled", false);
		}
		return false;
	});

	$(document).on('click', '#btnUpdDem',function(){
		var id_ind = $(this).val();
		$('#retModalPrcNf').load('data/recebimento/modal/m_upd_ind_dem.php?search=',{id_ind:id_ind});
	});

	$(document).on('click', '.btnSaveUpdIndDem', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			var id_ind 			= $(this).val();
			var nr_trans_dep  	= $(this).closest('tr').find('#nr_trans_dep').text();
			var nr_dem_proc 	= $(this).closest('tr').find('#nr_dem_proc').text();

			$.ajax
			({
				url:"data/dashboard/upd_ind_dem.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_trans_dep:nr_trans_dep,
					nr_dem_proc:nr_dem_proc
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_deem_rec.php');
				}
			});	
		}
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnCadIndCron',function(){
		$('#retModalTransp').load("data/dashboard/modal/m_ins_ind_cron.php");
	});

	$(document).on('click', '#btnSaveIndCron', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveIndCron').prop("disabled", true);
			var ds_data 	= $('#ds_data').val();
			var nr_ped 		= $('#nr_ped').val();
			var nr_at 		= $('#nr_at').val();

			$.ajax
			({
				url:"data/dashboard/ins_ind_cron.php",
				method:"POST",
				data:{
					ds_data:ds_data,
					nr_ped:nr_ped,
					nr_at:nr_at
				},
				success:function(data)
				{
					alert(data);
					$('#retransporte').load('data/dashboard/dash_cron_ent.php');
				}
			});			
			$('#btnSaveIndCron').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnUpdCron',function(){
		var id_ind = $(this).val();
		$('#retModalTransp').load('data/recebimento/modal/m_upd_ind_cron.php?search=',{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdIndCron', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdIndCron').prop("disabled", true);
			var id_ind 	  = $(this).val();
			var ds_mes 	  = $(this).attr("data-mes");
			var nr_ped    = $(this).closest('tr').find('#nr_ped').text();
			var nr_at     = $(this).closest('tr').find('#nr_at').text();

			$.ajax
			({
				url:"data/dashboard/upd_ind_cron.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_ped:nr_ped,
					nr_at:nr_at
				},
				success:function(data)
				{
					alert(data);
					$('#retransporte').load('data/dashboard/dash_cron_ent.php');
					$('#listTbCronAt').load('data/dashboard/modal/list_tb_cron_at.php?search=',{ds_mes:ds_mes});
				}
			});			
			$('#btnSaveUpdIndCron').prop("disabled", false);
		}
	});

	$(document).on('click','#btnDelIndCron',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			
			$('#btnDelIndCron').prop("disabled", true);

			var id_ind = $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_ind_cron.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#retransporte').load('data/dashboard/dash_cron_ent.php');
					$('#listTbCronAt').load('data/dashboard/modal/list_tb_cron_at.php?search=',{id_ind:id_ind});

				}
			});

			$('#btnDelIndCron').prop("disabled", true);
			return false;
		}
	});
});

$(document).ready(function(){

	$(document).on('click','.btnUpdRecNf',function(e) {
		event.preventDefault();
		if(confirm("Confirma a alteração do registro?")){
			var id_ind     = $(this).val();
			var ds_data    = $(this).closest('tr').find('#ds_data').text();
			var nf_rec     = $(this).closest('tr').find('#nf_rec').text();
			var nf_rec_div = $(this).closest('tr').find('#nf_rec_div').text();

			console.log(id_ind,ds_data,nf_rec,nf_rec_div);

			$.ajax
			({  
				url:"data/dashboard/upd_ind_rec.php",  
				method:"POST",  
				data:{
					id_ind    	:id_ind,
					ds_data 	:ds_data,
					nf_rec      :nf_rec,
					nf_rec_div  :nf_rec_div
				},
				success:function(data)
				{

					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_process_nf.php');
					$('#listTbRec').load('data/dashboard/modal/list_tb_ind_rec.php?search=',{id_ind:id_ind});
				}  
			});         
			return false;
		}
	});

	$(document).on('click','#btnDelIndRec',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			$('#btnDelIndRec').prop("disabled", true);

			var id_ind = $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_ind_rec.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_process_nf.php');
					$('#listTbRec').load('data/dashboard/modal/list_tb_ind_rec.php?search=',{id_ind:id_ind});
				}
			});
			$('#btnDelIndRec').prop("disabled", true);
			return false;
		}
	});

});

$(document).ready(function(){
	$(document).on('dblclick','.indDem',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#retModalPrcNf').load("data/dashboard/modal/m_list_ind_dem.php?search=",{ds_mes:ds_mes});
	});

	$(document).on('click','#btnDelIndDem',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			$('#btnDelIndDem').prop("disabled", true);

			var id_ind = $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_ind_dem.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_deem_rec.php');
					$('#listTbDem').load('data/dashboard/modal/list_tb_ind_dem.php?search=',{id_ind:id_ind});
				}
			});
			$('#btnDelIndDem').prop("disabled", true);
			return false;
		}
	});
});

$(document).ready(function(){
	$(document).on('dblclick','.indCronAt',function(){
		event.preventDefault();
		var ds_ind = $(this).attr("data-ind");
		$('#retModalCron').load("data/dashboard/modal/m_list_cron_at.php?search=",{ds_ind:ds_ind});
	});

	$(document).on('click','#btnDelIndDem',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			$('#btnDelIndDem').prop("disabled", true);

			var id_ind = $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_ind_dem.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_deem_rec.php');
					$('#listTbDem').load('data/dashboard/modal/list_tb_ind_dem.php?search=',{id_ind:id_ind});

				}
			});

			$('#btnDelIndDem').prop("disabled", true);
			return false;
		}
	});

	$(document).on('dblclick','.indInvCl',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalInv').load("data/dashboard/modal/m_list_inv_cl.php?search=",{id_ind:id_ind});
	});
});

$(document).ready(function(){
	$(document).on('dblclick','.indTmpExpede',function(){
		event.preventDefault();
		var dt_exp = $(this).attr("data-exp");
		$('#retModalCron').load("data/dashboard/modal/m_list_tmp_exp.php?search=",{dt_exp:dt_exp});
	});

	$(document).on('dblclick','.indSeg',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalSeg').load("data/dashboard/modal/m_list_seg.php?search=",{id_ind:id_ind});
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnCadIndAv',function(){
		$('#modalOutros').load("data/dashboard/modal/m_ins_avaria.php");
	});

	$(document).on('click', '#btnSaveIndAv', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveIndAv').prop("disabled", true);

			$.post("data/dashboard/ins_ind_av.php", $("#forminsIindAvaria").serialize(), function(data) {

				alert(data);
				$('#retorno_outros').load('data/dashboard/dash_avaria.php');

			});

			$('#btnSaveIndAv').prop("disabled", false);
		}
		return false;
	});

	$(document).on('dblclick','.indAv',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#modalOutros').load("data/dashboard/modal/m_list_avaria.php?search=",{ds_mes:ds_mes});
	});

	$(document).on('click', '#btnSaveUpdAv', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdAv').prop("disabled", true);

			var id_ind 	  	= $(this).val();
			var ds_mes 	  	= $(this).attr("data-mes");
			var sku_int    	= $(this).closest('tr').find('#sku_int').text();
			var vlr_int     = $(this).closest('tr').find('#vlr_int').text();
			var sku_for    	= $(this).closest('tr').find('#sku_for').text();
			var vlr_for     = $(this).closest('tr').find('#vlr_for').text();
			var sku_cli    	= $(this).closest('tr').find('#sku_cli').text();
			var vlr_cli     = $(this).closest('tr').find('#vlr_cli').text();
			var sku_total   = $(this).closest('tr').find('#sku_total').text();
			var vlr_total   = $(this).closest('tr').find('#vlr_total').text();

			$.ajax
			({
				url:"data/dashboard/upd_ind_av.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					sku_int:sku_int,
					vlr_int:vlr_int,
					sku_for:sku_for,
					vlr_for:vlr_for,
					sku_cli:sku_cli,
					vlr_cli:vlr_cli, 
					sku_total:sku_total,
					vlr_total:vlr_total
				},
				success:function(data)
				{
					alert(data);
					$('#retorno_outros').load('data/dashboard/dash_avaria.php');
					$('#listTbAv').load('data/dashboard/modal/list_tb_avaria.php?search=',{ds_mes:ds_mes});
				}
			});

			$('#btnSaveUpdAv').prop("disabled", false);
		}
	});

	$(document).on('click','#btnDelAv',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			
			$('#btnDelAv').prop("disabled", true);

			var id_ind 	= $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_ind_av.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#recListIndAv').modal('hide');
					$('#retorno_outros').load('data/dashboard/dash_avaria.php');

				}
			});

			$('#btnDelAv').prop("disabled", true);
			return false;
		}
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnCadIndRev',function(){
		$('#modalOutros').load("data/dashboard/modal/m_ins_reversa.php");
	});

	$(document).on('click', '#btnSaveIndRev', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveIndRev').prop("disabled", true);

			$.post("data/dashboard/ins_ind_reversa.php", $("#forminsIindReversa").serialize(), function(data) {

				alert(data);
				$('#retorno_outros').load('data/dashboard/dash_reversa.php');

			});

			$('#btnSaveIndRev').prop("disabled", false);
		}
		return false;
	});

	$(document).on('dblclick','.indRev',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#modalOutros').load("data/dashboard/modal/m_list_reversa.php?search=",{ds_mes:ds_mes});
	});

	$(document).on('click', '#btnSaveUpdRev', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdRev').prop("disabled", true);

			var id_ind 	  	= $(this).val();
			var ds_mes 	  	= $(this).attr("data-mes");
			var nr_log_rev  = $(this).closest('tr').find('#nr_log_rev').text();
			var log_rev_at  = $(this).closest('tr').find('#log_rev_at').text();

			$.ajax
			({
				url:"data/dashboard/upd_ind_rev.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_log_rev:nr_log_rev,
					log_rev_at:log_rev_at
				},
				success:function(data)
				{
					alert(data);
					$('#retorno_outros').load('data/dashboard/dash_reversa.php');
					$('#listTbRev').load('data/dashboard/modal/list_tb_reversa.php?search=',{ds_mes:ds_mes});
				}
			});

			$('#btnSaveUpdRev').prop("disabled", false);
		}
	});

	$(document).on('click','#btnDelRev',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			
			$('#btnDelRev').prop("disabled", true);

			var id_ind 	= $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_ind_rev.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#recListIndRev').modal('hide');
					$('#retorno_outros').load('data/dashboard/dash_reversa.php');

				}
			});

			$('#btnDelRev').prop("disabled", true);
			return false;
		}
	});
});

$(document).ready(function(){
	$(document).on('click', '#btnCadIndSct',function(){
		$('#modalOutros').load("data/dashboard/modal/m_ins_sucata.php");
	});

	$(document).on('click', '#btnSaveIndSct', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveIndSct').prop("disabled", true);

			$.post("data/dashboard/ins_ind_sucata.php", $("#forminsIindSucata").serialize(), function(data) {

				alert(data);
				$('#retorno_outros').load('data/dashboard/dash_sucata.php');

			});

			$('#btnSaveIndSct').prop("disabled", false);
		}
		return false;
	});

	$(document).on('dblclick','.indSct',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#modalOutros').load("data/dashboard/modal/m_list_sucata.php?search=",{ds_mes:ds_mes});
	});

	$(document).on('click', '#btnSaveUpdSct', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdSct').prop("disabled", true);

			var id_ind 	  		= $(this).val();
			var ds_mes 	  		= $(this).attr("data-mes");
			var nr_total_sct  	= $(this).closest('tr').find('#nr_total_sct').text();
			var nr_sct_div  	= $(this).closest('tr').find('#nr_sct_div').text();

			$.ajax
			({
				url:"data/dashboard/upd_ind_sct.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_total_sct:nr_total_sct,
					nr_sct_div:nr_sct_div
				},
				success:function(data)
				{
					alert(data);
					$('#retorno_outros').load('data/dashboard/dash_sucata.php');
					$('#listTbSct').load('data/dashboard/modal/list_tb_sucata.php?search=',{ds_mes:ds_mes});
				}
			});

			$('#btnSaveUpdSct').prop("disabled", false);
		}
	});

	$(document).on('click','#btnDelSct',function(){
		event.preventDefault();
		if(confirm("Confirma a exclusão?")){
			
			$('#btnDelSct').prop("disabled", true);

			var id_ind 	= $(this).val();

			$.ajax
			({
				url:"data/dashboard/del_ind_sct.php",
				method:"POST",
				data:{
					id_ind:id_ind
				},
				success:function(data){

					alert(data);
					$('#recListIndSct').modal('hide');
					$('#retorno_outros').load('data/dashboard/dash_sucata.php');

				}
			});

			$('#btnDelSct').prop("disabled", true);
			return false;
		}
	});
});

$(document).ready(function(){
	$(document).on('dblclick','.indSku',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#retModalPrcNf').load("data/dashboard/modal/m_list_nf_sku.php?search=",{ds_mes:ds_mes});
	});
});

$(document).ready(function(){
	$(document).on('dblclick','.indAgFor',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#retModalPrcNf').load("data/dashboard/modal/m_list_ag_for.php?search=",{ds_mes:ds_mes});
	});

	$(document).on('click', '#btnSaveUpdAgFor', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdAgFor').prop("disabled", true);

			var id_ind 	  		= $(this).val();
			var ds_mes 	  		= $(this).attr("data-mes");
			var nr_total_sts  	= $(this).closest('tr').find('#nr_total_sts').text();

			$.ajax
			({
				url:"data/dashboard/upd_ag_for.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_total_sts:nr_total_sts
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_ag_for.php');
					$('#listTbAgFor').load('data/dashboard/modal/list_ag_for.php?search=',{ds_mes:ds_mes});
				}
			});

			$('#btnSaveUpdAgFor').prop("disabled", false);
		}
	});

	$(document).on('dblclick','.indAgEx',function(){
		event.preventDefault();
		var ds_mes = $(this).attr("data-mes");
		$('#retModalPrcNf').load("data/dashboard/modal/m_list_ag_ex.php?search=",{ds_mes:ds_mes});
	});

	$(document).on('click', '#btnSaveUpdAgEx', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdAgEx').prop("disabled", true);

			var id_ind 	  		= $(this).val();
			var ds_mes 	  		= $(this).attr("data-mes");
			var nr_total_rec  	= $(this).closest('tr').find('#nr_total_rec').text();
			var nr_total_ex  	= $(this).closest('tr').find('#nr_total_ex').text();

			$.ajax
			({
				url:"data/dashboard/upd_ag_ex.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_total_rec:nr_total_rec,
					nr_total_ex:nr_total_ex
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_ag_ex.php');
					$('#listTbAgEx').load('data/dashboard/modal/list_ag_ex.php?search=',{ds_mes:ds_mes});
				}
			});

			$('#btnSaveUpdAgEx').prop("disabled", false);
		}
	});
});

// CONTROLE DE TRANSPORTE //

$(document).ready(function(){

	$(document).on('dblclick','.indVeicNr',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalTransp').load("data/dashboard/modal/m_list_veic_nr.php?search=",{id_ind:id_ind});
	});

	$(document).on('dblclick','.indVeicFx',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalTransp').load("data/dashboard/modal/m_list_veic_fx.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdVeicNr', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdVeicNr').prop("disabled", true);

			var id_ind 	  		= $(this).val();
			var nr_veic_total  	= $(this).closest('tr').find('#nr_veic_total').text();
			var nr_veic_sp  	= $(this).closest('tr').find('#nr_veic_sp').text();

			$.ajax
			({
				url:"data/dashboard/upd_veic_nr.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_veic_total:nr_veic_total,
					nr_veic_sp:nr_veic_sp
				},
				success:function(data)
				{
					alert(data);
					$('#retransporte').load('data/dashboard/dash_veic_nr.php');
					$('#listTbVeicNr').load('data/dashboard/modal/list_tb_veic_nr.php?search=',{id_ind:id_ind});
				}
			});

			$('#btnSaveUpdVeicNr').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnSaveUpdVeicFx', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdVeicFx').prop("disabled", true);

			var id_ind 	  		= $(this).val();
			var nr_veic_total  	= $(this).closest('tr').find('#nr_veic_total').text();
			var nr_veic_fx  	= $(this).closest('tr').find('#nr_veic_fx').text();

			$.ajax
			({
				url:"data/dashboard/upd_veic_fx.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_veic_total:nr_veic_total,
					nr_veic_fx:nr_veic_fx
				},
				success:function(data)
				{
					alert(data);
					$('#retransporte').load('data/dashboard/dash_veic_nr.php');
					$('#listTbVeicFx').load('data/dashboard/modal/list_tb_veic_fx.php?search=',{id_ind:id_ind});
				}
			});

			$('#btnSaveUpdVeicFx').prop("disabled", false);
		}
	});
});

// UPDATE NF SKU //

$(document).ready(function(){

	$(document).on('click', '#btnSaveUpdNfSku', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){

			$('#btnSaveUpdNfSku').prop("disabled", true);

			var id_ind 	  	 = $(this).val();
			var ds_mes 	  	 = $(this).attr("data-mes");
			var nr_nf_rec    = $(this).closest('tr').find('#nr_nf_rec').text();
			var nr_forn_rec  = $(this).closest('tr').find('#nr_forn_rec').text();
			var nr_sku_rec   = $(this).closest('tr').find('#nr_sku_rec').text();

			$.ajax
			({
				url:"data/dashboard/upd_nf_sku.php",
				method:"POST",
				data:{
					id_ind:id_ind,
					nr_nf_rec:nr_nf_rec,
					nr_forn_rec:nr_forn_rec,
					nr_sku_rec:nr_sku_rec
				},
				success:function(data)
				{
					alert(data);
					$('#retornoPrcNF').load('data/dashboard/dash_nf_sku.php');
					$('#listTbNfSku').load('data/dashboard/modal/list_tb_nf_sku.php?search=',{ds_mes:ds_mes});
				}
			});

			$('#btnSaveUpdNfSku').prop("disabled", false);
		}
	});
});

// INDICADORES - QUALIDADE E TRÂNSITO //

$(document).ready(function(){
	$(document).on('click', '#btnCadIndTran',function(){
		$('#retModalTransp').load("data/dashboard/modal/m_ins_tran.php");
	});

	$(document).on('click', '#btnSaveTran', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveTran').prop("disabled", true);

			$.post("data/dashboard/ins_ind_transito.php", $("#forminsIindTransito").serialize(), function(data) {

				alert(data);
				$('#retransporte').load('data/dashboard/dash_tran.php');

			});

			$('#btnSaveTran').prop("disabled", false);
		}
		return false;
	});

	$(document).on('dblclick','.indTran',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalTransp').load("data/dashboard/modal/m_list_tran.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdTran', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdTran').prop("disabled", true);
			var id_ind 		= $(this).val();
			var nr_prazo    = parseFloat($(this).closest('tr').find('#nr_prazo').text().replace(',','.'));
			var nr_atraso = parseFloat(100 - nr_prazo).toFixed(2);

			$.ajax
			({
				url:"data/dashboard/upd_tran.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					nr_prazo: 		nr_prazo,
					nr_atraso: 		nr_atraso
				},
				success:function(data)
				{
					alert(data);
					$('#retransporte').load('data/dashboard/dash_tran.php');
					$('#listTbTran').load('data/dashboard/modal/list_tb_tran.php?search=',{id_ind:id_ind});
				}
			});
			$('#btnSaveUpdTran').prop("disabled", false);
		}
	});

	$(document).on('click', '#btnCadIndQld',function(){
		$('#retModalSQld').load("data/dashboard/modal/m_ins_qld.php");
	});

	$(document).on('click', '#btnSaveQld', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){
			$('#btnSaveQld').prop("disabled", true);

			$.post("data/dashboard/ins_ind_qualidade.php", $("#forminsIindQualidade").serialize(), function(data) {

				alert(data);
				$('#retorno_qld').load('data/dashboard/dash_qld.php');

			});

			$('#btnSaveQld').prop("disabled", false);
		}
		return false;
	});

	$(document).on('dblclick','.indQld',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalSQld').load("data/dashboard/modal/m_list_qld.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdQld', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdQld').prop("disabled", true);
			var id_ind 		= $(this).val();
			var nr_sku_blq  = $(this).closest('tr').find('#nr_sku_blq').text();
			var vlr_sku_blq = $(this).closest('tr').find('#vlr_sku_blq').text().replace('.','').replace(',','.');
			var nr_est_qld  = $(this).closest('tr').find('#nr_est_qld').text();
			var vlr_est_qld = $(this).closest('tr').find('#vlr_est_qld').text().replace('.','').replace(',','.');

			$.ajax
			({
				url:"data/dashboard/upd_qld.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					nr_sku_blq: 	nr_sku_blq,
					vlr_sku_blq: 	vlr_sku_blq,
					nr_est_qld: 	nr_est_qld,
					vlr_est_qld: 	vlr_est_qld
				},
				success:function(data)
				{
					alert(data);
					$('#retorno_qld').load('data/dashboard/dash_qld.php');
					$('#listTbQld').load('data/dashboard/modal/list_tb_qld.php?search=',{id_ind:id_ind});
				}
			});
			$('#btnSaveUpdQld').prop("disabled", false);
		}
	});

	$(document).on('dblclick','.indQtdAt',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalCron').load("data/dashboard/modal/m_list_qtd_at.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdQtdAt', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveUpdQtdAt').prop("disabled", true);
			var id_ind 		= $(this).val();
			var nr_qtd_sol = $(this).closest('tr').find('#nr_qtd_sol').text().replace(',','.');
			var nr_qtd_at = $(this).closest('tr').find('#nr_qtd_at').text().replace(',','.');

			$.ajax
			({
				url:"data/dashboard/upd_qtd_at.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					nr_qtd_sol: 	nr_qtd_sol,
					nr_qtd_at: 		nr_qtd_at
				},
				success:function(data)
				{
					alert(data);
					$('#retTempoMedio').load('data/dashboard/dash_qtd_at.php');
					$('#listTbQtdAt').load('data/dashboard/modal/list_tb_qtd_at.php?search=',{id_ind:id_ind});
				}
			});
			$('#btnSaveUpdQtdAt').prop("disabled", false);
		}
	});

});

// INDICADORES - OCUPAÇÃO DE ESTOQUE //

$(document).ready(function(){

	$(document).on('dblclick','.ind_ocupa_int',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalOcpInt').load("data/dashboard/modal/m_list_ocupa_int.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '#btnUpOcupInt', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnUpOcupInt').prop("disabled", true);
			var id_ind 			= $(this).val();
			var nr_total_sku  	= $(this).closest('tr').find('#nr_total_sku').text();
			var nr_pos_ocp    	= $(this).closest('tr').find('#nr_pos_ocp').text();
			var nr_ocupa_sku    = $(this).closest('tr').find('#nr_ocupa_sku').text().replace(',','.');
			;

			$.ajax
			({
				url:"data/dashboard/upd_ind_ocp_int.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					nr_total_sku: 	nr_total_sku,
					nr_pos_ocp: 	nr_pos_ocp,
					nr_ocupa_sku: 	nr_ocupa_sku
				},
				success:function(data)
				{
					alert(data);
					$('#retDashOcupa').load('data/dashboard/dash_ocupa_int.php');
					$('#listTbOcpInt').load('data/dashboard/modal/list_tb_ocupa_int.php?search=',{id_ind:id_ind});
				}
			});			
			$('#btnUpOcupInt').prop("disabled", false);
		}
	});

	$(document).on('dblclick','.ind_ocupa_ext',function(){
		event.preventDefault();
		var id_ind = $(this).attr("data-ind");
		$('#retModalOcpInt').load("data/dashboard/modal/m_list_ocupa_ext.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '#btnUpOcupExt', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnUpOcupExt').prop("disabled", true);
			var id_ind 			= $(this).val();
			var nr_total_sku  	= $(this).closest('tr').find('#nr_total_sku').text();
			var nr_pos_ocp    	= $(this).closest('tr').find('#nr_pos_ocp').text();
			var nr_ocupa_sku    = $(this).closest('tr').find('#nr_ocupa_sku').text().replace(',','.');
			;

			$.ajax
			({
				url:"data/dashboard/upd_ind_ocp_ext.php",
				method:"POST",
				data:{
					id_ind: 		id_ind,
					nr_total_sku: 	nr_total_sku,
					nr_pos_ocp: 	nr_pos_ocp,
					nr_ocupa_sku: 	nr_ocupa_sku
				},
				success:function(data)
				{
					alert(data);
					$('#retDashOcupa').load('data/dashboard/dash_ocupa_ext.php');
					$('#listTbOcpExt').load('data/dashboard/modal/list_tb_ocupa_ext.php?search=',{id_ind:id_ind});
				}
			});			
			$('#btnUpOcupExt').prop("disabled", false);
		}
	});

});

// INDICADORES - VALOR DE ESTOQUE //

$(document).ready(function(){

	$(document).on('click', '#btnCadIndVlrEst',function(){
		$('#retModalOcpInt').load("data/dashboard/modal/m_ins_vlr_est.php");
	});

	$(document).on('click', '#btnSaveVlrEst', function(){
		event.preventDefault();
		if(confirm("Confirma o cadastro?")){

			var ds_data 		= $('#ds_data').val();
			var vlr_total 		= $('#vlr_total').val().substring(3).replace('.','').replace('.','').replace(',','.');
			var vlr_medio 		= $('#vlr_medio').val().substring(3).replace('.','').replace('.','').replace(',','.');

			$('#btnSaveVlrEst').prop("disabled", true);

			$.post("data/dashboard/ins_ind_vlr_est.php",{ds_data:ds_data,vlr_total:vlr_total,vlr_medio:vlr_medio},
				function(data) {

					alert(data);
					$('#retDashOcupa').load('data/dashboard/dash_vlr_est.php');

				});

			$('#btnSaveVlrEst').prop("disabled", false);
		}
		return false;
	});

	$(document).on('click','#btnUpdVlrEst',function(){
		event.preventDefault();
		var id_ind = $(this).val();
		$('#retModalOcpInt').load("data/dashboard/modal/m_list_vlr_est.php?search=",{id_ind:id_ind});
	});

	$(document).on('click', '#btnSaveUpdVlrEst', function(){
		event.preventDefault();
		if(confirm("Confirma a alteração?")){
			$('#btnSaveVlrEst').prop("disabled", true);
			var id_ind 		= $(this).val();
			var vlr_total  	= $(this).closest('tr').find('#vlr_total').text().replace('.','').replace('.','').replace(',','.');;
			var vlr_medio   = $(this).closest('tr').find('#vlr_medio').text().replace('.','').replace('.','').replace(',','.');;

			$.ajax
			({
				url:"data/dashboard/upd_vlr_est.php",
				method:"POST",
				data:{
					id_ind: 	id_ind,
					vlr_total: 	vlr_total,
					vlr_medio: 	vlr_medio
				},
				success:function(data)
				{
					alert(data);
					$('#retDashOcupa').load('data/dashboard/dash_vlr_est.php');
					$('#listTbVlrEst').load('data/dashboard/modal/list_tb_vlr_est.php?search=',{id_ind:id_ind});
				}
			});			
			$('#btnSaveVlrEst').prop("disabled", false);
		}
	});

});