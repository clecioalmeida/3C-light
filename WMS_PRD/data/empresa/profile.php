<?php
	session_start();	
?>
<?php

	if(isset($_SESSION["id"]) || isset($_SESSION["usuario"])){

		$id=$_SESSION["id"];

	}else{
		
		echo "<script>alert('Você não está logado!')</script>";
	}

?>
<?php

	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$user="select t1.nm_cliente, t1.avatar, t1.fl_nivel, t1.nr_telefone, t1.ds_email, t1.ds_skype, t2.nm_cargo 
	from tb_cliente t1
	left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
	 where cod_cliente = '$id'";
	$usuario = mysqli_query($link,$user);
	while ($dados=mysqli_fetch_assoc($usuario)) {
		$user=$dados['nm_cliente'];
		$img_user=$dados['avatar'];
		$nr_telefone=$dados['nr_telefone'];
		$ds_email=$dados['ds_email'];
		$ds_skype=$dados['ds_skype'];
		if($dados['fl_nivel'] == 'A'){

			$fl_nivel = 'Administrador de sistemas';

		}elseif($dados['fl_nivel'] == '3'){

			$fl_nivel = 'Coordenação';

		}elseif($dados['fl_nivel'] == '1'){

			$fl_nivel = 'Operação';

		}
	}

	$task="select * from tb_task_user where id_user = '$id' and fl_status = 'A'";
	$res_task = mysqli_query($link,$task);
