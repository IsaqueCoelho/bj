<?php
	if(isset($_POST['Delete_Post']))
	{
		$DeletePost = $conexao->prepare("DELETE FROM `noticias` WHERE `id` = ?");
		$DeletePost->execute(array($_POST['Delete_Post']));
		echo "<script> window.onload = function() {	Materialize.toast('Post Deletado', 4000);}; </script>";
	}
?>

<table class="striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Data - Horário</th>
            <th>Opções</th>
        </tr>
    </thead>

    <tbody>
    	<form method="post">
        <?php 
			require_once "BuscaListPost.php";			
			$startNotice=0;
			$limitNotice=5;
			
			// Recebe quantidade total de páginas
			$totalPagNotice = qtdPagNoticias($limitNotice);
			
			if(isset($_GET['pgNot']))
			{
				$pgNot = $_GET['pgNot'];
				$startNotice=($pgNot-1)*$limitNotice;
			}
			else
			{
				isset($_GET['pgNot']);
				$pgNot = 1;
				
			}			
			include("../class/conexao.php");
			$selectPost = $conexao->prepare("SELECT id, titulo, DATE_FORMAT(data,'%d-%m-%Y - %H:%i:%s') FROM `noticias` ORDER BY id DESC LIMIT $startNotice, $limitNotice");
			$selectPost->execute();
			$Post = $selectPost->fetch(PDO::FETCH_NUM);
			if($Post > 0)
			{		
				do
				{					
					echo "<tr>
							<td>".$Post[1]."</td>
							<td>".$Post[2]."</td>
							<td><button id='Edit_Post' data-id='".$Post[0]."' class='btn-floating green' data-remodal-target='modalPost'><i class='material-icons'>edit</i></button><button name='Delete_Post' value='".$Post[0]."' class='btn-floating red'><i class='material-icons'>delete</i></button></td>
						</tr>";
						 
				}while($Post = $selectPost->fetch(PDO::FETCH_NUM));						
			}
		?>
        </form>
    </tbody>
</table>

<ul class='pagination right'>
	<?php
		if($totalPagNotice > 0)
		{
			if($pgNot>1)
			{
				echo "<li><a href='?pgNot=".($pgNot-1)."'><i class='material-icons'>chevron_left</i></a></li>";
			}
			else
			{
				echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
			}
			
				for($i=1;$i<=$totalPagNotice;$i++)
				{
					if($i==$pgNot) { echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>"; }
				
					else { echo "<li><a href='?pgNot=".$i."'>".$i."</a></li>"; }
				}
				
			if($pgNot == $totalPagNotice)
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
			}
			else
			{
				echo "<li><a href='?pgNot=".($pgNot+1)."'><i class='material-icons'>chevron_right</i></a></li>";
			}
		}
	?>
</ul>