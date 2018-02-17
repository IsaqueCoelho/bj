<?php
	function qtdPagNoticias($limit)
	{
		include("../class/conexao.php");
		$selectPostNotice = $conexao->prepare("SELECT COUNT(*) FROM `noticias` ORDER BY id DESC");
		$selectPostNotice->execute();
		$rows = $selectPostNotice->fetch(PDO::FETCH_NUM);
		
		return $total=ceil($rows[0]/$limit);;		
	}
?>