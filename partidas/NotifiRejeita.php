<?php
	$ProcuraUserRejeito = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
	$ProcuraUserRejeito->execute(array($RecebeNotificacao[1]));
	$UserRejeito = $ProcuraUserRejeito->fetch(PDO::FETCH_NUM);	
	$ProcuraPartida = $conexao->prepare("SELECT DATE_FORMAT(`data`, '%d/%m/%Y'), `horario` FROM `partida` WHERE `id` = ?");
	$ProcuraPartida->execute(array($RecebeNotificacao[3]));
	$RecebePartidaRejeitada = $ProcuraPartida->fetch(PDO::FETCH_NUM);
	
	echo "	<div class='col s12 m6'>
				<div class='card red lighten-1'>
					<div class='card-content white-text'>
						<span class='card-title'><b>Recusado</b></span>
						<p><b>".$UserRejeito[0]."</b> <b><u>recusou</u></b> seu desafio para o dia <b>".$RecebePartidaRejeitada[0]."</b> no horário <b>".$RecebePartidaRejeitada[1]."!</b></p>
					</div>
					<div class='card-action' style='border-top:solid #d32f2f;'>
						<button type='submit' class='btn-floating blue darken-1 waves-effect waves-blue' name='VisualizaNotifiRejeita' value=".$RecebeNotificacao[0]."><i class='material-icons'>done</i></button>
					</div>
				</div>
			</div>";
?>