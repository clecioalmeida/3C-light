<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$local = $_POST['local'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql = "select t1.*, t2.nome 
from tb_endereco t1
left join tb_armazem t2 on t1.galpao = t2.id
where t1.galpao = '$local'";
$res_local = mysqli_query($link,$sql);

$link->close();
?>
<header>
    <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
    <h2>Relação de endereços</h2>
</header>
<div>
    <div class="widget-body no-padding">
        <div id="retorno"></div>                                                        
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> Ações </th>
                    <th> Código</th>
                    <th> Galpão </th>
                    <th> Rua </th>
                    <th> Coluna </th>
                    <th> Altura </th>
                    <th> Tipo </th>
                    <th> Peso limite </th>
                    <th> Cubagem limite </th>
                    <th> Bloqueado </th>
                    <th> Situação </th>
                </tr>
            </thead>
            <tbody>
                <?php while($dados = mysqli_fetch_array($res_local)) {?>
                    <tr class="odd gradeX">
                        <td style="text-align: center;width: 150px">  
                            
                        </td>
                        <td style="text-align: center; width: 10px"> 
                            <?php echo $dados['id']; ?> 
                        </td>
                        <td> 
                            <?php echo $dados['nome']; ?> 
                        </td>
                        <td> 
                            <?php echo $dados['rua']; ?> 
                        </td>
                        <td> 
                            <?php echo $dados['coluna']; ?> 
                        </td>
                        <td> 
                             <?php echo $dados['altura']; ?> 
                        </td>
                        <td> 
                            
                        </td>
                        <td> 
                            <?php echo $dados['peso']; ?> 
                        </td>
                        <td> 
                            
                        </td>
                        <td> 
                            <?php echo $dados['fl_bloq']; ?> 
                        </td>
                        <td> 
                            <?php
                            if ($dados['fl_status'] == 'A'){
                                echo 'Ativo';
                            }else{
                                echo 'Inativo';
                            }
                            ?>  
                        </td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>                                                        
    </div>
</div>