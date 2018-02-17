<?php
	session_start();
	if(!isset($_SESSION['ID']) || !isset($_SESSION['EMAIL']) || !isset($_SESSION['PRIV']) || $_SESSION['PRIV'] == "0")
	{
		session_destroy();
		header("Location:../Home.php");
	}
	include("../class/conexao.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php header('Content-Type: text/html; charset=UTF-8;'); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Isaque D. Coelho" />
	<!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="../css/padrao.css"/>
    <link type="text/css" rel="stylesheet" href="../css/remodal.css">
    <link type="text/css" rel="stylesheet" href="../css/remodal-default-theme.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
</head>
<body>
	
    <div class="navbar-fixed">
        <nav class="teal darken-4">
        	<div class="nav-wrapper">
          		<a href="index.php" class="brand-logo" style="font-size:24px; margin-left:5px;"> Bom jogo</a>
          		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          		<ul class="right hide-on-med-and-down">
            		<li><a href="index.php?pag=Home"<?php if(@$_GET['pag'] == "Home"){}?>>Home</a></li>
                    <li><a href="index.php?pag=Ranking"<?php if(@$_GET['pag'] == "Ranking"){}?>>Ranking</a></li>
            		<li><a href="index.php?pag=Times"<?php if(@$_GET['pag'] == "Times"){}?>>Times</a></li>
                    <li><a href="index.php?pag=Controle"<?php if(@$_GET['pag'] == "Controle"){}?>>Controle</a></li>
                    <li><a href="index.php?pag=Pagamentos"<?php if(@$_GET['pag'] == "Pagamento"){}?>>Pagamentos</a></li>
            		<li><a href="index.php?pag=Sair"<?php if(@$_GET['pag'] == "Sair"){ include("../class/sair.php"); }?>>Sair</a></li>
          		</ul>
          		<ul class="side-nav" id="mobile-demo">
            		<li><a href="index.php?pag=Home"<?php if(@$_GET['pag'] == "Home"){}?>>Home</a></li>
                    <li><a href="index.php?pag=Ranking"<?php if(@$_GET['pag'] == "Ranking"){}?>>Ranking</a></li>
            		<li><a href="index.php?pag=Times"<?php if(@$_GET['pag'] == "Times"){}?>>Times</a></li>
                    <li><a href="index.php?pag=Controle"<?php if(@$_GET['pag'] == "Controle"){}?>>Controle</a></li>
                    <li><a href="index.php?pag=Pagamentos"<?php if(@$_GET['pag'] == "Pagamento"){}?>>Pagamentos</a></li>
            		<li><a href="index.php?pag=Sair"<?php if(@$_GET['pag'] == "Sair"){ include("../class/sair.php"); }?>>Sair</a></li>
          		</ul>
        	</div>
    	</nav>
	</div>
    
	<div class="container">
        <div class="row" style="margin-top:50px;">
        	<div class="col s12">                
                <!-- Corpo da Página -->
                <div class="row white z-depth-5" style="margin-bottom:0px; padding:20px;">
                	<?php 
				
						if(!isset($_GET['pag']))
						{
							include("Home.php");
						}
						else
						{
							include(@$_GET['pag'].".php");
						}
					?>
                </div>
                <!-- Fim do Corpo da Página -->               
            </div>
        </div>
    </div>
          

	<script type="text/javascript" src="../js/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <!--MaskedBox-->
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <!--MaskedBox-->
    <!--Modal-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/zepto/1.1.4/zepto.js"></script>
	<script>window.Zepto || document.write('<script src="../libs/zepto/zepto.min.js"><\/script>')</script>
    <script type="text/javascript" src="../js/remodal.min.js"></script>    
    <!--Fim Modal-->    
    <script>
    	$( document ).ready(function()
		{
			$(".button-collapse").sideNav(
			{
				inDuration: 300,
				outDuration: 225,
				constrain_width: false, // Does not change width of dropdown to that of the activator
				hover: true, // Activate on hover
				gutter: 0, // Spacing from edge
				belowOrigin: false, // Displays dropdown below the button
				alignment: 'left' // Displays dropdown with edge aligned to the left of button
			});
			
			$('select').material_select();
			
			$('.CPF').mask('000.000.000-00');// CPF
			$('.RG').mask('00.000.000-00');// RG
			$('.Tel').mask('(000) 0000-0000'); // Telefone residencial
			$('.TelCel').mask('(000)0 0000-0000'); //Telefone celular
			
			//Evento do botão para Editar Post
			$(document).on('click', '#Edit_Post', function(e){
				e.preventDefault();
				
				var id_post = $(this).data('id');//Pega o id do botão de Editar Post
				$('#conteudo-EditPostModal').html();
				$('#progressBar-EditPost').show();
				
				$.ajax({
					url:'Post/EditPost.php',
					type:'POST',
					data:'id='+id_post,
					dataType:'html'
				})
				.done(function(data){
					console.log(data);
					$('#conteudo-EditPostModal').html('');
					$('#conteudo-EditPostModal').html(data);
					$('#progressBar-EditPost').hide();
				})
				.fail(function(){
					$('#conteudo-EditPostModal').html();
					$('#progressBar-EditPost').hide();	
				});
			})
			
			$(document).on('click', '#fechar_form_editCampos', function(e){
				window.location.reload();
			})
			
			
			//Evento do botão para Editar Campo
			$(document).on('click', '#Edit_Campo', function(e){
				e.preventDefault();
				
				var id_campo = $(this).data('id');//Pega o id do botão de Editar Campo
				$('#conteudo-EditCampoModal').html();
				$('#progressBar-EditCampo').show();
				
				$.ajax({
					url:'Campos/EditCampos.php',
					type:'POST',
					data:'id='+id_campo,
					dataType:'html'
				})
				.done(function(data){
					console.log(data);
					$('#conteudo-EditCampoModal').html('');
					$('#conteudo-EditCampoModal').html(data);
					$('#progressBar-EditCampo').hide();
				})
				.fail(function(){
					$('#conteudo-EditCampoModal').html();
					$('#progressBar-EditCampo').hide();	
				});
			})
			
			//Evento do botão para Editar Patrocinador
			$(document).on('click', '#Edit_Patrocinador', function(e){
				e.preventDefault();
				
				var id_patrocinador = $(this).data('id');//Pega o id do botão de Editar Patrocinador
				$('#conteudo-EditPatrocinadorModal').html();
				$('#progressBar-EditPatrocinador').show();
				
				$.ajax({
					url:'Patrocinadores/EditPatrocinador.php',
					type:'POST',
					data:'id='+id_patrocinador,
					dataType:'html'
				})
				.done(function(data){
					console.log(data);
					$('#conteudo-EditPatrocinadorModal').html('');
					$('#conteudo-EditPatrocinadorModal').html(data);
					$('#progressBar-EditPatrocinador').hide();
				})
				.fail(function(){
					$('#conteudo-EditPatrocinadorModal').html();
					$('#progressBar-EditPatrocinador').hide();	
				});
			})
		});    
    </script>
   <!-- Modal -->
    <script>
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