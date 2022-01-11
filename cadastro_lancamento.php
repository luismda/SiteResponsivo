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

		<div class="container-fluid">
			
			<div class="row" style="margin-top: 165px;">
				
				<div class="col-md-4"></div>       
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Cadastro de Lançamentos</h2>
						
						<form name="frm" method="post" action="" enctype="multipart/form-data">
						
							<p>
							
								<select name="lancamento" class="form-control">
								
									<option value="">--- Escolha um bolsa ---</option>
									
									<?php
								
										require "conexao.php";
										
											$consulta=$conn-> prepare('select * from bolsas order by idbolsa desc');
											$consulta->execute();
											
											while ($row=$consulta->fetch(PDO::FETCH_ASSOC)) {
												echo "<option value=$row[idbolsa]> $row[nome_bolsa] </option>";
											}
									
										$conn == null;
										
									?>
								
								</select>
							
							</p>
							
							<p class="text-center">
								<input type="submit" name="BtnCadastrar" value="Cadastrar" class="btn btn-outline-danger">
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

	// Código do Cadastro
	
	if (isset($_REQUEST["BtnCadastrar"])) {

		try{

			// abre a conexao com o BD
			require "conexao.php";
			
				$lancamento = $_REQUEST["lancamento"];
				
				// Cadastra um novo lançamento no banco

				$insert = $conn->prepare("INSERT INTO lancamentos (idlancamento, idbolsa)
				VALUES (:idlancamento, :idbolsa) ");

				$insert->bindValue(':idlancamento',null);
				$insert->bindValue(':idbolsa',$lancamento);

				//Executa o comando SQL INSERT
				$insert->execute();
			
				echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'success',
								type: 'success',
								title: 'Pronto!',
								text: 'Lançamento cadastrado com sucesso!',
								confirmButtonColor: '#52B640',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'cadastro_lancamento';
								}
							})

					</script>";	
			
			// fecha a conexao com BD
			$conn = null;

		}catch (PDOException $erro) {
		echo $erro->getMessage();}

	}

?>