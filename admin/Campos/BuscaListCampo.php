<?php
	function qtdPagCampos($limit)
	{
		include("../class/conexao.php");
		$selectCampo = $conexao->prepare("SELECT COUNT(*) FROM `campos` ORDER BY id DESC");
		$selectCampo->execute();
		$rows = $selectCampo->fetch(PDO::FETCH_NUM);
		
		return $total=ceil($rows[0]/$limit);		
	}
?>