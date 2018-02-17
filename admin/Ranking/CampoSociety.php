<?php
	$inicioRanking = 0;
	$BuscPaginasRanking = $conexao->prepare("SELECT COUNT(`id`) FROM `ranking` WHERE `tipo_campo` = ?");
	$BuscPaginasRanking->execute(array(1));
	$QTDPaginas = $BuscPaginasRanking->fetch(PDO::FETCH_NUM);
	$totalPaginasRanking = ceil($QTDPaginas[0]/3);
	if(isset($_GET['pagRankingSociety']))
	{
		$pgRankSociety = $_GET['pagRankingSociety'];
		$inicioRanking = ($pgRankSociety - 1) * 3;
	}
	else
	{
		isset($_GET['pagRankingSociety']);
		$pgRankSociety = 1;
	}
	
?>
<div class="row">
    <div class="card-panel blue darken-4 white-text" style="margin-top:8px;"><center>Ranking - Campo Society</center></div>
    <table class="responsive-table striped centered">
        <thead>
            <tr>
                <th>Classificação</th>
                <th>Escudo</th>
                <th>Time</th>
                <th class="blue-text">Pontos</th>
                <th class="green-text">Partidas</th>
            </tr>
        </thead>
    
        <tbody>
        	<?php
				$Classificacao = 1;
            	$BuscDadosRanking = $conexao->prepare("SELECT `id_usuario`, `pontos` FROM `ranking` WHERE `tipo_campo` = ? ORDER BY `pontos` DESC LIMIT $inicioRanking, 3");
				$BuscDadosRanking->execute(array(1));
				while($BDK = $BuscDadosRanking->fetch(PDO::FETCH_NUM))
				{
					
					$BuscDadosTime = $conexao->prepare("SELECT `nome_time`, `foto` FROM `time` WHERE `id_usuario` = ?");
					$BuscDadosTime->execute(array($BDK[0]));
					$BDT = $BuscDadosTime->fetch(PDO::FETCH_NUM);
					
					$BuscPartidasFeitas = $conexao->prepare("SELECT COUNT(`id`) FROM `partida` WHERE (`id_desafiante` = ? OR `id_desafiado` = ?) AND (`data` < NOW())");
					$BuscPartidasFeitas->execute(array($BDK[0], $BDK[0]));
					$BPF = $BuscPartidasFeitas->fetch(PDO::FETCH_NUM);
					
					echo "
							<tr>
								<td>".$Classificacao."</td>
								<td><img class='responsive-img' src='../image/times/".$BDT[1]."' width='50px'></td>
								<td>".$BDT[0]."</td>
								<td class='blue-text text-lighten-1'>".$BDK[1]."</td>
								<td class='green-text text-lighten-1'>".$BPF[0]."</td>
							</tr>
						 ";
					$Classificacao++;					
				} 
			?>
        </tbody>
    </table>
</div>
<div class="row">
    <ul class="pagination right">
    	<?php
        	if($totalPaginasRanking > 0)
			{
				if($pgRankSociety > 1)
				{
					 echo "<li><a href='index.php?pag=Ranking&pagRankingSociety=".($pgRankSociety - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
				}
				else
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_left</i></li>";
				}
				
				for($i = 1; $i <= $totalPaginasRanking; $i++)
				{
					if($i == $pgRankSociety)
					{
						 echo "<li class='active teal darken-4 white-text'>".$i."</li>";
					}
					else
					{
						echo "<li><a href='index.php?pag=Ranking&pagRankingSociety=".$i."'>".$i."</a></li>";
					}
				}
				
				if($pgRankSociety == $totalPaginasRanking)
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
				}
				else
				{
					echo "<li><a href='index.php?pag=Ranking&pagRankingSociety=".($pgRankSociety + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
				}
			}
			else
			{
				 echo "	<div class='col s12 m12'>
                            <div class='card-panel brown darken-1 white-text' style='margin-left:25px; margin-right:25px;'>
                                <center>Não há Ranking</center>
                            </div>
                        </div>";
			}
		?>
    </ul>
</div>