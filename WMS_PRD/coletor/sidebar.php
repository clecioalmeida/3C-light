<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        <li class="sidebar-search-wrapper">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                            <form class="sidebar-search hide" action="#" method="POST">
                                <a href="javascript:;" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                                </div>
                            </form>
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                        </li>
                        <li class="nav-item start active open">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Indicadores</span>
                                <span class="selected"></span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start">
                                    <a href="dashboard_atendimento.php" class="nav-link ">
                                        <i class="fa fa-thumbs-o-up"></i>
                                        <span class="title">Atendimento</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="dashboard_estoque.php" class="nav-link ">
                                        <i class="fa fa-industry"></i>
                                        <span class="title">Estoques</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="dashboard_ocupacao_estoque.php" class="nav-link ">
                                        <i class="fa fa-industry"></i>
                                        <span class="title">Ocupação do estoque</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="#" class="nav-link ">
                                        <i class="fa fa-truck"></i>
                                        <span class="title">Transportes</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item start active navbar-collapse">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-globe"></i>
                                <span class="title">Cadastros</span>
                                <span class="selected"></span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start">
                                    <a href="entidades.php" class="nav-link ">
                                        <i class="icon-frame"></i>
                                        <span class="title">Entidades</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
								<li class="nav-item start">
                                    <a href="empresas.php" class="nav-link ">
                                        <i class="icon-briefcase"></i>
                                        <span class="title">Empresas</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>

								<li class="nav-item start">
                                    <a href="armazem.php" class="nav-link ">
                                        <i class="icon-folder-alt"></i>
                                        <span class="title">Armazém</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>

								<li class="nav-item start">
                                    <a href="produtos.php" class="nav-link ">
                                        <i class="icon-basket-loaded"></i>
                                        <span class="title">Produtos</span>
                                        <!--span class="selected"></span-->
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item start active navbar-collapse">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-cogs"></i>
                                <span class="title">Operacional</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start">
                                    <a href="recebimento.php" class="nav-link ">
                                        <i class="fa fa-arrow-circle-right"></i>
                                        <span class="title">Recebimento</span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="movimento.php" class="nav-link ">
                                        <i class="fa fa-arrows-alt"></i>
                                        <span class="title">Movimentação</span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="expedicao.php" class="nav-link ">
                                        <i class="fa fa-arrow-circle-left"></i>
                                        <span class="title">Expedição</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="relatorio.php" class="nav-link ">
                                        <i class="fa fa-file-text"></i>
                                        <span class="title">Relatórios</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item start">
                                            <a href="dashboard_atendimento.php" class="nav-link ">
                                                <i class="fa fa-thumbs-o-up"></i>
                                                <span class="title">Atendimento</span>
                                                <span class="selected"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item start">
                                            <a href="dashboard_estoque.php" class="nav-link ">
                                                <i class="fa fa-industry"></i>
                                                <span class="title">Estoques</span>
                                                <span class="selected"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item start">
                                            <a href="dashboard_ocupacao_estoque.php" class="nav-link ">
                                                <i class="fa fa-industry"></i>
                                                <span class="title">Ocupação do estoque</span>
                                                <span class="selected"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item start">
                                            <a href="#" class="nav-link ">
                                                <i class="fa fa-truck"></i>
                                                <span class="title">Transportes</span>
                                                <!--span class="selected"></span-->
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item start active">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-line-chart"></i>
                                <span class="title">Inventário</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start">
                                    <a href="inv_parametro.php" class="nav-link ">
                                        <i class="fa fa-clipboard"></i>
                                        <span class="title">Parâmetros</span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="inv_programacao.php" class="nav-link ">
                                        <i class="fa fa-calendar"></i>
                                        <span class="title">Programação</span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="inv_historico.php" class="nav-link ">
                                        <i class="fa fa-archive"></i>
                                        <span class="title">Histórico</span>
                                    </a>
                                </li>
                                <li class="nav-item start">
                                    <a href="#" class="nav-link ">
                                        <i class="fa fa-file-text"></i>
                                        <span class="title">Relatórios</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->

