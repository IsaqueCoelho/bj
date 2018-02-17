<!DOCTYPE html>
<html>
<head>
	<!--Titulo Site-->
    <title>Bom Jogo</title>
	<?php header('Content-Type: text/html; charset=UTF-8;'); ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
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
	<link type="text/css" rel="stylesheet" href="css/remodal.css">
    <link type="text/css" rel="stylesheet" href="css/remodal-default-theme.css">
    
</head>
<body>
	
    <div class="navbar-fixed">
        <nav class="teal darken-4">
        	<div class="nav-wrapper">
          		<a href="index.php" class="brand-logo" style="font-size:24px; margin-left:5px;"> Bom Jogo</a>
          		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          		<ul class="right hide-on-med-and-down">
            		<li><a href="index.php?pag=Ranking" <?php if(@$_GET['pag'] == "Ranking"){}?>>Ranking</a></li>
            		<li><a href="index.php?pag=Times" <?php if(@$_GET['pag'] == "Times"){} ?> >Times</a></li>
                    <li>
                    	<a href="index.php?pag=Partidas" <?php if(@$_GET['pag'] == "Partidas"){} ?>>Partidas 
                    		<span class="Badge">
                            	<?php
									//Notificações									
								?>
                            </span>
                        </a>                    
                    </li>
                    <li><a href="index.php?pag=Campos"<?php if(@$_GET['pag']== "Campos"){}?> >Campos</a></li>
                    <li><a href="index.php?pag=Conta" <?php if(@$_GET['pag'] == "Conta"){} ?> class="hide-on-med-and-down">Conta</a></li>
                    <li><a href="index.php?pag=Sair" <?php if(@$_GET['pag'] == "Sair"){include("class/sair.php");}?>>Sair</a></li>
          		</ul>
          		<ul class="side-nav" id="mobile-demo">
            		<li><a href="index.php?pag=Ranking" <?php if(@$_GET['pag'] == "Ranking"){}?>>Ranking</a></li>
            		<li><a href="index.php?pag=Times" <?php if(@$_GET['pag'] == "Times"){} ?> >Times</a></li>
                    <li><a href="index.php?pag=Partidas" <?php if(@$_GET['pag'] == "Partidas"){} ?>>Partidas</a></li>
                    <li><a href="index.php?pag=Campos"<?php if(@$_GET['pag']== "Campos"){}?> >Campos</a></li>
                    <li><a href="index.php?pag=Conta" <?php if(@$_GET['pag'] == "Conta"){} ?> class="hide-on-med-and-down">Conta</a></li>
                    <li><a href="index.php?pag=Sair" <?php if(@$_GET['pag'] == "Sair"){include("class/sair.php");}?>>Sair</a></li>
          		</ul>                
                
        	</div>
    	</nav>
	</div>
    
	<div class="container">
        <div class="row" style="margin-top:50px;">
        	<div class="col s12">                
                <!-- Corpo da Página -->
                <div class="row white z-depth-5" style="margin-bottom:0px; padding-top:10px; padding-left:20px; padding-right:20px; padding-bottom:100px;">
                	
                    <?php 
						header('Content-Type: text/html; charset=UTF-8;');
						if(!isset($_GET['pag']))
						{
							include("Ranking.php");
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
                	<?php include("Patrocinio.php"); ?>
                </div>
        		<!-- Fim dos Patrocinadores ->
                <!-- Fim do Opcional Patrocinadores -->
                
                <!-- Créditos -->
                <div class="row">
                	<footer class="page-footer  grey darken-4 white-text z-depth-5" style="margin:0px;">
                    	<div class="container">
                        	<div class="row">
                          		<div class="col l6 s12">
                            		<h5 class="white-text">Bom Jogo</h5>
                            		<p class="grey-text text-lighten-4">O website Bom jogo oferece um meio seguro, dinâmico e rápido para marcar partidas de futebol. Cadastre-se e aproveite melhor a vida!</p>
                          		</div>
                          		<div class="col l4 offset-l2 s12">
                            		<h5 class="white-text">Social</h5>
                            		<ul>
                              			<li><a class="grey-text text-lighten-3" href="https://www.facebook.com/isaque.coelho.7">Administrador</a></li>
                              			<li><a class="grey-text text-lighten-3" href="https://www.facebook.com/isaque.coelho.7">Desenvolvedor</a></li>
                            		</ul>
                          		</div>
                        	</div>
                            <div class="row"><div class="col s12">Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
                      </div>
                      <div class="footer-copyright">
                      	<div class="container">
                        	Bom Jogo © 2016 Copyright reserved. Desenvolvido baseado no Design <a href="http://materializecss.com/">Materialize</a> por
                        	<a href="#">Isaque D. Coelho</a>
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
    <!-- Mascaras -->
    <script type="text/javascript" src="js/jquery.mask.min.js"></script>
    <!-- Fim das mascaras -->
    
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
    });	
	
	$(document).ready(function() {
       		 $('.CPF').mask('000.000.000-00', {reverse:true});// CPF
			 $('.RG').mask('00.000.000-00', {reverse:true});// RG
			 $('.Tel').mask('(00)0000-0000', {reverse:true});//Telefone
			 $('.TelCel').mask('(00)0 0000-0000', {reverse:true});//Celular
			 $('.QTDpontuacao').mask('000', {reverse:false});//Pontuacao
			 
			 var mask = function (val) {
				val = val.split(":");
				return (parseInt(val[0]) > 19)? "HZ:M0" : "H0:M0";
			}
			
			pattern = {
				onKeyPress: function(val, e, field, options) {
					field.mask(mask.apply({}, arguments), options);
				},
				translation: {
					'H': { pattern: /[0-2]/, optional: false },
					'Z': { pattern: /[0-3]/, optional: false },
					'M': { pattern: /[0-5]/, optional: false }
				},
				placeholder: 'hh:mm'
			};
			
			$("#Horario").mask(mask, pattern);
			 
			//$("#Time").keyup(){}
    });
	
	//Conta caracteres	
	$(document).ready(function() {
    		$('input#input_text, textarea#textarea1').characterCounter();
  	});
	
	$(document).ready(function(){
		
		$(document).on('click', '#close_EditPartidas', function(e){
 					window.location.reload();	
		})
        
    });
	
	$(document).ready(function() {
		Materialize.updateTextFields();
	  });	
		
	$(document).ready(function (e)
	{
		$('.datepicker').pickadate(
		{
    		selectMonths: true, // Creates a dropdown to control month
    		selectYears: 15 // Creates a dropdown of 15 years to control year
  		});			  
	});
	
	//Editar Partidas
	$(document).ready(function() {
        $(document).on('click', '#btnEditarPartida', function(e){
			e.preventDefault();
			
			var uid = $(this).data('id');
			$('#content-editPartida').html('');
			$('#progressBar-EditPartida').show();
			
			$.ajax({
				url: 'partidas/EditPartidas.php',
				type: 'POST',
				data: 'id='+uid,
				dataType: 'html'
			})
			.done(function(data){
				console.log(data);
				$('#content-editPartida').html('');
				$('#content-editPartida').html(data);
				$('#progressBar-EditPartida').hide();
			})
			.fail(function(){
				$('#content-editPartida').html('Erro no carregamento da pagina');
				$('#progressBar-EditPartida').hide();
			});
		})
    });
	
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
  
  //Validando formulário
	function Valida(CriaPartida)
	{		
		if(CriaPartida.MarcarData.value == "")
		{
			Materialize.toast('<span>Campo de Data não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red'); // 4000 ms is the toast duration
			return false;
		}
		
		if(CriaPartida.Time.value == "")
		{
			Materialize.toast('<span>Campo de Time não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red'); // 4000 ms is the toast duration
			return false;
		}
		
		if(CriaPartida.Horario.value == "")
		{
			Materialize.toast('<span>Hora da partida não correto <i class="material-icons right">report_problem</i></span>', 4000, 'red'); // 4000 ms is the toast duration
			return false;
		}
		
		if(CriaPartida.Rua.value == "")
		{
			Materialize.toast('<span>Campo de Rua não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red'); // 4000 ms is the toast duration
			return false;
		}
		
		if(CriaPartida.Numero.value == "")
		{
			Materialize.toast('<span>Campo de Nº da Casa não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red'); // 4000 ms is the toast duration
			return false;
		}
		
		if(CriaPartida.Bairro.value == "")
		{
			Materialize.toast('<span>Campo de Bairro não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red'); // 4000 ms is the toast duration
			return false;
		}
		
		if(CriaPartida.Cidade.value == "")
		{
			Materialize.toast('<span>Campo de Cidade não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red'); // 4000 ms is the toast duration
			return false;
		}
		return true;
	}
	
</script>
    
</body>
</html>