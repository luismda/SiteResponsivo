<?php

	// inicializa a sessão
	session_start();

	// destroi todas as sessões
	session_destroy();

	// redireciona para página de login
	header("location: login");
			
?>