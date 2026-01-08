<?php
$nr_pedido = $_POST['nr_pedido'];

require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$cliente = "select t1.produto, t1.cod_cliente, t3.nm_cliente, t3.ds_endereco, t3.ds_bairro, t3.ds_cidade, t3.ds_uf, t3.nr_telefone
from tb_pedido_coleta t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_cliente t3 on t1.cod_cliente = t3.cod_cliente
where t1.nr_pedido = '$nr_pedido'";
$res_cliente = mysqli_query($link,$cliente); 
while($dados_cliente=mysqli_fetch_assoc($res_cliente)){
    $nm_cliente = $dados_cliente['nm_cliente'];
    $ds_endereco = $dados_cliente['ds_endereco'];
    $ds_bairro = $dados_cliente['ds_bairro'];
    $ds_cidade = $dados_cliente['ds_cidade'];
    $ds_uf = $dados_cliente['ds_uf'];
    $nr_telefone = $dados_cliente['nr_telefone'];
        //$multiplo = $dados_cliente['multiplo'];
        //$total_mult = $dados_cliente['multiplo'] * $dados_cliente['nr_qtde'];
}

$destinatario = "select t1.cod_cliente, t1.dt_limite, t2.nm_cliente, t2.ds_endereco, t2.ds_bairro, t2.ds_cidade, t2.ds_uf, t2.nr_telefone 
from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.nr_pedido = '$nr_pedido'";
$res_destino = mysqli_query($link,$destinatario); 
while($dados_destino=mysqli_fetch_assoc($res_destino)){
    $nm_destino = $dados_destino['nm_cliente'];
    $end_destino = $dados_destino['ds_endereco'];
    $cid_destino = $dados_destino['ds_cidade'];
    $uf_destino = $dados_destino['ds_uf'];
    $tel_destino = $dados_destino['nr_telefone'];
    $bairro_destino = $dados_destino['ds_bairro'];
    $dt_limite = $dados_destino['dt_limite'];
}

$total = "select sum(nr_qtde) as total from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
$res_total = mysqli_query($link,$total); 
while($dados_total=mysqli_fetch_assoc($res_total)){
    $total = $dados_total['total'];
}

$pedido = "select t1.*, t2.nm_produto, t2.unid, t2.multiplo  
from tb_pedido_coleta t1 left join tb_produto t2 on t1.produto = t2.cod_produto 
where t1.nr_pedido = '$nr_pedido'";
$res_pedido = mysqli_query($link,$pedido); 

$link->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gisis - WMS</title>
</head>
<body>
    <div class="clearfix"> </div>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="index.php">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Operacional |</span>
                    </li>
                    <li>
                        <span>Expedição |</span>
                    </li>
                    <li>
                        <span>Minuta de transporte</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm hide" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                        <i class="icon-calendar"></i>&nbsp;
                        <span class="thin uppercase hidden-xs"></span>&nbsp;
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>
            </div><br/>
            <div class="row">
               <div class="col-md-12">
                <h5>Minuta de transporte</h5>
            </div>   
            <br><br>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green-haze">
                        <i class="icon-settings font-green-haze"></i>
                        <span class="caption-subject bold uppercase"> Expedição</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">


                 <div id="content">
                    <section id="widget-grid" class="">
                        <div class="row">
                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="jarviswidget well jarviswidget-color-darken" id="wid-id-0" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false" style="background-color: #ffffff">
                                    <header>
                                        <span class="widget-icon"> <i class="fa fa-barcode"></i> </span>
                                        <h4>Pedido <?php echo $nr_pedido; ?> </h4>
                                    </header>
                                    <div>
                                        <div class="jarviswidget-editbox">
                                        </div>
                                        <div class="widget-body no-padding">
                                            <div class="padding-10">
                                                <br>
                                                <div class="pull-left col-sm-3">
                                                    <address>
                                                        <br>
                                                        <strong>Remetente: <?php echo $nm_cliente; ?></strong>
                                                        <br>
                                                        <?php echo $ds_endereco; ?> - <?php echo $ds_bairro; ?>
                                                        <br>
                                                        <?php echo $ds_cidade; ?> - <?php echo $ds_uf; ?>
                                                        <br>
                                                        <abbr title="Phone">Telefone:</abbr> <?php echo $nr_telefone; ?>
                                                    </address>
                                                </div>
                                                <div class="pull-midle col-sm-4">
                                                    <address>
                                                        <br>
                                                        <strong>Destinatário:<?php echo $nm_destino; ?></strong>
                                                        <br>
                                                        <?php echo $end_destino; ?> - <?php echo $bairro_destino; ?>
                                                        <br>
                                                        <?php echo $cid_destino; ?> - <?php echo $uf_destino; ?>
                                                        <br>
                                                        <abbr title="Phone">Telefone:</abbr> <?php echo $tel_destino; ?>
                                                    </address>
                                                </div>
                                                <div class="pull-right col-sm-3">
                                                    <h4>Minuta de transporte</h4>
                                                    <div class="font-md">
                                                <strong>Data de saída:</strong>
                                                <span class="pull-right"> <i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($dt_limite)); ?> </span>
                                            </div>
                                        </div>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">NF</th>
                                                    <th>PRODUTO</th>
                                                    <th>TIPO VOLUME</th>
                                                    <th>VOLUMES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                while($dados_pedido=mysqli_fetch_assoc($res_pedido)){

                                                    if($dados_pedido['multiplo'] > 0){
                                                        $total_itens = $dados_pedido['nr_qtde'] * $dados_pedido['multiplo'];
                                                    } else {
                                                        $total_itens = $dados_pedido['nr_qtde'] * 1;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><strong></strong></td>
                                                        <td><a href="javascript:void(0);"><?php echo $dados_pedido['nm_produto']; ?></a></td>
                                                        <td><?php echo $dados_pedido['unid']; ?></td>
                                                        <td><?php echo $dados_pedido['nr_qtde']; ?></td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="3">Total</td>
                                                    <td><strong><?php echo $total; ?></strong></td>
                                                </tr>
                                                <tr>

                                                </tbody>
                                            </table>
                                            <div class="invoice-footer">

                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <div >
                                                            <h3><strong>Total de volumes: <span class="text-success"><?php echo $total; ?></span></strong></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="note">**Confirmo que recebi as mercadorias constantes nas notas fiscais relacionadas acima.</p>
                                                        <p class="note">
                                                            MOTORISTA:__________________________________
                                                        </p>
                                                        <p class="note">
                                                            ASS:__________________________________
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
            </div>
        </div>

    </div>
