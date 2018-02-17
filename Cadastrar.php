<?php
	 require_once "class/cadastrar.php";
	 
	 if(isset($_POST['Nome']) && isset($_POST['RG']) && isset($_POST['CPF']) && isset($_POST['Telefone']) && isset($_POST['Celular']) && isset($_POST['Rua']) && isset($_POST['NumCasa']) && isset($_POST['Bairro']) && isset($_POST['Cidade']) && isset($_POST['Nome_Time']) && isset($_POST['Campo']) && isset($_POST['Email']) && isset($_POST['Senha']))
	{
		if(CadUsuario($_POST['Email'],$_POST['Senha'],$_POST['Nome'],$_POST['RG'],$_POST['CPF'],$_POST['Telefone'],$_POST['Celular'],$_POST['Rua'],$_POST['NumCasa'],$_POST['Bairro'],$_POST['Cidade']))
		{			
			if(CadTime($_POST['Email'], $_POST['Nome_Time'], $_POST['Campo']))
			{
				echo "<script> window.onload = function() {					  
					  Materialize.toast('Cadastrado Time e Usuário', 4000, 'blue white-text');
					  Materialize.toast('Você tem 15 dias de acesso gratis, após isso efetue um pagamento seguro usando o botão PagSeguro na tela de login', 15000, 'blue white-text'); };</script>";
			}
			else
			{
				echo "<script> window.onload = function() { Materialize.toast('Time inválido', 4000, 'red darken-4 white-text'); };</script>";
			}
		}
		else
		{
			echo "<script> window.onload = function() { Materialize.toast('Email inválido', 4000, 'red darken-4 white-text'); };</script>";
		}				
	}
?>

<!DOCTYPE html>
<html>
<head>
	<!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="css/register.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Campos dos Melhores</title>
    
