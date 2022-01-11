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

	<body id="topo" style="background:url(imagens/bg.png);">

		<?php
			
			// Chama o menu
			require "menu.php";
		
		?>
		
		<div class="container mt-5">
		
			<div class="row">
				
				<div class="col-md-12 mt-5">
				
					<p><img src="imagens/logo.png" width="210" class="m-auto d-block"></p>
					
				</div>
			
			</div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
				
					<p class="text-center">Lucrochê é uma marca especializada na confecção de bolsas de crochê totalmente
					artesanais de diferentes modelos, tamanhos e cores.</p>
				
				</div>
				<div class="col-md-2"></div>
			</div>
			
		</div>
		
		<div class="container-fluid mt-5 shadow p-3 mb-5 bg-white rounded" >
		
			<div class="row mb-3">
				
				<div class="col-md-12 mt-5 mb-3">
				
					<h2 class="text-center" style="font-family: 'Sofia', sans-serif;">Bolsas de Crochê</h2>
				
				</div>
			</div>
			<div class="row mb-3">
				
				<div class="col-md-6">
				
					<img src="imagens/bolsa.jpg" width="270" class="rounded-circle m-auto d-block">
				
				</div>
				
				<div class="col-md-6 mt-4">
				
					<p class="text-justify mx-4">
					
						As bolsas de crochê são feitas com diferentes características como tipo do fio, cor, tamanho,
						modelo, com ou sem forro, tipo de alça e o tipo de ponto utilizado, tudo isso para atender os
						diversos gostos. Conheça as bolsas disponíveis para pronta entrega no Catálogo de Bolsas.
					
					</p>
					
					<a href="catalogo" class="mx-4" style="color: #dc3545;"><b>Catálogo de Bolsas</b> <i class="fa fa-arrow-right"></i></a>
				
				</div>
				
			</div>
			
		</div>
		<?php

			// Verificando se existe lançamentos cadastrados

			try{

				// abre a conexao com o BD
				require "conexao.php";

				$consulta = $conn->prepare("SELECT * FROM lancamentos");
				$consulta->execute();

				while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {}

				$total_linhas = $consulta->rowCount();

				// fecha a conexao com BD
				$conn = null;

			} catch (PDOException $erro) {
			echo $erro->getMessage();}

		?>
			
			<?php 

				if($total_linhas != 0){

					echo "

						<div class='container-fluid mb-5'>
							<div class='row mb-3'>
				
								<div class='col-md-12 mt-5 mb-3'>
					
									<h2 class='text-center' style='font-family: Sofia, sans-serif;'>Lançamentos</h2>
					
								</div>
				
							</div>

						";

				}

			?>
			
			<div class="row mb-3">
				
				<?php

					// Código da consulta dos lançamentos

					try{

						// abre a conexao com o BD
						require "conexao.php";

						$consulta = $conn->prepare("SELECT *,c.idbolsa as idbolsa FROM lancamentos n INNER JOIN bolsas c on n.idbolsa = c.idbolsa");
						$consulta->execute();

						while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
				?>

				<div class="col-md-4 mb-3">
					
					<div class="card gallery-single rounded-circle m-auto d-block" style="width: 17rem;">
					
						<img src="<?php echo $row['foto_capa']; ?>" class="rounded-circle m-auto d-block img-fluid" width="270">
						
						<div class='why-text'>
							<a href='verdetalhes?vd=<?php echo $row['idbolsa']; ?>' id='link_del_img' style="color: white; text-decoration: none;" ><b>Ver detalhes</b> <i class="fa fa-share"></i></a>
						</div>
						
					</div>
					
					<h5 class="text-center mt-3" style="font-family: 'Sofia', sans-serif;"><?php echo $row['nome_bolsa']; ?></h5>
				
				</div>

				<?php 

					// fecha o while
					}
			
					// fecha a conexao com BD
					$conn = null;

					} catch (PDOException $erro) {
					echo $erro->getMessage();}

				?>
			
			</div>
		
		</div>
		
		<div class="container-fluid mb-5">
		
			<div class="row">
			
				<div class="col-md-12 mt-5 mb-3">
				
					<h2 class="text-center" style="font-family: 'Sofia', sans-serif;">Enviamos para todo o Brasil</h2>
				
				</div>
			</div>
			<div class="row">
				
				<div class="col-md-6">
					
					<p class="text-justify mt-4 mx-4">
					
						Atualmente, as bolsas Lucrochê se encontram em três estados do Brasil, elas foram adquiridas pela
						internet e enviadas pela transportadora. A distância não é um impedimento para que você possa ter
						uma bolsa Lucrochê! Entre em contato e compre a sua!
					
					</p>
				
				</div>
				
				<div class="col-md-6">
				
					<img src="imagens/mapa.png" width="270" class="m-auto d-block">
				
				</div>
			
			</div>
		
		</div>
		
		<div class="container-fluid mb-5">
		
			<div class="row">
			
				<div class="col-md-12 mt-5 mb-3">
				
					<h2 class="text-center" style="font-family: 'Sofia', sans-serif;">Lucimara Cristina</h2>
				
				</div>
			</div>
			<div class="row">
				
				<div class="col-md-6">
					
					<img src="imagens/lucimara.jpg" width="270" class="rounded-circle m-auto d-block">
					
				</div>
				
				<div class="col-md-6">
				
					<p class="text-justify mt-5 mx-4">
					
						Lucimara Cristina aprendeu a fazer crochê quando criança e trabalha com artesanato há muitos anos.
						Criou sua marca Lucrochê e se especializou na criação de bolsas. Quando se trabalha com o que ama
						o resultado é sempre fruto de muito amor e carinho.
					
					</p>
				
				</div>
			
			</div>
		
		</div>
		
		<div class="container-fluid mb-5">
		
			<div class="row">
			
				<div class="col-md-12 mt-5">
				
					<h2 id="contato" class="text-center" style="font-family: 'Sofia', sans-serif;">Contato</h2>
					<p class="text-center">
						Entre em contato para adquirir uma bolsa de crochê. <br>
						Você pode me visitar no Facebook, seguir no Instagram ou enviar uma mensagem no Whatsapp! 
					</p>
					<p class="text-center">
						<a href="https://www.facebook.com/lucimara.cristina.1217727" title="Facebook" target="new" class="mt-2"><img src="imagens/face.png" width="45"></a>
						<a href="https://www.instagram.com/lucristinaalves/" title="Instagram" target="new" class="mt-2"><img src="imagens/insta.png" width="39"></a>
						<a href="https://api.whatsapp.com/send?phone=5519995369960&text=Oi.%20Vim%20pelo%20site!" title="Whatsapp" target="new" class="mt-2"><img src="imagens/whats.png" width="50"></a>
					</p>
				
				</div>
			
			</div>
		
		</div>
		
		<?php
			
			// Chama o rodapé
			require "rodape.php";
		
		?>
		
	</body>
	
</html>