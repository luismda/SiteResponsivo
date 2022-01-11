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
			// Consulta para recuperar as informações para o Formulário

			if ((isset($_REQUEST["al"])) and (isset($_REQUEST["img"]))) {

				try{

					// abrir a conexao com BD
					require "conexao.php";
						
						// receber o valor do parâmetro da url
						$idbolsa = $_REQUEST["al"];
						$caminho = $_REQUEST["img"];

						$consulta = $conn->prepare ("SELECT * FROM bolsas where idbolsa=:idbolsa");
						$consulta->bindValue(":idbolsa",$idbolsa);

						$consulta->execute();

						// recupera apenas uma linha da tabela. (sem o while - apenas uma linha)
						$row = $consulta->fetch (PDO::FETCH_ASSOC);
						
						$caminhobd = $row["foto_capa"];
						
						// Atribuir os valores da tabela para variáveis locais - Campo select
						$tamanho = $row["tamanho"];
						$forro = $row["forro"];
						
					// fechar a conexao com BD
					$conn = null;

				}catch (PDOException $erro) {
				echo $erro->getMessage();}

			}
		?>
		
		<div class="container-fluid">
			
			<div class="row" style="margin-top: 55px;">
				
				<div class="col-md-4"></div>
				
				<div class="col-md-4">
				
					<div class="card shadow p-3 mb-5 bg-white rounded">
					  <div class="card-body">
						
						<h2 class="text-center my-4" style="font-family: 'Sofia', sans-serif;">Alterar Cadastro da Bolsa</h2>
						
						<form name="frm" method="post" action="" enctype="multipart/form-data">
						
							<p>Nome da bolsa:<input type="text" name="nome_bolsa" class="form-control mt-2" value="<?php echo $row['nome_bolsa']; ?>"></p>
							<p>Cores:<input type="text" name="cores" class="form-control mt-2" value="<?php echo $row['cores']; ?>"></p>
							<p>Alça:<input type="text" name="alca" class="form-control mt-2" value="<?php echo $row['alca']; ?>"></p>
							
							<p>Preço:<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">R$</span>
								</div>
								<input type="text" id="preco" name="preco" class="form-control" value="<?php echo $row['preco']; ?>">
							</div></p>
							
							<p>Tamanho:<select name="tamanho" class="form-control mt-2" id="tamanho">
								<option value="Pequena">Pequena</option>
								<option value="Média">Média</option>
								<option value="Grande">Grande</option>
							</select></p>
							
							<p>Forro:<select name="forro" class="form-control mt-2" id="forro">
								<option value="Sim">Sim</option>
								<option value="Não">Não</option>
							</select></p>
							
							<p>Descrição:<textarea name="descricao" class="form-control mt-2" rows="4" style="resize: none;"><?php echo $row["descricao"]; ?></textarea></p>
							
							<p>
								Foto atual de capa:<br>
								<img src="<?php echo $caminho; ?>" width="200" class="rounded mt-2">
							</p>
							
							<p>Nova foto de capa (opcional):<input type="file" name="foto_capa" class="form-control mt-2"></p>
							
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

	// Código do Alterar Cadastro de Bolsa
	
	if (isset($_REQUEST["BtnAlterar"])) {

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
			
			// Verifica se a imagem de capa foi alterada
			if(!empty($_FILES["foto_capa"] ["name"])){
				
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
										window.location.href = 'alterar_bolsa';
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
										window.location.href = 'alterar_bolsa';
									}
								})

								</script>";	
								exit;			

				}
				
				// Remove a imagem antiga da pasta 
				unlink($caminhobd);
				
				// Comando para mover a imagem para a pasta arquivos_upload - upload
				move_uploaded_file($temp, $caminho);
				
			}else{
				
				// Mantendo o caminho atual do arquivo
				$caminho = $caminhobd;
				
			}
			
			// Código Update para alterar no BD

			$update=$conn->prepare("UPDATE bolsas SET nome_bolsa=:nome_bolsa, cores=:cores, alca=:alca, 
			preco=:preco, tamanho=:tamanho, forro=:forro, descricao=:descricao, foto_capa=:foto_capa where idbolsa=:idbolsa");
				
			$update->bindValue(":idbolsa",$idbolsa);
			$update->bindValue(":nome_bolsa",$nome_bolsa);
			$update->bindValue(":cores",$cores);
			$update->bindValue(":alca",$alca);
			$update->bindValue(":preco",$preco);
			$update->bindValue(":tamanho",$tamanho);
			$update->bindValue(":forro",$forro);
			$update->bindValue(":descricao",$descricao);
			$update->bindValue(":foto_capa",$caminho);
			
			$update->execute();
			
			echo "<script type='text/javascript'>
					Swal.fire({
						icon: 'success',
						type: 'success',
						title: 'Pronto!',
						text: 'Cadastro da bolsa alterado com sucesso!',
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

<script>

	$("#tamanho").val("<?php echo $tamanho; ?>");
	$("#forro").val("<?php echo $forro; ?>");

</script>