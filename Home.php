<?php
	try
	{
		session_start();
	}
	catch(Exception $e)
	{
		echo "<script>function() { Materialize.toast('Erro na conexao com banco de dados!', 1500 ); }</script>";
	}
	
	if(isset($_SESSION['id']))
	{
		session_destroy();
		header("Location:index.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<!--Titulo Site-->
    <title>Bom Jogo</title>
	<!--Tags para Page ranking-->
    <META NAME="LANGUAGE" CONTENT="Pt-Br">
    <META NAME="ROBOT" CONTENT="Index,Follow" >
    <META NAME="DESCRIPTION" CONTENT="O Bom Jogo é um Site de agendamento de partidas de futebol não profissional para entretenimento e lazer!">
    <META NAME="KEYWORDS" CONTENT="futebol, encontro, jogos, partida, partida de futebol, jogo de futebol, times, campo de futebol" >
    <META NAME="RATING" CONTENT="general">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="css/padrao.css"/>
    <link type="text/css" rel="stylesheet" href="css/remodal.css"/>
    <link type="text/css" rel="stylesheet" href="css/remodal-default-theme.css"/>
    <style>
		.remodal-bg.with-red-theme.remodal-is-opening,
		.remodal-bg.with-red-theme.remodal-is-opened { filter: none; }
		.remodal-overlay.with-red-theme { background-color: #f44336; }
		.remodal.with-red-theme { background: #fff; }
	</style>
</head>
<body>
    <div class="navbar-fixed">
        <nav class="teal darken-4">
        	<div class="nav-wrapper">
          		<a href="principal.php" class="brand-logo" style="font-size:24px; margin-left:5px;"> Bom jogo</a>
          		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          		<ul class="right hide-on-med-and-down">
            		<li><a href="Home.php?pag=Principal"<?php if(@$_GET['pag']== "Principal"){}?> >Home</a></li>
            		<li><a href="Home.php?pag=Campos"<?php if(@$_GET['pag']== "Campos"){}?> >Campos</a></li>
                    <li><a href="Home.php?pag=Contato"<?php if(@$_GET['pag']== "Contato"){}?> >Contato</a></li>
                    <li style="margin-top:5px;">
                    	<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
						<form action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
							<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
							<input type="hidden" name="code" value="539AC1AB2A2AB32884409F8BB46B9D6F" />
							<input type="hidden" name="iot" value="button" />
							<input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/120x53-pagar-azul.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
						</form>
						<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
						<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
                    </li>
                    <li><a href="#modal" data-remodal-target="modalLogin"><i class="large material-icons">perm_identity</i></a></li>
          		</ul>
          		<ul class="side-nav" id="mobile-demo">
            		<li><a href="Home.php?pag=Principal"<?php if(@$_GET['pag']== "Principal"){}?> >Home</a></li>
            		<li><a href="Home.php?pag=Campos"<?php if(@$_GET['pag']== "Campos"){}?> >Campos</a></li>
                    <li><a href="Home.php?pag=Contato"<?php if(@$_GET['pag']== "Contato"){}?> >Contato</a></li>
                    <li><a href="#modal" data-remodal-target="modalLogin">Login/Cadastro</a></li>
          		</ul>
                <!-- The Modal -->
                <?php include("Login.php");?>
                <!-- Fim do Modal -->
        	</div>
    	</nav>
	</div>
    
	<div class="container">
        <div class="row" style="margin-top:50px;">
        	<div class="col s12">
            	<!-- Linha do Slider -->
                <div class="row z-depth-5" style="margin-bottom:0px;">
                	<?php include("slider.php"); ?>
                </div>
                <!-- Fim da linha do Slider-->
                
                <!-- Corpo da Página -->
                <div class="row white z-depth-5" style="margin-bottom:0px; padding-top:10px; padding-left:20px; padding-right:20px; padding-bottom:100px;">    	
                    <?php 
						if(!isset($_GET['pag']))
						{
							include("Principal.php"); 		
						}
						else
						{
							include($_GET['pag'].".php");
						}
					?>                    
                </div>
                <!-- Fim do Corpo da Página --->
                
                <!-- Opcional Patrocinadores --->
                <!-- Patrocinadores -->
                <div class="row  blue-grey darken-4 white-text z-depth-5 hide-on-small-only" style="margin-bottom:0px; padding:20px;">
                    	<?php include("Patrocinio.php");?>
                </div>
        		<!-- Fim dos Patrocinadores ->
                <!-- Fim do Opcional Patrocinadores -->
                
                <!-- Créditos -->
                <div class="row">
                	<footer class="page-footer  grey darken-4 white-text z-depth-5" style="margin:0px;">
                    	<div class="container">
                        	<div class="row">
                          		<div class="col m6 s12">
                            		<h5 class="white-text">Bom Jogo</h5>
                            		<p class="grey-text text-lighten-4">O website Bom jogo oferece um meio seguro, dinamico e rápido para marcar partidas de futebol. Cadastre-se e aproveite melhor a vida!</p>
                          		</div>
                          		<div class="col m4 offset-l2 s12">
                            		<h5 class="white-text">Contatos</h5>
                            		<ul>
                              			<li><a class="grey-text text-lighten-3" href="https://www.facebook.com/rogerio.ferreira.14661">Administrador</a></li>
                              			<li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                              			<li><a class="grey-text text-lighten-3" href="https://www.facebook.com/isaque.coelho.7">Desenvolvedor</a></li>
                            		</ul>
                          		</div>
                        	</div>
                            <div class="row"><div class="col s12">Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
                      </div>
                      <div class="footer-copyright">
                      	<div class="container">
                        	Bom Jogo © <?php echo gmdate('Y')?> Copyright reserved. Desenvolvido baseado no Design <a href="http://materializecss.com/">Materialize</a>
                        </div>
                      </div>
                    </footer>
                </div>
                <!-- Fim dos Créditos -->
            </div>
        </div>
    </div>
          

	<script type="text/javascript" src="js/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--Modal-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/zepto/1.1.4/zepto.js"></script>
	<script>window.Zepto || document.write('<script src="../libs/zepto/zepto.min.js"><\/script>')</script>
    <script type="text/javascript" src="js/remodal.min.js"></script>    
    <!--Fim Modal-->
    <!-- Events -->
<script>

	$(document).ready(function(e) {
        $(".button-collapse").sideNav();
		 $('.dropdown-button').dropdown({
		  inDuration: 300,
		  outDuration: 225,
		  constrain_width: false, // Does not change width of dropdown to that of the activator
		  hover: true, // Activate on hover
		  gutter: 0, // Spacing from edge
		  belowOrigin: false, // Displays dropdown below the button
		  alignment: 'left' // Displays dropdown with edge aligned to the left of button
		}
	  );
	  
	  $('.tooltipped').tooltip({delay: 50});
    });
	
	
	function ErroLogin()
	{
		alert('erro login');
		//Materialize.toast('I am a toast!', 4000);
	}

	$(document).ready(function(){$('.slider').slider({full_width: true});});
	
	$(document).on('opening', '.remodal', function () {
		console.log('opening');
	});
	
	$(document).on('opened', '.remodal', function () {
		console.log('opened');
	});
	
	$(document).on('closing', '.remodal', function (e) {
		console.log('closing' + (e.reason ? ', reason: ' + e.reason : ''));
	});
	
	$(document).on('closed', '.remodal', function (e) {
		console.log('closed' + (e.reason ? ', reason: ' + e.reason : ''));
	});
	
	$(document).on('confirmation', '.remodal', function () {
		console.log('confirmation');
	});
	
	$(document).on('cancellation', '.remodal', function () {
		console.log('cancellation');
	});

  //  Usage:
  //  $(function() {
  //
  //    // In this case the initialization function returns the already created instance
  //    var inst = $('[data-remodal-id=modal]').remodal();
  //
  //    inst.open();
  //    inst.close();
  //    inst.getState();
  //    inst.destroy();
  //  });

  //  The second way to initialize:
  $('[data-remodal-id=modal2]').remodal({
    modifier: 'with-red-theme'
  });
</script>
    
</body>
</html>