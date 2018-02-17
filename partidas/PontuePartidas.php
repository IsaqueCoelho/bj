<?php
	if(isset($_POST['pontuar_partida']) && isset($_POST['Pontuacao_Desafiante']) && isset($_POST['Pontuacao_Desafiado']))
	{
		$BuscPontuacaoPartida = $conexao->prepare("SELECT `pontos_desafiante`, `pontos_desafiado` FROM `pontuacao` WHERE `id_partida` = ?");
		$BuscPontuacaoPartida->execute(array($_POST['pontuar_partida']));
		$BPP = $BuscPontuacaoPartida->fetch(PDO::FETCH_NUM);
		
		if((count($BPP)) == 1)
		{
			//Insere pontuacoes da partida
			$InsertPontuacoes = $conexao->prepare("INSERT INTO `pontuacao` (`id_partida`, `id_usuario`, `pontos_desafiante`, `pontos_desafiado`) VALUES (?,?,?,?)");
			$InsertPontuacoes->execute(array($_POST['pontuar_partida'], $_SESSION['ID'], $_POST['Pontuacao_Desafiante'], $_POST['Pontuacao_Desafiado']));
			$Updatepartida = $conexao->prepare("UPDATE `partida` SET `usuario_pontuando_partida` = ? WHERE `id` = ?");
			$Updatepartida->execute(array($_SESSION['ID'], $_POST['pontuar_partida']));
			echo "<script>window.onload = function(){Materialize.toast('Pontuações realizadas com sucesso', 4000, 'blue white-text')};</script>";
		}
		else
		{
			if(($BPP[0] == $_POST['Pontuacao_Desafiante']) && ($BPP[1] == $_POST['Pontuacao_Desafiado']))
			{
				//Busca id dos competidores
				$BuscCompetidores = $conexao->prepare("SELECT `id_desafiante`, `id_desafiado` FROM `partida` WHERE `id` = ?");
				$BuscCompetidores->execute(array($_POST['pontuar_partida']));
				$BC = $BuscCompetidores->fetch(PDO::FETCH_NUM);
				//Busca pontos no banco
				$BuscPontosDesafiante = $conexao->prepare("SELECT `pontos` FROM `ranking` WHERE `id_usuario` = ?");
				$BuscPontosDesafiante->execute(array($BC[0]));
				$BPDte = $BuscPontosDesafiante->fetch(PDO::FETCH_NUM);
				$BuscPontosDesafiado = $conexao->prepare("SELECT `pontos` FROM `ranking` WHERE `id_usuario` = ?");
				$BuscPontosDesafiado->execute(array($BC[1]));
				$BPDdo = $BuscPontosDesafiado->fetch(PDO::FETCH_NUM);
				$BPP[0] += $BPDte[0];
				$BPP[1] += $BPDdo[0];
				//Acrescenta pontuacao no ranking
				$InsertPontuacaoDesafiante = $conexao->prepare("UPDATE `ranking` SET `pontos` = ? WHERE `id_usuario` = ?");
				$InsertPontuacaoDesafiante->execute(array($BPP[0], $BC[0]));
				$InsertPontuacaoDesafiado = $conexao->prepare("UPDATE `ranking` SET `pontos` = ? WHERE `id_usuario` = ?");
				$InsertPontuacaoDesafiado->execute(array($BPP[1], $BC[1]));
				//Altera status de partida para pontuado
				$UpdatePartida = $conexao->prepare("UPDATE `partida` SET `pontuado` = ? WHERE `id` = ? ");
				$UpdatePartida->execute(array(1, $_POST['pontuar_partida']));
				echo "<script>window.onload = function(){Materialize.toast('Pontuações realizadas com sucesso', 4000, 'blue white-text')};</script>";
			}
			else
			{
				//Deleta a pontuacao
				$DeletePontuacoes = $conexao->prepare("DELETE FROM `pontuacao` WHERE `id_partida` = ?");
				$DeletePontuacoes->execute(array($_POST['pontuar_partida']));
				$UpdatePartida = $conexao->prepare("UPDATE `partida` SET `pontuado` = ? WHERE `id` = ? ");
				$UpdatePartida->execute(array(1, $_POST['pontuar_partida']));
				echo "<script>window.onload = function(){Materialize.toast('Pontuação Incompatível, os times não receberão pontos no Ranking!', 4000, 'red white-text')};</script>";
			}
		}
	}
	if(isset($_POST['reportar_partida']))
	{
		$BuscaUsuarioReportado = $conexao->prepare("SELECT `id_desafiante`, `id_desafiado` FROM `partida` WHERE `id` = ?");
		$BuscaUsuarioReportado->execute(array($_POST['reportar_partida']));
		$BUR = $BuscaUsuarioReportado->fetch(PDO::FETCH_NUM);
		if($BUR[0] == $_SESSION['ID'])
		{
			$user_reportado = $BUR[1];
		}
		else
		{
			$user_reportado = $BUR[0];
		}
		$InsertReport = $conexao->prepare("INSERT INTO `reporte` (`id_partida`, `id_reportante`, `id_reportado`, `status`) VALUES (?,?,?,?)");
		$InsertReport->execute(array($_POST['reportar_partida'], $_SESSION['ID'], $user_reportado, 0));
		echo "<script>window.onload = function(){Materialize.toast('Partida Reportada. Você ainda pode pontuar normalmente!', 4000, 'yellow darken-2 black-text')};</script>";
	}
