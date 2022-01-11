<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">

	<title>Lucrochê - Pontinhos de Amor</title>
	
	<!-- Tag otimizada padrão para dispositivos móveis -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<!-- Bootstrap css -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- 1º jQuery -->
	<script src="js/jquery-3.5.1.js"></script>
		
	<!-- jQuery -->
	<script src="js/popper.min.js"></script>
		
	<!-- 2º Bootstrap css -->
	<script src="js/bootstrap.js"></script>
	
	<!-- API Alerta Javascript -->
	<script src="js/sweetalert.js"></script>
		
	<link rel="icon" type="image/png" sizes="16x16" href="imagens/icon.png">

</head>

<body>

<?php

	if (isset($_REQUEST["user"])) {

		try{

			// abre a conexao com o BD
			require "conexao.php";
			
				// Receber usuário e senha do formulário
				$user = $_REQUEST["user"];
				$senha = $_REQUEST["senha"];
				
				// Faz a busca no BD de acordo com o usuário digitado
				// Se existir o usuário ele verifica os dados, caso contrário erro !
				$consulta = $conn->prepare("SELECT * FROM user where nome_user=:nome_user");
				$consulta->bindValue(':nome_user',$user);
				$consulta->execute();
					
				//criar um vetor de 1 linha com as informações consultadas no BD
				$row = $consulta->fetch(PDO::FETCH_ASSOC);
					
				// Conta o número de linhas retornadas
				$total_linhas = $consulta->rowCount();
					
				// Verifica se o usuário está cadastrado de acordo com o nome de usuário
				if ($total_linhas == 0) {
						
					echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'error',
								type: 'error',
								title: 'Ops...',
								text: 'Usuário e/ou senha não cadastrados!',
								confirmButtonColor: '#DC143C',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'login';
								}
							})

							</script>";	
							exit;	 
						
				}
				
				// Verifico a senha do Usuário com a função Password Verify
				// Verifica se a senha digitada no form é igual a senha do BD

				if (password_verify($senha, $row["senha"])) {
					
					// inicia a sessão
					session_start();
					
					$_SESSION["user"] = $row["nome_user"];
					
					// Se a senha estiver correta redireciona para a página inicial da área adm
					header("location:adm_inicial");
				
				}else{
					
					echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'error',
								type: 'error',
								title: 'Ops...',
								text: 'Usuário e/ou senha não cadastrados!',
								confirmButtonColor: '#DC143C',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'login';
								}
							})

							</script>";	
							exit;	 
					
				}
			
			// fecha a conexao com BD
			$conn = null;

		}catch (PDOException $erro) {
		echo $erro->getMessage();}

	}

?>

</body>

</html>