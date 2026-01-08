<?php
/* prepara o documento para comunicação com o JSON, as duas linhas a seguir são obrigatórias 
	  para que o PHP saiba que irá se comunicar com o JSON, elas sempre devem estar no ínicio da página */
header("Content-Type: application/json; charset=utf-8");
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");
require 'dados_conexao.php';
$conexao = Conexao::getInstance();

$dt_ini = $_POST['dt_ini'];
$dt_fim = $_POST['dt_fim'];

try {
    $sql = "SELECT id, id_produto, n_serie, nm_fornecedor FROM tb_nserie WHERE date(dt_create) >= ? and date(dt_create) <= ?";
    $stm = $conexao->prepare($sql);
    $stm->bindValue(1, $dt_ini);
    $stm->bindValue(2, $dt_fim);
    $stm->execute();

    $resultadoDaConsulta = $stm->fetchAll();

    //var_dump($resultadoDaConsulta);

    $StringJson = "[";
    if (count($resultadoDaConsulta)) {

        // Gera arquivo CSV
        $fp = fopen("../../../arquivos/numeros_de_serie - ".$dt_ini."-".$dt_fim.".csv", "a"); // o "a" indica que o arquivo será sobrescrito sempre que esta função for executada.
        $escreve = fwrite($fp, "id;Material;Serial;Fornecedor");

        foreach ($resultadoDaConsulta as $registro) {
            $escreve = fwrite($fp, "\n$registro[id];$registro[id_produto];$registro[n_serie];$registro[nm_fornecedor]");
            if ($StringJson != "[") {
                $StringJson .= ",";
            }
            $StringJson .= '{"id":"' . $registro['id']  . '",';
            $StringJson .= '"id_produto":"' . $registro['id_produto']  . '",';
            $StringJson .= '"n_serie":"' . $registro['n_serie']    . '",';
            $StringJson .= '"nm_fornecedor":"' . $registro['nm_fornecedor'] . '"}';
        }
        //echo $StringJson . "]"; // Exibe o vettor JSON
        $StringJson .= "]";
        //echo $StringJson;

        $arquivo = "numeros_de_serie - ".$dt_ini."-".$dt_fim.".csv";

		$retorno = array(
			'info' => "0",
			'arquivo' => $arquivo,
		);

		echo json_encode($retorno);
        //echo "0";
        
        fclose($fp);
        // Converte para XLS
        /*include("data/recebimento/PHPExcel/Classes/PHPExcel/IOFactory.php");
        $objReader = PHPExcel_IOFactory::createReader('CSV');
        $objReader->setDelimiter(";"); // define que a separação dos dados é feita por ponto e vírgula
        $objReader->setInputEncoding('UTF-8'); // habilita os caracteres latinos.
        $objPHPExcel = $objReader->load('numeros_de_serie.csv'); //indica qual o arquivo CSV que será convertido
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('numeros_de_serie.xls'); // Resultado da conversão; um arquivo do EXCEL  */


    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); // opcional, apenas para teste
}
