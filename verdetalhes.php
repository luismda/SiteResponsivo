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
		<link href="css/lightbox.css" rel="stylesheet">

		<!-- 1º jQuery -->
		<script src="js/jquery-3.5.1.js"></script>
		
		<!-- jQuery -->
		<script src="js/popper.min.js"></script>
		
		<!-- 2º Bootstrap css -->
		<script src="js/bootstrap.js"></script>
		
		<!-- Lightbox -->
		<script src="js/lightbox.js"></script>
		
		<link rel="icon" type="image/png" sizes="16x16" href="imagens/icon.png">

</head>

	<body style="background:url(imagens/bg.png);">

		<?php
			
			// Chama o menu
			require "menu_catalogo_verdetalhes.php";
		
		?>
		
		<div class="container mt-5">

			<div class="row mb-5">
				
				<div class="col-md-6 mt-5">
					
					<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="3500">
					
						<div class="carousel-inner">
						
							<?php
								
								// *************** Código da Consulta para recuperar imagens do álbum*************************

								try{

									// abre a conexao com o BD
									require "conexao.php";
									
									$idbolsa = $_REQUEST["vd"];
									
									$primeiroActive = true;
									
									// Consulta na tabela album
									$consulta = $conn->prepare("SELECT * FROM album where idbolsa=:idbolsa order by idalbum desc");
									$consulta->bindValue(':idbolsa',$idbolsa);
									$consulta->execute();
						
									//codigo para consulta
									while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
										
							?>
							
								<div class="carousel-item <?php echo $primeiroActive ? ' active' : ''; ?>">
									<a href="<?php echo $row["caminho"]; ?>" data-lightbox="album">
										<img class="d-block w-100 rounded" src="<?php echo $row["caminho"]; ?>" alt="Imagens do carrossel">
									</a>
								</div>
							
							<?php
							
								$primeiroActive = false; //Torna em false para não adicionar novamente o active

								// fecha o while
								}
											
								// fecha a conexao com BD
								$conn = null;

								} catch (PDOException $erro) {
								echo $erro->getMessage();}
							
							?>
						
						</div>
					  
					  <!-- Botões do corrossel -->
					  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
					  
					</div>
				
				</div>
				
				<?php
				
					// *************** Código da Consulta para recuperar informações da bolsa *************************

					try{

						// abre a conexao com o BD
						require "conexao.php";
									
						$idbolsa = $_REQUEST["vd"];
									
						// Consulta na tabela bolsas
						$consulta = $conn->prepare("SELECT * FROM bolsas where idbolsa=:idbolsa");
						$consulta->bindValue(':idbolsa',$idbolsa);
						$consulta->execute();
						
						//criar um vetor de 1 linha com as informações consultadas no BD
						$row = $consulta->fetch(PDO::FETCH_ASSOC);
						
						// fecha a conexao com BD
						$conn = null;

					} catch (PDOException $erro) {
					echo $erro->getMessage();}
				
				?>
				
				<div class="col-md-6 mt-5">
				
					<h2 style="font-family: 'Sofia', sans-serif;"><?php echo $row['nome_bolsa']; ?></h2>
					<p class="text-justify" ><?php echo $row['descricao']; ?></p>
					<p><b>Tamanho:</b> <?php echo $row['tamanho']; ?></p>
					<p><b>Cores:</b> <?php echo $row['cores']; ?></p>
					<p><b>Alça:</b> <?php echo $row['alca']; ?></p>
					<p><b>Forro:</b> <?php echo $row['forro']; ?></p>
					<p><b>Valor:</b> <?php echo $row['preco']; ?></p><br>
					<p>Gostou? Então me mande uma mensagem pelo Whatsapp!</p>
					<a href="https://api.whatsapp.com/send?phone=5519995369960&text=Oi.%20Gostei%20da%20<?php echo $row['nome_bolsa']; ?>.%20Quais%20as%20formas%20de%20pagamento?" target="new"><img src="imagens/enviar_msg.png" width="155"></a>
				</div>
			
			</div>
			
			
		</div>
		
		<?php
			
			// Chama o rodapé
			require "rodape.php";
		
		?>
		
	</body>
	
</html>