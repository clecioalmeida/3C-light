<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php   
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_ped = $_GET['cod_ped'];

$dt_relatorio = date('d/m/Y');

$sql_ped = "select t1.nr_pedido, t1.nr_ped_sap, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, t1.cod_almox, upper(t2.ds_nome) as ds_nome, t3.nm_dpto, t1.ds_custo, t2.nr_matricula 
from tb_pedido_coleta t1
left join tb_funcionario t2 on t1.cod_almox = t2.nr_matricula and t2.fl_empresa = '$cod_cli'
left join tb_dpto t3 on t1.ds_custo = t3.cod_sap
 where nr_pedido = '$cod_ped'" or die(mysqli_error($sql_ped));
$res_ped = mysqli_query($link, $sql_ped);

$sql_item = "select t1.produto, round(t1.nr_qtde,0) as nr_qtde, t2.nm_produto 
from tb_pedido_coleta_produto t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.nr_pedido = '$cod_ped' and t1.fl_status <> 'E' and t2.fl_empresa = '$cod_cli'" or die(mysqli_error($sql_item));
$res_item = mysqli_query($link, $sql_item);

$row = mysqli_fetch_assoc($res_ped);

$nr_ped_sap     = $row['nr_ped_sap'];
$dt_pedido      = $row['dt_pedido'];
$cod_almox      = $row['cod_almox'];
$ds_nome        = $row['ds_nome'];
$nm_dpto        = $row['nm_dpto'];
$ds_custo       = $row['ds_custo'];
$nr_matricula   = $row['nr_matricula'];

