<?php 
	error_reporting(E_ALL & ~ E_NOTICE);
	require_once "class/patrocinador.php";
	
	for($idPatrocinador == 1; $idPatrocinador <= 4; $idPatrocinador++)
	{
		try
		{
			if($patrocinador = patrocinador($idPatrocinador))
			{
				echo "<div class='col s12 m3'>
	<a href='".$patrocinador['link']."' class='tooltipped' data-position='top' data-delay='50' data-tooltip='".$patrocinador['nome']."'><img class='responsive-img circle' width='200px' style='max-height:200px;' src='image/patrocinios/".$patrocinador['imagem']."'></a>
</div>";				
			}
		}
		catch(Exception $erroBuscaPatrocinadores)
		{
			
		}
	}	
?>