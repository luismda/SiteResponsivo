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
		
		<!-- Plugin Máscara Monetária Jquery -->
		<script src="js/jquery.maskMoney.min.js"></script>
		
		<!-- API Alerta Javascript -->
		<script src="js/sweetalert.js"></script>
		
		<link rel="icon" type="image/png" sizes="16x16" href="imagens/icon.png">
		
		<script>
		
			// Máscara monetária Jquery no campo input
		
			$(document).ready(function()
			{
				 $("#preco").maskMoney({
					 decimal: ",",
					 thousands: "."
				 });
			});
		
		</script>
		
</head>

	<body style="background:url(imagens/bg.png);">

		<?php

			// Exibe a mensagem: "Deletado com sucesso!"
			if(isset($_REQUEST["delete"])) {

				$msg_delete = $_REQUEST["delete"];

				echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'success',
								type: 'success',
								title: 'Pronto!',
								text: '$msg_delete',
								confirmButtonColor: '#52B640',
								confirmButtonText: 'Ok'
							})

					</script>";	

			}

		?>
	
		<div class="container-fluid">
		
			<div class="row">
			
				<div class="col-md-12">
				
					<h2 class="text-center mt-5 mb-3" style="font-family: 'Sofia', sans-serif;">Área Administrativa Lucrochê</h2>
					
					<p class="text-center"><a href="sair" style="color: #dc3545;"><b>Sair</b> <i class="fa fa-times-circle" aria-hidden="true"></i></a></p>
					
					<hr>
				
				</div>
			
			</div>
			
			<div class="row">
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Cadastro de Bolsas</h2>
						
						<form name="frm" method="post" action="" enctype="multipart/form-data">
						
							<p><input type="text" name="nome_bolsa" class="form-control" placeholder="Nome da bolsa"></p>
							<p><input type="text" name="cores" class="form-control" placeholder="Cores"></p>
							<p><input type="text" name="alca" class="form-control" placeholder="Alça"></p>
							
							<p><div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">R$</span>
								</div>
								<input type="text" id="preco" name="preco" class="form-control" placeholder="Preço">
							</div></p>
							
							<p><select name="tamanho" class="form-control">
								<option value="">--- Escolha o tamanho ---</option>
								<option value="Pequena">Pequena</option>
								<option value="Média">Média</option>
								<option value="Grande">Grande</option>
							</select></p>
							
							<p><select name="forro" class="form-control">
								<option value="">--- Forro ---</option>
								<option value="Sim">Sim</option>
								<option value="Não">Não</option>
							</select></p>
							
							<p><textarea name="descricao" class="form-control" rows="4" placeholder="Descrição da bolsa" style="resize: none;"></textarea></p>
							
							<p>Foto de capa:<input type="file" name="foto_capa" class="form-control"></p>
							
							<p class="text-center"><input type="submit" name="BtnCadastrar" value="Cadastrar" class="btn btn-outline-danger"></p>
						
						</form>
						
					  </div>
					</div>
				
				</div>
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Bolsas Cadastradas</h2>
						
						<table class="table table-hover">
						
							<?php
							
								// *************** Código da Consulta *************************

								try{

									// abre a conexao com o BD
									require "conexao.php";

									//cria a variavel consulta que ira armazenar resultado sql
									$consulta = $conn->prepare("SELECT * FROM bolsas order by idbolsa desc");
									$consulta->execute();

									//codigo para consulta
									while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
							
							?>
							
							<tr>
								
								<td><?php echo $row["nome_bolsa"]?></td>
								
								<td class="text-right">
									<p>
										<a href="album_bolsa?ab=<?php echo $row['idbolsa']; ?>" title="Mais fotos"><img src="imagens/add_img.png" width="27"></a>
										<a href="alterar_bolsa?al=<?php echo $row['idbolsa']; ?>&img=<?php echo $row['foto_capa']; ?>" title="Alterar"><img src="imagens/edit.png" width="27"></a>
										<a href="adm_inicial?ex_bolsa=<?php echo $row['idbolsa']; ?>&img=<?php echo $row['foto_capa']; ?>" title="Excluir"><img src="imagens/del.png" width="27"></a>
									</p>
								</td>
							
							</tr>
						
							<?php
		
								// fecha o while
								}
								
								$total_linhas = $consulta->rowCount();

									if($total_linhas == 0){

										echo "
											<div class='col-md-12'>
												<h5 class='text-center'>Nenhuma bolsa cadastrada. &#128533;</h5>
											</div>
											";

									}

								// fecha a conexao com BD
								$conn = null;

								} catch (PDOException $erro) {
								echo $erro->getMessage();}

							?>
						
						</table>
						
					  </div>
					</div>
				
				</div>
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Usuários</h2>
						<p class="text-center"><a href="cadastro_user" style="color: #dc3545;"><b>Novo Usuário</b> <i class="fa fa-plus" aria-hidden="true"></i></a></p>
						
						<table class="table table-hover">
						
							<?php
							
								// *************** Código da Consulta *************************

								try{

									// abre a conexao com o BD
									require "conexao.php";

									//cria a variavel consulta que ira armazenar resultado sql
									$consulta = $conn->prepare("SELECT * FROM user order by iduser desc");
									$consulta->execute();

									//codigo para consulta
									while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
							
							?>
							
							<tr>

								<td><?php echo $row["nome_user"]?></td>
								
								<td class="text-right">
								
									<a href="alterar_user?al=<?php echo $row['iduser']; ?>" title="Alterar"><img src="imagens/edit.png" width="27"></a>
									<a href="adm_inicial?ex_user=<?php echo $row['iduser']; ?>" title="Excluir"><img src="imagens/del.png" width="27"></a>
									
								</td>
							
							</tr>
						
							<?php
		
								// fecha o while
								}
								
								// fecha a conexao com BD
								$conn = null;

								} catch (PDOException $erro) {
								echo $erro->getMessage();}

							?>
							
						</table>
						
					  </div>
					</div>
				
				</div>
				
			</div>
			
			<div class="row">
			
				<div class="col-md-12">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
						<div class="card-body">
						
							<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Lançamentos</h2>
							<p class="text-center mb-4"><a href="cadastro_lancamento" style="color: #dc3545;"><b>Novo Lançamento</b> <i class="fa fa-plus" aria-hidden="true"></i></a></p>
							
							<div class="row">
							
								<?php
								
									// *************** Código da Consulta dos lançamentos *************************

									try{

										// abre a conexao com o BD
										require "conexao.php";

										//cria a variavel consulta que ira armazenar resultado sql
										$consulta = $conn->prepare("SELECT *,c.idbolsa as idbolsa FROM lancamentos n INNER JOIN bolsas c on n.idbolsa = c.idbolsa");
										$consulta->execute();

										//codigo para consulta
										while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
								
								?>
								
								<div class="col-md-4 mb-3">
						
									<div class="card gallery-single rounded-circle m-auto d-block" style="width: 17rem;">
						
										<img src="<?php echo $row['foto_capa']; ?>" class="rounded-circle m-auto d-block img-fluid" width="270">
							
										<div class='why-text'>
											<a href='adm_inicial?ex_lancamento=<?php echo $row['idlancamento']; ?>' title='Deletar lançamento' id='link_del_img' style="color: white; text-decoration: none;" id='link_del_img'><b><img src='imagens/del_album.png' width='50'></b></a>
										</div>
							
									</div>
						
									<h5 class="text-center mt-3" style="font-family: 'Sofia', sans-serif;"><?php echo $row['nome_bolsa']; ?></h5>
					
								</div>
								
								<?php
			
									// fecha o while
									}

									$total_linhas = $consulta->rowCount();

									if($total_linhas == 0){

										echo "
											<div class='col-md-12'>
												<h5 class='text-center'>Nenhum lançamento cadastrado. &#128533;</h5>
											</div>
											";

									}
									
									// fecha a conexao com BD
									$conn = null;

									} catch (PDOException $erro) {
									echo $erro->getMessage();}

								?>
								
							</div>
						</div>
					</div>
					
				</div>
			
			</div>
			
		</div>
		
	</body>
	
