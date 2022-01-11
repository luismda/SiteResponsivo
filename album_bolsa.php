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
		
		<script src="js/sweetalert.js"></script>
		
		<link rel="icon" type="image/png" sizes="16x16" href="imagens/icon.png">
		
</head>

	<body style="background:url(imagens/bg.png);">
		
		<?php
			
			// Recebendo o id da bolsa da url
			$idbolsa = $_REQUEST["ab"];
		
		?>
		
		<div class="container-fluid">
			
			<div class="row" style="margin-top: 55px;">
				
				<div class="col-md-4"></div>
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Adicionar fotos:</h2>
						
						<form name="frm" method="post" action="" enctype="multipart/form-data">
							
							<input type="hidden" name="idbolsa" value="<?php echo $idbolsa; ?>">
							
							<p><input type="file" name="album" class="form-control" onchange="this.form.submit()"></p>
							
							<p class="text-center">
								
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

	// Código do Cadastro das fotos
	
	if (isset($_FILES['album']["name"])) {

		try{

			// abre a conexao com o BD
			require "conexao.php";
			
			// Recebendo o id da bolsa do formulário
			$idbolsa = $_REQUEST["idbolsa"];
			
			// Recebendo as informações do arquivo
			
			$album   = $_FILES["album"] ["name"]; // nome do arquivo
			$temp    = $_FILES["album"] ["tmp_name"]; // nome do arquivo temporário - caminho
			$tamanho = $_FILES['album'] ['size']; // tamanho do arquivo em bytes
			
			// ************* Códigos para renomear o arquivo ************************

			// definindo timezone - data e hora
			date_default_timezone_set('America/Sao_Paulo');
			$data = date("d-m-Y");
			$time = date("H-i-s");
			
			//Separa a extensão do arquivo (ex: .jpg .pdf .docx .mp4)
			$ext = pathinfo($album, PATHINFO_EXTENSION);
			
			// convertendo as extensões para minúsculo
			$ext = strtolower($ext);
			
			// Gera um número aleatório
			$ale = rand(1,99999999);
			
			// Renomeia o arquivo - Concatenando Strings com Variáveis
			$novo_nome = "imagem"."-".$data."-".$time."-".$ale.".".$ext;
			
			$caminho = 'arquivos_upload/'.$novo_nome;
			
			// ************* Fim da mudança de nome ************************

			//Verifica a Extensão - Só serão permitidos arquivos jpg e png
			if (($ext != 'jpg') and ($ext != 'png')){

				echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'error',
								type: 'error',
								title: 'Ops...',
								text: 'Extensão da imagem deve ser jpg ou png!',
								confirmButtonColor: '#DC143C',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'album_bolsa.php';
								}
							})

							</script>";	
							exit;	 		

			}
			
			// Verificar o tamanho do arquivo - 5.000.000 Bytes = 5MB
			if ($tamanho > 5000000 ) {

				echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'error',
								type: 'error',
								title: 'Ops...',
								text: 'Imagem muito grande! Tamanho máximo é 5MB.',
								confirmButtonColor: '#DC143C',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'album_bolsa.php';
								}
							})

							</script>";	
							exit;			

			}
			
			// Comando para mover a imagem para a pasta arquivos_upload - upload
			move_uploaded_file($temp, $caminho);
			
			// Código para gravar no BD
			
			$insert = $conn->prepare("INSERT INTO album (idalbum, idbolsa, caminho)
			VALUES (:idalbum, :idbolsa, :caminho) ");

			$insert->bindValue(':idalbum',null);
			$insert->bindValue(':idbolsa',$idbolsa);
			$insert->bindValue(':caminho',$caminho);

			//Executa o comando SQL INSERT
			$insert->execute();
			
			// fecha a conexao com BD
			$conn = null;

		}catch (PDOException $erro) {
		echo $erro->getMessage();}

	}

?>

<div class="container">

	<div class="row my-5">
	
		<div class="col-md-12">
		
			<h2 class="text-center mb-4" style="font-family: 'Sofia', sans-serif;">Fotos cadastradas:</h2>
		
		</div>
		
			<?php
			
				// *************** Código da Consulta das fotos *************************

				try{

					// abre a conexao com o BD
					require "conexao.php";
					
					//cria a variavel consulta que ira armazenar resultado sql
					$consulta = $conn->prepare("SELECT * FROM album where idbolsa=:idbolsa order by idalbum desc");
					$consulta->bindValue(":idbolsa", $idbolsa);
					$consulta->execute();
					
					//codigo para consulta
					while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
							
						echo "
								<div class='col-md-3 m-0 p-0'>
										
									<div class='card'>
											
										<div class='card-body p-0 gallery-single'>
											
											<img src='$row[caminho]' class='img-fluid'>
											<div class='why-text'>
												<a href='album_bolsa.php?ex=$row[idalbum]&img=$row[caminho]&ab=$row[idbolsa]' title='Deletar imagem' id='link_del_img'><img src='imagens/del_album.png' width='50'></a>
											</div>
												
										</div>
											
									</div>
										
								</div>
						";
					}
					
					// Conta o número de linhas retornadas
					$total_linhas = $consulta->rowCount();
					
					if($total_linhas == 0){
						
						echo "<div class='col-md-12'><h5 class='text-center'>Nenhuma imagem cadastrada. &#128533;</h5></div>";
					}
					
					// fecha a conexao com BD
					$conn = null;

				} catch (PDOException $erro) {
					echo $erro->getMessage();}
			
			?>
		
	</div>

</div>

<?php

	// ********************** Código Excluir das fotos do álbum ****************************
	
	// Verifica se existe a variável ex na URL
	if (isset($_REQUEST["ex"])) {
			
		try {
		
			// abrir a conexao com BD
			require "conexao.php";
			
			// Recuperar os parâmetros da URL
			$idbolsa = $_REQUEST["ab"];
			$idalbum = $_REQUEST["ex"];
			$caminho = $_REQUEST["img"];
				
			// Código SQL do Excluir
			$delete = $conn->prepare ("DELETE FROM album WHERE idalbum=:idalbum");
			$delete->bindValue(":idalbum",$idalbum);
			$delete->execute();
				
			// Remove a imagem da pasta - de acordo com a variável $caminho
			unlink($caminho);
			
			echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'success',
								type: 'success',
								title: 'Pronto!',
								text: 'Imagem deletada com sucesso!',
								confirmButtonColor: '#52B640',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'album_bolsa.php?ab=$idbolsa';
								}
							})

					</script>";	
			
			// fechar a conexao com BD
			$conn = null;
				
		}catch (PDOException $erro) {
		echo $erro->getMessage ();}	
	}

?>