<div class="card-panel blue darken-4 white-text"><center>Times de Campo Society</center></div>    
<div class="row" style="margin-bottom:0px;">
	<?php
		//Define onde começa a busca e quantos registros buscar
		$startTime = 0;
		$limitTime = 10;
		include("class/conexao.php");
		$qtdPaginas = $conexao->prepare("SELECT COUNT(*) FROM `time` WHERE `campo` = 1 ORDER BY id DESC");
		$qtdPaginas->execute();
		$rows = $qtdPaginas->fetch(PDO::FETCH_NUM);
		//Define Quantas páginas existem
		$totalPagCampos = ceil($rows[0] / $limitTime);
		
		if(isset($_GET['pgTimesSociety']))
		{
			$pgCamp = $_GET['pgTimesSociety'];
			$startTime = ($pgCamp-1) * $limitTime;
		}
		else
		{
			isset($_GET['pgTimesSociety']);
			$pgCamp = 1;
			
		}		
		// Busca os dados no banco e exibe conforme limite de registros e número de página
        $selectTime = $conexao->prepare("SELECT nome_time, cor_uniforme, campo_endereco, campo, foto, reportes, id_usuario FROM `time` WHERE `campo` = 1 ORDER BY id DESC LIMIT $startTime, $limitTime");
        $selectTime->execute();
        $Time = $selectTime->fetch(PDO::FETCH_NUM);
        if($Time > 0)
        {		
            do
            {				
				$selectUsuario = $conexao->prepare("SELECT `cidade` FROM `usuario` WHERE `id` = ?");
				$selectUsuario->execute(array($Time[6]));
				$Usuario = $selectUsuario->fetch(PDO::FETCH_NUM);
                echo "	<div class='col s12 m3'>		 
                            <div class='card' style='max-width:400px; min-height:350px;'>
                                <div class='card-image waves-effect waves-block waves-light'>
                                  <img class='activator' src='image/times/".$Time[4]."'>
                                </div>
                                <div class='card-content'>
                                    <div class='col s12 m10'>
                                        <span class='activator grey-text text-darken-4'>".$Time[0]."</span>
                                    </div>
                                    <div class='col s12 m2'>
                                        <span class='activator card-title grey-text text-darken-4'><i class='material-icons right'>more_vert</i></span>
                                    </div>
                                </div>
                                <div class='card-reveal'>
									<div class='col s12 m10'>
										<span class='grey-text text-darken-4'><b>".$Time[0]."</b></span>
									</div>
									<div class='col s12 m2'>
										<span class='card-title grey-text text-darken-4'><i class='material-icons right'>close</i></span>
									</div>
                                  <p>
								  <br>
                                    <ul>
                                        <li>Time de: ".$Usuario[0]."</li>
                                        <li>".$Time[2]." </li>
                                        <li>".$Time[1]." </li>
                                        <li>Reportado por mal comportamento: ".$Time[5]." vezes</li>
                                    </ul>
                                  </p>
                                </div>
                              </div>
                        </div>";
                     
            }while($Time = $selectTime->fetch(PDO::FETCH_NUM));
        }
			
	?>
</div>
<div class="row">
    <ul class="pagination">
        <?php 
			if($pgCamp>1)
				{
					echo "<li><a href='?pag=Times&pgTimesSociety=".($pgCamp-1)."'><i class='material-icons'>chevron_left</i></a></li>";
				}
				else
				{
					echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
				}
				
					for($i=1;$i<=$totalPagCampos;$i++)
					{
						if($i==$pgCamp) { echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>"; }
					
						else { echo "<li><a href='?pag=Times&pgTimesSociety=".$i."'>".$i."</a></li>"; }
					}
					
				if($pgCamp == $totalPagCampos)
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
				}
				else
				{
					echo "<li><a href='?pag=Times&pgTimesSociety=".($pgCamp+1)."'><i class='material-icons'>chevron_right</i></a></li>";
				}
		?>
    </ul>
</div>