</head>
<body background="image/cad.png" style="background-color:#4caf50;">

	<?php //include("CadSlider.php");?>

    <div class="card blue-grey darken-1" style="z-index:9999; margin-left:10%; margin-right:10%; top:45px; border: solid 2px #263238;-webkit-box-shadow: 0px 5px 30px 5px rgba(0,0,0,1); -moz-box-shadow: 0px 5px 30px 5px rgba(0,0,0,1); box-shadow: 0px 5px 30px 5px rgba(0,0,0,1);">
        <div class="card-content red white-text">
            <span class="card-title blue"><center>Cadastrar</center></span>
        </div>
        <form id="FormCad" name="FormCad" onSubmit="return Valida(this)" action="" method="post">
            <div class="row">        	
                    <div class="col s12 m12 l6">    
                        <div class="input-field col s12">
                            <input id="Nome" type="text" class="validate white-text" length="30" name="Nome"  maxlength="30">
                            <label for="Nome">Nome Completo</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="RG" type="text" class="validate white-text" name="RG" maxlength="10" length="10">
                            <label for="RG">RG (só números)</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="CPF" type="text" class="validate white-text" name="CPF" maxlength="11" length="11">
                            <label for="CPF">CPF (só números)</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="Telefone" type="text" class="validate white-text" name="Telefone" maxlength="11" length="11">
                            <label for="Telefone">Telefone (só números)</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="Celular" type="text" class="validate white-text" name="Celular" maxlength="12" length="12">
                            <label for="Celular">Celular (só números)</label>
                        </div>
                            
                        <div class="input-field col s12 m9 l9 ">
                            <input id="Rua" type="text" class="validate white-text" length="60" name="Rua"  maxlength="60">
                            <label for="Rua">Rua</label>
                        </div>
                            
                        <div class="input-field col s12 m3 l3">
                            <input id="NumCasa" type="text" class="validate white-text" length="6" name="NumCasa"  maxlength="6">
                            <label for="NumCasa">Nº Casa</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="Bairro" type="text" class="validate white-text" length="30" name="Bairro"  maxlength="30">
                            <label for="Bairro">Bairro</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="Cidade" type="text" class="validate white-text" length="20" name="Cidade"  maxlength="20">
                            <label for="Cidade">Cidade</label>
                        </div>            
                    </div>
                        
                    <div class="col s12 m12 l6">
                            
                        <div class="input-field col s12">
                            <input id="NomeTime" type="text" class="validate white-text" length="80" name="Nome_Time"  maxlength="80">
                            <label for="NomeTime">Nome do Time</label>
                        </div>
                            
                        <div class="input-field col s2 white-text" style="margin-top:25px;">
                                Campo:
                        </div>
                            
                        <div class="input-field col s12 m10 l10">
                        	<input class="with-gap" name="Campo" value="0" type="radio" id="Normal" checked/>
                            <label for="Normal">Campo Normal</label>
                            <input class="with-gap" name="Campo" value="1" type="radio" id="Society"/>
                            <label for="Society">Socyte</label>                            
                        </div>
                            
                        <div class="input-field col s12">
                            <input id="Email" type="email" class="validate white-text" length="127" name="Email">
                            <label for="Email" data-error="wrong" data-success="right">Email</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="Senha" type="password" class="validate white-text" name="Senha" length="20" maxlength="20">
                            <label for="Senha">Senha</label>
                        </div>
                            
                        <div class="input-field col s12 m6 l6">
                            <input id="Senha2" type="password" class="validate white-text" name="Senha2" length="20" maxlength="20">
                            <label for="Senha2">Reescreva a senha</label>
                        </div>                
                            
                    </div>                
            </div>
                    
            <div class="card-action">
                <input type="submit" class="btn blue white-text" value="Cadastrar" formmethod="post">
                <a href="home.php" class="btn red white-text">Voltar</a> 
            </div>
		</form>
    </div>

	<script type="text/javascript" src="js/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!-- Mascaras -->
    <script type="text/javascript" src="js/jquery.mask.min.js"></script>
    <!-- Fim das mascaras -->
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
			 $('.Tel').mask('(000) 0000-0000', {reverse:true});
			 $('.TelCel').mask('(000)0 0000-0000', {reverse:true});
    });
	
	//Conta caracteres	
	 $(document).ready(function() {
		$('input#input_text, textarea#textarea1').characterCounter();
	  });
	
		
	//Formulários	
	$(document).ready(function (e)
	{
		//Data
		$('.datepicker').pickadate(
		{
    		selectMonths: true, // Creates a dropdown to control month
    		selectYears: 15 // Creates a dropdown of 15 years to control year
  		});
		
		// ComboBox
		$('select').material_select();
		
		//Contatador de caracteres
		$('input#input_text, textarea#textarea1').characterCounter();
		
	});

	//Slider
	$(document).ready(function(){$('.slider').slider({full_width: true});});	
	
	//Validando formulário
	function Valida(FormCad)
	{		
		if(FormCad.Nome.value == "")
		{
			Materialize.toast('<span>Campo de Nome não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.RG.value == "")
		{
			Materialize.toast('<span>Campo de RG não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4') // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.CPF.value == "")
		{
			Materialize.toast('<span>Campo de CPF não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Telefone.value == "")
		{
			Materialize.toast('<span>Campo de Telefone não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Celular.value == "")
		{
			Materialize.toast('<span>Campo de Celular não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Rua.value == "")
		{
			Materialize.toast('<span>Campo de Rua não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.NumCasa.value == "")
		{
			Materialize.toast('<span>Campo de Nº da Casa não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Bairro.value == "")
		{
			Materialize.toast('<span>Campo de Bairro não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Cidade.value == "")
		{
			Materialize.toast('<span>Campo de Cidade não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.NomeTime.value == "")
		{			
			Materialize.toast('<span>Campo de NomeTime não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Email.value == "")
		{
			Materialize.toast('<span>Campo de Email não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Senha.value == "")
		{
			Materialize.toast('<span>Campo de Senha não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Senha2.value == "")
		{
			Materialize.toast('<span>Campo de Confirmação de Senha não preenchido <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		
		if(FormCad.Senha.value != FormCad.Senha2.value)
		{
			Materialize.toast('<span>Senhas inconpatíveis <i class="material-icons right">report_problem</i></span>', 4000, 'red darken-4'); // 4000 is the duration of the toast
			return false;
		}
		return true;
	}
</script>
</body>
</html>