<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8"/>
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

			// inicializa a sessão
			session_start();

			// Verificar o nome correto das variáveis de sessão
			// ISSET - se uma variável existe (! - negação)

			if(!isset($_SESSION["user"])){

				echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'error',
								type: 'error',
								title: 'Ops...',
								text: 'Sem permissão para acessar!',
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

		?>

	</body>
</html>