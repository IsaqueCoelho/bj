<?php

	function Patrocinador($ID)
	{
		include("../class/conexao.php");
		$select = $conectBanco->prepare("SELECT * FROM `patrocinadores` WHERE `id`= ?");
		$select->execute(array($ID));
		$patrocinador = $select->fetch(PDO::FETCH_ASSOC);
		if($patrocinador > 0)
		{
			return $patrocinador;
		}
	}
	
	function BuscaPatrocinadores()
	{
		include("../class/conexao.php");
		$select = $conectBanco->prepare("SELECT * FROM `patrocinadores`");
		$select->execute();
		//$patrocinadores = $select->fetch(PDO::FETCH_ASSOC);
		
		return $select->fetch(PDO::FETCH_ASSOC);
		
	}
	
?>