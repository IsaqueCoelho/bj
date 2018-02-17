<?php
	
	if(isset($_POST['libera_user_bloqueado']))
	{
		$DeleteUserBloqueado = $conexao->prepare("DELETE FROM `bloqueado` WHERE `id_usuario` = ?");
		$DeleteUserBloqueado->execute(array($_POST['libera_user_bloqueado']));
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
		echo "<script> window.onload = function() {	Materialize.toast('Usuario Liberado', 3000, 'white-text'); };</script>";
	}	
	
	$inicioBloqueados = 0;
	$BuscPaginasBloqueados = $conexao->prepare("SELECT COUNT(`id`) FROM `bloqueado`");
	$BuscPaginasBloqueados->execute(array(0));
	$QTDPaginas = $BuscPaginasBloqueados->fetch(PDO::FETCH_NUM);
	$totalPaginasBloqueados = ceil($QTDPaginas[0]/3);
	if(isset($_GET['pgBloqueados']))
	{
		$pgBloqueados = $_GET['pgBloqueados'];
		$inicioBloqueados = ($pgBloqueados - 1) * 3;
	}
	else
	{
		isset($_GET['pgBloqueados']);
		$pgBloqueados = 1;
	}
	
?>

<table class="responsive-table striped centered">
	<thead>
		<tr>
        	<th>Usuário</th>
            <th>Time</th>
            <th>Email</th>
            <th class="purple-text text-darken-4">Desde</th>
            <th>Opção</th>
        </tr>
	</thead>

	<tbody>
    	<form method="post">
        <?php
			$selectBloqueados = $conexao->prepare("SELECT `id_usuario`, `data` FROM `bloqueado` LIMIT $inicioBloqueados, 3");
			$selectBloqueados->execute(array(0));
			while($RB = $selectBloqueados->fetch(PDO::FETCH_NUM))
			{
				//Busca dados usuario
				$BuscDadosUsuario = $conexao->prepare("SELECT `nome`, `email` FROM `usuario` WHERE `id` = ?");
				$BuscDadosUsuario->execute(array($RB[0]));
				$BDU = $BuscDadosUsuario->fetch(PDO::FETCH_NUM);
				//Busca dados time
				$BuscDadosTime = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
				$BuscDadosTime->execute(array($RB[0]));
				$BDT = $BuscDadosTime->fetch(PDO::FETCH_NUM);
				
				echo "
						<tr>
							<td>".$BDU[0]."</td>								
							<td>".$BDT[0]."</td>
							<td>".$BDU[1]."</td>
							<td class='purple-text text-darken-4'><b>".implode('/',array_reverse(explode('-',$RB[1])))."</b></td>
							<td><button name='libera_user_bloqueado' value='".$RB[0]."' class='btn-floating blue'><i class='material-icons'>verified_user</i></button></td>
						</tr>
					 ";				
			} 
		?>
		</form>
	</tbody>
</table>
<ul class="pagination right">
    <?php
		if($totalPaginasBloqueados > 0)
		{
			if($pgBloqueados > 1)
			{
				 echo "<li><a href='index.php?pag=Controle&pgBloqueados=".($pgBloqueados - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
			}
			else
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_left</i></li>";
			}
			
			for($i = 1; $i <= $totalPaginasBloqueados; $i++)
			{
				if($i == $pgBloqueados)
				{
					 echo "<li class='active teal darken-4 white-text'>".$i."</li>";
				}
				else
				{
					echo "<li><a href='index.php?pag=Controle&pgBloqueados=".$i."'>".$i."</a></li>";
				}
			}
			
			if($pgBloqueados == $totalPaginasBloqueados)
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
			}
			else
			{
				echo "<li><a href='index.php?pag=Controle&pgBloqueados=".($pgBloqueados + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
			}
		}
	?>
</ul>