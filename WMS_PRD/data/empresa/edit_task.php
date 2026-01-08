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

    $id_task = $_POST['id_task'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();
    
    $update_task = "update tb_task_user set fl_status = 'F', dt_update = now() where id = '$id_task'";

    $res_update = mysqli_query($link, $update_task);

    if($res_update){
 
    include 'modal/sucess_ins_user.php';

    }

    $task="select * from tb_task_user where id_user = '$id' and fl_status = 'A'";
    $res_task = mysqli_query($link,$task);

$link->close();
?>
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
            ?> <!--small class="text-muted pull-right ultra-light"> 2 Minutes ago </small--></a> <?php echo $dados['ds_task'];?> </span>
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
     <?php } ?>
</ul>