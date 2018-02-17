<div class="row">
<?php
	// Busca Dados da tabela ntificações
	include("class/conexao.php");
	
	if(isset($_POST['AceitaNotifiRecebe']))
	{		
		// Seta a notificação de partida recebida para visualizada/aceitada
		$AceitaVistoNotifiRecebe = $conexao->prepare("UPDATE `notificacao` SET visualizado = ? WHERE `id` = ?");
		$AceitaVistoNotifiRecebe->execute(array(1, $_POST['AceitaNotifiRecebe']));
		
		//Seleciona o id do desafiante para fazer a inserção de dado de aceito
		$AceitaVistoNotifiRecebe = $conexao->prepare("SELECT `id_criaNotifi`, `id_partida` FROM `notificacao` WHERE `id` = ?");
		$AceitaVistoNotifiRecebe->execute(array($_POST['AceitaNotifiRecebe']));
		$dadosAceitaNotifiRecebe = $AceitaVistoNotifiRecebe->fetch(PDO::FETCH_NUM);
		
		$AceitaCriaNotifiRecebe = $conexao->prepare("INSERT INTO `notificacao`(id_criaNotifi, id_recebeNotifi, id_partida, tipo, visualizado) VALUES(?,?,?,?,?)");
		$AceitaCriaNotifiRecebe->execute(array($_SESSION['ID'], $dadosAceitaNotifiRecebe[0], $dadosAceitaNotifiRecebe[1], 1, 0));		
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
	}
	
	if(isset($_POST['RejeitaNotifiRecebe']))
	{		
		//Busca o id do desafiante para criar a notificação de partida rejeitada
		$RejeitaVistoNotifiRecebe = $conexao->prepare("SELECT `id_criaNotifi`, `id_partida` FROM `notificacao` WHERE `id` = ?");
		$RejeitaVistoNotifiRecebe->execute(array($_POST['RejeitaNotifiRecebe']));
		$dadosRejeitaNotifiRecebe = $RejeitaVistoNotifiRecebe->fetch(PDO::FETCH_NUM);
		//Cria uma notificação de partida rejeitada
		$RejeitaCriaNotifiRecebe = $conexao->prepare("INSERT INTO `notificacao`(id_criaNotifi, id_recebeNotifi, id_partida, tipo, visualizado) VALUES(?,?,?,?,?)");
		$RejeitaCriaNotifiRecebe->execute(array($_SESSION['ID'], $dadosRejeitaNotifiRecebe[0], $dadosRejeitaNotifiRecebe[1], 3, 0));
		
		//Exclui a notificação de partida do banco de dados
		$RejeitaVistoNotifiRecebe = $conexao->prepare("DELETE FROM `notificacao` WHERE `id` = ?");
		$RejeitaVistoNotifiRecebe->execute(array($_POST['RejeitaNotifiRecebe']));		
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
	}
	
	if(isset($_POST['VisualizaNotifiAceito']))
	{
		// Seta a notificação de partida aceitada para visualizada
		$VisualizaNotifiAceito = $conexao->prepare("DELETE FROM `notificacao` WHERE `id` = ?");
		$VisualizaNotifiAceito->execute(array($_POST['VisualizaNotifiAceito']));		
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
	}
	
	if(isset($_POST['VisualizaNotifiEdita']))
	{
		// Seta a notificação de partida editada para visualizada
		$VisualizaNotifiEdita = $conexao->prepare("DELETE FROM `notificacao` WHERE `id` = ?");
		$VisualizaNotifiEdita->execute(array($_POST['VisualizaNotifiEdita']));		
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
	}
	
	if(isset($_POST['VisualizaNotifiRejeita']))
	{
		// Busca o id da partida 
		$schPartida = $conexao->prepare("SELECT `id_partida` FROM `notificacao` WHERE `id` = ?");
		$schPartida->execute(array($_POST['VisualizaNotifiRejeita']));
		$idPartida = $schPartida->fetch(PDO::FETCH_NUM);
		//Deleta partida do BD
		$DelPartida = $conexao->prepare("DELETE FROM `partida` WHERE `id` = ?");
		$DelPartida->execute(array($idPartida[0]));
		//Deleta notificacao do BD
		$VisualizaNotifiRejeita = $conexao->prepare("DELETE FROM `notificacao` WHERE `id` = ?");
		$VisualizaNotifiRejeita->execute(array($_POST['VisualizaNotifiRejeita']));
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
	}
