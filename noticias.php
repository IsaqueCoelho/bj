<head>
    <meta name="author:" content="Isaque D. Coelho">
    <title> Bom Jogo </title>
</head>

<div class="row" style="margin-bottom:0px;">

	<?php
		//Define onde começa a busca e quantos registros buscar
		$startNotice = 0;
		$limitNotice = 6;
		include("class/conexao.php");
		$qtdPaginas = $conexao->prepare("SELECT COUNT(*) FROM `noticias` ORDER BY id DESC");
		$qtdPaginas->execute();
		$rows = $qtdPaginas->fetch(PDO::FETCH_NUM);
		//Define Quantas páginas existem
		$totalPagNotice = ceil($rows[0]/$limitNotice);
		
		if(isset($_GET['pgNotice']))
		{
			$pgNot = $_GET['pgNotice'];
			$startNotice=($pgNot-1)*$limitNotice;
		}
		else
		{
			isset($_GET['pgNotice']);
			$pgNot = 1;
			
		}
		
		
		// Busca os dados no banco e exibe conforme limite de registros e número de página
		$selectNoti = $conexao->prepare("SELECT titulo, DATE_FORMAT(data, '%d/%m/%Y %H:%i:%s'), descricao FROM `noticias` ORDER BY id DESC LIMIT $startNotice, $limitNotice");
		$selectNoti->execute();
		$Noticias = $selectNoti->fetch(PDO::FETCH_NUM);
		if($Noticias > 0)
		{		
			do
			{
				echo "	<div class='col s12 m6' style='padding:10px;'>
							<div class='card blue lighten-5'>
								<div class='TituloNoticia blue white-text'>
									<b>".$Noticias[0]."</b> <span class='right'> ".$Noticias[1]."</span>
								</div>
								<div class='card-content'>
									".$Noticias[2]."            
								</div>
							</div>                
						</div>";
					 
			}while($Noticias = $selectNoti->fetch(PDO::FETCH_NUM));
		}
			
	?>
</div>
<ul class="pagination right">
	<?php
		if($totalPagNotice > 0)
		{
			if($pgNot>1)
			{
				echo "<li><a href='?pgNotice=".($pgNot-1)."'><i class='material-icons'>chevron_left</i></a></li>";
			}
			else
			{
				echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
			}
			
				for($i=1;$i<=$totalPagNotice;$i++)
				{
					if($i==$pgNot) { echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>"; }
				
					else { echo "<li><a href='?pgNotice=".$i."'>".$i."</a></li>"; }
				}
				
			if($pgNot == $totalPagNotice)
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
			}
			else
			{
				echo "<li><a href='?pgNotice=".($pgNot+1)."'><i class='material-icons'>chevron_right</i></a></li>";
			}
		}
    ?>
</ul>