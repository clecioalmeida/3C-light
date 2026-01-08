<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

$id = "";
$cod_cli = "";
$id_rec = $_POST["id_rec"];

$diretorio = "pdf/$id_rec";

if(!is_dir($diretorio)){ 

	mkdir("pdf/".$id_rec,0777);

	if(is_dir($diretorio)){

		$arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;
		for ($controle = 0; $controle < count($arquivo['name']); $controle++){

			$destino = $diretorio."/".$arquivo['name'][$controle];
			$FileType = strtolower(pathinfo($destino,PATHINFO_EXTENSION));

			if (file_exists($destino)) {

				echo "O arquivo $arquivo existe";

			}else{

				if($FileType != "pdf") {

					echo "Somente arquivos PDF são permitidos.";

				}else{

					if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){

						echo "Upload realizado com sucesso<br>";

						$nome = $arquivo['name'][$controle];

						$origem =$diretorio.$arquivo['name'][$controle];
						echo $origem."<br>";			

					}else{

						echo "Erro ao realizar upload.<br>";

					}
				}

			}

		}

	}else{

		echo "Falha no upload.<br>";

	}

}else{

	$arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++){

		$destino = $diretorio."/".$arquivo['name'][$controle];
		$FileType = strtolower(pathinfo($destino,PATHINFO_EXTENSION));

		if (file_exists($destino)) {

			echo "O arquivo $destino já existe.<br>";

		}else{

			if($FileType != "pdf") {

				echo "Somente arquivos PDF são permitidos.";

			}else{

				if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){

					echo "Upload realizado com sucesso<br>";

					$nome = $arquivo['name'][$controle];

					$origem =$diretorio.$arquivo['name'][$controle];
					echo $origem."<br>";			

				}else{

					echo "Erro ao realizar upload.<br>";

				}
			}

		}

	}

}