$logo = "img/logo2.jpg";
$width = "60";
$height = "24";

    $html = '<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title> GrowUp </title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <style type="text/css">
            p {
                font-size: 9px;
                margin: 0;
                text-align: justify;
            }

            table {
                border-left: 0.05em solid #ccc;
                border-right: 0;
                border-top: 0.05em solid #ccc;
                border-bottom: 0;
                border-collapse: collapse;
                font-size: 9px;
                line-height: 1.8;
                font-weight: bold;
            }

            table td,
            table th {
                border-left: 0;
                border-right: 0.05em solid #ccc;
                border-top: 0;
                border-bottom: 0.05em solid #ccc;
            }

            table tr {
                border-left: 0;
                border-right: 0.05em solid #ccc;
                border-top: 0;
                border-bottom: 0.05em solid #ccc;
            }

            .assina {
                border-left: 0.05em solid #ccc;
                border-right: 0.05em solid #ccc;
                border-top: 0.05em solid #ccc;
                border-bottom: 0.05em solid #ccc;
                line-height: 5;
            }

            /*label{
                display:inline-block;
                font:12px Lucida;
                float:left;
                margin-left: 10px
            }
            label input{
              float: left;
            }*/

            .borda {
              border: 4px;
            }


        </style>
    </head>
    <body>
        <div class="row" style="font-size: 9px;color: black;margin-left:20px">
            <table class="users" style="width:100%">
                <tr style = "border>2px">
                    <td><img src="'.$logo.'" width="'.$width.'" height="'.$height.'" alt=""><br></td>
                    <td> Requisição de EPI / EPC / Ferramentas / Materiais</td>
                    <td> Requisição Número: '.$cod_ped.' </td>
                </tr>
                <tr>
                    <td> Data: '.$dt_pedido.'</td>
                    <td colspan="2"></td>
                </tr>                                                               
            </table><br>
            <table style="width:100%">
                <tr>
                    <td> Solicitante: </td>
                    <td> '.$ds_nome.' </td>
                    <td> CR: </td>
                    <td> '.$ds_custo.' </td>
                    <td> Área: </td>
                    <td sytle="text-align:left"> '.$nm_dpto.' </td>
                </tr>               
                <tr>
                    <td colspan="6" style="text-align: center;background-color:grey">Uso exclusivo do Almoxarifado</td>
                </tr>                                                               
            </table><br>
            <table style="width:100%">
                <tr style="height:20px">
                    <td style="width:200px">Dada / hora de recebimento no almoxarifado:</td>
                    <td style="width:30px">_______/_______/_______</td>
                    <td style="width:30px">_________:________</td>
                    <td style="width:200px">Dada / hora de recebimento no almoxarifado:</td>
                    <td style="width:30px">_______/_______/_______</td>
                    <td style="width:30px">_________:________</td>
                </tr>                                                               
            </table><br>
            <table style="width:100%">
                <tr style="height:20px;background-color:grey">
                    <td colspan="3" style="text-align: center">RELAÇÃO DE MATERIAIS</td>
                    <td colspan="3" style="text-align: center">MOVIMENTAÇÃO DE MATERIAIS</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center">Área solicitante</td>
                    <td colspan="3" style="text-align: center">Uso exclusivo do almoxarifado</td>
                </tr>                                                               
            </table><br>
            <table style="width:100%">
                <thead>
                    <tr style="height:20px;background-color:grey">
                        <th style="width:50px">Código</th>
                        <th style="width:50px">Qtde</th>
                        <th style="width:300px">Motivo</th>
						<th colspan="4" style="width:150px">Descontar?</th>
						<th colspan="4" style="width:150px">Mau uso?</th>
                        <th style="width:150px">Posição / endereço</th>
                        <th>CA</th>
                        <th>Assinatura</th>
                    </tr>
                <thead>
            <tbody>';

    while ($dados = mysqli_fetch_assoc($res_item)) {
        $html .= '
                <tr>
                    <td style="text-align:center">'.$dados['produto'].'</td>
                    <td style="text-align:center">'.$dados['nr_qtde'].'</td>
                    <td>'.$dados['nm_produto'].'</td>
                    <td></td>
                    <td><label> Sim</label></td>
                    <td></td>
                    <td><label> Não</label></td>
                    <td></td>
                    <td><label> Sim</label></td>
                    <td></td>
                    <td><label> Não</label></td>
                    <td></td>
                    <td style="text-align:center"></td>
                    <td></td>
                </tr>';
    }

    $html .='</tbody>                                                               
            </table>
            <table style="width:100%">
                <tr>
                    <td colspan="7" style="text-align: center">
                        <p>Declaro para os fins de direito que recebi gratuitamente após orientação de uso e aplicação dos Equipamentos de Proteção Individual-EPI acima descritos os quais me comprometo a utilizar durante a realização de minhas atividades.</p>
                        <p>a) Cumprir as disposições legais e regulamentares sobre segurança e medicina do trabalho, inclusive as ordens de serviços expedidas pelo empregador.</p>
                        <p>b) Usar o EPI fornecido pelo empregador.</p>
                        <p>c) Colaborar com a empresa na aplicação das Normas Regulamentares - NR.</p>
                        <p>1.8.1 - Constitui ato faltoso a recusa injustificada das normas regulamentadoras - NR;
                        <p>NR 06: 6.7 - Cabe ao empregado:</p>
                        <p>6.7.1 - Cabe ao empregado quanto ao EPI</p>
                        <p>a) Usar utilizando-o apenas para a finalidade a que se destina.</p>
                        <p>b) Responsabilizar-se pela guarda e conservação.</p>
                        <p>c) Comunicar ao empregador qualquer alteração que o torne impróprio para uso e,</p>
                        <p>d) cumprir as determinações do empregador sobre o uso adequado.</p>
                        <p>CLT Arg 462: Ao empregador é vetado efetuar qualquer desconto nos salários do empregado, salvo quando este resultar em adiantamentos de dispositivos de lei ou de contrato coletivo.</p>
                        <p>Em caso de dano causado pelo empregado, o desconto será lícito desde que esta possibilidade tenha sido acordada ou na ocorrência de dolo do empregado. </p>
                        <p>Confirmo que estou de acordo com todos os termos presentes, razão pela qual assino por livre e espontânea vontade.</p>
                        <p></p>

                    </td>
                </tr>                                                               
            </table><br>

            <div>
                <p>'.$ds_nome.' - '.$nr_matricula.'</p>
            </div>
            <div class="col-sm-12 assina">
                <p style="text-align: center; vertical-align: top;">Assinatura e Matrícula do Funcionário</p>
            </div>
            <div></div>
        </div>
    </body>
    </html>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/app.config.js"></script>';


    //referenciar o DomPDF com namespace
use Dompdf\Dompdf;

    // include autoloader
require_once("dompdf/autoload.inc.php");

    //Criando a Instancia
$dompdf = new DOMPDF();

    // Carrega seu HTML
$dompdf->load_html($html);
$dompdf->setPaper('A4', 'landscape');

    //Renderizar o html
$dompdf->render();

    //Exibibir a página
$dompdf->stream(
    "REQUISIÇÃO DE MATERIAIS", 
    array(
            "Attachment" => false //Para realizar o download somente alterar para true
        )
);

$link->close();
?>