</html>

<?php

	// ********************** Código do Excluir Usuário ****************************
	
	// Verifica se existe a variável ex na URL
	if (isset($_REQUEST["ex_user"])) {
			
		try {
		
			// abrir a conexao com BD
			require "conexao.php";
			
				$iduser = $_REQUEST["ex_user"];
				
				echo "
				<script>
				
					Swal.fire({
					  title: 'Tem certeza?',
					  text: 'Ao deletar esse usuário a ação não poderá ser revertida!',
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: 'Cancelar',
					  confirmButtonText: 'Sim, deletar!'
					}).then((result) => {
					  if (result.isConfirmed) {
							
						window.location.href = 'delete_user?ex_user=$iduser';
							
					  }
					})
				
				</script>";
			
			// fechar a conexao com BD
			$conn = null;
				
		}catch (PDOException $erro) {
		echo $erro->getMessage ();}	
	}

?>

<?php

	// Código do Cadastro de Bolsas
	
	if (isset($_REQUEST["BtnCadastrar"])) {

		try{

			// abre a conexao com o BD
			require "conexao.php";
			
			// Recebendo as informações do form
			$nome_bolsa = $_REQUEST["nome_bolsa"];
			$cores = $_REQUEST["cores"]; 
			$alca = $_REQUEST["alca"];
			$preco = $_REQUEST["preco"];
			$tamanho = $_REQUEST["tamanho"];
			$forro = $_REQUEST["forro"];
			$descricao = $_REQUEST["descricao"];
			
			// Recebendo as informações da imagem
			$foto_capa    = $_FILES["foto_capa"] ["name"]; // nome da imagem
			$temp         = $_FILES["foto_capa"] ["tmp_name"]; // nome da imagem temporário - caminho
			$tamanho_img  = $_FILES['foto_capa'] ['size']; // tamanho da imagem em bytes
			
			// ************* Códigos para renomear a imagem ************************

				// definindo timezone - data e hora
				date_default_timezone_set('America/Sao_Paulo');
				$data = date("d-m-Y");
				$time = date("H-i-s");
				
				//Separa a extensão da imagem (ex: .jpg .pdf .docx .mp4)
				$ext = pathinfo($foto_capa, PATHINFO_EXTENSION);
				
				// convertendo as extensões para minúsculo
				$ext = strtolower($ext);
				
				// Gera um número aleatório
				$ale = rand(1,99999999);
				
				// Renomeia o arquivo - Concatenando Strings com Variáveis
				$novo_nome = "imagem"."-".$data."-".$time."-".$ale.".".$ext;
				
				// Caminho da imagem
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
									window.location.href = 'adm_inicial';
								}
							})

							</script>";	
							exit;	 		

			}
			
			// Verificar o tamanho do arquivo - 5.000.000 Bytes = 5MB
			if ($tamanho_img > 5000000 ) {

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
									window.location.href = 'adm_inicial';
								}
							})

							</script>";	
							exit;			

			}
			
			// Comando para mover a imagem para a pasta arquivos_upload - upload
			move_uploaded_file($temp, $caminho);
			
			// Cadastro das informações no banco
				
				$insert = $conn->prepare("INSERT INTO bolsas (idbolsa, nome_bolsa, cores, alca, preco, tamanho, forro, descricao, foto_capa)
				VALUES (:idbolsa, :nome_bolsa, :cores, :alca, :preco, :tamanho, :forro, :descricao, :foto_capa) ");
				
				$insert->bindValue(':idbolsa',null);
				$insert->bindValue(':nome_bolsa',$nome_bolsa);
				$insert->bindValue(':cores',$cores);
				$insert->bindValue(':alca',$alca);
				$insert->bindValue(':preco',$preco);
				$insert->bindValue(':tamanho',$tamanho);
				$insert->bindValue(':forro',$forro);
				$insert->bindValue(':descricao',$descricao);
				$insert->bindValue(':foto_capa',$caminho);
				
				//Executa o comando SQL INSERT
				$insert->execute();
				
				echo "<script type='text/javascript'>
							Swal.fire({
								icon: 'success',
								type: 'success',
								title: 'Pronto!',
								text: 'Bolsa cadastrada com sucesso!',
								confirmButtonColor: '#52B640',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'adm_inicial';
								}
							})

					</script>";	
			
			// fecha a conexao com BD
			$conn = null;

		}catch (PDOException $erro) {
		echo $erro->getMessage();}

	}

