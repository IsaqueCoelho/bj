<?php
	$inicioTimeSociety = 0;
	$BuscPaginasTimeSociety = $conexao->prepare("SELECT COUNT(`id`) FROM `time` WHERE `campo` = ?");
	$BuscPaginasTimeSociety->execute(array(1));
	$QTDPaginas = $BuscPaginasTimeSociety->fetch(PDO::FETCH_NUM);
	$totalPaginasTimeSociety = ceil($QTDPaginas[0]/3);
	if(isset($_GET['pagTimeSociety']))
	{
		$pagTimeSociety = $_GET['pagTimeSociety'];
		$inicioTimeSociety = ($pagTimeSociety - 1) * 3;
	}
	else
	{
		isset($_GET['pagTimeSociety']);
		$pagTimeSociety = 1;
	}
	
?>
<div class="row">
    <div class="card-panel blue darken-4 white-text" style="margin-top:8px;"><center>Times - Campo Society</center></div>
    <table class="responsive-table striped centered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Time</th>
                <th>Email</th>
                <th class="blue-text">pontos</th>
                <th class="green-text">Partidas</th>
            </tr>
        </thead>
    
        <tbody>
        	<?php
            	$BuscDadosRankingSociety = $conexao->prepare("SELECT `id_usuario`, `pontos` FROM `ranking` WHERE `tipo_campo` = ? LIMIT $inicioTimeSociety, 3");
				$BuscDadosRankingSociety->execute(array(1));
				while($BDKS = $BuscDadosRankingSociety->fetch(PDO::FETCH_NUM))
				{
					
					$BuscDadosTime = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
					$BuscDadosTime->execute(array($BDKS[0]));
					$BDT = $BuscDadosTime->fetch(PDO::FETCH_NUM);
					
					$BuscDadosUsuario = $conexao->prepare("SELECT `nome`, `email` FROM `usuario` WHERE `id` = ?");
					$BuscDadosUsuario->execute(array($BDKS[0]));
					$BDU = $BuscDadosUsuario->fetch(PDO::FETCH_NUM);
					
					$BuscPartidasFeitas = $conexao->prepare("SELECT COUNT(`id`) FROM `partida` WHERE (`id_desafiante` = ? OR `id_desafiado` = ?) AND (`data` < NOW())");
					$BuscPartidasFeitas->execute(array($BDKS[0], $BDKS[0]));
					$BPF = $BuscPartidasFeitas->fetch(PDO::FETCH_NUM);
					
					echo "
							<tr>
								<td>".$BDU[0]."</td>
								<td>".$BDT[0]."</td>
								<td>".$BDU[1]."</td>								
								<td class='blue-text text-lighten-1'>".$BDKS[1]."</td>
								<td class='green-text text-lighten-1'>".$BPF[0]."</td>
							</tr>
						 ";					
				} 
			?>
        </tbody>
    </table>
</div>
<div class="row">
    <ul class="pagination right">
    	<?php
        	if($totalPaginasTimeSociety > 0)
			{
				if($pagTimeSociety > 1)
				{
					 echo "<li><a href='index.php?pag=Times&pagTimeSociety=".($pagTimeSociety - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
				}
				else
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_left</i></li>";
				}
				
				for($i = 1; $i <= $totalPaginasTimeSociety; $i++)
				{
					if($i == $pagTimeSociety)
					{
						 echo "<li class='active teal darken-4 white-text'>".$i."</li>";
					}
					else
					{
						echo "<li><a href='index.php?pag=Times&pagTimeSociety=".$i."'>".$i."</a></li>";
					}
				}
				
				if($pagTimeSociety == $totalPaginasTimeSociety)
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
				}
				else
				{
					echo "<li><a href='index.php?pag=Times&pagTimeSociety=".($pagTimeSociety + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
				}
			}
			else
			{
				 echo "	<div class='col s12 m12'>
                            <div class='card-panel brown darken-1 white-text' style='margin-left:25px; margin-right:25px;'>
                                <center>Não há Times Society</center>
                            </div>
                        </div>";
			}
		?>
    </ul>
</div>