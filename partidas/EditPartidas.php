<?php
	if($_REQUEST['id'])
	{
		include("../class/conexao.php");
		$idNotifi = intval($_REQUEST['id']);
		
		$idPart = $conexao->prepare("SELECT `id_partida` FROM `notificacao` WHERE `id` = ?");
		$idPart->execute(array($idNotifi));
		$idPartida = $idPart->fetch(PDO::FETCH_NUM);
		$BuscaPartida = $conexao->prepare("SELECT `tipo_campo`, `data`, `horario`, `rua`, `numero`, `bairro`, `cidade` FROM `partida` WHERE `id` = ?");
		$BuscaPartida->execute(array($idPartida[0]));
		$BusPartida = $BuscaPartida->fetch(PDO::FETCH_NUM);
		
		if($BusPartida[0] == 0)
		{
			$campoNormal = "checked";
			$campoSociety = "";
		}
		else
		{
			$campoNormal = "";
			$campoSociety = "checked";
		}
		
?>
<form name="editando_partidas" method="post">
    <div class="row" style="margin-top:45px;">
        <center><span><b>Dados da partida</b></span></center>                   
    
        <div class="col s12 m6">
            <div class="input-field">
                <input id="MarcarData_partida" <?php echo "value='".implode("/",array_reverse(explode("-",$BusPartida[1])))."'"?> type="text" placeholder="Clique aqui e Selecione a Data" style="margin-top:15px;" name="MarcarData_partida" onclick="Materialize.toast('Marque no mínimo 2 DIAS ANTES da partida!', 7000, 'green white-text')">
            </div>            
        </div>
        
        <div class="col s12 m3">
            <div class="input-field" style="margin-top:30px;">
                <input type="text" class="validate HorarioPartida" <?php echo "value='".$BusPartida[2]."'"?> id="Horario_EditPartida"  maxlength="5" />
                <label for="Horario">Horário</label>                
            </div> 
        </div>
        
        <div class="col s12 m3">
            <ul  style="margin-top:30px;">
                <li>            	
                    <input class="with-gap" name="group3" type="radio" id="Campo" value="0" <?php echo "".$campoNormal.""?>/>
                    <label for="Campo">Campo</label>
                    <input class="with-gap" name="group3" type="radio" id="Socyte" value="1" <?php echo "".$campoSociety.""?> />
                    <label for="Socyte">Socyte</label>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="row" style="margin-top:45px;">
        <center><span><b>Endereço do Campo</b></span></center>
        <div class="input-field col s12 m10">
            <input id="EditPart_Rua" type="text" length="120" <?php echo "value='".$BusPartida[3]."'"?>>
            <label for="EditPart_Rua">Rua:</label>
        </div>
        <div class="input-field col s12 m2">
            <input id="EditPart_Num" type="text" length="4" maxlength="4" <?php echo "value='".$BusPartida[4]."'"?>>
            <label for="EditPart_Num">Número:</label>
        </div>
        <div class="input-field col s12 m6"  style="margin-top:75px;">
            <input id="EditPart_Bairro" type="text" length="80" <?php echo "value='".$BusPartida[5]."'"?>>
            <label for="EditPart_Bairro">Bairro</label>
        </div>
        <div class="input-field col s12 m6"  style="margin-top:75px;">
            <input id="EditPart_Cidade" type="text" length="80" <?php echo "value='".$BusPartida[6]."'"?>>
            <label for="EditPart_Cidade">Cidade</label>
        </div>
    </div>
    <div class="row" style="margin-top:75px;">
        <button type="button" id="EditarPartidaAgora" data-id="<?php echo $idPartida[0]?>" class="btn red darken-1 white-text">Editar</button>
    </div>
</form>
<?php }?>

<script>
	$(document).ready(function(e) {
        $('.MarcarData_partida').mask('00/00/00',{reverse:true});
    });
	
	$(document).ready(function() {
		Materialize.updateTextFields();
	  });
	
	$(document).ready(function() {
        $(document).on('click', '#EditarPartidaAgora', function(e){
			e.preventDefault();
			var id_partida = $(this).data('id');
			var campo_tipo;
			if(document.editando_partidas.group3[0].checked == true)
			{
				campo_tipo = 0;
			}
			else
			{
				campo_tipo = 1;
			}
										
			$.ajax({
				url: 'class/EditaPartida.php',
				type: 'POST',
				data: 'idPartida='+id_partida+'&campo='+campo_tipo+'&data_Parti='+$("#MarcarData_partida").val()+'&hora='+$("#Horario_EditPartida").val()+'&rua='+$("#EditPart_Rua").val()+'&num='+$("#EditPart_Num").val()+'&bairro='+$("#EditPart_Bairro").val()+'&cidade='+$("#EditPart_Cidade").val(),
				dataType: 'html'
				
			})	
			.done(function(data){
				console.log(data);
				
				if(data == "0")
				{
					Materialize.toast('Partida Editada', 4000, 'blue white-text');
				}
				else if(data == "1")
				{
					Materialize.toast('Data de partida invalida', 4000, 'yellow black-text');
				}
				else
				{
					alert('Erro: '+data+' Contacte administrador do site');
				}
			})
			.fail(function(){				  
					  Materialize.toast('Erro ao editar partida, contacte administrador', 4000);
			})
		})
    });
</script>