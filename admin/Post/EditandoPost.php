<?php
	if(isset($_REQUEST['id']))
	{
		include("../../class/conexao.php");
		$UpdateDadosNoticia = $conexao->prepare("UPDATE `noticias` SET `titulo` = ?, `descricao` = ? WHERE `id` = ?");
		$UpdateDadosNoticia->execute(array($_POST['titulo'], $_POST['descricao'], $_POST['id']));
		
		echo "Post Atualizado";
	}
?>