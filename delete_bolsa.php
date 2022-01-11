<?php require "acesso_restrito.php"; ?>

<?php
	
	// Verifica se existe a variável ex na URL
	if ((isset($_REQUEST["ex_bolsa"])) and (isset($_REQUEST["img"]))) {
	
		try {
			
			// abrir a conexao com BD
			require "conexao.php";
			
				$idbolsa = $_REQUEST["ex_bolsa"];
				$caminho = $_REQUEST["img"];
				
				// --------------- Código excluir das bolsas ------------------
				$delete = $conn->prepare ("DELETE FROM bolsas WHERE idbolsa=:idbolsa");
				$delete->bindValue(":idbolsa",$idbolsa);
				$delete->execute();
				
				// Remove a imagem da pasta - de acordo com a variável $caminho
				unlink($caminho);
				// --------------- Fim do Código excluir das bolsas ------------------
				
				// ------------------ Código excluir do álbum --------------------

				// Consulta na tabela album
				$consulta = $conn->prepare("SELECT * FROM album where idbolsa=:idbolsa");
				$consulta->bindValue(":idbolsa", $idbolsa);
				$consulta->execute();
				
				//codigo para consulta
				while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
					
					// Recupera o caminho da imagem da consulta
					$caminho_album = $row["caminho"];
				
					// Código SQL do Excluir album
					$delete = $conn->prepare ("DELETE FROM album WHERE idbolsa=:idbolsa");
					$delete->bindValue(":idbolsa",$idbolsa);
					$delete->execute();
				
					// Remove a imagem da pasta - de acordo com a variável $caminho
					unlink($caminho_album);
					
				}
				// ------------------ Fim do Código excluir do álbum --------------------

				// -------------------- Código excluir dos lançamentos -------------------

				// Consulta na tabela lançamentos
				$consulta = $conn->prepare("SELECT * FROM lancamentos where idbolsa=:idbolsa");
				$consulta->bindValue(":idbolsa", $idbolsa);
				$consulta->execute();

				$row = $consulta->fetch(PDO::FETCH_ASSOC);

				$total_linhas = $consulta->rowCount();

				if($total_linhas != 0){

					// Código SQL do Excluir Lançamentos
					$delete = $conn->prepare ("DELETE FROM lancamentos WHERE idbolsa=:idbolsa");
					$delete->bindValue(":idbolsa",$idbolsa);
					$delete->execute();

				}
				// -------------------- Fim do Código excluir dos lançamentos -------------------

				$delete = "Cadastro da bolsa deletado com sucesso!";

				header("location:adm_inicial?delete=$delete");
				
			// fechar a conexao com BD
			$conn = null;
					
		}catch (PDOException $erro) {
		echo $erro->getMessage ();}	
	}
	
	

?>