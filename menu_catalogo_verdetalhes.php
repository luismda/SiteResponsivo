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

	<body>

		<div class="container-fluid">
			
			<div class="row">
				
				<div class="col-md-12 p-0">
				
					<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" style="background-color: ">

						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>

						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="nav navbar-nav flex-fill justify-content-center">

								<li class="nav-item">
									<a class="nav-link" id="nav_link" href="https://websitelucroche.epizy.com">Início</a>
								</li>
								
								<li class="nav-item">
									<a class="nav-link" id="nav_link" href="catalogo">Catálogo de Bolsas</a>
								</li>
								
								<li class="nav-item">
									<a class="nav-link" id="nav_link" href="https://websitelucroche.epizy.com">Contato</a>
								</li>

							</ul>

						</div>
					</nav>
				
				</div>	
				
			</div>
		</div>
		
	</body>
	
    <!-- F’in sweet Webflow Hacks -->
    <script>
        // when the DOM is ready
        $(document).ready(function() {
            // get the anchor link buttons
            const menuBtn = $('.nav-link');
            // when each button is clicked
            menuBtn.click(()=>{	
                // set a short timeout before taking action
                // so as to allow hash to be set
                setTimeout(()=>{
                    // call removeHash function after set timeout
                    removeHash();
                }, 5); // 5 millisecond timeout in this case
            });

        // removeHash function
        // uses HTML5 history API to manipulate the location bar
        function removeHash(){
            history.replaceState('', document.title, window.location.origin + window.location.pathname + window.location.search);
        }
        });

        /**
        * another way to skin the same cat 
        *
        * $('.links').click(function(e){ 
        *	 $('html, body').animate({
        *   scrollTop: $( $.attr(this, 'href') ).offset().top - $('.nav').height()
        *	 }, 1000);
        *  return false;
        * });
        */
    </script>

</html>