<?php
	$inicioTimeNormal = 0;
	$BuscPaginasTimeNormal = $conexao->prepare("SELECT COUNT(`id`) FROM `time` WHERE `campo` = ?");
	$BuscPaginasTimeNormal->execute(array(0));
	$QTDPaginas = $BuscPaginasTimeNormal->fetch(PDO::FETCH_NUM);
	$totalPaginasTimeNormal = ceil($QTDPaginas[0]/3);
	if(isset($_GET['pagTimeNormal']))
	{
		$pagTimeNormal = $_GET['pagTimeNormal'];
		$inicioTimeNormal = ($pagTimeNormal - 1) * 3;
	}
	else
	{
		isset($_GET['pagTimeNormal']);
		$pagTimeNormal = 1;
	}
	
?>
<div class="row">
    <div class="card-panel blue darken-4 white-text" style="margin-top:8px;"><center>Times - Campo Normal</center></div>
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
            	$BuscDadosRankingNormal = $conexao->prepare("SELECT `id_usuario`, `pontos` FROM `ranking` WHERE `tipo_campo` = ? LIMIT $inicioTimeNormal, 3");
				$BuscDadosRankingNormal->execute(array(0));
				while($BDKN = $BuscDadosRankingNormal->fetch(PDO::FETCH_NUM))
				{
					
					$BuscDadosTime = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
					$BuscDadosTime->execute(array($BDKN[0]));
					$BDT = $BuscDadosTime->fetch(PDO::FETCH_NUM);
					
					$BuscDadosUsuario = $conexao->prepare("SELECT `nome`, `email` FROM `usuario` WHERE `id` = ?");
					$BuscDadosUsuario->execute(array($BDKN[0]));
					$BDU = $BuscDadosUsuario->fetch(PDO::FETCH_NUM);
					
					$BuscPartidasFeitas = $conexao->prepare("SELECT COUNT(`id`) FROM `partida` WHERE (`id_desafiante` = ? OR `id_desafiado` = ?) AND (`data` < NOW())");
					$BuscPartidasFeitas->execute(array($BDKN[0], $BDKN[0]));
					$BPF = $BuscPartidasFeitas->fetch(PDO::FETCH_NUM);
					
					echo "
							<tr>
								<td>".$BDU[0]."</td>								
								<td>".$BDT[0]."</td>
								<td>".$BDU[1]."</td>	
								<td class='blue-text text-lighten-1'>".$BDKN[1]."</td>
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
        	if($totalPaginasTimeNormal > 0)
			{
				if($pagTimeNormal > 1)
				{
					 echo "<li><a href='index.php?pag=Times&pagTimeNormal=".($pagTimeNormal - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
				}
				else
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_left</i></li>";
				}
				
				for($i = 1; $i <= $totalPaginasTimeNormal; $i++)
				{
					if($i == $pagTimeNormal)
					{
						 echo "<li class='active teal darken-4 white-text'>".$i."</li>";
					}
					else
					{
						echo "<li><a href='index.php?pag=Times&pagTimeNormal=".$i."'>".$i."</a></li>";
					}
				}
				
				if($pagTimeNormal == $totalPaginasTimeNormal)
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
				}
				else
				{
					echo "<li><a href='index.php?pag=Times&pagTimeNormal=".($pagTimeNormal + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
				}
			}
			else
			{
				 echo "	<div class='col s12 m12'>
                            <div class='card-panel brown darken-1 white-text' style='margin-left:25px; margin-right:25px;'>
                                <center>Não há Times de campo Normal</center>
                            </div>
                        </div>";
			}
		?>
    </ul>
</div>