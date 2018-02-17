<?php

	function patrocinador($ID)
	{
		include("class/conexao.php");
		$select = $conexao->prepare("SELECT * FROM `patrocinadores` WHERE `id` = ?");
		$select->execute(array($ID));
		$patrocinador = $select->fetch(PDO::FETCH_ASSOC);
		return $patrocinador;
	}
?>