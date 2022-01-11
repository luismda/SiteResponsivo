<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">

	<title>Lucrochê - Pontinhos de Amor</title>
	
		<link href="css/estilo.css" rel="stylesheet" type="text/css">
		
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

		<?php
			
			// Chama o menu
			require "menu_catalogo_verdetalhes.php";
		
		?>
		
		<div class="container mt-5">
		
			<div class="row mb-4">
				
				<div class="col-md-12 mt-5">
				
					<h2 class="text-center" style="font-family: 'Sofia', sans-serif;">Catálogo de Bolsas</h2>
					<p class="text-center">Consulte as bolsas de crochê disponíveis para pronta entrega.</p>
				
				</div>
			
			</div>

			<div class="row">

				<div class="col-md-3"></div>

				<div class="col-md-3"></div>

				<div class="col-md-3"></div>

				<div class="col-md-3">

					<form name="frm" method="post" action="">
						
						Filtrar:
						<select class="form-control mb-5" name="filtrar" id="filtrar" onchange="this.form.submit()">

							<option value="Todas">Todas as bolsas</option>
							<option value="Pequena">Bolsas pequenas</option>
							<option value="Média">Bolsas médias</option>
							<option value="Grande">Bolsas grandes</option>

						</select>

					</form>

				</div>

			</div>
			
			<div class="row mb-4">
				
				<?php
					
					if(isset($_REQUEST["filtrar"])){

						$filtrar = $_REQUEST["filtrar"];

					}else{

						$filtrar = "Todas";

					}

					// *************** Código da Consulta das bolsas *************************

					try{

						// abre a conexao com o BD
						require "conexao.php";

						if($filtrar == "Todas"){

							//cria a variavel consulta que ira armazenar resultado sql
							$consulta = $conn->prepare("SELECT * FROM bolsas order by idbolsa desc");
							$consulta->execute();

							//codigo para consulta
							while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {

								echo "

									<div class='col-md-4'>
										<div class='card mb-3'>
					  						<img class='card-img-top' src='$row[foto_capa]'>
					  						<div class='card-body'>
												<h5 class='card-text'>$row[nome_bolsa]</h5>
												<a class='card-link' href='verdetalhes?vd=$row[idbolsa]' style='color: #dc3545;'><b>Ver detalhes</b> <i class='fa fa-arrow-right'></i></a>
					  						</div>
										</div>
				
									</div>

									";
							}

							$total_linhas = $consulta->rowCount();

							if($total_linhas == 0){

							echo "
								<div class='col-md-12' style='margin-bottom: 450px;'>
									<h5 class='text-center mt-5'>Nenhuma bolsa cadastrada. &#128533;</h5>
								</div>
								";
							}

						}else {

							//cria a variavel consulta que ira armazenar resultado sql
							$consulta = $conn->prepare("SELECT * FROM bolsas where tamanho=:tamanho order by idbolsa desc");
							$consulta->bindValue(":tamanho", $filtrar);
							$consulta->execute();

							//codigo para consulta
							while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {

								echo "

									<div class='col-md-4'>
										<div class='card mb-3'>
					  						<img class='card-img-top' src='$row[foto_capa]'>
					  						<div class='card-body'>
												<h5 class='card-text'>$row[nome_bolsa]</h5>
												<a class='card-link' href='verdetalhes.php?vd=$row[idbolsa]' style='color: #dc3545;'><b>Ver detalhes</b> <i class='fa fa-arrow-right'></i></a>
					  						</div>
										</div>
				
									</div>

									";
							}

							$total_linhas = $consulta->rowCount();

							if($total_linhas == 0){

							echo "
								<div class='col-md-12' style='margin-bottom: 450px;'>
									<h5 class='text-center mt-5'>Nenhuma bolsa cadastrada. &#128533;</h5>
								</div>
								";
							}

						}

						// fecha a conexao com BD
						$conn = null;

					} catch (PDOException $erro) {
					echo $erro->getMessage();}
				
				?>
				
			</div>
			
		</div>
		
		<?php
			
			// Chama o rodapé
			require "rodape.php";
		
		?>
		
	</body>
	
</html>

<script>

	$("#filtrar").val("<?php echo $filtrar; ?>");

</script>