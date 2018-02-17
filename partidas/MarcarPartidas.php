<?php
	require_once "class/MarcarPartidas.php";
	if(isset($_POST['btnMarcar']))
	{
		if(isset($_POST['MarcarData']) && isset($_POST['Time']) && isset($_POST['Horario']) && isset($_POST['Rua']) && isset($_POST['Numero']) && isset($_POST['Bairro']) && isset($_POST['Cidade']))
		{
			if(marcarPartida($_SESSION['ID'], $_POST['Tipo_Campo'], $_POST['MarcarData'], $_POST['Horario'], $_POST['Rua'], $_POST['Numero'], $_POST['Bairro'], $_POST['Cidade'], $_POST['Time']))
			{
				echo "<script> window.onload = function() {
					  //executado quando tudo na página está carregado					  
					  Materialize.toast('Partida Marcada', 4000, 'blue white-text');
					};</script>";
			}
		}
	}
?>
<form name="CriaPartida" onsubmit="return Valida(this)" method="post">
    <div class="row">
        <div class="col s12 m6">
            <input id="birthdate" type="date" class="datepicker" placeholder="Clique aqui e Selecione a Data" style="margin-top:15px;" name="MarcarData" onclick="Materialize.toast('Marque no mínimo 2 DIAS ANTES da partida!', 7000, 'green white-text')">
        </div>
        <div class="col s12 m6">
            <div class="input-field">
                <input type="text" class="validate autocomplete" id="Time" length="60" maxlength="60" name="Time"/>
                <label for="Time">Time Adversário</label>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col s12 m6">
            <div class="input-field">
                <input type="text" class="validate" id="Horario" name="Horario" maxlength="5" />
                <label for="Horario">Horário</label>                
            </div> 
        </div>
    </div>
        
    <div class="row">
        <center><b>Endereço do campo</b></center>
        
        <div class="col s12">
            <div class="input-field">
                <b>Tipo de Campo</b>
                <br>
                <input class="with-gap" name="Tipo_Campo" type="radio" id="Normal" value="0" checked />
                <label for="Normal">Normal</label>
                <input class="with-gap" name="Tipo_Campo" type="radio" id="Society"  value="1" />
                <label for="Society">Society</label>
                <br>
            </div>
        </div>
        
        <div class="col s12 m10">
            <div class="input-field">
                <input type="text" class="validate" id="Rua" length="60" maxlength="60" name="Rua"/>
                <label for="Rua">Rua</label>                
            </div> 
        </div>
        <div class="col s12 m2">
            <div class="input-field">
                <input type="text" class="validate" id="Numero" length="4" maxlength="4" name="Numero"/>
                <label for="Numero">Número</label>                
            </div> 
        </div>
        <div class="col s12 m6">
            <div class="input-field">
                <input type="text" class="validate" id="Bairro" length="30" maxlength="30" name="Bairro"/>
                <label for="Bairro">Bairro</label>                
            </div> 
        </div>
        <div class="col s12 m6">
            <div class="input-field">
                <input type="text" class="validate" id="Cidade" length="20" maxlength="20" name="Cidade"/>
                <label for="Cidade">Cidade</label>                
            </div> 
        </div>
    </div>
        
    <div class="row">
        <button type="submit" class="btn red darken-1 white-text waves-effect waves-yellow" name="btnMarcar" style="margin-left:35%;" formmethod="post">Marcar</button>
    </div>
</form>