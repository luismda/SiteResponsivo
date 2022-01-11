<?php require "acesso_restrito.php"; ?>

<?php
	
	// Verifica se existe a variável ex na URL
	if (isset($_REQUEST["ex_user"])) {
	
		try {
			
			// abrir a conexao com BD
			require "conexao.php";
			
			$iduser = $_REQUEST["ex_user"];
				
				// Código SQL do Excluir
				$delete = $conn->prepare ("DELETE FROM user WHERE iduser=:iduser");
				$delete->bindValue(":iduser",$iduser);
				$delete->execute();

				$delete = "Usuário deletado com sucesso!";

				header("location:adm_inicial?delete=$delete");
				
			// fechar a conexao com BD
			$conn = null;
					
		}catch (PDOException $erro) {
		echo $erro->getMessage ();}	
	}
	
	

?>