<?php
	function CriandoPost($tituloPost, $descricaoPost)
	{
		try
		{
			include("../class/conexao.php");
			date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
			$insert = $conexao->prepare("INSERT INTO `noticias`(titulo, data, descricao) VALUES(?,?,?)");
			$insert->execute(array($tituloPost, date('Y-m-d H:i:s'), $descricaoPost));
		
			return TRUE;
		}
		catch(Exception $erroInsertPostCriando)
		{
			return FALSE;
		}
	}
?>