$link->close();
?>
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<!--span class="ribbon-button-alignment"> 
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span> 
				</span-->

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>Home</li><li>Profile</li><li><?php echo $user;?></li>
				</ol>
				<!-- end breadcrumb -->

				<!-- You can also add more buttons to the
				ribbon for further usability

				Example below:

				<span class="ribbon-button-alignment pull-right">
				<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
				<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
				<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
				</span> -->

			</div>
			<!-- END RIBBON -->

			<!-- MAIN CONTENT -->
			<div id="content">

				<!-- Bread crumb is created dynamically -->
				<!-- row -->
				<div class="row">
				
					<!-- col -->
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --> Empresa <span> |
							Perfil </span></h1>
					</div>
					<!-- end col -->
				
					<!-- right side of the page with the sparkline graphs -->
					<!-- col -->
				
				</div>
				<!-- end row -->
				
				<!-- row -->
				
				<div class="row">
				
					<div class="col-sm-12">
				
				
							<div class="well well-sm">
				
								<div class="row">
				
									<div class="col-sm-12 col-md-12 col-lg-6">
										<div class="well well-light well-sm no-margin no-padding">
				
											<div class="row">
				
												<div class="col-sm-12">
													<div id="myCarousel" class="carousel fade profile-carousel">
														<div class="air air-bottom-right padding-10">
															<!--a href="javascript:void(0);" class="btn txt-color-white bg-color-teal btn-sm"><i class="fa fa-check"></i> Follow</a>&nbsp; <a href="javascript:void(0);" class="btn txt-color-white bg-color-pinkDark btn-sm"><i class="fa fa-link"></i> Connect</a-->
														</div>
														<div class="air air-top-left padding-10">
															<!--h4 class="txt-color-white font-md">Jan 1, 2014</h4-->
														</div>
														<ol class="carousel-indicators">
															<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
															<li data-target="#myCarousel" data-slide-to="1" class=""></li>
															<li data-target="#myCarousel" data-slide-to="2" class=""></li>
														</ol>
														<div class="carousel-inner">
															<!-- Slide 1 -->
															<div class="item active">
																<img src="img/demo/s3.jpg" alt="demo user">
															</div>
															<!-- Slide 2 -->
															<div class="item">
																<img src="img/demo/s2.jpg" alt="demo user">
															</div>
															<!-- Slide 3 -->
															<div class="item">
																<img src="img/demo/s1.jpg" alt="demo user">
															</div>
														</div>
													</div>
												</div>
				
												<div class="col-sm-12">
				
													<div class="row">
				
														<div class="col-sm-3 profile-pic">
															<img src="img/avatars/<?php echo $img_user;?>" alt="demo user">
															<div class="padding-10">
																<h4 class="font-md">
																<br>
																<small><button type="submit" class="btn btn-xs btn-default text-muted pull-right" id="btnUpdPass" value="<?php echo $id;?>">Alterar senha</button></small></h4>
																<br>
																<h4 class="font-md">
																<br>
																</h4>
															</div>
														</div>
														<div class="col-sm-6">
															<h1><?php echo $user;?>
															<br>
															<small> <?php echo $fl_nivel;?>, 3C Services - Bauru</small></h1>
				
															<ul class="list-unstyled">
																<li>
																	<p class="text-muted">
																		<i class="fa fa-phone"></i>&nbsp;&nbsp;<span class="txt-color-darken"><?php echo $nr_telefone;?></span>
																	</p>
																</li>
																<li>
																	<p class="text-muted">
																		<i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="mailto:simmons@smartadmin"><?php echo $ds_email;?></a>
																	</p>
																</li>
																<li>
																	<p class="text-muted">
																		<i class="fa fa-skype"></i>&nbsp;&nbsp;<span class="txt-color-darken"><?php echo $ds_skype;?></span>
																	</p>
																</li>
																<!--li>
																	<p class="text-muted">
																		<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span class="txt-color-darken">Free after <a href="javascript:void(0);" rel="tooltip" title="" data-placement="top" data-original-title="Create an Appointment">4:30 PM</a></span>
																	</p>
																</li-->
															</ul>
															<br>
															<!--p class="font-md">
																<i>A little about me...</i>
															</p>
															<p>
				
																Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio
																cumque nihil impedit quo minus id quod maxime placeat facere
				
															</p-->
															<br>
															<!--a href="javascript:void(0);" class="btn btn-default btn-xs"><i class="fa fa-envelope-o"></i> Send Message</a-->
															<br>
															<br>
				
														</div>
														<div class="col-sm-3">
															<!--h1><small>Connections</small></h1>
															<ul class="list-inline friends-list">
																<li><img src="img/avatars/1.png" alt="friend-1">
																</li>
																<li><img src="img/avatars/2.png" alt="friend-2">
																</li>
																<li><img src="img/avatars/3.png" alt="friend-3">
																</li>
																<li><img src="img/avatars/4.png" alt="friend-4">
																</li>
																<li><img src="img/avatars/5.png" alt="friend-5">
																</li>
																<li><img src="img/avatars/male.png" alt="friend-6">
																</li>
																<li>
																	<a href="javascript:void(0);">413 more</a>
																</li>
															</ul>
				
															<h1><small>Recent visitors</small></h1>
															<ul class="list-inline friends-list">
																<li><img src="img/avatars/male.png" alt="friend-1">
																</li>
																<li><img src="img/avatars/female.png" alt="friend-2">
																</li>
																<li><img src="img/avatars/female.png" alt="friend-3">
																</li>
															</ul-->
				
														</div>
				
													</div>
				
												</div>
				
											</div>
				
											<div class="row">
				
												<div class="col-sm-12">
				
													<hr>
				
													<div class="padding-10">
				
														<ul class="nav nav-tabs tabs-pull-right">
															<!--li class="active">
																
															</li>
															<li>
																<a href="#a2" data-toggle="tab">New Members</a>
															</li>
															<li class="pull-left">
																<span class="margin-top-10 display-inline"><i class="fa fa-rss text-success"></i> Activity</span>
															</li-->
														</ul>
				
														<div class="tab-content padding-top-10">
															<!--div class="tab-pane fade in active" id="a1">
				
																<div class="row">
				
																	<div class="col-xs-2 col-sm-1">
																		<time datetime="2014-09-20" class="icon">
																			<strong>Jan</strong>
																			<span>10</span>
																		</time>
																	</div>
				
																	<div class="col-xs-10 col-sm-11">
																		<h6 class="no-margin"><a href="javascript:void(0);">Allice in Wonderland</a></h6>
																		<p>
																			Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi Nam eget dui.
																			Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero,
																			sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel.
																		</p>
																	</div>
				
																	<div class="col-sm-12">
				
																		<hr>
				
																	</div>
				
																	<div class="col-xs-2 col-sm-1">
																		<time datetime="2014-09-20" class="icon">
																			<strong>Jan</strong>
																			<span>10</span>
																		</time>
																	</div>
				
																	<div class="col-xs-10 col-sm-11">
																		<h6 class="no-margin"><a href="javascript:void(0);">World Report</a></h6>
																		<p>
																			Morning our be dry. Life also third land after first beginning to evening cattle created let subdue you'll winged don't Face firmament.
																			You winged you're was Fruit divided signs lights i living cattle yielding over light life life sea, so deep.
																			Abundantly given years bring were after. Greater you're meat beast creeping behold he unto She'd doesn't. Replenish brought kind gathering Meat.
																		</p>
																	</div>
				
																	<div class="col-sm-12">
				
																		<br>
				
																	</div>
				
																</div>
				
															</div-->
															<!--div class="tab-pane fade" id="a2">
				
																<div class="alert alert-info fade in">
																	<button class="close" data-dismiss="alert">
																		×
																	</button>
																	<i class="fa-fw fa fa-info"></i>
																	<strong>51 new members </strong>joined today!
																</div>
				
																<div class="user" title="email@company.com">
																	<img src="img/avatars/female.png" alt="demo user"><a href="javascript:void(0);">Jenn Wilson</a>
																	<div class="email">
																		travis@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Marshall Hitt</a>
																	<div class="email">
																		marshall@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Joe Cadena</a>
																	<div class="email">
																		joe@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Mike McBride</a>
																	<div class="email">
																		mike@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Travis Wilson</a>
																	<div class="email">
																		travis@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Marshall Hitt</a>
																	<div class="email">
																		marshall@company.com
																	</div>
																</div>
																<div class="user" title="Joe Cadena joe@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Joe Cadena</a>
																	<div class="email">
																		joe@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Mike McBride</a>
																	<div class="email">
																		mike@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Marshall Hitt</a>
																	<div class="email">
																		marshall@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);">Joe Cadena</a>
																	<div class="email">
																		joe@company.com
																	</div>
																</div>
																<div class="user" title="email@company.com">
																	<img src="img/avatars/male.png" alt="demo user"><a href="javascript:void(0);"> Mike McBride</a>
																	<div class="email">
																		mike@company.com
																	</div>
																</div>
				
																<div class="text-center">
																	<ul class="pagination pagination-sm">
																		<li class="disabled">
																			<a href="javascript:void(0);">Prev</a>
																		</li>
																		<li class="active">
																			<a href="javascript:void(0);">1</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);">2</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);">3</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);">...</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);">99</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);">Next</a>
																		</li>
																	</ul>
																</div>
				
															</div--><!-- end tab -->
														</div>
				
													</div>
				
												</div>
				
											</div>
											<!-- end row -->
				
										</div>
				
									</div>
									<div class="col-sm-12 col-md-12 col-lg-6">
				
										<form method="post" id="formCadTask" class="well padding-bottom-10">
											<input type="hidden" name="id_user" value="<?php echo $id;?>">
											<textarea rows="5" class="form-control" name="ds_task" placeholder="Lembretes e atividades"></textarea>
											<div class="margin-top-10">
												<button type="submit" class="btn btn-sm btn-primary pull-right" id="btnInsTask">
													Salvar
												</button>
												<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add Location"><!--i class="fa fa-location-arrow"></i--></a>
												<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add Voice"><!--i class="fa fa-microphone"></i--></a>
												<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add Photo"><!--i class="fa fa-camera"></i--></a>
												<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add File"><!--i class="fa fa-file"></i--></a>
											</div>
											
										</form>

										<div class="timeline-seperator text-center">
											<div class="btn-group pull-right">
											</div> 
										</div>
										<div class="chat-body no-padding profile-message" id="retorno_task">
											<ul>
												<?php
													while ($dados=mysqli_fetch_assoc($res_task)) {
												?>
												<li class="message">
													<span class="message-text"> <a href="javascript:void(0);" class="username"><?php 
														if($dados['dt_limite'] > 0){
															echo date('d-m-Y', strtotime($dados['dt_limite']));
														}else{
															echo "Sem data definida";
														}
													?></a> <?php echo $dados['ds_task'];?> </span>
													<ul class="list-inline font-xs">
														<li id="concluir">
															<button type="submit" class="btn btn-xs btn-success text-muted pull-right" id="btnFimTask" value="<?php echo $dados['id'];?>">Concluir</button>
														</li>
														<li>
															<button type="submit" class="btn btn-xs btn-primary text-muted pull-right" id="btnUpdTask" value="<?php echo $dados['id'];?>">Editar</button>
														</li>
														<li>
															<button type="submit" class="btn btn-xs btn-danger text-muted pull-right" id="btnDelTask" value="<?php echo $dados['id'];?>">Excluir</button>
														</li>
													
													</ul>
												</li>
											</ul>
											<?php } ?>
										</div>
										
										<div class="timeline-seperator text-center">
										</div>
										<div class="chat-body no-padding profile-message">
				
										</div>
				
				
									</div>
								</div>
				
							</div>
							
				
					</div>
				
				</div>
				
				<!-- end row -->

			</div>
			<!-- END MAIN CONTENT -->
			<div id="retorno_upd"></div>
		</div>