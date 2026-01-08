<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$minuta = $_POST['minuta'];


$sql = "select * from tb_minuta";
$res_minuta = mysqli_query($link,$sql); 
$min = mysqli_num_rows($res_minuta);
$link->close();
?>
<section class="panel col-lg-12">
    <?php
    if($min>0){
    ?>
    <div id="retExp"></div>
    <br><br>
    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
        <thead>
            <tr>
                <th> Minuta</th>
                <th> Veículo </th>
                <th> Placa </th>
                <th> Motorista </th>
                <th> Data </th>
                <th> Status</th>
                <th colspan="3"> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($dados = mysqli_fetch_assoc($res_minuta)) {
                ?>
                <tr class="odd gradeX">
                    <td style="text-align: center; width: 10px"><?php echo $dados['cod_minuta']; ?></td>
                    <td><?php echo $dados['ds_carro']; ?></td>
                    <td><?php echo $dados['nr_placa']; ?></td>
                    <td><?php echo $dados['nm_motorista']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($dados['dt_minuta'])); ?></td>
                    <td><?php echo $dados['fl_expedido']; ?></td>
                    <td style="text-align: center">
                        <button type="submit" id="btnPrintMin" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_minuta']; ?>">Imprimir</button>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>


    <div id="retornoExpede"></div>
    <?php }else{?>
    
    <h4>Nao foram encontrados pedidos com esta descrição.</h4>
    
    <?php }
    ?>
</section>