<?php require "acesso_restrito.php"; ?>

<?php
	
	// Verifica se existe a variável ex na URL
	if (isset($_REQUEST["ex_lancamento"])) {
	
		try {
			
			// abrir a conexao com BD
			require "conexao.php";
			
			$idlancamento = $_REQUEST["ex_lancamento"];
				
				// Código SQL do Excluir
				$delete = $conn->prepare ("DELETE FROM lancamentos WHERE idlancamento=:idlancamento");
				$delete->bindValue(":idlancamento",$idlancamento);
				$delete->execute();
				
				$delete = "Lançamento deletado com sucesso!";

				header("location:adm_inicial?delete=$delete");
				
			// fechar a conexao com BD
			$conn = null;
					
		}catch (PDOException $erro) {
		echo $erro->getMessage ();}	
	}
	
	

?>