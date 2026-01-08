<?php
	session_start();	
	//Incluindo a conexão com banco de dados
	include_once("data/movimento/bd_class.php");

	$objDb = new db();
	$link = $objDb->conecta_mysql();	
	//O campo usuário e senha preenchido entra no if para validar
	if((isset($_POST['username'])) && (isset($_POST['password']))){
		$usuario = mysqli_real_escape_string($link, $_POST['username']); //Escapar de caracteres especiais, como aspas, prevenindo SQL injection
		$senha = mysqli_real_escape_string($link, $_POST['password']);
		//$senha = md5($senha);
			
		//Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário
		$SQL = "select cod_cliente, nm_usuario, avatar, cod_cli from tb_cliente where nm_usuario = '$usuario' and ds_senha = '$senha' and (fl_tipo = 'F' or fl_tipo = 'U' or fl_tipo = 'P') and fl_status = '1' "; 
	    $res = mysqli_query($link,$SQL); 

	    $dados = mysqli_fetch_assoc($res);
		
		//Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		if(isset($dados)){
			$_SESSION['id'] = $dados['cod_cliente'];
			$_SESSION['usuario'] = $dados['nm_usuario'];
			header("Location: home.php");
/*			
			$_SESSION['usuarioNiveisAcessoId'] = $dados['niveis_acesso_id'];
			$_SESSION['usuarioEmail'] = $dados['email'];

			if($_SESSION['usuarioNiveisAcessoId'] == "1"){
				header("Location: administrativo.php");
			}elseif($_SESSION['usuarioNiveisAcessoId'] == "2"){
				header("Location: colaborador.php");
			}else{
				header("Location: home.php");
			}
*/
		//Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		//redireciona o usuario para a página de login
		}else{	
			//Váriavel global recebendo a mensagem de erro
			$_SESSION['loginErro'] = "Usuário ou senha Inválido";
			header("Location: index.php");
		}
	//O campo usuário e senha não preenchido entra no else e redireciona o usuário para a página de login
	}else{
		$_SESSION['loginErro'] = "Usuário ou senha inválido";
		header("Location: index.php");
	}
?>