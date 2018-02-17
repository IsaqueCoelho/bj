<?php
	$ProcuraDesafiante = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
	$ProcuraDesafiante->execute(array($RecebeNotificacao[1]));
	$Desafiante = $ProcuraDesafiante->fetch(PDO::FETCH_NUM);	
	$ProcuraPartida = $conexao->prepare("SELECT `tipo_campo`, `data`, `horario`, `rua`, `numero`, `bairro`, `cidade` FROM `partida` WHERE `id` = ?");
	$ProcuraPartida->execute(array($RecebeNotificacao[3]));
	$RecebePartida = $ProcuraPartida->fetch(PDO::FETCH_NUM);
	
	if($RecebePartida[0] == 0){$campo = "Normal";} else	{$campo = "Society";}
	
	echo "	<div class='col s12 m6'>
				<div class='card blue lighten-1'>
					<div class='card-content white-text'>
						<span class='card-title'><b>Desafiado</b></span>
						<p> <b>".$Desafiante[0]."</b> te <b><u>desafiou</b></u> para o dia: <b>".implode("/", array_reverse(explode("-",$RecebePartida[1])))."</b>, no horário: <b>".$RecebePartida[2]."</b>, em campo: <b>".$campo."</b>, endereço: Rua <b>".$RecebePartida[3]."</b>, Nº <b>".$RecebePartida[4]."</b>, <b>".$RecebePartida[5]."</b>, <b>".$RecebePartida[6]."</b>.</p>
					</div>
					<div class='card-action' style='border-top:solid #0d47a1;'>
						<button type='submit' class='btn-floating blue darken-1 waves-effect waves-blue' name='AceitaNotifiRecebe' value=".$RecebeNotificacao[0]."><i class='material-icons'>done</i></button><button type='submit' class='btn-floating red darken-1 waves-effect waves-red' name='RejeitaNotifiRecebe' value=".$RecebeNotificacao[0]."><i class='material-icons'>delete</i></button>
					</div>
				</div>
			</div>";
?>