<?php
	if(isset($_POST['libera_user']))
	{
		$libera_user = $conexao->prepare("DELETE FROM `reporte` WHERE `id` = ?");
		$libera_user->execute(array($_POST['libera_user']));
		echo "<script> window.onload = function() {	Materialize.toast('Usuario Liberado', 3000, 'white-text'); };</script>";
	}
	
	if(isset($_POST['bloqueia_user']))
	{
		$BuscUserReportado = $conexao->prepare("SELECT `id_reportado` FROM `reporte` WHERE `id` = ?");
		$BuscUserReportado->execute(array($_POST['bloqueia_user']));
		$BUR = $BuscUserReportado->fetch(PDO::FETCH_NUM);

		$UpdateReportUser = $conexao->prepare("UPDATE `reporte` SET `status` = ? WHERE `id` = ?");
		$UpdateReportUser->execute(array(1, $_POST['bloqueia_user']));

		$Selec_Time_User_Reporte = $conexao->prepare("SELECT `reportes` FROM `time` WHERE `id_usuario` = ?");
		$Selec_Time_User_Reporte->execute(array($BUR[0]));
		$STUR = $Selec_Time_User_Reporte->fetch(PDO::FETCH_NUM);
		$qtd_reportes = $STUR[0] += 1;
		$Update_reportes_time = $conexao->prepare("UPDATE `time` SET `reportes` = ? WHERE `id_usuario` = ?");
		$Update_reportes_time->execute(array($qtd_reportes, $BUR[0]));

		$BuscReportsUser = $conexao->prepare("SELECT COUNT(`id`) FROM `reporte` WHERE `id_reportado` = ? AND `status` = ?");
		$BuscReportsUser->execute(array($BUR[0], 1));
		$BRU = $BuscReportsUser->fetch(PDO::FETCH_NUM);

		if($BRU[0] >= 2)
		{
			$BuscReportsUser = $conexao->prepare("SELECT `id` FROM `reporte` WHERE `id_reportado` = ?");
			$BuscReportsUser->execute(array($BUR[0]));
			while($BuReU = $BuscReportsUser->fetch(PDO::FETCH_NUM))
			{
				$DeleteReportsUser = $conexao->prepare("DELETE FROM `reporte` WHERE `id` = ?");
				$DeleteReportsUser->execute(array($BuReU[0]));
			}
			$InsertBloqueado = $conexao->prepare("INSERT INTO `bloqueado`(`id_usuario`, `data`) VALUES(?,?)");
			$InsertBloqueado->execute(array($BUR[0], date('Y-m-d')));
			echo "<script> window.onload = function() {	Materialize.toast('Usuario Bloqueado', 3000, 'white-text'); };</script>";
		}
		else
		{
			echo "<script> window.onload = function() {	Materialize.toast('Usuario Reportado', 3000, 'white-text'); };</script>";
		}
	}

	$inicioReportados = 0;
	$BuscPaginasReportados = $conexao->prepare("SELECT COUNT(`id`) FROM `reporte` WHERE `status` = ?");
	$BuscPaginasReportados->execute(array(0));
	$QTDPaginas = $BuscPaginasReportados->fetch(PDO::FETCH_NUM);
	$totalPaginasReportados = ceil($QTDPaginas[0]/3);
	if(isset($_GET['pagReportados']))
	{
		$pagReportados = $_GET['pagReportados'];
		$inicioReportados = ($pagReportados - 1) * 3;
	}
	else
	{
		isset($_GET['pagReportados']);
		$pagReportados = 1;
	}
?>
<table class="responsive-table striped centered">
	<thead>
		<tr>
        	<th class="blue-text">Acusador</th>
            <th class="blue-text">Time</th>
            <th class="blue-text">Email</th>
            <th class="red-text">Acusado</th>
            <th class="red-text">Time</th>
            <th class="red-text">Email</th>
            <th>Opção</th>
        </tr>
	</thead>

	<tbody>
    	<form method="post">
        <?php
			$BuscDadosReport = $conexao->prepare("SELECT `id`, `id_reportante`, `id_reportado` FROM `reporte` WHERE `status` = ? LIMIT $inicioReportados, 3");
			$BuscDadosReport->execute(array(0));
			while($BDR = $BuscDadosReport->fetch(PDO::FETCH_NUM))
			{
				//Busca dados Usuarios
				$BuscDadosUsuarioReportante = $conexao->prepare("SELECT `nome`, `email` FROM `usuario` WHERE `id` = ?");
				$BuscDadosUsuarioReportante->execute(array($BDR[1]));
				$BDUReportante = $BuscDadosUsuarioReportante->fetch(PDO::FETCH_NUM);
				$BuscDadosUsuarioReportado = $conexao->prepare("SELECT `nome`, `email` FROM `usuario` WHERE `id` = ?");
				$BuscDadosUsuarioReportado->execute(array($BDR[2]));
				$BDUReportado = $BuscDadosUsuarioReportado->fetch(PDO::FETCH_NUM);
				
				//Busca dados Time
				$BuscDadosTimeReportante = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
				$BuscDadosTimeReportante->execute(array($BDR[1]));
				$BDTReportante = $BuscDadosTimeReportante->fetch(PDO::FETCH_NUM);
				$BuscDadosTimeReportado = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
				$BuscDadosTimeReportado->execute(array($BDR[2]));
				$BDTReportado = $BuscDadosTimeReportado->fetch(PDO::FETCH_NUM);
				
				echo "
						<tr>
							<td>".$BDUReportante[0]."</td>								
							<td>".$BDTReportante[0]."</td>
							<td>".$BDUReportante[1]."</td>
							<td>".$BDUReportado[0]."</td>
							<td>".$BDTReportado[0]."</td>
							<td>".$BDUReportado[1]."</td>
							<td><button name='libera_user' value='".$BDR[0]."' class='btn-floating blue'><i class='material-icons'>verified_user</i></button><button name='bloqueia_user' value='".$BDR[0]."' class='btn-floating red'><i class='material-icons'>lock</i></button></td>
						</tr>
					 ";					
			} 
		?>
		</form>
	</tbody>
</table>
<ul class="pagination right">
    <?php
		if($totalPaginasReportados > 0)
		{
			if($pagReportados > 1)
			{
				 echo "<li><a href='index.php?pag=Controle&pagReportados=".($pagReportados - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
			}
			else
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_left</i></li>";
			}
			
			for($i = 1; $i <= $totalPaginasReportados; $i++)
			{
				if($i == $pagReportados)
				{
					 echo "<li class='active teal darken-4 white-text'>".$i."</li>";
				}
				else
				{
					echo "<li><a href='index.php?pag=Controle&pagReportados=".$i."'>".$i."</a></li>";
				}
			}
			
			if($pagReportados == $totalPaginasReportados)
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
			}
			else
			{
				echo "<li><a href='index.php?pag=Controle&pagReportados=".($pagReportados + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
			}
		}
	?>
</ul>