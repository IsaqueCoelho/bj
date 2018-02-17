<?php
	function SelectDadosUsuario($ID)
	{
		include("class/conexao.php");
		$select = $conexao->prepare("SELECT * FROM `usuario` WHERE `id` = ?");
		$select->execute(array($ID));
		$BuscaDadosUsuario = $select->fetch(PDO::FETCH_ASSOC);
		if($BuscaDadosUsuario > 0)
		{
			return $BuscaDadosUsuario;
		}
	}
	
	function SelectDadosTime($ID)
	{
		include("class/conexao.php");
		$select = $conexao->prepare("SELECT * FROM `time` WHERE `id_usuario` = ?");
		$select->execute(array($ID));
		$BuscaDadosTime = $select->fetch(PDO::FETCH_ASSOC);
		if($BuscaDadosTime > 0)
		{
			return $BuscaDadosTime;
		}
	}
	
	function AtualizandoDadosUsuario($ID, $NomeUser, $Email, $rg, $cpf, $telefone, $celular, $rua, $bairro, $ncasa, $cidade)
	{
		include("class/conexao.php");
		$insert = $conexao->prepare("UPDATE `usuario` SET nome = ?, email = ?, rg = ?, cpf = ?, telefone = ?, celular = ?, rua = ?, bairro = ?, ncasa = ?, cidade = ? WHERE id = ?");
		$insert->execute(array($NomeUser, $Email, $rg, $cpf, $telefone, $celular, $rua, $bairro, $ncasa, $cidade, $ID));
		return true;
	}
	
	function AtualizandoDadosTime($ID, $NomeTime, $cor_uniforme, $campo_endereco, $Campo)
	{
		include("class/conexao.php");
		$insert = $conexao->prepare("UPDATE `time` SET nome_time = ?, cor_uniforme = ?, campo_endereco = ?, campo = ? WHERE id_usuario = ?");
		$insert->execute(array($NomeTime, $cor_uniforme, $campo_endereco, $Campo, $ID));
		return true;
	}
?>