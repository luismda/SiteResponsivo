<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">

	<title>Lucrochê - Pontinhos de Amor</title>
	
		<link href="css/estilo.css" type="text/css" rel="stylesheet">
		
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.13/css/all.css'>
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
	
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
		
		<link rel="icon" type="image/png" sizes="16x16" href="imagens/icon.png">

</head>

	<body style="background:url(imagens/bg.png);">

		<div class="container-fluid">
		
			<div class="row" style="margin-top: 125px;">
			
				<div class="col-md-4"></div>
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Login Administrador</h2>
						
						<form name="frm" method="post" action="checalogin">
						
							<p><input type="text" name="user" class="form-control" placeholder="Usuário"></p>
							<p><input type="password" name="senha" class="form-control" placeholder="Senha"></p>
							<p class="text-center"><input type="submit" name="BtnEntrar" value="Entrar" class="btn btn-outline-danger"></p>
						
						</form>
						
					  </div>
					</div>
				
				</div>
				
				<div class="col-md-4"></div>
			
			</div>
		
		</div>
		
	</body>
	
</html>