?>
<div class="row" style="padding-left:10px; padding-right:15px;">
	<form method="post">
		<?php
			$startBuscPartida = 0;
			$QTDBuscaPartidasFeitas = $conexao->prepare("SELECT COUNT(*) FROM `partida` WHERE `data` BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND DATE_SUB(NOW(), INTERVAL 1 DAY) AND (`id_desafiante` = ? OR `id_desafiado` = ?) AND (`usuario_pontuando_partida` <> ?) AND (`pontuado` = 0)");
			$QTDBuscaPartidasFeitas->execute(array($_SESSION['ID'], $_SESSION['ID'], $_SESSION['ID']));
			$QTDPartiFeitas = $QTDBuscaPartidasFeitas->fetch(PDO::FETCH_NUM);
			$totalpaginasPartidasFeitas = ceil($QTDPartiFeitas[0]/1);
			if(isset($_GET['pagPontua']))
			{
				$pgPontua = $_GET['pagPontua'];
				$startBuscPartida = ($pgPontua - 1) * 1;
			}
			else
			{
				isset($_GET['pagPontua']);
				$pgPontua = 1;
			}
			
			$BuscPartFeita = $conexao->prepare("SELECT `id`, `id_desafiante`, `id_desafiado`, `data` FROM `partida` WHERE `data` BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND DATE_SUB(NOW(), INTERVAL 1 DAY) AND (`id_desafiante` = ? OR `id_desafiado` = ?) AND (`usuario_pontuando_partida` <> ?) AND (`pontuado` = 0) ORDER BY `id` DESC LIMIT $startBuscPartida, 1");
			$BuscPartFeita->execute(array($_SESSION['ID'], $_SESSION['ID'], $_SESSION['ID']));
			while(($BPF = $BuscPartFeita->fetch(PDO::FETCH_NUM)) && ($BPF != NULL))
			{
				$BuscaTimeDesafiante = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
				$BuscaTimeDesafiante->execute(array($BPF[1]));
				$Desafiante = $BuscaTimeDesafiante->fetch(PDO::FETCH_NUM);
				$BuscaTimeDesafiado = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
				$BuscaTimeDesafiado->execute(array($BPF[2]));
				$Desafiado = $BuscaTimeDesafiado->fetch(PDO::FETCH_NUM);			
				
				echo "
						<div class='card blue lighten-5 col s12'>
							<div class='col s12 m3' style='padding-top:10px'> <label>Partida do dia: <b>".implode('/', array_reverse(explode('-', $BPF[3])))."</b></label> </div>
							<div class='col s12 m3'>
								<div class='input-field'>
									<input name='Pontuacao_Desafiante' type='text' class='validate QTDpontuacao'/>
									<label for='Pontuacao_Desafiante'>".$Desafiante[0]."</label>
								</div>
							</div>
							<div class='col s12 m3'>
								<div class='input-field'>
									<input name='Pontuacao_Desafiado' type='text' class='validate QTDpontuacao'/>
									<label for='Pontuacao_Desafiado'>".$Desafiado[0]."</label>
								</div>
							</div>
							<div class='col s12 m3'><center>
								<button name='pontuar_partida' type='submit' value=".$BPF[0]." class='btn-floating blue darken-1' style='margin-top:20px'> <i class='material-icons'>done_all</i> </button>
								<button name='reportar_partida' type='submit' value=".$BPF[0]." data-position='top' data-delay='50' data-tooltip='Reportar' class='btn-floating red darken-1 tooltipped' style='margin-top:20px; margin-left:10px;'> <i class='material-icons'>announcement</i> </button>
							</center></div>
						</div>		
					 ";
			}	
		?>
	</form>
</div>

<div class="row">
	<ul class="pagination right-align">
		<?php
            if($totalpaginasPartidasFeitas > 0)
            {
                if($pgPontua > 1)
                {
                    echo "<li><a href='index.php?pag=Partidas&pagPontua=".($pgPontua - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
                }
                else
                {
                    echo "<li class='desabled'><i class='material-icons'>chevron_left</i></li>";
                }
                
                for($i = 1; $i <= $totalpaginasPartidasFeitas; $i++)
                {
                    if($i == $pgPontua)
                    {
                        echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>";
                    }
                    else
                    {
                        echo "<li><a href='index.php?pag=Partidas&pagPontua=".$i."'>".$i."</a></li>";
                    }
                }
                
                if($pgPontua == $totalpaginasPartidasFeitas)
                {
                    echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
                }
                else
                {
                    echo "<li><a href='index.php?pag=Partidas&pagPontua=".($pgPontua + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
                }
            }
            else
            {
                echo "	<div class='col s12 m12'>
                            <div class='card-panel brown darken-1 white-text' style='margin-left:25px; margin-right:25px;'>
                                <center>Não há jogos para pontuar!</center>
                            </div>
                        </div>";
            }
        ?>
	</ul>
</div>