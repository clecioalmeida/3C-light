<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
$year = date("Y");

require_once 'data/empresa/bd_class_req.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$diretorio = "sap/";
$tab = "\t";
if(!is_dir($diretorio)){ 
	echo "Pasta $diretorio nao existe";
}else{
	$arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++){
		
		$destino = $diretorio."/".$arquivo['name'][$controle];
		if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){

			echo "Upload realizado com sucesso<br>";

			$nome = $arquivo['name'][$controle];

			$origem =$diretorio.$arquivo['name'][$controle];
			echo $origem."<br>";

			$arquivo2 = fopen($origem, 'r');
			
			while(!feof($arquivo2)){
				$linha = fgets($arquivo2, 1024);

				$dados = str_getcsv($linha,$tab);

				if($dados[0] != 'ds_nome' && !empty($linha)){

					$nm_forn 			= strtoupper($dados[0]);
					$fl_empresa 		= $dados[1];

					$temp = explode(" ",$nm_forn);

					$nomeNovo = strtolower($temp[0] . "." . $temp[count($temp)-1]);

					$string = $nm_forn;
					$iniciais = strstr($string, ' ', true)[0] . trim(strstr($string, ' ')[1]);
					$senha1 = strtolower($iniciais.$year."#");
					$ds_senha = password_hash($senha1, PASSWORD_DEFAULT);

					$sql = "insert into tb_acesso (ds_nome, ds_usuario, ds_senha, id_oper, fl_status, fl_nivel) values (upper('$nm_forn'), '$nomeNovo', '$ds_senha', '$fl_empresa', 'A', '5')";
					$resultado_id = mysqli_query($link, $sql);

					echo "NOME: ".$nm_forn."<br>";
					echo "LOGIN: ".$nomeNovo."<br>";
					echo "SENHA: ".$senha1."<br>";
					echo "<hr>";
				}
			}

			fclose($arquivo2);

			/*$importado = 'sap/importados/'.$nome;
			copy($origem, $importado);
			unlink($origem);*/

		}else{

			echo "Erro ao realizar upload";

		}

	}
}

$link->close();
$link1->close();
$link2->close();
?>