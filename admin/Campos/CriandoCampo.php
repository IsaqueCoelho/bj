<?php 
	function CriandoCampo($CampoTitulo, $CampoCelular, $TipoCampo, $Endereco, $imagem)
	{
		try
		{
			include("../class/conexao.php");
			$insert = $conexao->prepare("INSERT INTO `campos`(nome, celular, tipo, endereco, imagem) VALUES(?,?,?,?,?)");
			$insert->execute(array($CampoTitulo, $CampoCelular, $TipoCampo, $Endereco, $imagem));
		
			return TRUE;
		}
		catch(Exception $erroInsertCriandoCampo)
		{
			return FALSE;
		}		
	}
?>