?>

<?php

	// ********************** Código do Excluir Cadastro de Bolsas ****************************
	
	// Verifica se existe a variável ex e img na URL
	if ((isset($_REQUEST["ex_bolsa"])) and (isset($_REQUEST["img"]))) {
			
		try {
		
			// abrir a conexao com BD
			require "conexao.php";
			
			$idbolsa = $_REQUEST["ex_bolsa"];
			$caminho = $_REQUEST["img"];
			
			echo "
				<script>
				
					Swal.fire({
					  title: 'Tem certeza?',
					  text: 'Ao deletar essa bolsa a ação não poderá ser revertida!',
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: 'Cancelar',
					  confirmButtonText: 'Sim, deletar!'
					}).then((result) => {
					  if (result.isConfirmed) {
							
						window.location.href = 'delete_bolsa?ex_bolsa=$idbolsa&img=$caminho';
						
					  }
					})
				
				</script>";
			
			// fechar a conexao com BD
			$conn = null;
				
		}catch (PDOException $erro) {
		echo $erro->getMessage ();}	
	}

?>

<?php

	// ********************** Código do Excluir Lançamentos ****************************
	
	// Verifica se existe a variável ex na URL
	if (isset($_REQUEST["ex_lancamento"])) {

		try{

			// abre a conexao com o BD
			require "conexao.php";

			$idlancamento = $_REQUEST["ex_lancamento"];

			echo "
				<script>
				
					Swal.fire({
					  title: 'Tem certeza?',
					  text: 'Ao deletar esse lançamento a ação não poderá ser revertida!',
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: 'Cancelar',
					  confirmButtonText: 'Sim, deletar!'
					}).then((result) => {
					  if (result.isConfirmed) {
							
						window.location.href = 'delete_lancamento?ex_lancamento=$idlancamento';
							
					  }
					})
				
				</script>";

			// fechar a conexao com BD
			$conn = null;
				
		}catch (PDOException $erro) {
		echo $erro->getMessage ();}	
	}

?>

