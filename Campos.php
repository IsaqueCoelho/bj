<div class="card-panel blue darken-4 white-text"><center>Campos</center></div>
<div class="row" style="margin-bottom:0px;">
	<?php
		//Define onde começa a busca e quantos registros buscar
		$startCampos = 0;
		$limitCampos = 12;
		include("class/conexao.php");
		$qtdPaginas = $conexao->prepare("SELECT COUNT(*) FROM `campos` ORDER BY id DESC");
		$qtdPaginas->execute();
		$rows = $qtdPaginas->fetch(PDO::FETCH_NUM);
		//Define Quantas páginas existem
		$totalPagCampos = ceil($rows[0] / $limitCampos);
		
		if(isset($_GET['pgCampos']))
		{
			$pgCamp = $_GET['pgCampos'];
			$startCampos = ($pgCamp-1) * $limitCampos;
		}
		else
		{
			isset($_GET['pgCampos']);
			$pgCamp = 1;			
		}
		
		// Busca os dados no banco e exibe conforme limite de registros e número de página
		$selectCamp = $conexao->prepare("SELECT nome, celular, tipo, endereco, imagem FROM `campos` ORDER BY id DESC LIMIT $startCampos, $limitCampos");
		$selectCamp->execute();
		$Campos = $selectCamp->fetch(PDO::FETCH_NUM);
		if($Campos > 0)
		{
			do
			{
				//Se o tipo do campo é verdadeiro, então é Society, se não então campo normal
				if($Campos[2])
				{
					$TipoCampo = "Society";
				}
				else
				{
					$TipoCampo = "Normal";
				}
				
				echo "
					<div class='col s12 m3'>
						<div class='card green lighten-5' style='max-width:400px; min-height:380px;'>
							<div class='card-image waves-effect waves-block waves-light'>
							  <img class='activator' src='image/campos/".$Campos[4]."'>
							</div>
							<div class='card-content '>
								<div class='col s12 m10'>
									<span class='activator grey-text text-darken-4'>".$Campos[0]."</span>
								</div>
								<div class='col s12 m2'>
									<i class='card-title activator material-icons right'>more_vert</i>
								</div>
							</div>
							<div class='card-reveal green lighten-5'>
								<div class='row'>
									<div class='col s12 m10'>
										<span class='activator grey-text text-darken-4'><b>".$Campos[0]."</b></span>
									</div>
									<div class='col s12 m2'>
										<i class='card-title activator material-icons right'>close</i>
									</div>
								</div>
								<div class='row'>
									<p>
										<ul>
											<li>Tipo: Campo ".$TipoCampo."</li>
											<br>
											<li>Celular ou Telefone:<br> ".$Campos[1]."</li>
											<br>
											<li>Endereço: ".$Campos[3]."</li>
										</ul>
									</p>
								</div>
							</div>
						</div>
					  </div>";
			}while($Campos = $selectCamp->fetch(PDO::FETCH_NUM));
		}
	?>
</div>
<div class="row">
    <ul class="pagination">
        <?php
			if($totalPagCampos > 0)
			{
				if($pgCamp>1)
				{
					echo "<li><a href='?pag=Campos&pgCampos=".($pgCamp-1)."'><i class='material-icons'>chevron_left</i></a></li>";
				}
				else
				{
					echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
				}
				
				for($i=1;$i<=$totalPagCampos;$i++)
				{
					if($i==$pgCamp) { echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>"; }
				
					else { echo "<li><a href='?pag=Campos&pgCampos=".$i."'>".$i."</a></li>"; }
				}
				
				if($pgCamp == $totalPagCampos)
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
				}
				else
				{
					echo "<li><a href='?pag=Campos&pgCampos=".($pgCamp+1)."'><i class='material-icons'>chevron_right</i></a></li>";
				}
			}
		?>
    </ul>
</div>