?>

<form name="partidas" method="post">
	<?php
		$StartBuscaRecebeNotificacoes = 0;
		$LimiteBuscaRecebeNotificacoes = 8;
		$DefinePaginasRecebeNotificacoes = $conexao->prepare("SELECT COUNT(*) FROM `notificacao` WHERE `visualizado` = 0 AND `id_recebeNotifi` = ?");
		$DefinePaginasRecebeNotificacoes->execute(array($_SESSION['ID']));
		$PaginasRecebeNotificacoes = $DefinePaginasRecebeNotificacoes->fetch(PDO::FETCH_NUM);
		//Numero de páginas
		$totalPaginasRecebePartidas = ceil($PaginasRecebeNotificacoes[0]/$LimiteBuscaRecebeNotificacoes);
		
		if(isset($_GET['pagRecebeNotificacoes']) && $totalPaginasRecebePartidas != 0)
		{
			$pgNotificacoes = $_GET['pagRecebeNotificacoes'];
			$StartBuscaRecebeNotificacoes = ($pgNotificacoes - 1) * $LimiteBuscaRecebeNotificacoes;
		}
		else
		{
			isset($_GET['pagRecebeNotificacoes']);
			$pgNotificacoes = 1;
		}
		
        $ProcuraNotificacao = $conexao->prepare("SELECT `id`, `id_criaNotifi`, `id_recebeNotifi`, `id_partida`, `tipo`, `visualizado` FROM `notificacao` WHERE `id_recebeNotifi` = ? LIMIT $StartBuscaRecebeNotificacoes, $LimiteBuscaRecebeNotificacoes");
        $ProcuraNotificacao->execute(array($_SESSION['ID']));
        $RecebeNotificacao = $ProcuraNotificacao->fetch(PDO::FETCH_NUM);
		
		if($RecebeNotificacao != null)
		{
			do
			{
				if($RecebeNotificacao[5] == 0)
				{	
					// Verifica qual o tipo de atualização irá exibir
					if($RecebeNotificacao[4] == 0)
					{
						include("NotifiRecebe.php");
					}
					else if($RecebeNotificacao[4] == 1)
					{
						include("NotifiAceito.php");
					}
					else if($RecebeNotificacao[4] == 2)
					{
						include("NotifiEdita.php");
					}
					else if($RecebeNotificacao[4] == 3)
					{
						include("NotifiRejeita.php");
					}
				}
			}while($RecebeNotificacao = $ProcuraNotificacao->fetch(PDO::FETCH_NUM));
		}
		else
		{}
    ?>
</form>
</div>

<div class="row">
    <ul class="pagination right-align">
        <?php
		
        	if($totalPaginasRecebePartidas > 0)
			{
				if($pgNotificacoes > 1)
				{
					echo "<li><a href='index.php?pag=Partidas&pagRecebeNotificacoes=".($pgNotificacoes - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
				}
				else
				{
					echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
				}
				
				for($i = 1; $i <= $totalPaginasRecebePartidas; $i++)
				{
					if($i == $pgNotificacoes)
					{
						echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>";
					}
					else
					{
						echo "<li><a href='index.php?pag=Partidas&pagRecebeNotificacoes=".$i."'>".$i."</a></li>";
					}
				}
				
				if($pgNotificacoes == $totalPaginasRecebePartidas)
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
				}
				else
				{
					echo "<li><a href='index.php?pag=Partidas&pagRecebeNotificacoes=".($pgNotificacoes + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
				}
			}
			else
			{
				echo "	<div class='col s12 m6'>
							<div class='card-panel brown darken-1 white-text' style='margin-left:25px; margin-right:25px;'>
								<center>Não há notificações!</center>
							</div>
						</div>";
			}
		?>
    </ul>
</div>