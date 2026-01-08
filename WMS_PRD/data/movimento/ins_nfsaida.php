<?php
	require_once('bd_class.php');
	
	$nr_pedido = $_POST['nr_pedido'];
    //$id_destinatario = $_POST['id_destinatario'];
    $nr_nf_formulario = $_POST['nr_nf_formulario'];
	$nr_serie = $_POST['nr_serie'];
	$dt_emissao = $_POST['dt_emissao'];
    $nr_cfop = $_POST['nr_cfop'];
	$ds_obs_nf = $_POST['ds_obs_nf'];
 
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$select="select nr_pedido from tb_nf_saida where nr_pedido = '$nr_pedido'";
    $resultado_sel = mysqli_query($link, $select);
    

    if(mysqli_affected_rows($link) > 0){ ?>
        <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title" id="myModalLabel">Já existe nota fiscal para este pedido!</h4>
	                </div>
	                <div class="modal-body">
	                	<?php echo $nr_pedido;?>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <script>
	        $(document).ready(function () {
	            $('#conf_cadastro').modal('show');
	        });
	    </script>
    <?php }else{
	    		$sql_nsaida = "insert into tb_nf_saida (nr_pedido, nr_nf_formulario, nr_serie, dt_emissao, nr_cfop, ds_obs_nf) values ('$nr_pedido', '$nr_nf_formulario', '$nr_serie', '$dt_emissao', '$nr_cfop', '$ds_obs_nf')";
	            $res_nsaida = mysqli_query($link, $sql_nsaida);
                if(mysqli_affected_rows($link) > 0){ ?>
                    <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Nota fiscal de saída inserida com sucesso!</h4>
                                </div>
                                <div class="modal-body">
                                	<?php
                                		$select_nf="select nr_nf, nr_nf_formulario from tb_nf_saida where nr_pedido = '$nr_pedido'";
    									$resultado_nf = mysqli_query($link, $select_nf);
    									while ($dados_nf=mysqli_fetch_assoc($resultado_nf)) {
    										$nr_nf=$dados_nf['nr_nf_formulario'];?>
    										Nota fiscal número: <?php echo $nr_nf; ?>, pedido número: <?php echo $nr_pedido;?>
    									<?php }
    								?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#conf_cadastro').modal('show');
                        });
                    </script>
               <?php } else { ?>
                            <div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                                        </div>
                                        <div class="modal-body">                                
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>          
                            <script>
                                $(document).ready(function () {
                                    $('#conf_cadastro').modal('show');
                                });
                            </script>
              <?php  }

    }
    
    $link->close();
    ?>