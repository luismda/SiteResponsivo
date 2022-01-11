<?php require "acesso_restrito.php"; ?>

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
		
		<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
		<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		
		<script src="js/sweetalert.js"></script>
		
		<link rel="icon" type="image/png" sizes="16x16" href="imagens/icon.png">

</head>

	<body style="background:url(imagens/bg.png);">
		
		<?php
			// Consulta para recuperar as informações para o Formulário

			if (isset($_REQUEST["al"])) {

				try{

					// abrir a conexao com BD
					require "conexao.php";
						
						// receber o valor do parâmetro da url
						$iduser = $_REQUEST["al"];

						$consulta = $conn->prepare ("SELECT * FROM user where iduser=:iduser");
						$consulta->bindValue(":iduser",$iduser);

						$consulta->execute();

						// recupera apenas uma linha da tabela. (sem o while - apenas uma linha)
						$row = $consulta->fetch (PDO::FETCH_ASSOC);
						
					// fechar a conexao com BD
					$conn = null;

				}catch (PDOException $erro) {
				echo $erro->getMessage();}

			}
		?>
		
		<div class="container-fluid">
			
			<div class="row" style="margin-top: 135px;">
				
				<div class="col-md-4"></div>
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Alterar Usuário</h2>
						
						<form name="frm" method="post" action="" enctype="multipart/form-data">
						
							<p><input type="text" name="nome_user" value="<?php echo $row['nome_user']; ?>" class="form-control"></p>
							<hr>
							<h5 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Alterar senha (opcional)</h5>
							<p><input type="password" name="senha_atual" class="form-control" placeholder="Senha atual"></p>
							<p><input type="password" name="nova_senha" class="form-control" placeholder="Nova senha"></p>
							<p><input type="password" name="repete_nova_senha" class="form-control" placeholder="Repetir nova senha"></p>
							
							<p class="text-center">
								<input type="submit" name="BtnAlterar" value="Alterar" class="btn btn-outline-danger">
								<a href="adm_inicial" class="btn btn-outline-danger">Voltar</a>
							</p>
						
						</form>
						
					  </div>
					</div>
				
				</div>
				
				<div class="col-md-4"></div>
				
			</div>
			
		</div>
		
	</body>
	
</html>

<?php

	// Código do Alterar Usuário
	
	if (isset($_REQUEST["BtnAlterar"])) {

		try{

			// abre a conexao com o BD
			require "conexao.php";
				
				$iduser = $_REQUEST["al"];
				$nome_user = $_REQUEST["nome_user"];
				
				// Verifica se o usuário alterou o nome de usuário
				if($nome_user != $row["nome_user"]){
					
					// Alterando o nome de usuário
					$sql = $conn->prepare("UPDATE user SET nome_user=:nome_user WHERE iduser=:iduser");
					
					$sql->bindValue(":nome_user",$nome_user);
					$sql->bindValue(":iduser",$iduser);
					$sql->execute();
					
					echo "<script type='text/javascript'>
								Swal.fire({
									icon: 'success',
									type: 'success',
									title: 'Pronto!',
									text: 'Usuário alterado com sucesso! Faça login novamente.',
									confirmButtonColor: '#52B640',
									confirmButtonText: 'Ok'
								}).then((result) => {
									if (result.isConfirmed) {
										window.location.href = 'sair';
									}
								})

						</script>";	
					
				}
				
				// Verifica se o usuário alterou sua senha
				if((!empty($_REQUEST["senha_atual"])) and (!empty($_REQUEST["nova_senha"])) and (!empty($_REQUEST["repete_nova_senha"]))) {
				
					// Recebendo as senhas
					$senha_atual = $_REQUEST["senha_atual"];
					$nova_senha = $_REQUEST["nova_senha"];
					$repete_nova_senha = $_REQUEST["repete_nova_senha"];
					
					// VALIDAÇÕES
					// A nova senha tem que ser igual a confirmação de senha
					// E a senha atual tem que ser igual a senha do BD
					
					if ($nova_senha == $repete_nova_senha and password_verify($senha_atual, $row["senha"])) {
						
						// Criptografar a senha
						$hash = password_hash($nova_senha, PASSWORD_DEFAULT);
						
						$sql = $conn->prepare("UPDATE user SET senha=:nova_senha WHERE iduser=:iduser");
					
						$sql->bindValue(":nova_senha",$hash);
						$sql->bindValue(":iduser",$iduser);
						$sql->execute();
						
						echo "<script type='text/javascript'>
								Swal.fire({
									icon: 'success',
									type: 'success',
									title: 'Pronto!',
									text: 'Senha alterada com sucesso! Faça login novamente.',
									confirmButtonColor: '#52B640',
									confirmButtonText: 'Ok'
								}).then((result) => {
									if (result.isConfirmed) {
										window.location.href = 'sair';
									}
								})

						</script>";	
						
					}else{
						
						echo "<script type='text/javascript'>
								Swal.fire({
									icon: 'error',
									type: 'error',
									title: 'Ops...',
									text: 'As senhas estão diferentes!',
									confirmButtonColor: '#DC143C',
									confirmButtonText: 'Ok'
								}).then((result) => {
									if (result.isConfirmed) {
										window.location.href = 'alterar_user?al=$iduser';
									}
								})

								</script>";	
								exit;	 
						
					}
				}
			
			// fecha a conexao com BD
			$conn = null;

		}catch (PDOException $erro) {
		echo $erro->getMessage();}

	}

?>